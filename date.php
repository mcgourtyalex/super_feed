<?php

// consistent date format
function format_date($date) {
    $dt = new DateTime($date);
    return $dt->format('M j \a\t')." ".$dt->format('g:i a');
}

?>