/* Creamos las rutas de nuestra aplicación y sus controladores */
angular.module('SlimCrudApp', []).
  config(['$routeProvider', function($routeProvider) {
  $routeProvider.
      when('/', {templateUrl: 'plantillas/listado.html', controller: ControladorListado}).
      when('/editar/:id', {templateUrl: 'plantillas/editar.html', controller: ControladorEditar}).
      otherwise({redirectTo: '/'});
}]);

/********** CONTROLADORES **********/

/* Controlador para el listado de usuarios */
function ControladorListado($scope, $http, $location) {
  /* Carga de datos en el controlador */
  $scope.cargar = function() {
    $http.get('usuarios').success(function(datos) {
      if (datos.error == true) {
        Popup.mostrar(datos.mensaje, 'danger');
      } else {
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
  $scope.columna = 'usuario';
  $scope.orden = true;
  $scope.ordenar = function(columna) {
    $scope.orden = ($scope.columna === columna) ? !$scope.orden : false;
    $scope.columna = columna;
  };
  /* Cargamos el listado de usuarios */
  $scope.cargar();
}

/* Controlador para el listado de usuarios */
function ControladorEditar($scope, $http, $location, $routeParams) {
  var id = $routeParams.id;
  $http.get('usuarios/' + id).success(function(datos) {
    if (datos.error == true) {
      Popup.mostrar(datos.mensaje, 'danger');
    } else {
      $scope.usuario = datos.usuario;
    }
  });
  
  /* Control para borrar un usuario */
  $scope.borrar = function(id) {
    borrarUsuario($scope, $http, $location, id);
  };
  /* Control para actualizar los datos */
  $scope.actualizar = function(usuario, id) {
    actualizarUsuario($scope, $http, $location, usuario, id);
  };
  $scope.aleatorio = function() {
    //obtenerNombre($scope, )
  }
}

/************ UTILIDADES ************/

/* Función para borrar el usuario cuando se pulse el botón adecuado */
function borrarUsuario($scope, $http, $location, usuario) {
  console.log(usuario);

  var deleteUser = confirm('¿Estás seguro de querer borrar el usuario?');
  if (deleteUser) {
    $http.delete('usuarios/' + usuario.id);
    $location.path('/');
  }
}

function actualizarUsuario($scope, $http, $location, usuario, id){
  $http.put('/usuarios/' + id, usuario).success(function(data) {
    $scope.users = data;
    $scope.activePath = $location.path('/');
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
        elemento.attr('class', "alert alert-" + clase);
        elemento.delay(200).fadeIn().delay(4000).fadeOut();
    };
    return que;
}());

Popup.configurar({
  "selector": "#alertas"
});

/*************** NOMBRES Y APELLIDOS ***************/
$.get('https://raw.githubusercontent.com/ojgarciab/Randomuser.me-Source/master/nats/ES/lists/male_first.txt')
  .done(function(datos) {
    datos = datos.split("\n");
    for (var dato in datos) {
      datos[dato] = convertirNombre(datos[dato]);
    }
    console.log(datos);
  });
