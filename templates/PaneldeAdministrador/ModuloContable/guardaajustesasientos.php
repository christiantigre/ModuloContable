<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor CHRISTIAN.
 */
session_start();
require '../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$con = $dbi->conexion();
if (mysqli_connect_errno()) {
    echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
    exit();
}
$idlogeobl = $_SESSION['id_user'];
unset($success, $fail);
$date = $_POST['datetimepicker1'];
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
$num_bl = $_POST['balances_realizados'];
//$campoajuste = $_POST['saldo'];
$camposumahaber = $_POST['camposumahaber'];
$camposumadebe = $_POST['camposumadebe'];
//$idlogaj = $_POST['idlogaj'];
if ($camposumadebe != $camposumahaber) {
    print "Los datos no cuadran";
} elseif ($camposumadebe == $camposumahaber) {
    (float) $campoauxsaldos = $camposumadebe = $camposumahaber;
}

$saldodebe = 0.00;
$saldohaber = 0.00;

$concepto = $_POST['textarea_asaj'];
$asiento_num = $_POST['asiento_num'];

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($con, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($con), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];
    }
}

$sqlcontaj = "SELECT COUNT(*)+1 as caj FROM `num_asientos_ajustes`";
$caaj = mysqli_query($con, $sqlcontaj);
$datarow = mysqli_fetch_array($caaj);
$contadorasientosaj = $datarow['caj'];


$insertasientoconcepto = "INSERT INTO `condata`.`num_asientos_ajustes` ("
        . "`idnum_asientos_ajustes` ,`fecha` ,`concepto` , `t_bl_inicial_idt_bl_inicial`, `t_ejercicio_idt_corrientes`,"
        . " mes,year,num_asientos_idnum_asientos)VALUES "
        . "('" . $contadorasientosaj . "' ,"
        . " '" . $date . "', "
        . "'" . trim($concepto) . "',"
        . " '" . $maxbalancedato . "',"
        . "'" . $asiento_num . "',"
        . "'" . $month . "',"
        . "'" . $year . "',"
        . "'" . $asiento_num . "');";
mysqli_query($con, $insertasientoconcepto);

$a = 1;
for ($i = 0; $i < count($_POST['campo9']); $i++) {
    mysqli_query($con, "INSERT INTO `condata`.`ajustesejercicio` (
        `idajustesejercicio` ,`ejercicio` ,`cod_cuenta` ,`cuenta` ,`fecha` ,`valor` ,`valorp` ,
        `t_bl_inicial_idt_bl_inicial` ,
`tipo` ,
`logeo_idlogeo` ,
`mes`,
year ,
num_asientos_ajustes_idnum_asientos_ajustes,
t_ejercicio_idt_corrientes
)VALUES (NULL ,
'" . $_POST['campo1'][$i] . "', 
'" . $_POST['campo2'][$i] . "',
'" . $_POST['campo3'][$i] . "', 
'" . $_POST['campo4'][$i] . "',
'" . $_POST['campo5'][$i] . "', 
'" . $_POST['campo6'][$i] . "',
'" . $maxbalancedato . "',
'" . $_POST['campo8'][$i] . "', 
'" . $idlogeobl . "',
'" . $month . "',
'" . $year . "'  ,
'" . $asiento_num . "',    
'" . $asiento_num . "'     
);");
    $a++;
}


if (mysqli_connect_errno()) {
    print_r("insert failed: %s\n<br />", mysqli_error($con));
} else {
    print_r("Asiento guardado con exito....\n");
}

//include '../../Clases/guardahistorial.php';
//$accion = "/ CONTABILIDAD / AJUSTES / CREO ASIENTO DE AJUSTE # ".$contadorasientosaj;
//generaLogs($_SESSION['username'], $accion);
mysqli_close($con);
?>