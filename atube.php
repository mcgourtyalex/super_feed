<?php
function get_atube_items ($number_of_each) {
    echo 'working<br />';
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
?>