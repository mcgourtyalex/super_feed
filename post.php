<?php  
require_once('date.php');

function create_post($item) {

    echo '<div class="title">';
    echo $item['type'];
    echo '</div>';

    echo '<div class="content">';
    echo "content here";
    echo "<br />";

    echo '<div class="author">';
    echo 'author here';
    echo '</div>';

    echo '<div class="date">';
    echo format_date($item['date_key']);
    echo '</div>';

    echo '</div>';

    echo '<div class="buffer">';
    echo '</div>';
}

?>