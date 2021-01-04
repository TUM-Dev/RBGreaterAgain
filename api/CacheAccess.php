<?php

class CacheAccess
{

    /**
     * Loads html from url or cache, if present.
     * @param $url
     * @param int $ttl
     * @return false|file_get_html|mixed
     */
    static function getHtml($url, $ttl = 60){
        if(apcu_exists($url)){
            $html = apcu_fetch($url);
        }else{
            $html = file_get_html($url);
            apcu_add($url, $html, $ttl);
        }
        return $html;
    }
}
