<?php

namespace MostViewedArticles\Widgets;

class MostViewedWidget extends \WP_Widget {

	public function __construct() {
		parent::__construct(
			'most_viewed_articles',
			__( 'Most Viewed Articles', 'mva' ),
			[
				'description' => __( 'Displays most viewed articles', 'mva' ),
			]
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Most Viewed', 'mva' );
		echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];

		?>
		<div class="mva-widget" data-post-id="<?php echo esc_attr( get_the_ID() ); ?>">
			<div class="mva-tabs">
				<button class="mva-tab mva-active" data-period="week"><?php _e( 'This Week', 'mva' ); ?></button>
				<button class="mva-tab" data-period="month"><?php _e( 'This Month', 'mva' ); ?></button>
			</div>
			<div class="mva-list">
				<div class="mva-loading"><?php _e( 'Loading…', 'mva' ); ?></div>
			</div>
		</div>
		<?php

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'Most Viewed', 'mva' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = [];
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		return $instance;
	}
}
