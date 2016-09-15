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
$num_bl=$_POST['balances_realizados'];
$concepto=$_POST['textarea_as'];
$asiento_num=$_POST['asiento_num'];
$camposumadebe = $_POST['camposumadebe'];
$camposumahaber = $_POST['camposumahaber'];
$saldodebe=0;
$saldohaber=0;
if ($camposumadebe>$camposumahaber) {
    $saldodebe=$camposumadebe-$camposumahaber;
    $saldohaber=0.00;
}else{
    $saldohaber=$camposumahaber-$camposumadebe;
    $saldodebe=0.00;
}
$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($con, $consulta) or trigger_error("Query Failed! SQL: $query - Error: ". mysqli_error($mysqli), E_USER_ERROR);
if($result) {
	while($row = mysqli_fetch_assoc($result)) {	
            $maxbalancedato = $row['id'];
	}
}
$consultacontador = "SELECT count( * )+1 as id FROM `num_asientos`";
$resultcont = mysqli_query($con, $consultacontador) or trigger_error("Query Failed! SQL: $consultacontador - Error: " . mysqli_error($con), E_USER_ERROR);
if ($resultcont) {
    while ($rowcont = mysqli_fetch_assoc($resultcont)) {
        $incremento = $rowcont['id'];
    }
}

$conceptotrim = trim($concepto);

$insertasientoconcepto="INSERT INTO `condata`.`num_asientos` (`idnum_asientos` ,`fecha` ,`concepto` , `t_bl_inicial_idt_bl_inicial`,"
        . " `t_ejercicio_idt_corrientes`, mes,year,saldodebe,saldohaber)VALUES "
        . "('".$incremento."' , '".$date."', '".utf8_encode($conceptotrim)."', '".$maxbalancedato."','".$asiento_num."','".$month."','".$year."',"
        . "'".$saldodebe."','".$saldohaber."');";
mysqli_query($con, $insertasientoconcepto);

$a=1;
for ($i = 0; $i < count($_POST['campo9']); $i++) {    
    
    $consultacontadorej = "SELECT count( * )+1 as id FROM `libro`";
    $resultcontej = mysqli_query($con, $consultacontadorej) or trigger_error("Query Failed! SQL: $consultacontadorej - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($resultcontej) {
        while ($rowcontej = mysqli_fetch_assoc($resultcontej)) {
            $incrementoej = $rowcontej['id'];
        }
    }    
    
    mysqli_query($con, "INSERT INTO `condata`.`libro` (
`idlibro` ,`fecha` ,
`asiento` ,`ref` ,
`cuenta` ,
`debe` ,
`haber` ,
`t_bl_inicial_idt_bl_inicial` ,
`t_cuenta_idt_cuenta` ,
`logeo_idlogeo` ,
`grupo` ,
`mes` ,
`year`
)
VALUES ('".$incrementoej."',
'".$_POST['campo4'][$i]."','".$_POST['campo1'][$i]."',
'".$_POST['campo2'][$i]."',
'".$_POST['campo3'][$i]."',
'".$_POST['campo5'][$i]."',
'".$_POST['campo6'][$i]."',
'".$_POST['campo7'][$i]."',
'".$_POST['campo8'][$i]."',
'".$_POST['campo9'][$i]."',
'".$_POST['campo8'][$i]."',
'".$month."',
'".$year."'
);");
    $a++;
  
}

include '../../../Clases/guardahistorialsecretaria.php';
    $accion="/ CONTABILIDAD / ADD ASIENTOS / Guardo ass ".$asiento_num;
    generaLogs($user, $accion);

if (mysqli_connect_errno()) {
    print_r("insert failed :", mysqli_error($con));
} else {
    print_r("Guardado con exito...");
}

mysqli_close($con);
?>