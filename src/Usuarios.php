<?php
namespace ASC;

class Usuarios
{
    private $conexion = false;
    
    public function testIt($bool = true)
    {
        return $bool;
    }
    
    public static function createUsuario()
    {
        // TODO: Crear usuario nuevo con los datos enviados en el formulario
    }
    
    public static function readUsuarios(
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
                    'error' => false,
                    'usuarios' => $resultado->fetchAll(\PDO::FETCH_OBJ),
                ])
            );
        } catch (\PDOException $e) {
            /* En caso de error enviamos el mensaje */
            $body->write(
                json_encode([
                    'error' => true,
                    'mensaje' => $e->getMessage(),
                ])
            );
        }
        return $respuesta;
    }
    
    public static function readUsuario(
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
                    'error' => false,
                    'usuario' => $consulta->fetch(\PDO::FETCH_OBJ),
                ])
            );
        } catch (\PDOException $e) {
            /* En caso de error enviamos el mensaje */
            $body->write(
                json_encode([
                    'error' => true,
                    'mensaje' => $e->getMessage(),
                ])
            );
        }
        return $respuesta;
    }
    
    public static function updateUsuario(
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
                'UPDATE usuario SET usuario = :usuario, nombre = :nombre, apellidos = :apellidos WHERE id = :id'
            );
            $consulta->bindValue(':id', $argumentos['id'], \PDO::PARAM_INT);
            $consulta->bindValue(':nombre', $argumentos['id'], \PDO::PARAM_INT);
            $consulta->bindValue(':id', $argumentos['id'], \PDO::PARAM_INT);
            //$consulta->execute();
            $body->write(
                json_encode([
                    'error' => true,
                    'mensaje' => var_export($peticion->getParsedBody(), true),
                ])
            );
            /*$body->write(
                json_encode([
                    'error' => false,
                    'usuario' => $consulta->fetch(\PDO::FETCH_OBJ),
                ])
            );*/
        } catch (\PDOException $e) {
            /* En caso de error enviamos el mensaje */
            $body->write(
                json_encode([
                    'error' => true,
                    'mensaje' => $e->getMessage(),
                ])
            );
        }
        return $respuesta;
    }
    
    public static function deleteUsuario(
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
                    'error' => false,
                    'borrados' => $consulta->rowCount(),
                ])
            );
        } catch (\PDOException $e) {
            /* En caso de error enviamos el mensaje */
            $body->write(
                json_encode([
                    'error' => true,
                    'mensaje' => $e->getMessage(),
                ])
            );
        }
        return $respuesta;
    }
}
