<?php

class CacheAccess
{
    static function getHtml($url){
        if(apcu_exists($url)){
            $html = apcu_fetch($url);
        }else{
            $html = file_get_html($url);
            apcu_add($url, $html, 60);
        }
        return $html;
    }
}