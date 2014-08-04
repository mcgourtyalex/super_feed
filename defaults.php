<?php

// GENERAL DEFAULT VALUES
$default_args = array(
        'number_of_each' => 10,
        'post_width' => '100%',
        'sort' => 'date',
);

// DEFAULT VALUES FOR SINGLE ITEM SELECTION
$item_args = array(
        'type' => '',
        'element' => 'title',
        'src' => 'none',
        'number_of_each' => 1,
        'formatted' => 'no'
);

// GLOBAL ARRAY OF REGISTERED FEED NAMES
$registered_feeds = [];

// register each feed to $registered_feeds and add arguments to $default_args
function register_defaults ($default, $default_val, $default_args) {
    $GLOBALS['default_args'][$default] = $default_val;
    foreach ($default_args as $key => $value) {
        $GLOBALS['default_args'][$key] = $value;
        $GLOBALS['item_args'][$key] = $value;
    }
    array_push($GLOBALS['registered_feeds'], $default);
}

// config attributes
function feed_defaults ($atts) {
    return shortcode_atts($GLOBALS['default_args'] , $atts);
}

// config single-item attributes
function item_defaults ($atts) {
    return shortcode_atts($GLOBALS['item_args'] , $atts);
}

?>