
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
include '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
if ((isset($_POST["texto"])) && (isset($_POST["campo"])) ) {
    if ($_POST["texto"])
    if ($_POST["campo"])
    $B_BUSCAR = "SELECT * FROM `t_plan_de_cuentas` WHERE ".$_POST["campo"]."= '".$_POST["texto"]."' ";
    $rnom = mysqli_query($c,$B_BUSCAR);
    $f = mysqli_fetch_array($rnom);    
        if ($f == 0) {
            echo 'Codigo incorrecto...';
        } else {
            $dato = $f['nombre_cuenta_plan'];
            $dato2 = $f['cod_cuenta'];
            $dato3 = $f['t_grupo_cod_grupo'];
            $valores = $dato."_".$dato2."_".$dato3;
            echo utf8_decode($valores);
        }
    }
    mysqli_close($c);
?>