<?php  
require_once('date.php');
require_once('type_controller.php');

function create_post($item, $atts) {
    // create title space
    echo '<div class="title">';
    echo '<div class="icon">';
    content_type($item, 'icon', $atts);
    echo '</div>';
    content_type($item, 'title', $atts);
    if (author_top($item)) {
        echo '<div class="author">';
        content_type($item, 'author', $atts);
        echo '</div>';
    }
    echo '</div>';
    // create content space
    echo '<div class="content">';
    content_type($item, 'content', $atts);
    echo '<div class="date">';
    content_type($item, 'date', $atts);
    echo '</div>';
    
    if (!author_top($item)) {
        echo '<div class="author">';
        content_type($item, 'author', $atts);
        echo '</div>';
    }
    echo '</div>';
}

// helpers for post style consistency:

function more_button ($link) {
    echo '<div class="right">';
    echo '<div class="hidden_button">';
    echo '<a href="';
    echo $link;
    echo '">';
    echo "<button class='feed_button'>more</button>";
    echo '</a>';
    echo '</div>';
    echo '</div>';
}

function link_title ($link, $title) {
    echo '<a class="title_link_text" href="'.$link.'">';
    echo strip_tags($title);
    echo '</a>';
}
?>