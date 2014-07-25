<?php

/*
Plugin Name: Recent Activity Feed
Description: Embeds all recent activity pages and posts with shortcodes
*/

require_once('atube.php');
require_once('qa.php');
require_once('rss.php');
require_once('twitter.php');

require_once('defaults.php');
require_once('feed_sort.php');

require_once('sp_page.php');


add_shortcode( 'recent_feed', 'recent_feed_controller' );

function recent_feed_controller($atts) {

    extract(feed_defaults($atts));

    $items = [];

    if (!($twitter == 'none')) {
        $tweets = get_tweet_items($twitter, $number_of_each);
        $items = array_merge($items, $tweets);
    }
    if (!($rss == 'none')) {
        $rss = get_rss_items($rss, $number_of_each);
        $items = array_merge($items, $rss);
    }
    if (!($atube == 'none')) {
        $atubes = get_atube_items($number_of_each);
        $items = array_merge($items, $atubes);
    }
    if (!($qa == 'none')) {
        $qas = get_qa_items($number_of_each);
        $items = array_merge($items, $qas);
    }

    $items = feed_sort($items, $sort);

    start_page();
    foreach ($items as $item) {
        create_post($item);
    }
    end_page();
}

?>