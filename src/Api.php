<?php

namespace ASC;

class Api
{
    private $app;

    public function __construct()
    {
        $this->app = new \Slim\App();
        /* Rutas a los servicios RESTful */
        $this->app->get('/usuarios', '\ASC\Usuarios:readUsuarios');
        $this->app->put('/usuarios', '\ASC\Usuarios:createUsuario');
        $this->app->get('/usuarios/{id}', '\ASC\Usuarios:readUsuario');
        $this->app->put('/usuarios/{id}', '\ASC\Usuarios:updateUsuario');
        $this->app->delete('/usuarios/{id}', '\ASC\Usuarios:deleteUsuario');
    }

    public function getApp()
    {
        return $this->app;
    }
}
