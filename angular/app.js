var app = angular.module( 'devtucApp',['ngRoute', 'jcs-autoValidate','DevtucApp.Formulario','ui.mask']);

angular.module('jcs-autoValidate')
.run([
    'defaultErrorMessageResolver',
    function (defaultErrorMessageResolver) {
        // To change the root resource file path
        defaultErrorMessageResolver.setI18nFileRootPath('angular/lib');
        defaultErrorMessageResolver.setCulture('es-co');

       
    }
]);


app.controller('mainCtrl', ['$scope','Formulario', function($scope, Formulario){
	
	$scope.menuPrincipal="templates/menu.html";
	$scope.cargando=false;
	$scope.botonDisabled=false;

	$scope.dato={
		radio:'Si'
	}

	//console.log($scope.cargando);
	$scope.guardarForm=function(dato,FrmRegistro){
		$scope.cargando=true;
	
		Formulario.guardar(dato).then(function(){

			if(Formulario.datos.err){
				
				swal({
					  title: "Fallo!",
					  text: Formulario.datos.Mensaje,
					  type: "error",
					  allowEscapeKey: false,
					  allowOutsideClick: false
					});
					$scope.cargando=false;

				
			}else{
				
				
				swal({
					  title: "Registrad@!",
					  text: "Gracias por registrarte!",
					  type: "success",
					  allowEscapeKey: false,
					  allowOutsideClick: false
					});

					
						$scope.dato={
						radio:'Si'
						};
						$scope.cargando=false;
						FrmRegistro.autoValidateFormOptions.resetForm();
					
							
				
			}
			
		})

	}



}]);
