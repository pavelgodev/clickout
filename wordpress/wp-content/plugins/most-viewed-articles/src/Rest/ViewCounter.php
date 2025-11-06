<?php

namespace MostViewedArticles\Rest;

use WP_Query;
use WP_REST_Response;

class ViewCounter {

	const REST_NAMESPACE = 'mva/v1';
	const META_DAILY = 'mva_views_daily';
	const TRANSIENT_IP_PREFIX = 'mva_last_view_';

	public function register_routes() {
		register_rest_route( self::REST_NAMESPACE, '/count-view', [
			'methods'             => 'POST',
			'callback'            => [ $this, 'rest_count_view' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'post_id' => [
					'required' => true,
					'validate_callback' => function( $param ) {
						return is_numeric( $param );
					}
				],
				'_wpnonce' => [
					'required' => true,
				],
			],
		] );

		register_rest_route( self::REST_NAMESPACE, '/top', [
			'methods'             => 'GET',
			'callback'            => [ $this, 'rest_get_top' ],
			'permission_callback' => '__return_true',
			'args' => [
				'period' => [
					'required' => true,
					'validate_callback' => function( $param ) {
						return in_array( $param, [ 'week', 'month' ], true );
					}
				],
				'limit' => [
					'required' => false,
					'default'  => 10,
					'validate_callback' => function( $param ) {
						return is_numeric( $param ) && intval( $param ) > 0;
					}
				]
			]
		] );
	}

	public function rest_count_view( $request ) {
		$post_id = (int) $request->get_param( 'post_id' );

		if ( $post_id <= 0 ) {
			return new WP_REST_Response( [ 'success' => false, 'message' => 'Invalid post_id' ], 400 );
		}

		$post = get_post( $post_id );
		if ( ! $post || $post->post_type !== 'post' ) {
			return new WP_REST_Response( [ 'success' => false, 'message' => 'Post not found' ], 404 );
		}

		$ip = $this->get_user_ip();
		$ip_hash = $this->hash_ip( $ip );

		$transient_key = self::TRANSIENT_IP_PREFIX . $post_id . '_' . $ip_hash;

		if ( get_transient( $transient_key ) ) {
			return rest_ensure_response( [ 'success' => true, 'counted' => false ] );
		}


		$today = gmdate( 'Y-m-d' );
		$daily = get_post_meta( $post_id, self::META_DAILY, true );

		if ( ! is_array( $daily ) ) {
			$daily = [];
		}

		if ( ! isset( $daily[ $today ] ) ) {
			$daily[ $today ] = 0;
		}

		$daily[ $today ] = (int) $daily[ $today ] + 1;
		update_post_meta( $post_id, self::META_DAILY, $daily );

		set_transient( $transient_key, time(), HOUR_IN_SECONDS );

		return rest_ensure_response( [ 'success' => true, 'counted' => true ] );
	}

	public function rest_get_top( $request ) {
		$period = $request->get_param( 'period' );
		$limit  = (int) $request->get_param( 'limit' );

		$days = $period === 'week' ? 7 : 30;

		$top = $this->get_most_viewed_posts( $days, $limit );

		return rest_ensure_response( [ 'success' => true, 'items' => $top ] );
	}

	public function get_most_viewed_posts( $days = 7, $limit = 10 ) {
		$scan_posts = 500;

		$q = new WP_Query( [
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $scan_posts,
			'no_found_rows'  => true,
			'fields'         => 'ids',
			'orderby'        => 'date',
			'order'          => 'DESC',
		] );

		$post_ids = $q->posts;
		$sums = [];

		if ( empty( $post_ids ) ) {
			return [];
		}

		$dates = [];
		for ( $i = 0; $i < $days; $i++ ) {
			$dates[] = gmdate( 'Y-m-d', strtotime( "-{$i} days" ) );
		}

		foreach ( $post_ids as $pid ) {
			$daily = get_post_meta( $pid, self::META_DAILY, true );
			if ( ! is_array( $daily ) ) {
				continue;
			}
			$sum = 0;
			foreach ( $dates as $d ) {
				if ( isset( $daily[ $d ] ) ) {
					$sum += (int) $daily[ $d ];
				}
			}
			if ( $sum > 0 ) {
				$sums[ $pid ] = $sum;
			}
		}

		arsort( $sums );

		$result = [];
		$rank = 1;
		foreach ( $sums as $pid => $count ) {
			if ( $rank > $limit ) {
				break;
			}
			$result[] = [
				'rank'  => $rank,
				'id'    => $pid,
				'title' => get_the_title( $pid ),
				'link'  => get_permalink( $pid ),
				'count' => $count,
			];
			$rank++;
		}

		return $result;
	}

	public function get_user_ip() {
		if ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			return sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
		}
		return '0.0.0.0';
	}

	protected function hash_ip( $ip ) {
		return substr( sha1( $ip ), 0, 16 );
	}

}
