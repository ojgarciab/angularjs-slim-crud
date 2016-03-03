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

  static public function readUsuarios($peticion, $respuesta) {
    $respuesta = $respuesta->withHeader('Content-Type', 'application/json');
    $body = $respuesta->getBody();
    try {
      $conexion = \miPDO\Conexion::obtenerPDO();
      $resultado = $conexion->query('SELECT * FROM usuarios');
      $body->write(json_encode([
        'error' => false,
        'usuarios' => $resultado->fetchAll(\PDO::FETCH_OBJ),
      ]));
    } catch (\PDOException $e) {
      $body->write(json_encode([
        'error' => true,
        'mensaje' => $e->getMessage(),
      ]));
    }
    return $respuesta;
  }

  static public function readUsuario($peticion, $respuesta, $argumentos) {
    $respuesta = $respuesta->withHeader('Content-Type', 'application/json');
    $body = $respuesta->getBody();
    $body->write(json_encode([
      'error' => false,
      'usuario' => [
      'id' => 1,
      'usuario' => 'redstar',
      'nombre' => 'Oscar',
      'apellidos' => 'Garcia',
    ]]));
    // TODO: Obtener un usuario por su identificador
    return $respuesta;
  }

  static public function updateUsuario($id) {
    // TODO: Actualizar un usuario por su identificador usando los datos enviados en el formulario
  }

  static public function deleteUsuario($peticion, $respuesta, $argumentos) {
    $respuesta = $respuesta->withHeader('Content-Type', 'application/json');
    // TODO: Borrar un usuario por su identificador
    return $respuesta;
  }

  private function obtenerConexion() {
    //  Establecer conexión a la base de datos
    return \PDO\Conexion::obtenerPDO();
  }
}
