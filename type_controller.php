<?php
function content_type ($item, $spot) {
    $type = $item['type'];
    call_user_func($type."_".$spot, $item);
}

function author_top ($item) {
    $type = $item['type'];
    return call_user_func($type."_author_top");
}
?>