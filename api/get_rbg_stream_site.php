<?php
include 'simple_html_dom.php';
include_once 'CacheAccess.php';

function ParseInformation($link) {
    // First get html of remote page
    $html = CacheAccess::getHtml($link);

    $veranstaltung = $html->find("main", 1)->find("font", 0)->find("b", 0)->innertext;
    $date = $html->find("main", 1)->find("font", 0)->find("b", 1)->innertext;
    $time = $html->find("main", 1)->find("font", 0)->find("b", 2)->innertext;

    $link;
    if ($html) {
        $matches = [];

        preg_match('/MMstartStream.*\'(.+)\'/', $html, $matches);

        if (sizeof($matches) >= 1) {
            $link = $matches[1];
        }
    }


    return ["name" => $veranstaltung, "date" => $date, "time" => $time, "hls_url" => $link];
}
