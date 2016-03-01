<?php
namespace ASC;

class Usuarios {
  private $conexion = false;

  public function testIt($bool = true) {
    return $bool;
  }

  public function createUsuario() {
    // TODO: Crear usuario nuevo con los datos enviados en el formulario
  }

  public function readUsuarios() {
    // TODO: Obtener listado de usuarios
  }

  public function readUsuario($id) {
    // TODO: Obtener un usuario por su identificador
  }

  public function updateUsuario($id) {
    // TODO: Actualizar un usuario por su identificador usando los datos enviados en el formulario
  }

  public function deleteUsuario($id) {
    // TODO: Borrar un usuario por su identificador
  }

  private function obtenerConexion() {
    if ($conexion !== false) {
      return $conexion;
    }
    // TODO: Establecer conexión a la base de datos
  }
}

