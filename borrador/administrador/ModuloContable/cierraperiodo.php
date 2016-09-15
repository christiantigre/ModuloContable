<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor CHRISTIAN.
 */
if (isset($_POST["texto"])) {
    if ($_POST["texto"])
        session_start();
    $user = $_SESSION['username'];
    require '../../../../templates/Clases/Conectar.php';
    $dbi = new Conectar();
    $c = $dbi->conexion();
    if (mysqli_connect_errno()) {
        echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
        exit();
    }
    $date = date("Y-m-j");
    $mes = date('F');
    $year = date("Y");
    $actualizaestado = "update t_bl_inicial set estado='0' where year='" . $year . "' and estado ='" . $_POST["texto"] . "' ";
    if ($c->query($actualizaestado) === TRUE) {
        echo "Periodo " . $year . " cerrado con exito...";
    } else {
        echo "Error updating record: " . $c->error;
    }
    include '../../Clases/guardahistorial.php';
    $accion = "Periodo cerrado " . $year;
    generaLogs($user, $accion);
    mysqli_close($c);
}
?>