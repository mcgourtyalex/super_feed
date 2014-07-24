<?php
function get_twitter_items ($twitter, $number_of_each) {
    echo 'working';
    $users = explode(" ", $twitter);
    $tweets = [];
    foreach($users as $user) {
        // fetch feed using WP
        $rss = fetch_feed('http://twitrss.me/twitter_user_to_rss/?user='.$user);

        if (!is_wp_error($rss)) {
        
            // get items
            $rss_items = $rss->get_items(0, $number_of_each);

            $i = 0;
            // iterate over all items
            foreach($rss_items as $rss_item) {
                
                //$title = $rss_item->get_title();
                $link = $rss_item->get_link();
                $id = array_pop(explode('/', $link));
                $date = $rss_item->get_date();
                $content = $rss_item->get_description();
                $tag = "https://twitter.com/".$user;

                $date_key = strtotime($date);
                
                array_push($tweets, [
                    'type' => 'tweet', 
                    'date_key' => $date_key, 
                    'type_vals' => [
                        'user' => $user, 
                        'date' => $date, 
                        'content' => $content,
                        'link' => $link,
                        'tag' => $tag,
                        'id' => $id,
                    ],
                ]);
                $i++;
                if ($i == $number_of_each) {
                    break;   
                } 
            }
        }
    }
    return $tweets;
}

?>