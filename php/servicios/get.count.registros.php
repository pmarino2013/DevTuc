<?php
// Incluir el archivo de base de datos
include_once("../clases/class.Database.php");

$total=Database::get_valor_query("SELECT count(*) as cuantos FROM registro","cuantos");

if($total >= 25){
    $respuesta = array('err' => true,'mensaje'=> 'Se alcanzó el cupo máximo' );
}else{
    $respuesta = array('err' => false,'mensaje'=> 'Todavía hay lugar' );
}


echo json_encode( $respuesta );


?>