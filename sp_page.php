<?php
    
require_once('sp_post.php');
wp_enqueue_style('feed_styles', plugins_url('feed_styles.css', __FILE__));

// creates wrapper for posts
function start_page ($atts) {
    $width = $atts['post_width'];
    echo '<div class="post_wrapper" ';
    if (strpos($width, "%")) {
        echo 'style="width: '.$width.';"';
    } else {
        echo 'style="width: '.$width.'px;"';
    }
    echo '>';
}

// ends wrapper
function end_page () {
    echo '</div>';
}
?>