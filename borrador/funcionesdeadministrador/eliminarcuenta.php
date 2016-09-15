<?php
require('../../Clases/cliente.class.php');

$idt_cuenta=$_GET['cod_clase'];
$objCuenta=new Clase;
if( $objCuenta->eliminarclase($idt_cuenta) == true){
	echo "Registro eliminado correctamente";
}else{
	echo "Ocurrio un error";
}
?>