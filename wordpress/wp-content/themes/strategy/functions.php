<?php

add_action( 'wp_enqueue_scripts', 'strategy_assets');

function strategy_assets() {
	$style_asset = include get_theme_file_path( 'public/css/styles.asset.php' );

	wp_enqueue_style(
		'strategy-style',
		get_theme_file_uri( 'public/css/styles.css' ),
		$style_asset['dependencies'],
		$style_asset['version']
	);

	$script_asset = include get_theme_file_path( 'public/js/main.asset.php' );

	wp_enqueue_script(
		'strategy-script',
		get_theme_file_uri( 'public/js/main.js' ),
		$script_asset['dependencies'],
		$script_asset['version'],
		true
	);
}






//require_once get_template_directory() . '/inc/user-meta.php';
//
//
//function authorly_setup() {
//	add_theme_support( 'title-tag' );
//	add_theme_support( 'post-thumbnails' );
//	add_image_size( 'author-thumb', 120, 90, true );
//	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
//}
//add_action( 'after_setup_theme', 'authorly_setup' );
//
//
//function authorly_assets() {
//	wp_enqueue_style( 'authorly-main', get_template_directory_uri() . '/assets/css/main.css', array(), filemtime( get_template_directory() . '/assets/css/main.css' ) );
//
//
//// small, focused JS for lazy loading; load deferred
//	wp_enqueue_script( 'authorly-lazy', get_template_directory_uri() . '/assets/js/lazyload.js', array(), filemtime( get_template_directory() . '/assets/js/lazyload.js' ), true );
//	wp_script_add_data( 'authorly-lazy', 'defer', true );
//}
//add_action( 'wp_enqueue_scripts', 'authorly_assets' );
//
//
//// Provide a clip of inline critical CSS (optional) — omitted here, but explain how to add later.
//
//
//// Register a simple sidebar for possible widgets on author page
//function authorly_widgets() {
//	register_sidebar( array(
//		'name' => 'Author Sidebar',
//		'id' => 'author-sidebar',
//		'before_widget' => '<aside class="widget %2$s" id="%1$s">',
//		'after_widget' => '</aside>',
//		'before_title' => '<h3 class="widget-title">',
//		'after_title' => '</h3>',
//	) );
//}
//add_action( 'widgets_init', 'authorly_widgets' );
//
//
//// Helper to safely output a user meta value
//function authorly_get_user_meta( $user_id, $key ) {
//	$v = get_user_meta( $user_id, $key, true );
//	return $v ? esc_url( $v ) : '';
//}
