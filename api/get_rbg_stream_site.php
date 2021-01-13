<?php
include 'simple_html_dom.php';

const CACHEPREFIX = "get_rbg_stream_site_";
const TTL = 24 * 60 * 60; // one day.
/**
 * Fetches all desired data about a specific video. This includes:
 * The videos name, recording date, time and the hls url (an m3u8 file hosted by RBG that references the video stream)
 * @param $link
 * @return array|false|mixed
 */
function ParseInformation($link) {
    $cacheKey = CACHEPREFIX . $link;
    if (apcu_exists($cacheKey)) {
        return apcu_fetch($cacheKey);
    } else {
        // First get html of remote page
        $html = file_get_html($link);

        if ($html) {
            $veranstaltung = $html->find("main", 1)->find("font", 0)->find("b", 0)->innertext;
            $date = $html->find("main", 1)->find("font", 0)->find("b", 1)->innertext;
            $time = $html->find("main", 1)->find("font", 0)->find("b", 2)->innertext;

            $matches = [];

            preg_match('/MMstartStream.*\'(.+)\'/', $html, $matches);

            if (sizeof($matches) >= 2) {
                $link = $matches[1];
            }

            $parsedData = ["name" => $veranstaltung, "date" => $date, "time" => $time, "hls_url" => $link];
            apcu_add($cacheKey, $parsedData, TTL);
            return $parsedData;
        } else {
            // Cache empty results (as null) as well, so this edge case doesn't overload the source
            apcu_add($cacheKey, null, TTL);
            return null;
        }
    }
}
