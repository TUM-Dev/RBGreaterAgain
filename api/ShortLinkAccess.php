<?php

class ShortLinkAccess {
    const SHORTLINKPREFIXURL = "shortlink_to_url_";

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
