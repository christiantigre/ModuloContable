<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
if ($_SESSION['loginu']) {
    $hora = str_pad(date("Y-m-d H:i:s"), 20, " ");
    $usuario = $_SESSION['loginu'];
    $accion = "---/ CERRO SESSION  /---";
    $cadena = $hora . strtoupper($usuario) . $accion;
    $pre = "";
    $date = date("j-m-Y");
    $fileName = $pre . $date;
    $f = fopen("../../hss/$fileName", "a");
    fputs($f, $cadena . "\r\n") or die("Historial panel...No se pudo crear o insertar el fichero");
    fclose($f);
    session_unset();
    session_destroy();
    $_SESSION['loginu']='';
    $_SESSION['username']='';
    $_SESSION['id_user']='';
    echo '<script language = javascript>
	alert("Sessión Finalizada")
	self.location = "../../login.php"
	</script>';
} else {
    echo '<script language = javascript>
	alert("No ha iniciado ninguna sesi�n, por favor reg�strese")
	self.location = "../../login.php"
	</script>';

    include '../PanelAdminLimitado/Clases/guardahistorial.php';
    $accion = "Error al Finalizar Sesion";
    generaLogs($_SESSION['loginu'], $accion);
}
?>




<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Documento sin t&iacute;tulo</title>
    </head>

    <body>
    </body>
</html>
