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
    $body->write(json_encode([
      [
        'id' => 1,
        'usuario' => 'redstar',
        'nombre' => 'Oscar',
        'apellidos' => 'Garcia',
      ],
      [
        'id' => 2,
        'usuario' => 'foobar',
        'nombre' => 'Foo',
        'apellidos' => 'Bar',
      ],
      [
        'id' => 3,
        'usuario' => 'redstar3',
        'nombre' => 'Oscar',
        'apellidos' => 'Garcia',
      ],
      [
        'id' => 4,
        'usuario' => 'foobar3',
        'nombre' => 'Foo',
        'apellidos' => 'Bar',
      ],
      [
        'id' => 5,
        'usuario' => 'redstar7',
        'nombre' => 'Oscar',
        'apellidos' => 'Garcia',
      ],
      [
        'id' => 6,
        'usuario' => 'foobar5',
        'nombre' => 'Foo',
        'apellidos' => 'Bar',
      ],
    ]));
    // TODO: Obtener listado de usuarios
    return $respuesta;
  }

  static public function readUsuario($peticion, $respuesta, $argumentos) {
    $respuesta = $respuesta->withHeader('Content-Type', 'application/json');
    $body = $respuesta->getBody();
    $body->write(json_encode([
      'id' => 1,
      'usuario' => 'redstar',
      'nombre' => 'Oscar',
      'apellidos' => 'Garcia',
    ]));
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
    if ($conexion !== false) {
      return $conexion;
    }
    // TODO: Establecer conexión a la base de datos
  }
}
