<?php
require('../../Clases/cliente.class.php');

$idt_grupo=$_GET['cod_user'];
$objGrupo=new Clase;
if( $objGrupo->eliminarcategoria($cod_user) == true){
        echo '<script language = javascript>
alert("Registro eliminado correctamente")
self.location = "panel_users.php"
</script>';
}else{
        echo '<script language = javascript>
alert("Ocurrio un error")
self.location = "panel_users.php"
</script>';
}
?>