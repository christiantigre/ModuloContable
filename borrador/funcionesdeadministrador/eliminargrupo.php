<?php
require('../../Clases/cliente.class.php');

$idt_grupo=$_GET['cod_grupo'];
$objGrupo=new Clase;
if( $objGrupo->eliminargrupo($idt_grupo) == true){
        echo '<script language = javascript>
alert("Registro eliminado correctamente")
self.location = "plangrupos.php"
</script>';
}else{
        echo '<script language = javascript>
alert("Ocurrio un error")
self.location = "plangrupos.php"
</script>';
}
?>