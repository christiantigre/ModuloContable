
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
include '../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
if (isset($_POST["texto"])) {
    if ($_POST["texto"])
    $B_BUSCAR = "SELECT nombre_cuenta_plan FROM t_plan_de_cuentas where cod_cuenta = '" . $_POST["texto"] . "' ";
    $rnom = mysqli_query($c,$B_BUSCAR);
    $f = mysqli_fetch_array($rnom);    
        if ($f == 0) {
            echo 'Codigo incorrecto...';
        } else {
            $dato = $f['nombre_cuenta_plan'];
            $nomcuenta = $dato;
            echo utf8_decode($nomcuenta);
        }
    }
    mysqli_close($c);
?>