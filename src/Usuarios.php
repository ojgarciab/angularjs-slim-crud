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
    // Obtener un usuario por su identificador
    $respuesta = $respuesta->withHeader('Content-Type', 'application/json');
    $body = $respuesta->getBody();
    try {
      $conexion = \miPDO\Conexion::obtenerPDO();
      $consulta = $conexion->prepare('SELECT * FROM usuarios WHERE id = :id');
      $consulta->bindValue(':id', $argumentos['id'], \PDO::PARAM_INT);
      $consulta->execute();
      $body->write(json_encode([
        'error' => false,
        'usuario' => $consulta->fetch(\PDO::FETCH_OBJ),
      ]));
    } catch (\PDOException $e) {
      $body->write(json_encode([
        'error' => true,
        'mensaje' => $e->getMessage(),
      ]));
    }
    return $respuesta;
  }

  static public function updateUsuario($id) {
    // TODO: Actualizar un usuario por su identificador usando los datos enviados en el formulario
  }

  static public function deleteUsuario($peticion, $respuesta, $argumentos) {
    // Borrar un usuario por su identificador
    $respuesta = $respuesta->withHeader('Content-Type', 'application/json');
    $body = $respuesta->getBody();
    try {
      $conexion = \miPDO\Conexion::obtenerPDO();
      $consulta = $conexion->prepare('DELETE FROM usuarios WHERE id = :id');
      $consulta->bindValue(':id', $argumentos['id'], \PDO::PARAM_INT);
      $consulta->execute();
      $body->write(json_encode([
        'error' => false,
        'borrados' => $consulta->rowCount(),
      ]));
    } catch (\PDOException $e) {
      $body->write(json_encode([
        'error' => true,
        'mensaje' => $e->getMessage(),
      ]));
    }
    return $respuesta;
  }

  private function obtenerConexion() {
    //  Establecer conexión a la base de datos
    return \PDO\Conexion::obtenerPDO();
  }
}
