<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor CHRISTIAN.
 */
//$con = mysqli_connect("localhost", "root", "alberto2791", "condata");
require '../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$con = $dbi->conexion();
$user = $_SESSION['username'];
if (mysqli_connect_errno()) {
    echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
    exit();
}
unset($success, $fail);
$date = date("Y-m-j");
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
//echo "<script>alert('$date-$num-$concepto')</script>";
$mes=  date('F');$year= date("Y");
$insertasientoconcepto="INSERT INTO `condata`.`num_asientos` (`idnum_asientos` ,`fecha` ,`concepto` , `t_bl_inicial_idt_bl_inicial`,"
        . " `t_ejercicio_idt_corrientes`, mes,year,saldodebe,saldohaber)VALUES "
        . "('".$incremento."' , '".$date."', '".trim($concepto)."', '".$maxbalancedato."','".$asiento_num."','".$mes."','".$year."','".$saldodebe."','".$saldohaber."');";
mysqli_query($con, $insertasientoconcepto);


$insertdatosumas = "INSERT INTO `condata`.`res_librodiario` (`idres_librodiario` ,`tot_debe` ,`tot_haber` ,"
        . "`t_bl_inicial_idt_bl_inicial`,num_asientos_idnum_asientos,year,mes )VALUES"
        . " (null, '".$camposumadebe  = str_replace(",", ".", $camposumadebe)."', '".$camposumahaber = str_replace(",", ".", $camposumahaber)."',"
        . " '".$maxbalancedato."','".$asiento_num."','".$year."','".$mes."');";
mysqli_query($con, $insertdatosumas);


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
'".$mes."',
'".$year."'
);");
    $a++;
  
}

//include '../../Clases/guardahistorial.php';
//    $accion="Guardo ass ".$asiento_num;
//    generaLogs($user, $accion);

if (mysqli_connect_errno()) {
    print_r("insert failed :", mysqli_error($con));
} else {
    print_r("Guardado con exito...");
}

mysqli_close($con);
?>