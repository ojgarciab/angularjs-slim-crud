<?php
require '../vendor/autoload.php';

$app = new \Slim\App();

$app->get('/', function () {
    echo "¡Hola!";
});
$app->run();


