<?php

/*
Plugin Name: Recent Activity Feed
Description: Embeds all recent activity pages and posts with shortcodes
*/

foreach (glob(dirname(__FILE__)."*/plugs/*.php") as $filename) {
    include $filename;
}

require_once('defaults.php');

/* REGISTER ALL FEEDS HERE. */
register_defaults ('twitter', 'none');
register_defaults ('rss', 'none');
register_defaults ('qa', 'none');
register_defaults ('atube', 'none');
register_defaults ('text', 'none');
/* REGISTER ALL FEEDS ABOVE. */

require_once('feed_sort.php');
require_once('sp_page.php');


add_shortcode( 'recent_feed', 'recent_feed_controller' );

function recent_feed_controller($atts) {

    $atts = feed_defaults($atts);
    $items = [];

    foreach ($GLOBALS['registered_feeds'] as $feed) {
        if (!($atts[$feed] == 'none')) {
            $new_items = call_user_func('get_'.$feed.'_items', $atts[$feed], $atts['number_of_each']);
            $items = array_merge($items, $new_items);
        }
    }

    $items = feed_sort($items, $atts['sort']);

    start_page();
    foreach ($items as $item) {
        create_post($item);
    }
    end_page();
}

?>