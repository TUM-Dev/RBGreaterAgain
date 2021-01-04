<?php
include 'simple_html_dom.php';
include_once 'CacheAccess.php';

function get_rbg_hls_link(string $url): ?string {
  $html = CacheAccess::getHtml($url, 60*60*24); // this site should be static, therefore we cache it longer.

  if($html) {
    $matches = array();

    preg_match('/MMstartStream.*\'(.+)\'/', $html, $matches);
  
    if(sizeof($matches) >= 1) {
      return $matches[1];
    }
  }

  return null;
}
?>
