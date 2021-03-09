<?php
require_once __DIR__ . '/vendor/autoload.php';

use robotwar\Robots\Robots;
use robotwar\Settings\Connection;

$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader);


$robot = new Robots();
$list = $robot->getRobotList();


$template = $twig->load('index.twig');
echo $template->render(['robotlist' => $list]);
