
<?php
require('../../../templates/Clases/Conectar.php');
$dbi = new Conectar();
$c = $dbi->conexion();
if (isset($_POST["texto"])) {
    if ($_POST["texto"])
    $B_BUSCAR = "SELECT nombre_cauxiliar FROM t_auxiliar where cod_cauxiliar='" . $_POST["texto"] . "' ";
    $rnom = mysqli_query($c,$B_BUSCAR) or die(mysqli_errno($c));
    $f = mysqli_fetch_array($rnom);
    $dato = $f['nombre_cauxiliar'];
    $nomcuenta = $dato;
    echo $nomcuenta;
}mysqli_close($c);
?>