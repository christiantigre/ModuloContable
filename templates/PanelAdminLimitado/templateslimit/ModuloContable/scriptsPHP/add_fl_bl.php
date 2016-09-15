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
$user = $_SESSION['username'];
if (mysqli_connect_errno()) {
    echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
    exit();
}
$deb = $_GET['deb'];
$hab = $_GET['hab'];
unset($success, $fail);
$date = $_GET['datetimepickert'];
list($year,$month,$dia) = explode("-",$date);
 $dia; // Imprime 12
 $month; // Imprime 01
 $year; // Imprime 2005
if ($month == '01') {
    $month = "Enero";
}elseif ($month == "02") {
    $month = "Febrero";
}elseif ($month == "03") {
    $month = "Marzo";
}elseif ($month == "04") {
    $month = "Abril";
}elseif ($month == "05") {
    $month = "Mayo";
}elseif ($month == "06") {
    $month = "Junio";
}elseif ($month == "07") {
    $month = "Julio";
}elseif ($month == "08") {
    $month = "Agosto";
}elseif ($month == "09") {
    $month = "Septiembre";
}elseif ($month == "10") {
    $month = "Octubre";
}elseif ($month == "11") {
    $month = "Noviembre";
}elseif ($month == "12") {
    $month = "Diciembre";
}
$num_bl=$_GET['balances_realizadost'];
$asiento_num=$_GET['asiento_numt'];

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($con, $consulta) or trigger_error("Query Failed! SQL: $query - Error: ". mysqli_error($mysqli), E_USER_ERROR);
if($result) {
	while($row = mysqli_fetch_assoc($result)) {	
            $maxbalancedato = $row['id'];
	}
}
$consultacontador = "SELECT count( * )+1 as id FROM `t_ejercicio`";
$resultcont = mysqli_query($con, $consultacontador) or trigger_error("Query Failed! SQL: $consultacontador - Error: " . mysqli_error($con), E_USER_ERROR);
if ($resultcont) {
    while ($rowcont = mysqli_fetch_assoc($resultcont)) {
        $incremento = $rowcont['id'];
    }
}

mysqli_query($con, "INSERT INTO `condata`.`t_ejercicio` (`idt_corrientes` ,`ejercicio` ,`cod_cuenta` ,`cuenta` ,
    `fecha` ,`valor` ,`valorp` ,`t_bl_inicial_idt_bl_inicial` ,
`tipo` ,`logeo_idlogeo` ,`mes`,year 
)VALUES ('" . $incremento . "' ,
'" . $_GET['asiento_numt'] . "', 
'" . $_GET['cod_cuentat'] . "',
'" . $_GET['nom_cuentat'] . "', 
'" . $date . "',
'" . $deb . "', 
'" . $hab . "',
'" . $_GET['balances_realizadost'] . "',
'" . $_GET['cod_grupot'] . "', 
'" . $_GET['idlogt'] . "',
'" . $month . "',
'" . $year . "'    
);");

mysqli_query($con, "INSERT INTO `temp_up`(`id_new`) VALUES ('".$incremento."');");

include '../../../Clases/guardahistorialsecretaria.php';
    $accion=" / MODIFICACIÓN ASIENTOS / MODIFICO ASIENTO ".$_GET['asiento_numt'];
    generaLogs($user, $accion);

if (mysqli_connect_errno()) {
    print_r("insert failed :", mysqli_error($con));
} else {
    print_r("Guardado con exito...");
}

mysqli_close($con);
?>