<?php
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

include_once 'vendor/autoload.php';
include_once 'language.php';
include_once 'api/get_rbg_streams.php';


$loader = new FilesystemLoader('tmpl');
$twig = new Environment($loader);

echo $twig->render('index.twig', $STREAMS);
