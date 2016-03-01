/* Creamos las rutas de nuestra aplicación y sus controladores */
angular.module('SlimCrudApp', []).
  config(['$routeProvider', function($routeProvider) {
  $routeProvider.
      when('/', {templateUrl: 'plantillas/listado.html', controller: ListCtrl}).
      otherwise({redirectTo: '/'});
}]);

/* Controlador para el listado de usuarios */
function ListCtrl($scope, $http) {
  $http.get('ususarios').success(function(usuarios) {
    $scope.usuarios = usuarios;
  });
}

