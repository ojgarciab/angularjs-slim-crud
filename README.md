# angularjs-slim-crud

[![Build Status](https://travis-ci.org/ojgarciab/angularjs-slim-crud.svg?branch=master)](https://travis-ci.org/ojgarciab/angularjs-slim-crud)
[![StyleCI](https://github.styleci.io/repos/52858877/shield?branch=master)](https://github.styleci.io/repos/52858877)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/c1af206b55fc4433a2032222ca1da616)](https://www.codacy.com/app/ojgarciab/angularjs-slim-crud)

## Introducción
Crear, Leer, Actualizar y Borrar (CLAB o ABM en castellano, CRUD en inglés) usando Angujar.js como interfaz (frontend) y PHP(Slim)/MySQL como motor (backend).

## Instalación
Para probar la aplicación deben seguirse los siguientes pasos:

* Descargar e instalar composer: https://getcomposer.org/download/
* Instalar dependencias: `php composer.phar update`
* Importar datos a la base de datos:
    * Crear la estructura de la tabla: `mysql -u<usuario> -p <base de datos> < sql.esquema.txt`
    * (Opcional) Importar datos de prueba: `mysql -u<usuario> -p <base de datos> < sql.datos.txt`
