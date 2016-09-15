
<?php
require('../../../../../templates/Clases/Conectar.php');
$dbi = new Conectar();
$c = $dbi->conexion();
if (isset($_POST["texto"])) {

    if ($_POST["texto"])
    $B_BUSCAR = "SELECT c.nombre_grupo AS ng FROM t_subcuenta s JOIN t_grupo c WHERE s.t_grupo_cod_grupo = c.cod_grupo AND s.cod_subcuenta = '" . $_POST["texto"] . "' ";
    $rnom = mysqli_query($c,$B_BUSCAR) or die(mysqli_errno($c));
    $f = mysqli_fetch_array($rnom);
    $dato = $f['ng'];
    $nomcuenta = $dato;
    echo $nomcuenta;
}mysqli_close($c);
?>