<?php
use robotwar\classes\Robots;

require_once __DIR__ . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader);


$robot = new \robotwar\robots\Robots();
$list = $robot->getRobotList();


$template = $twig->load('index.twig');
echo $template->render(['robotlist' => $list]);
