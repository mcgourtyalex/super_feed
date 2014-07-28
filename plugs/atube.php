<?php
function atube_defaults($atts) {
    return shortcode_atts( array(
        'width' => 400,
        'height' => 300,
    ), $atts );
}

function get_atube_items ($atts, $number_of_each) {
    $dom = new DOMDocument();
    $xml = $dom->load("http://atube/latest.xml");
    $atubes = [];
    if ($xml) {

        $items = $dom->getElementsByTagName('item');
        $i = 0;
        foreach($items as $item) {

            $title = $item->getElementsByTagName('title')->item(0)->nodeValue;
            $link = $item->getElementsByTagNameNS('*','content')->item(0)->getAttribute('url');
            $href = $item->getElementsByTagName('link')->item(0)->nodeValue;
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
                    'description' => $description,
                    'href' => $href,
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
    echo ' > ';
}

function atube_author_top() {
    return TRUE;
}

function atube_content($item) {
    extract($item['type_vals']);
    extract(atube_defaults());
    echo embedify($href, $width, $height);
    echo '<br />';

    more_button($href);
}

function atube_date($item) {
    extract($item['type_vals']);
    echo $date;
}

function atube_author($item) {
    extract($item['type_vals']);
    echo '<div class="hidden_button">';
    echo '<a href="';
    echo $href;
    echo '">';
    echo "<button class='feed_button'>more</button>";
    echo '</a>';
    echo '</div>';
}

function embedify($href, $width, $height) {
        $str = '<iframe src="'.$href.'/embed_player" style="width: ';
        $str = $str.$width.'px; height:'; 
        $str = $str.$height.'px; border: 1px solid #BBBBBB;"></iframe>';
        return $str;
}

?>