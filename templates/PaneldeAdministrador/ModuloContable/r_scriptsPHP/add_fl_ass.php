<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor CHRISTIAN.
 */
require '../../../../templates/Clases/Conectar.php';
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
    $month2 = '01';
    $month = "Enero";
}elseif ($month == "02") {
    $month2 = '02';
    $month = "Febrero";
}elseif ($month == "03") {
    $month2 = '03';
    $month = "Marzo";
}elseif ($month == "04") {
    $month2 = '04';
    $month = "Abril";
}elseif ($month == "05") {
    $month2 = '05';
    $month = "Mayo";
}elseif ($month == "06") {
    $month2 = '06';
    $month = "Junio";
}elseif ($month == "07") {
    $month2 = '07';
    $month = "Julio";
}elseif ($month == "08") {
    $month2 = '08';
    $month = "Agosto";
}elseif ($month == "09") {
    $month2 = '09';
    $month = "Septiembre";
}elseif ($month == "10") {
    $month2 = '10';
    $month = "Octubre";
}elseif ($month == "11") {
    $month2 = '11';
    $month = "Noviembre";
}elseif ($month == "12") {
    $month2 = '12';
    $month = "Diciembre";
}
$date2 = $year.'-'.$month2.'-'.$dia;
$num_bl=$_GET['balances_realizadost'];
$asiento_num=$_GET['asiento_numt'];

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($con, $consulta) or trigger_error("Query Failed! SQL: $query - Error: ". mysqli_error($mysqli), E_USER_ERROR);
if($result) {
	while($row = mysqli_fetch_assoc($result)) {	
            $maxbalancedato = $row['id'];
	}
}
$consultacontador = "SELECT count( * )+1 as id FROM `libro`";
$resultcont = mysqli_query($con, $consultacontador) or trigger_error("Query Failed! SQL: $consultacontador - Error: " . mysqli_error($con), E_USER_ERROR);
if ($resultcont) {
    while ($rowcont = mysqli_fetch_assoc($resultcont)) {
        $incremento = $rowcont['id'];
    }
}

mysqli_query($con, "INSERT INTO `condata`.`libro` (
`idlibro` ,`fecha` ,`asiento` ,`ref` ,`cuenta` ,`debe` ,`haber` ,
`t_bl_inicial_idt_bl_inicial` ,`t_cuenta_idt_cuenta` ,`logeo_idlogeo` ,`grupo` ,`mes` ,
`year`
)
VALUES ('".$incremento."',
'".$date2."','".$_GET['asiento_numt']."',
'".$_GET['cod_cuentat']."',
'".$_GET['nom_cuentat']."',
'".$deb."',
'".$hab."',
'".$_GET['balances_realizadost']."',
'".$_GET['cod_grupot']."',
'".$_GET['idlogt']."',
'".$_GET['cod_grupot']."',
'".$month."',
'".$year."'
);");



//include '../../../Clases/guardahistorialsecretaria.php';
//    $accion=" / MODIFICACIÓN ASIENTOS / MODIFICO ASIENTO ".$_GET['asiento_numt'];
//    generaLogs($user, $accion);

if (mysqli_connect_errno()) {
    print_r("insert failed :", mysqli_error($con));
} else {
    print_r("Guardado con exito...");
}

mysqli_close($con);
?>