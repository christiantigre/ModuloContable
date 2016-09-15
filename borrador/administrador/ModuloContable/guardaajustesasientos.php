<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor CHRISTIAN.
 */
   
$con = mysqli_connect("localhost", "root", "alberto2791", "condata");
if (mysqli_connect_errno()) {
    echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
    exit();
}

$mes=  date('F');$year= date("Y");
unset($success, $fail);
$date = date("Y-m-j");
$num_bl=$_POST['balances_realizados'];
$campoajuste = $_POST['saldo'];
$camposumahaber = $_POST['camposumahaber'];
$camposumadebe = $_POST['camposumadebe'];
$idlogaj = $_POST['idlogaj'];
//algo//
if ($camposumadebe!=$camposumahaber) {
    print "Los datos no cuadran";
}elseif ($camposumadebe==$camposumahaber) {
    (float)$campoauxsaldos = $camposumadebe = $camposumahaber;
}
 
$saldodebe=0.00;
$saldohaber=0.00;
 

$concepto=$_POST['textarea_asaj'];
$asiento_num=$_POST['asiento_num'];


$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($con, $consulta) or trigger_error("Query Failed! SQL: $query - Error: ". mysqli_error($mysqli), E_USER_ERROR);
if($result) {
	while($row = mysqli_fetch_assoc($result)) {	
            $maxbalancedato = $row['id'];
	}
}



if ($rwsaldod!=0.00) {
    (float)$varactualizasaldod=  (float)$rwsaldod-(float)$campoauxsaldos;
   // number_format($varactualizasaldod , 2 , "," , ".");
    $varactualizasaldoh=0.00;
    $sqlactualiza = "UPDATE `condata`.`num_asientos` SET `saldodebe` = '".(float)$varactualizasaldod."'"
            . " WHERE `num_asientos`.`idnum_asientos` ='".$rwsaldoid."' LIMIT 1 ;";
    //$sqlactualizador = mysqli_query($con,$sqlactualiza);
}  
elseif ($rwsaldoh!=0.00) {
    (float)$varactualizasaldoh=(float)$rwsaldoh-(float)$campoauxsaldos;
    //number_format($varactualizasaldoh , 2 , "," , ".");
    $varactualizasaldod=0.00;
    $sqlactualiza = "UPDATE `condata`.`num_asientos` SET `saldohaber` = '".(float)$varactualizasaldoh."'"
            . " WHERE `num_asientos`.`idnum_asientos` ='".$rwsaldoid."' LIMIT 1 ;";
    //$sqlactualizador = mysqli_query($con,$sqlactualiza);
}

//echo "<script>alert('$date-$num-$concepto')</script>";
$insertasientoconcepto="INSERT INTO `condata`.`num_asientos_ajustes` ("
        . "`idnum_asientos_ajustes` ,`fecha` ,`concepto` , `t_bl_inicial_idt_bl_inicial`, `t_ejercicio_idt_corrientes`,"
        . " mes,year,saldodebe,saldohaber,num_asientos_idnum_asientos)VALUES "
        . "(NULL , '".$date."', '".trim($concepto)."', '".$maxbalancedato."','".$asiento_num."','".$mes."','".$year."','".$varactualizasaldod."',"
        . "'".$varactualizasaldoh."','".$asiento_num."');";
mysqli_query($con, $insertasientoconcepto);

$a=1;
for ($i = 0; $i < count($campo9); $i++) {
    mysqli_query($con, "INSERT INTO `condata`.`ajustesejercicio` (
        `idajustesejercicio` ,`ejercicio` ,`cod_cuenta` ,`cuenta` ,`fecha` ,`valor` ,`valorp` ,`t_bl_inicial_idt_bl_inicial` ,
`tipo` ,`logeo_idlogeo` ,`mes`,year ,num_asientos_ajustes_idnum_asientos_ajustes,t_ejercicio_idt_corrientes
)VALUES (NULL ,
'".$campo1[$i]."', 
'".$campo2[$i]."',
'".$campo3[$i]."', 
'".$campo4[$i]."',
'".$campo5[$i]."', 
'".$campo6[$i]."',
'".$maxbalancedato."',
'".$campo8[$i]."', 
'".$idlogaj."',
'".$campo10[$i]."',
'".$year."'  ,
'".$asiento_num."',    
'".$asiento_num."'     
);");
    $a++;
  
}


if (mysqli_connect_errno()) {
    print_r("insert failed: %s\n<br />", mysqli_error($con));
} else {
    print_r("Asiento guardado con exito....\n");
}

mysqli_close($con);

?>