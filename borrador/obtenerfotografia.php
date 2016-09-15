<?php
require('Conectar.php');
$dbi = new Conectar();
$c = $dbi->conexion();
if ($_GET['keyimg'] > 0){
    $consulta = "SELECT logo, tipo FROM empresa WHERE idempresa='".$_GET['keyimg']."'";
    $resultado = mysqli_query($c,$consulta) or die(mysqli_errno($c));
    $datos = mysqli_fetch_assoc($resultado); 
    $imagen = $datos['logo']; 
    $tipo = $datos['tipo'];  
    header("Content-type: $tipo");
    echo $imagen;
}
?>