
<?php
require('../../../../../../templates/Clases/Conectar.php');
$dbi = new Conectar();
$c = $dbi->conexion();
if (isset($_POST["texto"])) {
    if ($_POST["texto"])
    $cod_cuenta = htmlspecialchars(trim($_POST['cod_cuenta']));
    $B_BUSCAR = "SELECT cod_subcuenta FROM t_subcuenta where cod_subcuenta='" . $_POST["texto"] . "' ";
    $rnom = mysqli_query($c,$B_BUSCAR) or die(mysqli_errno($c));
    $f = mysqli_fetch_array($rnom);
    $dato = $f['cod_subcuenta'];
    $nomcuenta = $dato;
    echo $nomcuenta;
}
mysqli_close($c);
?>