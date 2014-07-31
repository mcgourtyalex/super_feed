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
    echo '<svg class="icon" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
        <path class="fill" d="M3.2,11.2c1.1,0.1,2-0.2,2.9-0.8c-0.9-0.1-1.5-0.6-1.9-1.4c0.3,0,0.5,0,0.8,0c-1-0.5-1.6-1.3-1.5-2C3.8,7,4,7,4.3,7.1
			        c-0.9-1-1.1-1.9-0.6-2.8c1.1,1.3,2.5,2,4.2,2.1c0-0.2,0-0.4,0-0.6C8,5.1,8.4,4.5,9.2,4.1c0.8-0.3,1.5-0.2,2.1,0.3
			        c0.1,0.1,0.3,0.2,0.4,0.1c0.3-0.1,0.7-0.3,1-0.4C12.6,4.6,12.4,5,12,5.3c0.3-0.1,0.6-0.2,1-0.3c-0.2,0.4-0.5,0.6-0.8,0.9
			        C12.1,6,12,6.1,12,6.3c0,2.3-1.6,5.1-4.7,5.7c-1.4,0.2-2.7,0-4-0.6C3.3,11.3,3.2,11.3,3.2,11.2C3.1,11.2,3.2,11.2,3.2,11.2z"/>
        </svg>';
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
    echo "<button class='feed_button'><img class='twitter_icon' src='".plugins_url('imgs/twitter-256.png', __FILE__)."'></img>follow</button>";
    echo '</a>';
    echo " ";
    echo '<a href="https://twitter.com/intent/retweet?tweet_id=';
    echo $tweet['id'];
    echo '">';
    echo "<button class='feed_button'><img class='twitter_icon' src='".plugins_url('imgs/icon-retweet-white.png', __FILE__)."'></img>retweet</button>";
    echo '</a>';
    echo '<script src="https://platform.twitter.com/widgets.js"></script>';
    echo '</div>';

    echo "<a class='author_link' href='".$tweet['tag']."'>";
    echo "@".$tweet['user'];
    echo "</a>";
}

?>