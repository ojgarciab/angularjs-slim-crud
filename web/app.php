<?php

require '../vendor/autoload.php';

$app = new \Slim\App();

/* Rutas a los servicios RESTful */
$app->get('/usuarios', '\ASC\Usuarios:readUsuarios');
$app->put('/usuarios', '\ASC\Usuarios:createUsuario');
$app->get('/usuarios/{id}', '\ASC\Usuarios:readUsuario');
$app->put('/usuarios/{id}', '\ASC\Usuarios:updateUsuario');
$app->delete('/usuarios/{id}', '\ASC\Usuarios:deleteUsuario');

$app->run();
