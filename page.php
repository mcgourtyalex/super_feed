<?php
    
require_once('post.php');
wp_enqueue_style('feed_styles', plugins_url('feed_styles.css', __FILE__));

function start_page () {
    echo '<div class="post_wrapper">';
}
function end_page () {
    echo '</div>';
}
?>