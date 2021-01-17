<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

include_once 'vendor/autoload.php';
include_once 'language.php';
include_once 'api/get_rbg_stream_site.php';
include_once 'api/ShortLinkAccess.php';

$link = ShortLinkAccess::getVideoUrl($_GET["s"]);
$loader = new FilesystemLoader('tmpl');
$twig = new Environment($loader);

if (strlen($link) > 0) {
    $data = ParseInformation($link);
    if (isset($_GET["video_only"])) {
        echo $twig->render('video_only.twig', $data);
    } else {
        echo $twig->render('watch.twig', $data);
    }
} else {
    header("HTTP/1.0 404 Not Found");
    echo $twig->render("404.twig");
}
