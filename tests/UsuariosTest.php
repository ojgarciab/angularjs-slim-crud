<?php

namespace Tests;

class UsuariosTest extends \PHPUnit_Framework_TestCase
{
    public function testUsuarios()
    {
        $usuarios = new \ASC\Usuarios();
        $this->assertTrue(
            $usuarios !== null
        );
    }
}
