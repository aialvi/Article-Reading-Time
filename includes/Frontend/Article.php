<?php

namespace Aialvi\ArticleReadingTime\Frontend;

/**
 * Frontend article class
 */
class Article
{

    function __construct()
    {
        add_filter('the_content', [$this, 'ifWrap']);
    }

    /**
     * Check if article reading time should be displayed
     */
    public function ifWrap($content)
    {
        if ((is_main_query() and is_single()) and (get_option('article_reading_time_word_count', 'true') or get_option('article_reading_time_character_count', 'true') or get_option('article_reading_time_read_time', 'true'))) {
            return $this->createHTML($content);
        }
        return $content;
    }

    /**
     * Create the HTML for the article reading time
     */
    public function createHTML($content)
    {
        $word_count = str_word_count(wp_strip_all_tags($content));
        $character_count = strlen(wp_strip_all_tags($content));
        $reading_time = ceil($word_count / 225);
        $reading_time = apply_filters('article_reading_time', $reading_time);
        $title = get_option('article_reading_time_title', __('Article Statistics', 'article-reading-time'));

        $html = '<div class="article-reading-time"><h4 class="art-title">' . $title . '</h4>';
        if (get_option('article_reading_time_word_count', 'true')) {
            $html .= '<p class="art-word-count">' . __('Word count: ', 'article-reading-time') . $word_count . '</p>';
        }
        if (get_option('article_reading_time_character_count', 'true')) {
            $html .= '<p class="art-character-count">' . __('Character count: ', 'article-reading-time') . $character_count . '</p>';
        }
        if (get_option('article_reading_time_read_time', 'true')) {
            $html .= '<p class="art-reading-time">' . __('Estimated reading time: ', 'article-reading-time') . $reading_time . __(' minute(s)', 'article-reading-time') . '</p>';
        }
        $html .= '</div>';

        if (get_option('article_reading_time_location', 'end-of-article') === 'end-of-article') {
            return $content . $html;
        }
        return $html . $content;
    }
}