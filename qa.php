<?php
function get_qa_items ($number_of_each) {
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
?>