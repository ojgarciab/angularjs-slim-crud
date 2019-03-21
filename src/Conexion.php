<?php

namespace miPDO;

/* Factoría singleton para conexiones PDO */
class Conexion
{
    private static $configuracion = [
        'dsn'      => 'mysql:host=localhost;dbname=asc;charset=utf8',
        'usuario'  => 'root',
        'clave'    => '',
        'opciones' => [
        ],
    ];
    private static $conexion = false;

    public static function obtenerPDO()
    {
        is_file(__DIR__.'/configuracion.php') && require_once __DIR__.'/configuracion.php';
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
