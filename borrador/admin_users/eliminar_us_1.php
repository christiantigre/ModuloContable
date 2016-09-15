<?php
require('../../Clases/cliente.class.php');

$idt_grupo=$_GET['idusuario'];
$objGrupo=new Clase;
if( $objGrupo->eliminarusuario($idusuario) == true){
        echo '<script language = javascript>
alert("Registro eliminado correctamente")
self.location = "panel_reg_user.php"
</script>';
}else{
        echo '<script language = javascript>
alert("Ocurrio un error")
self.location = "panel_reg_user.php"
</script>';
}
?>