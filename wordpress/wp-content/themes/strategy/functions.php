<?php

include get_theme_file_path('/inc/acf-groups/user-group.php');

add_action('wp_enqueue_scripts', 'strategy_assets');

function strategy_assets()
{
    $style_asset = include get_theme_file_path('public/css/styles.asset.php');

    wp_enqueue_style(
        'strategy-style',
        get_theme_file_uri('public/css/styles.css'),
        $style_asset['dependencies'],
        $style_asset['version']
    );

    $script_asset = include get_theme_file_path('public/js/main.asset.php');

    wp_enqueue_script(
        'strategy-script',
        get_theme_file_uri('public/js/main.js'),
        $script_asset['dependencies'],
        $script_asset['version'],
        true
    );
}

function strategy_setup()
{
    add_theme_support('post-thumbnails');

    add_image_size('author-thumbnail', 177, 177, true);
    add_image_size('post-thumbnail', 176, 119, true);
    add_image_size('thumb-mini', 50, 33, true);
}

add_action('after_setup_theme', 'strategy_setup');

function strategy_add_last_btn_in_nav($template)
{
    global $wp_query;
    $total_pages = $wp_query->max_num_pages;

    if ($total_pages < 2) {
        return $template;
    }

    $last_page_url = get_pagenum_link($total_pages);
    $last_page_btn_html = '<a class="last-page-btn page-numbers" href="' . esc_url($last_page_url)
        . '"><span class="last-page-btn__title">Last (' . $total_pages . ')</span><img src="'
        . get_theme_file_uri('public/images/pagination/last-page-icon.png') . '"></a>';
    return str_replace('%3$s', '%3$s' . $last_page_btn_html, $template);
}

add_filter('navigation_markup_template', 'strategy_add_last_btn_in_nav');
