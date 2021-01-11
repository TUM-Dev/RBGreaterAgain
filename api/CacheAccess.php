<?php

class CacheAccess {
    const SHORTLINKPREFIXHTML = "shortlink_to_html_";
    const SHORTLINKPREFIXURL = "shortlink_to_url_";

    /**
     * Loads html from url or cache, if present.
     * @param $url
     * @param int $ttl
     * @return false|file_get_html|mixed
     */
    static function getHtml($url, $ttl = 60) {
        $shortLink = self::SHORTLINKPREFIXHTML . self::getVideoShortId($url); // get and store the shortlink in the cache
        if (apcu_exists($shortLink)) {
            $html = apcu_fetch($shortLink);
        } else {
            $html = file_get_html($url);
            apcu_add($shortLink, $html, $ttl);
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
        if (!apcu_exists(self::SHORTLINKPREFIXURL . $videoShortLink)) {
            apcu_add(self::SHORTLINKPREFIXURL . $videoShortLink, $videoUrl);
        }
        return $videoShortLink;
    }

    /**
     * gets the videos url from the shortId
     * @param $videoShortLink
     * @return false|mixed
     */
    static function getVideoUrl($videoShortLink) {
        if (!apcu_exists(self::SHORTLINKPREFIXURL . $videoShortLink)) {
            //error, this should exist.
            return "";
        } else {
            return apcu_fetch(self::SHORTLINKPREFIXURL . $videoShortLink);
        }
    }

}
