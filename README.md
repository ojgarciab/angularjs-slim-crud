# angularjs-slim-crud

## Introducción
Crear, Leer, Actualizar y Borrar (CLAB o ABM en castellano, CRUD en inglés) usando Angujar.js como interfaz (frontend) y PHP(Slim)/MySQL como motor (backend).

## Instalación
Para probar la aplicación deben seguirse los siguientes pasos:

* Descargar e instalar composer: https://getcomposer.org/download/
* Instalar dependencias: `php composer.phar update`
* Importar datos a la base de datos:
    * Crear la estructura de la tabla: `mysql -u<usuario> -p <base de datos> < sql.esquema.txt`
    * (Opcional) Importar datos de prueba: `mysql -u<usuario> -p <base de datos> < sql.datos.txt`
