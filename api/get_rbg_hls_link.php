<?php
include 'simple_html_dom.php';

function get_rbg_hls_link(string $url): ?string {
    $CACHEKEY = "get_rbg_hls_link_" . $url;
    $CACHETTL = 60 * 60 * 24; // One day
    if (apcu_exists($CACHEKEY)) {
        return apcu_fetch($CACHEKEY);
    }

    $html = file_get_html($url);

    if ($html) {
        $matches = [];

        preg_match('/MMstartStream.*\'(.+)\'/', $html, $matches);

        if (sizeof($matches) >= 1) {
            apcu_add($CACHEKEY, $matches[0], $CACHETTL);
            return $matches[1];
        }
    }
    apcu_add($CACHEKEY, null, $CACHETTL);
    return null;
}

