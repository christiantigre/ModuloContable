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
unset($success, $fail);
$user = $_POST['username'];
$datepick = $_POST['datetimepicker1'];
list($year,$month,$dia) = explode("-",$datepick);
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
//$mes = date('%B');
//$year = date("Y");
$num_bl = $_POST['balances_realizados'];
$camposumadebeconvertir = $_POST['camposumadebe'];
$camposumahaberconvertir = $_POST['camposumahaber'];
$saldodebe = 0.00;
$saldohaber = 0.00;
$concepto = $_POST['textarea_as'];
$asiento_num = $_POST['asiento_num'];
$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($con, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($con), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];
    }
}
if ($maxbalancedato == '') {
    print_r("NO SE PUEDE GUARDAR EL ASIENTO....\nDEBE CREAR EL PERIODO...");
    include '../../Clases/guardahistorial.php';
    $accion = " / BALANCE INICIAL / ERROR AL GUARDAR BALANCE INICIAL PERIODO " . $year;
    generaLogs($user, $accion);
} else {
    $consultacontador = "SELECT count( * )+1 as id FROM `num_asientos`";
    $resultcont = mysqli_query($con, $consultacontador) or trigger_error("Query Failed! SQL: $consultacontador - Error: " . mysqli_error($con), E_USER_ERROR);
    if ($resultcont) {
        while ($rowcont = mysqli_fetch_assoc($resultcont)) {
            $incremento = $rowcont['id'];
        }
    }
    $insertasientoconcepto = "INSERT INTO `condata`.`num_asientos` (`idnum_asientos` ,`fecha` ,`concepto` , `t_bl_inicial_idt_bl_inicial`, `t_ejercicio_idt_corrientes`, mes,year)VALUES "
            . "( '" . $incremento . "', '" . $datepick . "', '" . trim($concepto) . "', '" . $maxbalancedato . "','" . $asiento_num . "','" . $month . "','" . $year . "');";
    mysqli_query($con, $insertasientoconcepto);

//    $insertdatosalresultado = "INSERT INTO `condata`.`resultadosbalance` (`idresultadosbalance` ,`resdebe` ,`reshaber` ,`t_bl_inicial_idt_bl_inicial`,`num_asientos_idnum_asientos`,year,mes)VALUES (
//NULL , '" . $camposumadebeconvertir = str_replace(",", ".", $camposumadebeconvertir) . "', '" . $camposumahaberconvertir = str_replace(",", ".", $camposumahaberconvertir) . "', '" . $maxbalancedato . "','" . $asiento_num . "','" . $year . "','" . $mes . "'
//);";
//    mysqli_query($con, $insertdatosalresultado);

    $a = 1;
    for ($i = 0; $i < count($_POST['campo9']); $i++) {
        $consultacontadorej = "SELECT count( * )+1 as id FROM `t_ejercicio`";
        $resultcontej = mysqli_query($con, $consultacontadorej) or trigger_error("Query Failed! SQL: $consultacontadorej - Error: " . mysqli_error($con), E_USER_ERROR);
        if ($resultcontej) {
            while ($rowcontej = mysqli_fetch_assoc($resultcontej)) {
                $incrementoej = $rowcontej['id'];
            }
        }

        mysqli_query($con, "INSERT INTO `condata`.`t_ejercicio` (`idt_corrientes` ,`ejercicio` ,`cod_cuenta` ,`cuenta` ,`fecha` ,`valor` ,`valorp` ,`t_bl_inicial_idt_bl_inicial` ,
`tipo` ,`logeo_idlogeo` ,`mes`,year 
)VALUES ('" . $incrementoej . "' ,
'" . $_POST['campo1'][$i] . "', 
'" . $_POST['campo2'][$i] . "',
'" . $_POST['campo3'][$i] . "', 
'" . $_POST['campo4'][$i] . "',
'" . $_POST['campo5'][$i] . "', 
'" . $_POST['campo6'][$i] . "',
'" . $_POST['campo7'][$i] . "',
'" . $_POST['campo8'][$i] . "', 
'" . $_POST['campo9'][$i] . "',
'" . $month . "',
'" . $year . "'    
);");
        $a++;
    }


    if (mysqli_connect_errno()) {
        print_r("insert failed: %s\n<br />", mysqli_error($con));
    } else {
        print_r("Asiento guardado con exito....\n");
    }

    include '../../Clases/guardahistorial.php';
    $accion = "Registro el balance inicial periodo " . $year;
    generaLogs($user, $accion);


    mysqli_close($con);
}
?>