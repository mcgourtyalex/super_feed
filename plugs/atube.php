<?php

$atube_defaults = array(
    'atube_width' => 400,
    'atube_height' => 300,
);

function atube_defaults() {
    return $GLOBALS['atube_defaults'];
}

function get_atube_items ($atts) {
    extract($atts);
    $dom = new DOMDocument();
    $xml = $dom->load("http://atube/latest.xml");
    $atubes = [];
    if ($xml) {

        $items = $dom->getElementsByTagName('item');
        $i = 0;
        foreach($items as $item) {

            $title = $item->getElementsByTagName('title')->item(0)->nodeValue;
            //$link = $item->getElementsByTagNameNS('*','content')->item(0)->getAttribute('url');
            $link = $item->getElementsByTagName('link')->item(0)->nodeValue;
            $date = $item->getElementsByTagName('pubDate')->item(0)->nodeValue;
            $date_key = strtotime($date);
            $description = $item->getElementsByTagName('description')->item(0)->nodeValue;

            $atubes[$i] = [
                'type' => 'atube', 
                'date_key' => $date_key, 
                'type_vals' => [
                    'title' => $title, 
                    'link' => $link, 
                    'date' => $date,
                    'content' => $link,
                    'description' => $description,
                ],
            ];

            $i++;
            if ($i == $number_of_each) {
                break;
            }
        }
    }
    return $atubes;
}

function atube_title($item) {
    extract($item['type_vals']);
    link_title($link, $title);
}

function atube_icon($item) {
    echo '<svg class="icon">
	<path class="fill" d="M2.1,6.4h12.8v8.9H1.9v-0.3l0-7.5L1.1,4.5l12.4-3.9l0.6,2L9.6,4L2.1,6.4L2.1,6.4L2.1,6.4z M10.9,8.4l1.4-1.7h-1L10,8.4
		H10.9L10.9,8.4z M2.4,8.4h0.9l1.4-1.7H3.8L2.4,8.4L2.4,8.4z M8.3,8.4l1.4-1.7H8.7L7.3,8.4H8.3L8.3,8.4z M6.2,6.7L4.8,8.4h1l1.3-1.7
		H6.2L6.2,6.7z M14,6.7l-1.4,1.7h0.9l1-1.1l0-0.6H14L14,6.7z"/>
	<polygon fill="#FFFFFF" points="6.3,14.3 8.6,9.1 10.8,14.3 9.8,14.3 8.6,11.3 7.3,14.3 6.3,14.3 	"/>
	<polygon fill="#FFFFFF" points="7.7,12.8 9.6,12.8 9.8,13.2 7.4,13.2 	"/>
</g>
<polygon fill="#FFFFFF" points="1.7,4.6 3.3,5.5 4.3,5.2 2.6,4.3 1.7,4.6 "/>
<polygon fill="#FFFFFF" points="3.6,4.1 5.3,4.9 6.3,4.6 4.6,3.8 3.6,4.1 "/>
<polygon fill="#FFFFFF" points="5.5,3.5 7.1,4.3 8.2,4 6.5,3.2 5.5,3.5 "/>
<polygon fill="#FFFFFF" points="7.3,2.9 8.9,3.8 10,3.5 8.3,2.6 7.3,2.9 "/>
<polygon fill="#FFFFFF" points="9.1,2.4 10.7,3.2 11.8,2.9 10.1,2.1 9.1,2.4 "/>
<polygon fill="#FFFFFF" points="10.9,1.8 12.5,2.6 13.6,2.3 11.9,1.5 10.9,1.8 "/>
</svg>';
}

function atube_author_top() {
    return TRUE;
}

function atube_content($item, $atts) {
    extract($item['type_vals']);
    extract($atts);
    echo embedify($link, $atube_width, $atube_height);
    echo '<br />';

    more_button($link);
}

function atube_date($item) {
    extract($item['type_vals']);
    echo format_date($date);
}

function atube_author($item) {
    extract($item['type_vals']);
    echo '<div class="hidden_button">';
    echo '<a href="';
    echo $link;
    echo '">';
    echo "<button class='feed_button'>more</button>";
    echo '</a>';
    echo '</div>';
}

function embedify($link, $width, $height) {
        $str = '<iframe src="'.$link.'/embed_player" style="width: ';
        $str = $str.$width.'px; height:'; 
        $str = $str.$height.'px; border: 1px solid #BBBBBB;"></iframe>';
        return $str;
}

?>