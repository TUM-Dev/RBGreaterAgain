<?php
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

include_once 'vendor/autoload.php';

$loader = new FilesystemLoader('tmpl');
$twig = new Environment($loader);

echo $twig->render('404.twig');
