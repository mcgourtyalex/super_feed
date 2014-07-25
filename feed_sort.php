<?php
function feed_sort ($items, $sort) {
    switch ($sort) {
        case 'date':
            usort($items, 'compare_date_keys');
            break;
        case 'shuffle':
            shuffle($items);
            break;
        case 'alphabetical':
            usort($items, 'compare_title_keys');
            break;
        default:
            usort($items, 'compare_date_keys');
            break;
    }
    return $items;
}
function compare_date_keys($a, $b)
{
    $key_a = $a['date_key'];
    $key_b = $b['date_key'];
    if ($key_a == $key_b) {
        return 0;
    }
    return ($key_a > $key_b) ? -1 : 1;
}
function compare_title_keys($a, $b)
{
    extract($a['type_vals'],EXTR_PREFIX_ALL,'a');
    extract($b['type_vals'],EXTR_PREFIX_ALL,'b');
    $a_title = ucfirst($a_title);
    $b_title = ucfirst($b_title);
    if (!$a_title) {
        $a_title = $a_content;
    }
    if (!$b_title) {
        $b_title = $b_content;
    }
    if (!strcmp($a_title,$b_title)) {
        return 0;
    }
    return (strcmp($a_title,$b_title) < 0) ? -1 : 1;
}
?>