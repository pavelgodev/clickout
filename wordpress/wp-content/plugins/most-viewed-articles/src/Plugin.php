<?php

namespace MostViewedArticles;

use MostViewedArticles\Widgets\MostViewedWidget;
use MostViewedArticles\Rest\ViewCounter;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Plugin {
	public function run() {
		add_action('widgets_init', array( $this, 'register_widget' ) );
		add_action('rest_api_init', array( $this, 'register_rest_routes' ) );
		add_action('wp_enqueue_scripts', array( $this, 'enqueue_assets' ), 20 );
	}

	public function enqueue_assets() {
		$script_asset = include MVA_PLUGIN_DIR . 'public/js/frontend.asset.php';

		wp_enqueue_script(
			'mva-frontend',
			MVA_PLUGIN_URL . 'public/js/frontend.js',
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);

		$style_asset = include MVA_PLUGIN_DIR . 'public/css/styles.asset.php';

		wp_enqueue_style(
			'mva-style',
			MVA_PLUGIN_URL . 'public/css/styles.css',
			$style_asset['dependencies'],
			$style_asset['version']
		);

		$rest_url = esc_url_raw( rest_url( ViewCounter::REST_NAMESPACE ) );

		wp_localize_script( 'mva-frontend', 'MVA_Config', [
			'rest_url' => $rest_url,
			'nonce'    => wp_create_nonce( 'wp_rest' ),
		] );
	}
	public function register_rest_routes() {
		$view_counter_obj = new ViewCounter();
		$view_counter_obj->register_routes();
	}

	public function register_widget() {
		register_widget( MostViewedWidget::class );
	}
}
