<?php

namespace Aialvi\ArticleReadingTime\Admin;

/**
 * Admin menu class
 */
class Menu
{

    function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    public function admin_menu()
    {
        add_menu_page(
            __('Article Reading Time', 'article-reading-time'),
            __('Reading Time', 'article-reading-time'),
            'manage_options',
            'article-reading-time',
            [$this, 'plugin_page'],
            'dashicons-clock'
        );
    }

    public function plugin_page()
    {
        echo 'Hello World';
    }
}