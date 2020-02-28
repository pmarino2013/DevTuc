
var app = angular.module('DevtucApp.Formulario', []);

app.factory('Formulario', ['$http','$q', function($http, $q){
		var self={
			'cargando':false,
			'datos':[],
			guardar:function(dato){
				var d = $q.defer();
				self.cargando=true;

				$http.post('php/servicios/post.registro.php', dato)
				.then(function(data){

					self.datos=data.data;
					self.cargando=false;
					d.resolve();
					
					//console.log(self.datos);
				})

				
		

				return d.promise;
				}


			}



		return self;
}])
