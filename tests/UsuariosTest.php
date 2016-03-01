<?php
use ASC\Usuarios;

class UsuariosTest extends PHPUnit_Framework_TestCase {
  public function testNachHasCheese() {
    $usuarios = new Usuarios();
    $this->assertTrue($usuarios->testIt());
  }
}
