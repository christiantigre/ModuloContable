
<?php

error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
include '../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
if (isset($_POST["texto"])) {
    if ($_POST["texto"])
        $B_BUSCAR = "SELECT g.cod_grupo as grupo, g.nombre_grupo as nom
FROM `t_plan_de_cuentas` p
JOIN t_grupo g
WHERE p.`t_grupo_cod_grupo` = g.cod_grupo
AND `cod_cuenta` = '" . $_POST['texto'] . "'";
    $rnom = mysqli_query($c, $B_BUSCAR);
    $f = mysqli_fetch_array($rnom);
    if ($f == 0) {
        echo 'Error de codigo';
    } else {
        $dato = $f['grupo'];
        $dato1 = $f['nom'];
        $codcuenta = $dato;
        $nomcuenta = $dato1;
        echo $codcuenta;
    }
}
mysqli_close($c);
?>