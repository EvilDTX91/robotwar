<?php
require_once __DIR__ . '/vendor/autoload.php';

use robotwar\Robots\Robots;
use robotwar\Settings\Connection;

//$twig = new Twig_Environment(new Twig_Loader_Filesystem('templates/'));

$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader);

//echo $twig->render('index.twig');

$robot = new Robots();
//$robot = new Robots();
$list = $robot->getRobotList();

/*while ($obj = $list -> fetch_object()) {
    $tipus = $robot->getRobotTypeName($obj->tipus);
    printf("%s (%s) - %s\n", $obj->nev, $obj->ero, $tipus);
}*/

var_dump($list);

$template = $twig->load('index.twig');
echo $template->render(['robotlist' => $list]);
