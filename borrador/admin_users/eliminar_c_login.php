<?php
require('../../Clases/cliente.class.php');

$idt_grupo=$_GET['idlogin'];
$objGrupo=new Clase;
if( $objGrupo->eliminar_c_login($idlogeo) == true){
        echo "Registro eliminado correctamente";
}else{
        echo "Ocurrio un error";
}
?>