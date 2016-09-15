
<?php

require('../../../../../../templates/Clases/Conectar.php');
$dbi = new Conectar();
$c = $dbi->conexion();
if (isset($_POST["texto"])) {

    if ($_POST["texto"])
    $B_BUSCAR = "SELECT g.nombre_grupo as ng FROM t_cuenta c join t_grupo g where c.`t_grupo_cod_grupo` = g.cod_grupo and c.cod_cuenta='" . $_POST["texto"] . "' ";
    $rnom = mysqli_query($c,$B_BUSCAR) or die(mysqli_errno($c));
    $f = mysqli_fetch_array($rnom);
    $dato = $f['ng'];
    $nomcuenta = $dato;
    echo $nomcuenta;
}
mysqli_close($c);
?>