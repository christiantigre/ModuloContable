<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor CHRISTIAN.
 */
require '../../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$con = $dbi->conexion();


$sql_contador = "SELECT count(*) as c FROM `temp_up`";
$resultcont = mysqli_query($con, $sql_contador) or trigger_error("Query Failed! SQL: $sql_contador - Error: " . mysqli_error($con), E_USER_ERROR);
if ($resultcont) {
    while ($rowcont = mysqli_fetch_assoc($resultcont)) {
        $cantidad = $rowcont['c'];
    }
}

echo $cantidad;
// print_r("Guardado con exito...");