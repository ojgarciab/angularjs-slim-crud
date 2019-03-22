/* global angular:false, $:false */
/* eslint-env browser */

/*************** NOMBRES Y APELLIDOS ***************/
var generadorNombres = (function() {
  var nombres = {
    total: [],
    informacion: 0
  }, apellidos = {
    total: [],
    informacion: 0
  }, exterior = {};
  /* TODO: Por rendimiento debería ordenarse de mayor a menor frecuencia */
  $.get("datos/nombres.txt")
    .done(function(datos) {
      nombres = tratar(datos);
    });
  /* Ordenado de mayor a menor frecuencia */
  $.get("datos/apellidos.txt")
    .done(function(datos) {
      apellidos = tratar(datos);
    });
  function tratar(datos) {
    var informacion = [], acumulado = 0;
    datos = datos.split("\n");
    for (let dato of datos) {
      var elemento = dato.split("\t");
      var numero = parseInt(elemento[1], 10);
      acumulado += numero;
      informacion.push({
        texto: convertirNombre(elemento[0]),
        numero,
        acumulado,
      });
    }
    return {
      total: acumulado,
      informacion: informacion
    };
  }
  exterior.obtenerNombre = function() {
    if (nombres.total > 0) {
      var umbral =  Math.floor(Math.random() * nombres.total);
      var elegido = buscar(nombres.informacion, umbral);
      return elegido;
    } else {
      return "?";
    }
  };
  exterior.obtenerApellido = function() {
    if (apellidos.total > 0) {
      var umbral =  Math.floor(Math.random() * apellidos.total);
      var elegido = buscar(apellidos.informacion, umbral);
      return elegido;
    } else {
      return "?";
    }
  };
  function buscar(datos, umbral) {
    for (let dato of datos) {
      if (umbral < dato.acumulado) {
        return dato.texto;
      }
    }
  }
  return exterior;
}());

/********** CONTROLADORES **********/

/* Controlador para el listado de usuarios */
function ControladorListado($scope, $http, $location) {
  /* Carga de datos en el controlador */
  $scope.cargar = function() {
    $http.get("usuarios").success(function(datos) {
      /* En caso de producirse un error en el motor PHP, mostramos el mensaje de error */
      if (datos.error === true) {
        Popup.mostrar(datos.mensaje, "danger");
      } else {
        /* En caso contrario actualizamos los datos de la vista con los obtenidos */
        $scope.usuarios = datos.usuarios;
      }
    });
  };
  /* Control interno para borrar un usuario */
  $scope.borrar = function(usuario) {
    borrarUsuario($scope, $http, $location, usuario);
    /* Buscamos el elemento para borrarlo de la vista */
    for (var actual in $scope.usuarios) {
      if ($scope.usuarios[actual].id == usuario.id) {
        $scope.usuarios.splice(actual, 1);
      }
    }
  };
  /* Función de ordenado de columnas */
  $scope.columna = "usuario";
  $scope.orden = true;
  $scope.ordenar = function(columna) {
    $scope.orden = ($scope.columna === columna) ? !$scope.orden : false;
    $scope.columna = columna;
  };
  /* Cargamos el listado de usuarios */
  $scope.cargar();
}

/* Controlador para editar usuarios */
function ControladorEditar($scope, $http, $location, $routeParams) {
  var id = $routeParams.id;
  /* Solicitamos al motor el usuario por su "id" mediante GET */
  $http.get("usuarios/" + id).success(function(datos) {
    /* En caso de producirse un error en el motor PHP, mostramos el mensaje de error */
    if (datos.error === true) {
      Popup.mostrar(datos.mensaje, "danger");
    } else {
      /* En caso contrario rellenamos los datos del formulario con los recibidos */
      $scope.usuario = datos.usuario;
    }
  });
  /* Control para borrar un usuario */
  $scope.borrar = function(id) {
    borrarUsuario($scope, $http, $location, id);
  };
  /* Control para actualizar los datos */
  $scope.actualizar = function(usuario) {
    actualizarUsuario($scope, $http, $location, usuario, id);
  };
  /* Hacemos uso de las funciones de nombres y apellidos para generar uno aleatorio */
  $scope.aleatorio = function() {
    $scope.usuario.nombre = generadorNombres.obtenerNombre();
    $scope.usuario.apellidos = generadorNombres.obtenerApellido() + " " + generadorNombres.obtenerApellido();
    $scope.usuario.usuario = $scope.usuario.nombre + " " + $scope.usuario.apellidos;
  }
}

/* Controlador para agregar usuarios */
function ControladorAgregar($scope, $http, $location, $routeParams) {
  /* Mostramos mensaje de edición */
  $scope.usuario = {
    usuario: "",
    nombre: "",
    apellidos: ""
  }
  /* Control para borrar un usuario */
  $scope.borrar = function(id) {
    /* No hacemos nada, sólo salir */
    $scope.activePath = $location.path("/");
  };
  /* Control para actualizar los datos */
  $scope.agregar = function(usuario, id) {
    agregarUsuario($scope, $http, $location, usuario);
  };
  $scope.aleatorio = function() {
    $scope.usuario.nombre = generadorNombres.obtenerNombre();
    $scope.usuario.apellidos = generadorNombres.obtenerApellido() + " " + generadorNombres.obtenerApellido();
    $scope.usuario.usuario = $scope.usuario.nombre + " " + $scope.usuario.apellidos;
  }
}


/************ UTILIDADES ************/

/* Función para borrar el usuario cuando se pulse el botón adecuado */
function borrarUsuario($scope, $http, $location, usuario) {
  var deleteUser = window.confirm("¿Estás seguro de querer borrar el usuario?");
  if (deleteUser) {
    $http.delete("usuarios/" + usuario.id);
    $location.path("/");
  }
}

/* Función para actualizar un usuario dado su id */
function actualizarUsuario($scope, $http, $location, usuario, id){
  $http.put("usuarios/" + id, usuario).success(function(datos) {
    if (datos.error === true) {
      Popup.mostrar(datos.mensaje, "danger");
    } else {
      Popup.mostrar(datos.mensaje, "success");
      $scope.activePath = $location.path("/").replace().notify(false);
    }
  });
}

function agregarUsuario($scope, $http, $location, usuario){
  $http.put("usuarios", usuario).success(function(datos) {
    if (datos.error === true) {
      Popup.mostrar(datos.mensaje, "danger");
    } else {
      Popup.mostrar(datos.mensaje, "success");
      $scope.activePath = $location.path("/");
    }
  });
}

/* Función para generar palabras capitales */
function convertirNombre(nombre) {
    return nombre.replace(/\w\S*/g, function(palabra) {
      return palabra.charAt(0).toUpperCase() + palabra.substr(1).toLowerCase();
    });
}

/***************** POPUP *****************/
var Popup = (function() {
    "use strict";
    var elemento,
        que = {};
    que.configurar = function(opciones) {
        elemento = $(opciones.selector);
    };
    que.mostrar = function(texto, clase) {
        elemento.find("span").html(texto);
        elemento.attr("class", "alert alert-" + clase);
        elemento.delay(200).fadeIn().delay(4000).fadeOut();
    };
    return que;
}());

Popup.configurar({
  "selector": "#alertas"
});

/* Creamos las rutas de nuestra aplicación y sus controladores */
angular.module("SlimCrudApp", ["ngRoute"]).
  config(["$routeProvider", function($routeProvider) {
  $routeProvider.
      when("/", {templateUrl: "plantillas/listado.html", controller: ControladorListado}).
      when("/editar/:id", {templateUrl: "plantillas/editar.html", controller: ControladorEditar}).
      when("/agregar", {templateUrl: "plantillas/agregar.html", controller: ControladorAgregar}).
      otherwise({redirectTo: "/"});
}]);

