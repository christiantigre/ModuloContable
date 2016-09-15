
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
if (isset($_POST["texto"])) {
    if ($_POST["texto"])
        $conb = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
    mysql_select_db("condata", $conb) or die("ERROR con la base de datos");
    $cod_cuenta = htmlspecialchars(trim($_POST['cod_cuenta']));
    $B_BUSCAR = "SELECT nombre_cuenta_plan FROM t_plan_de_cuentas where cod_cuenta = '" . $_POST["texto"] . "' ";
    $rnom = mysql_query($B_BUSCAR, $conb);
    $f = mysql_fetch_array($rnom);
    if ($f == 0) {
        echo 'No existe';
    } else {
        $dato = $f['nombre_cuenta_plan'];
        $nomcuenta = $dato;
        echo $nomcuenta;
    }
}
?>