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
    $http.get('usuarios').success(function(usuarios) {
      $scope.usuarios = usuarios;
    });
  };
  /* Control interno para borrar un usuario */
  $scope.borrar = function(usuario) {
    borrarUsuario($scope, $http, $location, usuario);
    $scope.cargar();
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
  $scope.activePath = null;
  $http.get('usuarios/' + id).success(function(usuario) {
    $scope.usuario = usuario;
  });
  /* Control para borrar un usuario */
  $scope.borrar = function(id) {
    borrarUsuario($scope, $http, $location, id);
  };
  /* Control para actualizar los datos */
  $scope.actualizar = function(usuario, id) {
    actualizarUsuario($scope, $http, $location, usuario, id);
  };

}

/************ UTILIDADES ************/

/* Función para borrar el usuario cuando se pulse el botón adecuado */
function borrarUsuario($scope, $http, $location, usuario) {
  console.log(usuario);

  var deleteUser = confirm('Are you absolutely sure you want to delete?');
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
