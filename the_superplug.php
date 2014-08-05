<?php

/*
Plugin Name: Recent Activity Feed
Description: Aggregates and embeds feeds. To format your own feed, copy and edit "TEMPLATE.php" in /plugs and register it in the_superplug.php
*/

foreach (glob(dirname(__FILE__)."*/plugs/*.php") as $filename) {
    include $filename;
}

include 'info_page.php';

// Feed defaults can be edited in defaults.php:
require_once('defaults.php');

/* ------------------------- REGISTER ALL FEEDS HERE. ------------------------- */

register_defaults ('tweet', 'none');
register_defaults ('rss', 'none', $rss_defaults);
register_defaults ('qa', 'none', $qa_defaults);
register_defaults ('atube', 'none', $atube_defaults);
//register_defaults ('template', 'none', $template_defaults);
//register_defaults ('blank', 'none', $blank_defaults);

/* ------------------------- REGISTER ALL FEEDS ABOVE. ------------------------- */

// sort pages, and create posts:
require_once('feed_sort.php');
require_once('sp_page.php');

// shortcode to embed a full feed
add_shortcode( 'recent_feed', 'recent_feed_controller' );

// shortcode to embed a single item
add_shortcode( 'recent_item', 'recent_item_controller' );


/* ------------------------- FEED EMBED ------------------------- */


function recent_feed_controller($atts) {

    // collect default values
    $atts = feed_defaults($atts);


    // items to be collected, sorted, and embedded
    $items = [];

    // iterate through each feed, and if the feed is activated, call get_<feed slug>_items and pass it the defaults
    foreach ($GLOBALS['registered_feeds'] as $feed) {
        if (!($atts[$feed] == 'none')) {
            $new_items = call_user_func('get_'.$feed.'_items', $atts);
            // add item result to the item list
            $items = array_merge($items, $new_items);
        }
    }

    // sort the items by the sort attribute specified
    $items = feed_sort($items, $atts['sort']);

    // start the buffer to begin populating the page
    // this is necessary for WP to position the embed properly
    ob_start();
    
    // start page creation
    start_page($atts);
    foreach ($items as $item) {
        create_post($item, $atts);
    }
    // end page creation
    end_page();

    // return the buffer
    $body = ob_get_contents();
    ob_end_clean();
    return $body;
}


/* ------------------------- SINGLE FEED OBJECT ------------------------- */


// embeds a single feed object
function recent_item_controller($atts) {

    $atts = item_defaults($atts);
    extract($atts);

    // set the type equal to the source
    $atts[$type] = $src;
    $atts['number_of_each'] = $item_number;

    // get a single item of the type
    $new_items = call_user_func('get_'.$type.'_items', $atts);
    $item = $new_items[$item_number - 1];

    // return the item formatted

    ob_start();

    $response = content_type($item, $element, $atts);

    $body = ob_get_contents();
    ob_end_clean();

    if ($formatted == 'yes' && $body) {
        return $body;
    } else {
        return $item['type_vals'][$element];
    }

}

?>