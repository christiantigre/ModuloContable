<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
require '../Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
if ($c === false) {
    die("ERROR: No se estableció la conexión. " . mysqli_connect_error());
}
if (!isset($_SESSION)) {
    session_start();
}
$usuario = $_POST['loginu'];
$contrasena = $_POST['clave'];
$consulta = "SELECT l.password as password,l.username as username,l.user_tipo_iduser_tipo as tipo
    ,ut.tipo_user as tipousuario
FROM logeo l
JOIN user_tipo ut
WHERE username='" . $usuario . "' AND password='" . $contrasena . "' AND l.`user_tipo_iduser_tipo` = ut.iduser_tipo";
$resultado =  mysqli_query($c, $consulta) or die(mysqli_error($c));
$fila = mysqli_fetch_array($resultado);
    include '../PanelAdminLimitado/Clases/guardahistorial.php';
    if (!$fila[0]) {
    echo '<script language = javascript>
	alert("Usuario o Password errados, por favor verifique.")
	self.location = "../../login.php"
	</script>';
    $accion="Error al iniciar sesion";
    generaLogs($usuario, $accion);
} else {
    $_SESSION['username'] = $fila['username'];
    $tipo = $fila['tipo'];
    //$_SESSION['password'] = $fila['password'];
    if ($tipo == "1") {
        header("Location: ../../index.php");        
    $accion="Inicio de sesion";
    generaLogs($usuario, $accion);
    } elseif ($tipo == "2") {
        header("Location: ../PanelAdminLimitado/index_admin.php");        
    $accion="Inicio de sesion";
    generaLogs($usuario, $accion);
    }elseif ($tipo == "3") {
        header("Location: ../PanelAdminLimitado/templateslimit/ModuloContable/secretaria/index_modulo_contable.php");        
    $accion="Inicio de sesion";
    generaLogs($usuario, $accion);
    }  else {
        echo '<script language = javascript>
	alert("Lo sentimos, actualmente en desarrollo")
	self.location = "../../login.php"
	</script>';   
    }
}
mysqli_close($c);
?>