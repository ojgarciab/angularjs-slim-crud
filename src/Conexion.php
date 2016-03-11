<?php
namespace miPDO;

/* Factoría singleton para conexiones PDO */
class Conexion
{
    private static $configuracion = [
        'dsn' => 'mysql:host=localhost;dbname=asc;charset=utf8',
        'usuario' => 'root',
        'clave' => '',
        'opciones' => array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ),
    ];
    private static $conexion = false;

    public static function obtenerPDO()
    {
        if (self::$conexion === false) {
            self::$conexion = new \PDO(
                self::$configuracion['dsn'],
                self::$configuracion['usuario'],
                self::$configuracion['clave'],
                self::$configuracion['opciones']
            );
            self::$conexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$conexion;
    }
}
