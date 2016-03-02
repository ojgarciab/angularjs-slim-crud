<?php
require '../vendor/autoload.php';

$app = new \Slim\App();
$usuarios = new \ASC\Usuarios();
$usuarios->createUsuario();

/* Rutas a los servicios RESTful */
$app->get('/usuarios', '\ASC\Usuarios::readUsuarios');
$app->get('/usuarios/{id}', '\ASC\Usuarios::readUsuario');
$app->delete('/usuarios/{id}', '\ASC\Usuarios::deleteUsuario');


$app->run();
