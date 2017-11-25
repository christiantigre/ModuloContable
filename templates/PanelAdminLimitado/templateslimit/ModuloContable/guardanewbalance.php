<?php

date_default_timezone_set("America/Guayaquil");
session_start();
$user = $_SESSION['username'];
$idlogeobl = $_POST['idlogeobl'];
$concepto = $_POST['textarea_asnew'];
$idlogeobl = $_POST['idlogeobl'];
$idlogeoblu = $_SESSION['id_user'];
require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$date = date('Y-m-d');
$saldodebe = 0.00;
$saldohaber = 0.00;
$asiento_num = 1;
list($year,$month,$dia) = explode("-",$date);
 $dia; // Imprime 12
 $month; // Imprime 01
 $year; // Imprime 2005
 $year_next = $year+1;
 $date_next = $year_next.'-'.'01'.'-'.'01';
 $month_first='Enero';
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
$consultaaux = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$resultaux = mysqli_query($c, $consultaaux) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($c), E_USER_ERROR);
if ($resultaux) {
    while ($rowaux = mysqli_fetch_assoc($resultaux)) {
        $maxbalancedatoaux = $rowaux['id'];
    }
}
$sql_sumyear="SELECT year FROM `t_bl_inicial` where idt_bl_inicial='".$maxbalancedatoaux."'";
                                        $data = mysqli_query($c, $sql_sumyear);
                                        $resdata = mysqli_fetch_assoc($data);
                                        $yearactual = $resdata['year'];
                                        $yearactual = $yearactual+1;

$contarbalances = "SELECT count(`idt_bl_inicial`)+1 as contador FROM `t_bl_inicial`";
$rescontador = mysqli_query($c, $contarbalances);
$fila = mysqli_fetch_array($rescontador);
$contadorbalances = $fila['contador'];




$creanuevoperiodo = "INSERT INTO `condata`.`t_bl_inicial`"
        . " (`idt_bl_inicial`, `fecha_balance`, `logeo_idlogeo`, `year`, `estado`) "
        . "VALUES ('" . $contadorbalances . "', '".$date_next."', '" . $idlogeoblu . "', '" . $yearactual . "',"
        . " '1');";
mysqli_query($c, $creanuevoperiodo) or trigger_error("Query Failed! SQL: $creanuevoperiodo - Error: " . mysqli_error($c), E_USER_ERROR);
//DEFINE NOMBRE DE LAS TABLAS//
$num_asientos = 'num_asientos_'.$year;
$libro = 'libro_'.$year;
$num_asientos_ajustes = 'num_asientos_ajustes_'.$year;
$ajustesejercicio = 'ajustesejercicio_'.$year;
$t_ejercicio = 't_ejercicio_'.$year;

$clonanum_asientos = 'CREATE TABLE '.$num_asientos.' SELECT * FROM num_asientos;';
mysqli_query($c, $clonanum_asientos) or trigger_error("Query Failed! SQL: $clonanum_asientos - Error: " . mysqli_error($c), E_USER_ERROR);
sleep(2);
$clonanum_libro = 'CREATE TABLE '.$libro.' SELECT * FROM libro;';
mysqli_query($c, $clonanum_libro) or trigger_error("Query Failed! SQL: $clonanum_libro - Error: " . mysqli_error($c), E_USER_ERROR);
sleep(2);
$clonanum_ass_aj = 'CREATE TABLE '.$num_asientos_ajustes.' SELECT * FROM num_asientos_ajustes;';
mysqli_query($c, $clonanum_ass_aj) or trigger_error("Query Failed! SQL: $clonanum_ass_aj - Error: " . mysqli_error($c), E_USER_ERROR);
sleep(2);
$clonanum_ajustes_ejercicio = 'CREATE TABLE '.$ajustesejercicio.' SELECT * FROM ajustesejercicio;';
mysqli_query($c, $clonanum_ajustes_ejercicio) or trigger_error("Query Failed! SQL: $clonanum_t_ejercicio - Error: " . mysqli_error($c), E_USER_ERROR);
sleep(2);
$clonanum_t_ejercicio = 'CREATE TABLE '.$t_ejercicio.' SELECT * FROM t_ejercicio;';
mysqli_query($c, $clonanum_t_ejercicio) or trigger_error("Query Failed! SQL: $clonanum_t_ejercicio - Error: " . mysqli_error($c), E_USER_ERROR);
sleep(2);


$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($c), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];
    }
}
$contadorasientos = "SELECT count(*)+1 as con FROM `num_asientos`";
$resultc = mysqli_query($c, $contadorasientos) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($c), E_USER_ERROR);
if ($resultc) {
    while ($rowc = mysqli_fetch_assoc($resultc)) {
        $ccass = $rowc['con'];
    }
}
$vaciar_num_asientos="truncate num_asientos;";
mysqli_query($c, $vaciar_num_asientos);
$vaciar_t_ejercicio="truncate t_ejercicio;";
mysqli_query($c, $vaciar_t_ejercicio);
$insertasientoconcepto = "INSERT INTO `condata`.`num_asientos` (`idnum_asientos` ,`fecha` ,`concepto` , "
        . "`t_bl_inicial_idt_bl_inicial`, `t_ejercicio_idt_corrientes`, mes,year,saldodebe,saldohaber)VALUES "
        . "('1' , '" . $date_next . "', '" . trim($concepto) . "', '" . $maxbalancedato . "',"
        . "'" . $asiento_num . "','" . $month_first . "','" . $yearactual . "',"
        . "'" . (float) $saldodebe . "','" . (float) $saldohaber . "');";
mysqli_query($c, $insertasientoconcepto);

$a = 1;
for ($i = 0; $i < count($_POST['campo6']); $i++) {
    mysqli_query($c, "INSERT INTO `condata`.`t_ejercicio` 
        (`idt_corrientes` ,`ejercicio` ,`cod_cuenta` ,`cuenta` ,`fecha` ,
        `valor` ,`valorp` ,`t_bl_inicial_idt_bl_inicial` ,
`tipo` ,`logeo_idlogeo` ,`mes`,year 
)VALUES (NULL ,
'" . $asiento_num . "', 
'" . $_POST['campo2'][$i] . "',
'" . $_POST['campo3'][$i] . "', 
'" . $date_next . "',
'" . $_POST['campo4'][$i] . "', 
'" . $_POST['campo5'][$i] . "',
'" . $maxbalancedato . "',
'" . $_POST['campo6'][$i] . "', 
'" . $idlogeobl . "',
'" . $month_first . "',
'" . $yearactual . "'    
);");
    $a++;
}


$vaciar_libro="truncate libro;";
$vaciar_num_asientos_ajustes="truncate num_asientos_ajustes;";
$vaciar_t_ejercicio="truncate ajustesejercicio;";
mysqli_query($c, $vaciar_libro);
mysqli_query($c, $vaciar_num_asientos_ajustes);
mysqli_query($c, $vaciar_t_ejercicio);

if (mysqli_connect_errno()) {
    print_r("insert failed: %s\n<br />", mysqli_error($c));
} else {
    print_r("Balance guardado con exito....\n");
}

include '../../Clases/guardahistorial.php';
$accion = "Creo blce inicial periodo " . $yearactual;
generaLogs($user, $accion);


mysqli_close($c);
?>