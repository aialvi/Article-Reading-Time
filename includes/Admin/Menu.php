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
        add_action('admin_init', [$this, 'admin_init']);
    }

    /**
     * Register admin settings
     */
    public function admin_init()
    {

        add_settings_section(
            'art_first_section',
            null,
            null,
            'article-reading-time'
        );

        add_settings_field(
            'article_reading_time_location',
            'Display Location',
            [$this, 'locationHTML'],
            'article-reading-time',
            'art_first_section'
        );
        register_setting(
            'articlereadingtime',
            'article_reading_time_location',
            array(
                'type' => 'string',
                'default' => 'end-of-article',
                'sanitize_callback' => [
                    $this,
                    'sanitizeLocation'
                ]
            )
        );

        add_settings_field(
            'article_reading_time_title',
            'Display Title',
            [$this, 'titleHTML'],
            'article-reading-time',
            'art_first_section'
        );
        register_setting(
            'articlereadingtime',
            'article_reading_time_title',
            array(
                'type' => 'string',
                'default' => 'Article Statistics',
                'sanitize_callback' => 'sanitize_text_field'
            )
        );

        add_settings_field(
            'article_reading_time_word_count',
            'Word Count',
            [$this, 'checkBoxHTML'],
            'article-reading-time',
            'art_first_section',
            ['theName' => 'article_reading_time_word_count']
        );
        register_setting(
            'articlereadingtime',
            'article_reading_time_word_count',
            array(
                'type' => 'string',
                'default' => 'true',
                'sanitize_callback' => 'sanitize_text_field'
            )
        );

        add_settings_field(
            'article_reading_time_character_count',
            'Character Count',
            [$this, 'checkBoxHTML'],
            'article-reading-time',
            'art_first_section',
            ['theName' => 'article_reading_time_character_count']
        );
        register_setting(
            'articlereadingtime',
            'article_reading_time_character_count',
            array(
                'type' => 'string',
                'default' => 'false',
                'sanitize_callback' => 'sanitize_text_field'
            )
        );

        add_settings_field(
            'article_reading_time_read_time',
            'Read Time',
            [$this, 'checkBoxHTML'],
            'article-reading-time',
            'art_first_section',
            array('theName' => 'article_reading_time_read_time')
        );
        register_setting(
            'articlereadingtime',
            'article_reading_time_read_time',
            array(
                'type' => 'string',
                'default' => 'true',
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
    }

    function sanitizeLocation($input)
    {
        if ($input !== 'start-of-article' && $input !== 'end-of-article') {
            add_settings_error('article_reading_time_location', 'art_location_error', 'Display location must be either "Start of article" or "End of article"');
            return get_option('article_reading_time_location');
        }
        return $input;
    }

    function checkBoxHTML($args)
    {
        ?>
        <input type="checkbox" name="<?php echo esc_attr($args['theName']); ?>" value="true" <?php checked(get_option($args['theName']), 'true') ?>>
        <?php
    }

    function locationHTML()
    {
        $location = get_option('article_reading_time_location', 'end-of-article');
        ?>
        <select name="article_reading_time_location">
            <option value="start-of-article" <?php selected($location, 'start-of-article'); ?>>Start of article</option>
            <option value="end-of-article" <?php selected($location, 'end-of-article'); ?>>End of article</option>
        </select>
        <?php
    }

    function titleHTML()
    {
        $title = get_option('article_reading_time_title', 'Article Statistics');
        ?>
        <input type="text" name="article_reading_time_title" value="<?php echo esc_attr($title); ?>">
        <?php
    }
    public function admin_menu()
    {
        add_options_page(
            __('Article Reading Time', 'article-reading-time'),
            __('Reading Time', 'article-reading-time'),
            'manage_options',
            'article-reading-time',
            [$this, 'pluginPageHTML']
        );
    }

    public function pluginPageHTML()
    { ?>
        <div class="wrap">
            <h1>Article Reading Time Settings</h1>
        </div>
        <form action="options.php" method='POST'>
            <?php
            settings_fields('articlereadingtime');
            do_settings_sections('article-reading-time');
            submit_button();
            ?>
        </form>
        <?php
    }
}