app.config([ '$routeProvider', function($routeProvider){

	$routeProvider
		.when('/',{
			templateUrl: 'templates/home.html'
			// controller: 'dashboardCtrl'
		})
		.when('/form',{
			templateUrl: 'templates/formulario.html'
			// controller: 'formularioCtrl'
		})
		
		.otherwise({
			redirectTo: '/'
		})

}]);