<?php

/*  
    USE THIS TEMPLATE TO ADD FEEDS TO THE AGGREGATOR.

    REGISTER THE FEED IN 'the_superplug.php' IN THE FOLLOWING FORMAT:
        register_defaults ('<your slug>', 'none', $<your slug>_defaults);
    AND BE SURE THE SLUG YOU USE MATCHES THE SLUG YOU USE HERE.

    BE SURE THAT THE NAME OF EACH FUNCTION & GLOBAL VAR FOLLOWS THIS FORMAT, WITH 'template' REPLACED WITH YOUR FEED'S SLUG.
    EX get_<your slug>_items and <your slug>_title and <your slug>_defaults.

    USE ECHO AND NOT RETURN TO ADD ELEMENTS TO EACH POST

    ADD STYLES INTO FEED_STYLES.CSS TO STYLE THE PLUG.
*/

// (1)
$template_defaults = array(
        'custom_setting' => 'content',
);

// (2)
function template_defaults() {
    return $GLOBALS['template_defaults'];
}

// (3)
function get_template_items ($item, $atts) {
    // create items to return
    $items = [];

    // add at least one item with this base format:
    $items[0] = [
        'type' => 'template', 
        'date_key' => time(), 
        'type_vals' => [
            'title' => 'title', 
            'date' => time(), 
            'content' => "content",
            'link' => "#",
        ],
    ];

    // return the items
    return $items;
}

// (4)
function template_title($item, $atts) {
    extract($item['type_vals']);
    link_title($link, $title);
}

// (5)
function template_icon($item, $atts) {
     echo "icon ";
}

// (6)
function template_author_top($item, $atts) {
    return TRUE;
}

// (7)
function template_content($item, $atts) {
    extract($item['type_vals']);
    extract($atts);
    echo $custom_setting;
    more_button($link);
}

// (8)
function template_date($item, $atts) {
    $qa = $item['type_vals'];
    echo $qa['date'];
}

// (9)
function template_author($item, $atts) {
    extract($item['type_vals']);
    more_button($link);
}

?>