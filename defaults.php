<?php
function feed_defaults ($atts) {
    return shortcode_atts( array(
        'total_posts' => 10,
        'number_of_each' => 10,
        'post_width' => 300,
        'sort' => 'date',

        'twitter' => 'none',
        'rss' => 'none',
        'atube' => 'none',
        'qa' => 'none',
    ), $atts );
}
?>