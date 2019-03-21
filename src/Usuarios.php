<?php

namespace ASC;

class Usuarios
{
    private $conexion = false;

    public function testIt($bool = true)
    {
        return $bool;
    }

    public function createUsuario(
        \Psr\Http\Message\ServerRequestInterface $peticion,
        \Psr\Http\Message\ResponseInterface $respuesta,
        $argumentos
    ) {
        /* Configuramos el tipo MIME correcto para una salida JSON */
        $respuesta = $respuesta->withHeader('Content-Type', 'application/json');
        $body = $respuesta->getBody();

        try {
            /* Creamos el usuario usando los datos enviados en el formulario */
            $conexion = \miPDO\Conexion::obtenerPDO();
            $consulta = $conexion->prepare(
                'INSERT INTO usuarios (usuario, nombre, apellidos) VALUES (:usuario, :nombre, :apellidos)'
            );
            $datos = $peticion->getParsedBody();
            $consulta->bindValue(':usuario', $datos['usuario'], \PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $datos['nombre'], \PDO::PARAM_STR);
            $consulta->bindValue(':apellidos', $datos['apellidos'], \PDO::PARAM_STR);
            $consulta->execute();
            if ($consulta->rowCount() === 1) {
                $body->write(
                    json_encode([
                        'error'   => false,
                        'mensaje' => 'Registro agregado correctamente',
                    ])
                );
            } else {
                $body->write(
                    json_encode([
                        'error'   => true,
                        'mensaje' => 'No se ha agregado el registro',
                    ])
                );
            }
        } catch (\PDOException $e) {
            /* En caso de error enviamos el mensaje */
            $body->write(
                json_encode([
                    'error'   => true,
                    'mensaje' => $e->getMessage(),
                ])
            );
        }

        return $respuesta;
    }

    public function readUsuarios(
        \Psr\Http\Message\ServerRequestInterface $peticion,
        \Psr\Http\Message\ResponseInterface $respuesta
    ) {
        /* Configuramos el tipo MIME correcto para una salida JSON */
        $respuesta = $respuesta->withHeader('Content-Type', 'application/json');
        $body = $respuesta->getBody();

        try {
            /* Obtenemos el listado de ususarios */
            $conexion = \miPDO\Conexion::obtenerPDO();
            $resultado = $conexion->query(
                'SELECT * FROM usuarios'
            );
            $body->write(
                json_encode([
                    'error'    => false,
                    'usuarios' => $resultado->fetchAll(\PDO::FETCH_OBJ),
                ])
            );
        } catch (\PDOException $e) {
            /* En caso de error enviamos el mensaje */
            $body->write(
                json_encode([
                    'error'   => true,
                    'mensaje' => $e->getMessage(),
                ])
            );
        }

        return $respuesta;
    }

    public function readUsuario(
        \Psr\Http\Message\ServerRequestInterface $peticion,
        \Psr\Http\Message\ResponseInterface $respuesta,
        $argumentos
    ) {
        /* Configuramos el tipo MIME correcto para una salida JSON */
        $respuesta = $respuesta->withHeader('Content-Type', 'application/json');
        $body = $respuesta->getBody();

        try {
            /* Obtenemos el usuario cuyo identificador ha sido pasado como parámetro */
            $conexion = \miPDO\Conexion::obtenerPDO();
            $consulta = $conexion->prepare(
                'SELECT * FROM usuarios WHERE id = :id'
            );
            $consulta->bindValue(':id', $argumentos['id'], \PDO::PARAM_INT);
            $consulta->execute();
            $body->write(
                json_encode([
                    'error'   => false,
                    'usuario' => $consulta->fetch(\PDO::FETCH_OBJ),
                ])
            );
        } catch (\PDOException $e) {
            /* En caso de error enviamos el mensaje */
            $body->write(
                json_encode([
                    'error'   => true,
                    'mensaje' => $e->getMessage(),
                ])
            );
        }

        return $respuesta;
    }

    public function updateUsuario(
        \Psr\Http\Message\ServerRequestInterface $peticion,
        \Psr\Http\Message\ResponseInterface $respuesta,
        $argumentos
    ) {
        /* Configuramos el tipo MIME correcto para una salida JSON */
        $respuesta = $respuesta->withHeader('Content-Type', 'application/json');
        $body = $respuesta->getBody();

        try {
            /* Actualizamos el usuario seleccionado por su identificador, usando los datos enviados en el formulario */
            $conexion = \miPDO\Conexion::obtenerPDO();
            $consulta = $conexion->prepare(
                'UPDATE usuarios SET usuario = :usuario, nombre = :nombre, apellidos = :apellidos WHERE id = :id'
            );
            $datos = $peticion->getParsedBody();
            $consulta->bindValue(':id', $argumentos['id'], \PDO::PARAM_INT);
            $consulta->bindValue(':usuario', $datos['usuario'], \PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $datos['nombre'], \PDO::PARAM_STR);
            $consulta->bindValue(':apellidos', $datos['apellidos'], \PDO::PARAM_STR);
            $consulta->execute();
            if ($consulta->rowCount() === 1) {
                $body->write(
                    json_encode([
                        'error'   => false,
                        'mensaje' => 'Registro actualizado correctamente',
                    ])
                );
            } else {
                $body->write(
                    json_encode([
                        'error'   => true,
                        'mensaje' => 'No se ha encontrado el registro',
                    ])
                );
            }
        } catch (\PDOException $e) {
            /* En caso de error enviamos el mensaje */
            $body->write(
                json_encode([
                    'error'   => true,
                    'mensaje' => $e->getMessage(),
                ])
            );
        }

        return $respuesta;
    }

    public function deleteUsuario(
        \Psr\Http\Message\ServerRequestInterface $peticion,
        \Psr\Http\Message\ResponseInterface $respuesta,
        $argumentos
    ) {
        $respuesta = $respuesta->withHeader('Content-Type', 'application/json');
        $body = $respuesta->getBody();

        try {
            /* Borramos el usuario con el identificador proporcionado */
            $conexion = \miPDO\Conexion::obtenerPDO();
            $consulta = $conexion->prepare(
                'DELETE FROM usuarios WHERE id = :id'
            );
            $consulta->bindValue(':id', $argumentos['id'], \PDO::PARAM_INT);
            $consulta->execute();
            $body->write(
                json_encode([
                    'error'    => false,
                    'borrados' => $consulta->rowCount(),
                ])
            );
        } catch (\PDOException $e) {
            /* En caso de error enviamos el mensaje */
            $body->write(
                json_encode([
                    'error'   => true,
                    'mensaje' => $e->getMessage(),
                ])
            );
        }

        return $respuesta;
    }
}
