<?php
    
function get_tweet_items ($twitter, $number_of_each) {
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

function tweet_icon($item) {
     echo ' > ';
}

function tweet_author_top() {
    return FALSE;
}

function tweet_title($item) {
    //echo $item['type_vals']['content'];
    $tweet = $item['type_vals'];
    echo '<a class="title_link_text" href="'.$tweet['link'].'">';
    $hashtag = '\1</a><a class="author_link" href="http://twitter.com/search?q=%23\2">#\2</a><a class="title_link_text" href="'.$tweet['link'].'">';
    $handle = '\1</a><a class="author_link" href="http://twitter.com/\2">@\2</a><a class="title_link_text" href="'.$tweet['link'].'">';
    $content = $tweet['content'];
    $content = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', $hashtag, $content);
    $content = preg_replace('/(^|\s)@(\w*[a-zA-Z_]+\w*)/', $handle, $content);
    echo $content;
    echo '</a>';
}

function tweet_content($item) {

}

function tweet_date($item) {
    extract($item['type_vals']);
    echo $item['type_vals']['date'];
}

function tweet_author($item) {
    $tweet = $item['type_vals'];
    
    echo '<div class="hidden_button">';
    echo '<a href="https://twitter.com/intent/follow?screen_name=';
    echo $tweet['user'];
    echo '">';
    echo "<button class='feed_button'><img class='twitter_icon' src='".plugins_url('twitter-256.png', __FILE__)."'></img>follow</button>";
    echo '</a>';
    echo " ";
    echo '<a href="https://twitter.com/intent/retweet?tweet_id=';
    echo $tweet['id'];
    echo '">';
    echo "<button class='feed_button'><img class='twitter_icon' src='".plugins_url('icon-retweet-white.png', __FILE__)."'></img>retweet</button>";
    echo '</a>';
    echo '<script src="https://platform.twitter.com/widgets.js"></script>';
    echo '</div>';

    echo "<a class='author_link' href='".$tweet['tag']."'>";
    echo "@".$tweet['user'];
    echo "</a>";
}

?>