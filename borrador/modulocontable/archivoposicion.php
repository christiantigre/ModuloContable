<?php
if (isset($_POST["texto"])) {
    if ($_POST["texto"])
        $conb = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
    mysql_select_db("condata", $conb) or die("ERROR con la base de datos");
    $B_BUSCAR = "SELECT `nombre_cuenta_plan`
FROM `t_plan_de_cuentas`
WHERE `t_grupo_cod_grupo` = '".$_POST["texto"]."'
OR `t_cuenta_cod_cuenta` = '".$_POST["texto"]."'
OR `t_subcuenta_cod_subcuenta` = '".$_POST["texto"]."'
GROUP BY `nombre_cuenta_plan`";
    $rnom = mysql_query($B_BUSCAR, $conb) or die(mysql_error());
    $f = mysql_fetch_array($rnom);
    $dato = $f['nombre_cuenta_plan'];
    $nomcuenta = $dato;
    echo $nomcuenta;
}
?>