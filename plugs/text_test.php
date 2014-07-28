<?php

function get_text_items ($number_of_each) {
    $qa = [];
    $qa[0] = [
        'type' => 'text', 
        'date_key' => time(), 
        'type_vals' => [
            'title' => 'custom', 
            'date' => "", 
            'content' => "HEY!",
            'link' => "http://google.com",
            'heat' => "",
            'id' => "",
        ],
    ];
    return $qa;
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