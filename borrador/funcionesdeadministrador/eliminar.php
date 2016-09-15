<?php
require('../../Clases/cliente.class.php');

$idt_clase=$_GET['cod_clase'];
$objClase=new Clase;
if( $objClase->eliminar($cod_clase) == true){
	echo "Registro eliminado correctamente";
}else{
	echo "Ocurrio un error";
}
?>