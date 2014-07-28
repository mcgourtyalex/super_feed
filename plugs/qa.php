<?php

function get_qa_items ($atts, $number_of_each) {
    require_once('C:\Users\t_mcgoa\Documents\My Web Sites\wordpress1\qa\qa-include\qa-base.php');
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
     echo " > ";
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
    $qa = $item['type_vals'];
    echo $qa['date'];
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