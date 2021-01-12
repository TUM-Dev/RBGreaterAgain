<?php
include 'simple_html_dom.php';

function ParseInformation($link) {
    $CACHEKEY = "get_rbg_stream_site_" . $link;
    if (apcu_exists($CACHEKEY)) {
        return apcu_fetch($CACHEKEY);
    } else {
        // First get html of remote page
        $html = file_get_html($link);

        $veranstaltung = $html->find("main", 1)->find("font", 0)->find("b", 0)->innertext;
        $date = $html->find("main", 1)->find("font", 0)->find("b", 1)->innertext;
        $time = $html->find("main", 1)->find("font", 0)->find("b", 2)->innertext;

        if ($html) {
            $matches = [];

            preg_match('/MMstartStream.*\'(.+)\'/', $html, $matches);

            if (sizeof($matches) >= 1) {
                $link = $matches[1];
            }
        }
        $parsedData = ["name" => $veranstaltung, "date" => $date, "time" => $time, "hls_url" => $link];
        apcu_add($CACHEKEY, $parsedData);
        return $parsedData;
    }
}
