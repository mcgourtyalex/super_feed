<?php

$default_args = array(
        'total_posts' => 10,
        'number_of_each' => 10,
        'post_width' => 300,
        'sort' => 'date',
    );

$registered_feeds = array ();

function register_defaults ($default, $default_val) {
    $GLOBALS['default_args'][$default] = $default_val;
    array_push($registered_feeds, $default);
}

function feed_defaults ($atts) {
    
    return shortcode_atts($GLOBALS['default_args'] , $atts );
}
?>