<?php

class CacheAccess {

    /**
     * Loads html from url or cache, if present.
     * @param $url
     * @param int $ttl
     * @return false|file_get_html|mixed
     */
    static function getHtml($url, $ttl = 60) {
        if (apcu_exists($url)) {
            $html = apcu_fetch($url);
        } else {
            $html = file_get_html($url);
            apcu_add($url, $html, $ttl);
        }
        return $html;
    }

    /**
     * returns a video shortId from cache if present, otherwise generates one
     * @param $videoUrl
     * @return false|mixed|string
     */
    static function getVideoShortId($videoUrl) {
        // video short link is last 7 characters of the urls sha1
        $videoShortLink = substr(sha1($videoUrl), -7);
        if (!apcu_exists($videoShortLink)) {
            apcu_add($videoShortLink, $videoUrl);
        }
        return $videoShortLink;
    }

    /**
     * gets the videos url from the shortId
     * @param $videoShortLink
     * @return false|mixed
     */
    static function getVideoUrl($videoShortLink) {
        if (!apcu_exists($videoShortLink)) {
            //error, this should exist.
            return "";
        } else {
            return apcu_fetch($videoShortLink);
        }
    }

}
