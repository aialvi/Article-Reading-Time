<?php
/**
 * Plugin Name: Article Reading Time
 * Description: Calculates the estimated reading time for articles.
 * Plugin URI: https://github.com/aialvi/article-reading-time
 * Version: 1.0.0
 * Author: aialvi
 * Author URI: https://aialvi.me/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ArticleReadingTime main class
 */
final class ArticleReadingTime
{

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0.0';

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->define_constants();
    }

    /**
     * Singleton instance
     *
     * @return ArticleReadingTime
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define constants
     */
    public function define_constants()
    {
        define('ART_PLUGIN_VERSION', self::version);
        define('ART_PLUGIN_FILE', __FILE__);
        define('ART_PLUGIN_PATH', __DIR__);
        define('ART_PLUGIN_URL', plugins_url('', ART_PLUGIN_FILE));
        define('ART_PLUGIN_ASSETS', ART_PLUGIN_URL . '/assets');
    }
}

/**
 * Initialize the plugin
 */
function article_reading_time()
{
    return ArticleReadingTime::init();
}

// Start the plugin
article_reading_time();