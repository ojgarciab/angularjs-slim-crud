<?php

namespace Tests;

class UsuariosTest extends \PHPUnit_Framework_TestCase
{
    protected $app;

    public function setUp()
    {
	$api = new \ASC\Api();
        $this->app = $api->getApp();
     }

    public function testGetUsuarios()
    {
        $env = \Slim\Http\Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/usuarios',
        ]);
        $req = \Slim\Http\Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $respuesta = $this->app->run(true);
        $this->assertSame($respuesta->getStatusCode(), 200);
        $contentType = $respuesta->getHeader('Content-Type');
        $this->assertSame(count($contentType), 1);
        $this->assertSame($contentType[0], 'application/json');
        $datos = json_decode($respuesta->getBody());
        $this->assertNotNull($datos);
        $this->assertFalse($datos->error);
        $this->assertTrue(count($datos->usuarios) > 0);
    }
}
