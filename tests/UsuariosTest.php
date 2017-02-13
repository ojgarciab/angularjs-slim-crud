<?php

namespace Tests;

class UsuariosTest extends \PHPUnit_Framework_TestCase
{
    public function testNachHasCheese()
    {
        $usuarios = new \ASC\Usuarios();
        $this->assertTrue(
            $usuarios->testIt()
        );
    }
}
