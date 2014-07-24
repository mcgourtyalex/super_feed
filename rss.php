<?php
function get_rss_items ($rss, $number_of_each) {
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
                $author = $rss_item->get_author()->get_name();
                $author_link = $rss_item->get_author()->get_link();
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
?>