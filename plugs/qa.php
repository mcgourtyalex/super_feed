<?php

$qa_defaults = array(
    'directory' => '\qa\qa-include\qa-base.php',
);

function qa_defaults() {
    return $GLOBALS['qa_defaults'];
}

function get_qa_items ($atts) {
    
    extract($atts);

    require_once(ABSPATH.$directory);
    $prefix = constant('QA_MYSQL_TABLE_PREFIX'); 
    $limit = $number_of_each;
    $query = qa_db_query_sub("
        SELECT * FROM ".$prefix."posts 
        WHERE type= 'Q' 
        ORDER BY `".$prefix."posts`.`postid` DESC 
        LIMIT $limit        
    ");

    $i = 0;
    $qa = [];

    $row = qa_db_read_one_assoc($query, true);
    while ($row) {
        $title = $row['title'];
        $id = $row['postid'];
        $date = $row['created'];
        $date_key = strtotime($date);
        $content = $row['content'];
        $heat = $row['hotness'];
        $link = '/qa/'.qa_q_path_html($id, $title);

        $qa[$i] = [
            'type' => 'qa', 
            'date_key' => $date_key, 
            'type_vals' => [
                'title' => $title, 
                'date' => $date, 
                'content' => $content,
                'link' => $link,
                'heat' => $heat,
                'id' => $id,
            ],
        ];

        $i++;
        $row = qa_db_read_one_assoc($query, true);
    }
    return $qa;
}

function qa_title($item) {
    extract($item['type_vals']);
    link_title($link, $title);
}

function qa_icon($item) {
     echo '<svg class="icon" viewBox="0 0 16 16" enable-background="new 0 0 16 16">
		<path class="fill" fill="#999999" d="M4.1,9.4c0.3,0,0.5,0,0.8,0c0,1.4,0,2.7,0,4.1c2.1,0,4.1,0,6.2,0c0-1.4,0-2.7,0-4.1c0.3,0,0.5,0,0.8,0
			c0,1.6,0,3.3,0,4.9c-2.6,0-5.2,0-7.8,0C4.1,12.7,4.1,11.1,4.1,9.4z"/>
		<path class="fill" fill="#999999" d="M11.3,7.9c-0.2,0.3-0.4,0.6-0.5,0.9C9.4,8,8.1,7.2,6.7,6.4C6.9,6.1,7,5.8,7.2,5.5
			C8.6,6.3,9.9,7.1,11.3,7.9z"/>
		<path class="fill" fill="#999999" d="M10.4,10.4c0,0.4-0.1,0.7-0.1,1c-1.6-0.1-3.1-0.3-4.7-0.4c0-0.3,0-0.7,0.1-1C7.2,10.1,8.8,10.3,10.4,10.4z
			"/>
		<path class="fill" fill="#999999" d="M8.8,3.9c0.3-0.2,0.6-0.4,0.9-0.6c0.9,1.3,1.8,2.6,2.7,3.9c-0.3,0.2-0.6,0.4-0.9,0.6
			C10.6,6.5,9.7,5.2,8.8,3.9z"/>
		<path class="fill" fill="#999999" d="M11.7,2.5c0.4-0.1,0.7-0.1,1-0.2C13,3.9,13.2,5.4,13.5,7c-0.3,0.1-0.6,0.1-1,0.2
			C12.2,5.6,11.9,4.1,11.7,2.5z"/>
		<path class="fill" fill="#999999" d="M6.1,7.9c1.6,0.4,3.1,0.8,4.6,1.2c-0.1,0.3-0.1,0.6-0.2,1C8.9,9.7,7.4,9.3,5.8,8.9C5.9,8.5,6,8.2,6.1,7.9z
			"/>
		<path fill="#999999" d="M5.5,12.7c0-0.3,0-0.6,0-1c1.6,0,3.1,0,4.7,0c0,0.3,0,0.6,0,1C8.7,12.7,7.1,12.7,5.5,12.7z"/>
</svg>';
}

function qa_author_top() {
    return TRUE;
}

function qa_content($item) {
    extract($item['type_vals']);
    echo $content;
    echo '<br />';
    
    more_button($link);
}

function qa_date($item) {
    extract($item['type_vals']);
    echo format_date($date);
}

function qa_author($item) {
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