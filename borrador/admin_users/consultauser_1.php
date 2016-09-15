<?php

if (isset($_POST["texto"])) {
    if ($_POST["texto"])
        require '../../Clases/Conectar.php';
    $dbi = new Conectar();
$c = $dbi->conexion();
    $B_BUSCAR = "SELECT username FROM `logeo` WHERE username='".$_POST['texto']."'";
    $rnom = mysqli_query($c,$B_BUSCAR);
    if (mysqli_num_rows($rnom) > 0) {   
        echo 'Error!!!';
} else {
    echo $_POST['texto'];
}
mysqli_close($c);
}
?>