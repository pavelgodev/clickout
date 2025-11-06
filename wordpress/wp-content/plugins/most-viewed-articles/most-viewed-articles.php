<?php
/**
 * Plugin Name: Most Viewed Articles
 * Description: Widget that displays most viewed articles.
 * Version: 1.0.0
 * Author: Pavel Moiseenko
 * Text Domain: mva
 */

use MostViewedArticles\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define('MVA_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MVA_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once __DIR__ . '/vendor/autoload.php';

add_action( 'plugins_loaded', function () {
    $plugin = new Plugin();
    $plugin->run();
});
