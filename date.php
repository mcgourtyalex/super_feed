<?php
function compare_date_keys($a, $b)
{
    $key_a = $a['date_key'];
    $key_b = $b['date_key'];
    if ($key_a == $key_b) {
        return 0;
    }
    return ($key_a > $key_b) ? -1 : 1;
}
function format_date($date) {
    return date('M d \a\t g:i a', $date);
}
?>