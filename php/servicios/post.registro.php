<?php
// Incluir el archivo de base de datos
include_once("../clases/class.Database.php");

//clases para enviar mail
require("../clases/class.phpmailer.php");
require("../clases/class.smtp.php");

$postdata = file_get_contents("php://input");

$request   = json_decode($postdata);
$request   = (array) $request;
$documento = $request['dni'];
$correo    = $request['email'];


$cantidadDNI = Database::get_valor_query("SELECT count(*) as cuantos FROM registro WHERE dni='$documento'","cuantos");
$cantidadEmail=Database::get_valor_query("SELECT count(*) as cuantos FROM registro WHERE email='$correo'","cuantos");

if($cantidadDNI >=1){
	$respuesta = array( 'err'=>true, 'Mensaje'=>'DNI existente en el sistema');

}else if($cantidadEmail >=1){
	$respuesta = array( 'err'=>true, 'Mensaje'=>'Email existente en el sistema');
}
else{

$sql = "INSERT INTO registro(nombre, apellido, dni, email, cod, telefono, developer, consulta) VALUES ('". $request['name'] . "',
				'". $request['apellido'] . "',
				'". $request['dni'] . "',
				'". $request['email'] . "',
				'". $request['cod'] . "',
				'". $request['telefono'] . "',
				'". $request['radio'] . "',
				'". $request['comentario'] . "')";

	$hecho = Database::ejecutar_idu( $sql );

	
	if( is_numeric($hecho) OR $hecho === true ){
		$respuesta = array( 'err'=>false, 'Mensaje'=>'Registro insertado' );

		//Seccion de envio de mail de registro
		$destinatario = $request['email'];
		$smtpHost = "mail.afsa.com.ar";  // Dominio alternativo brindado en el email de alta 
		$smtpUsuario = "comunicaciones@afsa.com.ar";  // Mi cuenta de correo
		$smtpClave = "Al1s35fanl031";  // Mi contraseña

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Port = 587; 
		$mail->IsHTML(true); 
		$mail->CharSet = "utf-8";

		$mail->Host = $smtpHost; 
		$mail->Username = $smtpUsuario; 
		$mail->Password = $smtpClave;


		$mail->From = 'info@devtuc.com.ar'; // Email desde donde envío el correo.
		$mail->FromName = 'DevTuc';
		$mail->AddAddress($destinatario);

		$mail->addCC('pmarino@afsa.com.ar');


		$mail->Subject = "Registro de ".$request['name']; // Este es el titulo del email.
		$mensajeHtml = nl2br($mensaje);

		$mail->Body = "
		<html> 

		<body> 

		<h2>Gracias por registrarte! </h2>



		</body> 

		</html>

		<br />"; // Texto del email en formato HTML
		$mail->AltBody = "Registro \n\n "; // Texto sin formato HTML
		// FIN - VALORES A MODIFICAR //

		$mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);

		$estadoEnvio = $mail->Send();

		//------Fin seccion de envio de mail----------------


	}else{
		$respuesta = array( 'err'=>true, 'Mensaje'=>$hecho );
	}


}


// if( isset( $request['id'] )  ){  // ACTUALIZAR

// 	$sql = "UPDATE clientes 
// 				SET
// 					nombre    = '". $request['nombre'] ."',
// 					correo    = '". $request['correo'] ."',
// 					zip       = '". $request['zip'] ."',
// 					telefono1 = '". $request['telefono1'] ."',
// 					telefono2 = '". $request['telefono2'] ."',
// 					pais      = '". $request['pais'] ."',
// 					direccion = '". $request['direccion'] ."' 
// 			WHERE id=" . $request['id'];

// 	$hecho = Database::ejecutar_idu( $sql );

	
// 	if( is_numeric($hecho) OR $hecho === true ){
// 		$respuesta = array( 'err'=>false, 'Mensaje'=>'Registro actualizado' );
// 	}else{
// 		$respuesta = array( 'err'=>true, 'Mensaje'=>$hecho );
// 	}



// }else{  // INSERT

// 	$sql = "INSERT INTO clientes(nombre, correo, zip, telefono1, telefono2, pais, direccion) VALUES ('". $request['nombre'] . "',
// 				'". $request['correo'] . "',
// 				'". $request['zip'] . "',
// 				'". $request['telefono1'] . "',
// 				'". $request['telefono2'] . "',
// 				'". $request['pais'] . "',
// 				'". $request['direccion'] . "')";

// 	$hecho = Database::ejecutar_idu( $sql );

	
// 	if( is_numeric($hecho) OR $hecho === true ){
// 		$respuesta = array( 'err'=>false, 'Mensaje'=>'Registro insertado' );
// 	}else{
// 		$respuesta = array( 'err'=>true, 'Mensaje'=>$hecho );
// 	}

// }



echo json_encode( $respuesta );



?>