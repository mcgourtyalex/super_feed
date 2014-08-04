<?php

// (1)
$blank_defaults = array();

// (2)
function blank_defaults() {
    return $GLOBALS['blank_defaults'];
}

// (3)
function get_blank_items ($item, $atts) {
    $items = [];

    $items[0] = [
        'type' => 'blank', 
        'date_key' => '', 
        'type_vals' => [
            'title' => '', 
            'date' => '', 
            'content' => '',
            'link' => '',
        ],
    ];

    return $items;
}

// (4)
function blank_title($item, $atts) {
}

// (5)
function blank_icon($item, $atts) {
}

// (6)
function blank_author_top($item, $atts) {
}

// (7)
function blank_content($item, $atts) {
}

// (8)
function blank_date($item, $atts) {
}

// (9)
function blank_author($item, $atts) {
}

?>