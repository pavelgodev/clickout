<?php

include get_theme_file_path( '/inc/acf-groups/user-group.php' );

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

function strategy_setup() {
	add_image_size('author-thumbnail', 177, 177, true);
}

add_action('after_setup_theme', 'strategy_setup');
