<?php

// USE THIS TEMPLATE TO ADD FEEDS TO THE AGGREGATOR. 
// ADD STYLES INTO FEED_STYLES.CSS
// REGISTER THE FEED IN 'the_superplug.php' AND BE SURE THE SLUG YOU USE MATCHES THE SLUG YOU USE HERE.
// BE SURE THAT THE NAME OF EACH FUNCTION FOLLOWS THE FOLLOWING FORMAT, WITH 'text' REPLACED WITH YOUR FEED'S SLUG.
// EX get_<your slug name here>_items and <your slug name here>_title

function get_text_items ($atts, $number_of_each) {
    // create items to return
    $items = [];
    // add at least one item with this base format:
    $items[0] = [
        'type' => 'text', 
        'date_key' => time(), 
        'type_vals' => [
            'title' => 'title', 
            'date' => time(), 
            'content' => "content",
            'link' => "http://google.com",
        ],
    ];

    // return the items
    return $items;
}

function text_title($item) {
    extract($item['type_vals']);
    link_title($link, $title);
}

function text_icon($item) {
     echo " > ";
}

function text_author_top() {
    return TRUE;
}

function text_content($item) {
    extract($item['type_vals']);
    echo $content;
    echo '<br />';
    
    more_button($link);
}

function text_date($item) {
    $qa = $item['type_vals'];
    echo $qa['date'];
}

function text_author($item) {
    extract($item['type_vals']);
    echo '<div class="hidden_button">';
    echo '<a href="';
    echo $link;
    echo '">';
    echo "<button class='feed_button'>more</button>";
    echo '</a>';
    echo '</div>';
}

?>