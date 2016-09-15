
<?php
require('../../../templates/Clases/Conectar.php');
$dbi = new Conectar();
$c = $dbi->conexion();
if (isset($_POST["texto"])) {
    if ($_POST["texto"])
    $B_BUSCAR = "SELECT t_grupo_cod_grupo FROM t_cuenta where cod_cuenta='" . $_POST["texto"] . "' ";
    $rnom = mysqli_query($c,$B_BUSCAR) or die(mysqli_errno($c));
    $f = mysqli_fetch_array($rnom);
    $dato = $f['t_grupo_cod_grupo'];
    $nomcuenta = $dato;
    echo $nomcuenta;
}mysqli_close($c);
?>