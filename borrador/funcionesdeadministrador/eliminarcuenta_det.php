<?php
require('../../Clases/cliente.class.php');

$idt_cuenta=$_GET['cod_cuenta'];
$objGrupo=new Clase;
if( $objGrupo->eliminarcuenta($idt_cuenta) == true){
        echo '<script language = javascript>
alert("Registro eliminado correctamente")
self.location = "plancuen_detalle.php"
</script>';
}else{
        echo '<script language = javascript>
alert("Ocurrio un error")
self.location = "plancuen_detalle.php"
</script>';
}
?>