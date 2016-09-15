<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor CHRISTIAN.
 */
require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$con = $dbi->conexion();
session_start();
$user = $_SESSION['username'];

//$con = mysqli_connect("localhost", "root", "alberto2791", "condata");
if (mysqli_connect_errno()) {
    echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
    exit();
}
unset($success, $fail);
$user = $_POST['username'];
$date = date("Y-m-j");
$mes = date('F');
$year = date("Y");
$num_bl=$_POST['balances_realizados'];
$camposumadebeconvertir = $_POST['camposumadebe'];
$camposumahaberconvertir = $_POST['camposumahaber'];
$saldodebe=0.00;
$saldohaber=0.00;
$concepto=$_POST['textarea_as'];
$asiento_num=$_POST['asiento_num'];
$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($con, $consulta) or trigger_error("Query Failed! SQL: $query - Error: ". mysqli_error($mysqli), E_USER_ERROR);
if($result) {
	while($row = mysqli_fetch_assoc($result)) {	            $maxbalancedato = $row['id'];
	}}
//echo "<script>alert('$date-$num-$concepto')</script>";
$mes=  date('F');$year= date("Y");
$insertasientoconcepto="INSERT INTO `condata`.`num_asientos` (`idnum_asientos` ,`fecha` ,`concepto` , `t_bl_inicial_idt_bl_inicial`, `t_ejercicio_idt_corrientes`, mes,year,saldodebe,saldohaber)VALUES "
        . "(NULL , '".$date."', '".trim($concepto)."', '".$maxbalancedato."','".$asiento_num."','".$mes."','".$year."','".(float)$saldodebe."','".(float)$saldohaber."');";
mysqli_query($con, $insertasientoconcepto);

$insertdatosalresultado = "INSERT INTO `condata`.`resultadosbalance` (`idresultadosbalance` ,`resdebe` ,`reshaber` ,`t_bl_inicial_idt_bl_inicial`,`num_asientos_idnum_asientos`,year,mes)VALUES (
NULL , '".$camposumadebeconvertir = str_replace(",", ".", $camposumadebeconvertir)."', '".$camposumahaberconvertir = str_replace(",", ".", $camposumahaberconvertir)."', '".$maxbalancedato."','".$asiento_num."','".$year."','".$mes."'
);";
mysqli_query($con, $insertdatosalresultado);

$a=1;
for ($i = 0; $i < count($campo9); $i++) {
    mysqli_query($con, "INSERT INTO `condata`.`t_ejercicio` (`idt_corrientes` ,`ejercicio` ,`cod_cuenta` ,`cuenta` ,`fecha` ,`valor` ,`valorp` ,`t_bl_inicial_idt_bl_inicial` ,
`tipo` ,`logeo_idlogeo` ,`mes`,year 
)VALUES (NULL ,
'".$campo1[$i]."', 
'".$campo2[$i]."',
'".$campo3[$i]."', 
'".$campo4[$i]."',
'".$campo5[$i]."', 
'".$campo6[$i]."',
'".$campo7[$i]."',
'".$campo8[$i]."', 
'".$campo9[$i]."',
'".$campo10[$i]."',
'".$year."'    
);");
    $a++;
  
}


if (mysqli_connect_errno()) {
    print_r("insert failed: %s\n<br />", mysqli_error($con));
} else {
    print_r("Asiento guardado con exito....\n");
}

include '../../Clases/guardahistorial.php';
    $accion="Registro el balance inicial periodo ".$year;
    generaLogs($user, $accion);


mysqli_close($con);
?>