<?php
session_start();

$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$acceptLang = ['de', 'en'];
$lang = in_array($lang, $acceptLang) ? $lang : 'en';

if (isset($_SESSION["lang"])) {
    $lang = $_SESSION["lang"];
}

if (isset($_GET["lang"])) {
    $lang = $_GET["lang"];
}

$_SESSION["lang"] = $lang;


$DICT = [];

if ($lang == "de") {
    $DICT = [
        "holder"              => "Inhaber von",
        "impressum"           => "Impressum",
        "legal"               => "Datenschutz",
        "current_livestreams" => "Aktuelle Livestreams",
        "vod"                 => "Video-Aufzeichungen",
        "vod_archive"         => "Video-Aufzeichungen Archiv",
        "stream_not_found"    => "Stream nicht gefunden",
    ];
} else {
    $DICT = [
        "holder"              => "Holder of",
        "impressum"           => "Impressum",
        "legal"               => "Legal",
        "current_livestreams" => "Current Livestreams",
        "vod"                 => "Video-On-Demand",
        "vod_archive"         => "Video-On-Demand Archive",
        "stream_not_found"    => "Stream not found",
    ];
}
