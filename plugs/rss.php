<?php
    
$rss_defaults = array(
        'chars' => 250,
        'max_chars' => 500,
        'roll' => 'yes',
);

function rss_defaults() {
    return $GLOBALS['rss_defaults'];
}

function get_rss_items ($atts) {
    extract($atts);
    $feeds = explode(" ", $rss);
    $vals = [];
    foreach ($feeds as $feed) {
        $rss = fetch_feed($feed);
        if (!is_wp_error($rss)) {
            $feed_title = $rss->get_title();
            $rss_items = $rss->get_items(0,$atts['number']);
            $i = 0;
        
            foreach($rss_items as $rss_item) {
                // vars
                $title = $rss_item->get_title();
                $link = $rss_item->get_link();
                $date = $rss_item->get_date();
                $date_key = strtotime($date);
                $author_obj = $rss_item->get_author();
                if ($author_obj) {
                    $author = $author_obj->get_name();
                    $author_link = $author_obj->get_link();
                } else {
                    $author = "";
                    $author_link = "";
                }
                $category = $rss_item->get_category();
                $content = $rss_item->get_description();

                array_push($vals, [
                    'type' => 'rss', 
                    'date_key' => $date_key, 
                    'type_vals' => [
                        'author' => $author, 
                        'author_link' => $author_link, 
                        'date' => $date, 
                        'content' => $content,
                        'link' => $link,
                        'category' => $category,
                        'title' => $title,
                        'feed_title' => $feed_title,
                    ],
                ]);
                $i++;
                if ($i == $number_of_each) {
                    break 1;
                }
            }
        }
    }
    return $vals;
}

function rss_title($item) {
    extract($item['type_vals']);
    link_title($link, $title);
}

function rss_icon($item) {
     echo '<svg class="icon" viewBox="0 0 16 16" enable-background="new 0 0 16 16">
        <path class="fill" d="M13.5,11.1c-0.5,0-1,0-1.5,0c-0.1-1.9-0.7-3.5-2-4.8c-1.3-1.3-2.9-2-4.8-2c0-0.5,0-1,0-1.5C9.3,2.4,13.7,6.5,13.5,11.1z"/>
		<path class="fill" d="M10.6,11.1c-0.5,0-1,0-1.5,0c-0.3-2.4-1.6-3.7-4-4c0-0.5,0-1,0-1.5C7.8,5.4,10.7,8,10.6,11.1z"/>
		<path class="fill" d="M6.1,11.1C5.5,11.1,5,10.7,5,10c0-0.7,0.5-1.1,1.1-1.1c0.6,0,1.1,0.5,1.1,1.1C7.2,10.6,6.8,11.1,6.1,11.1z"/>
        </svg>';
}

function rss_author_top() {
    return TRUE;
}

function rss_content($item, $atts) {
    extract($atts);
    extract($item['type_vals']);
    $content = trim(strip_tags($content));
    $content_len = strlen($content);
    $total_len = $max_chars;
    $prev_len = preview_length_handler($chars, $content_len);
    $ext_len = $total_len - $prev_len;
    $content_prev = content_prev_string_handler($content, $prev_len);
    $content_end = content_end_string_handler($content, $prev_len, $ext_len);
    $roll = activate_roll ($prev_len, $content_len, $roll, $ext_len);
    if ($roll) {
        echo '<div class="rss_content_long">';
        echo $content_prev;
        echo '<div class="ellipses"></div>';
        echo '<span class="rss_content_ext';
        extension_ellipses_handler ($total_len, $content_len);
        echo '">';
        echo $content_end;
        echo '</span>';
        echo '</div>';
    } else {
        echo '<div class="rss_content">';
        echo $content_prev;
        echo '</div>';
    }
    more_button($link);
}

function rss_date($item) {
    extract($item['type_vals']);
    echo format_date($date);
}

function rss_author($item) {
    $rss = $item['type_vals'];
    echo '<a class="author_link" ';
    if ($rss['author_link']) {
        echo 'href='.$rss['author_link'];
    }
    echo '>';
    $author = $rss['author'];
    $author = explode('/', $author)[0];
    $author = explode('<', $author)[0];
    echo trim(strip_tags($author));
    echo '</a>';
    if ($rss['category']) {
        echo " | ";
        echo $rss['category'];
    }
}

//sets length of preview
function preview_length_handler($chars, $content_len) {
    $prev_len = $chars;
    // if chars is set to full, make the preview the size of all of the content
    if ($prev_len == 'full') {
        $prev_len = $content_len;
    }
    return $prev_len;
}

// creates content string to proper size
function content_end_string_handler($content, $prev_len, $ext_len) {
    $content_end = substr($content, $prev_len, $ext_len);
    // if max_chars is full, then make the end the rest of the length
    if ($total_len == 'full') {
        $content_end = substr($content, $prev_len);
    }
    return $content_end;
}

function content_prev_string_handler($content, $prev_len) {
    return substr($content, 0, $prev_len);
}

// activates rolldown if true
function activate_roll ($prev_len, $content_len, $roll, $ext_len) {
    return $prev_len != "full" && $prev_len < $content_len && $roll == 'yes' && $ext_len > 0;
}

// adds the ellipses class if true
function extension_ellipses_handler ($total_len, $content_len) {
    if ($total_len < $content_len) {
        echo ', ellipses_ext';
    }
}

?>