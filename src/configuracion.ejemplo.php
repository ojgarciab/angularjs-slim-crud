<?php

/* Hacer una copia de este archivo a configuracion.php para que se use */

self::$configuracion = array_merge(
    self::$configuracion,
    [
        'dsn'      => 'mysql:host=localhost;dbname=asc;charset=utf8',
        'usuario'  => 'root',
        'clave'    => '',
        'opciones' => [
        ],
    ]
);
