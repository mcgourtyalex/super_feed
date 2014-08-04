<?php
function content_type ($item, $spot, $atts) {
    $type = $item['type'];
    call_user_func($type."_".$spot, $item, $atts);
}

function author_top ($item) {
    $type = $item['type'];
    return call_user_func($type."_author_top");
}
?>