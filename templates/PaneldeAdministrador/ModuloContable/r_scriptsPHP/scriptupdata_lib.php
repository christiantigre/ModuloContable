<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$con = $dbi->conexion();
session_start();
$user = $_SESSION['username'];
$idlogeobl = $_SESSION['id_user'];
$idass = $_POST['idnumass'];
$textarea_as = $_POST['textarea_as'];
$asiento = $_POST['idnumass'];
$datetimepicker1 = $_POST['datetimepicker1'];
$fecha  = $_POST['datetimepicker1'];
$pos = explode('-',$datetimepicker1);
$year = $pos[0];
$month = $pos[1];
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
$updatoass_num = "UPDATE `num_asientos` SET `concepto`='".$_POST['textarea_as']."',"
        . "`fecha`='".$_POST['datetimepicker1']."', mes='".$month."',year='".$year."' "
            . " WHERE `idnum_asientos` = '".$asiento."'";
    
    mysqli_query($con, $updatoass_num) or die(mysqli_error($con));

     $a = 1;
    for ($i = 0; $i < count($_POST['campo8']); $i++) {
        $idt_corrientes = $_POST['campo1'][$i];
        $ejercicio = $asiento;
        $cod_cuenta = $_POST['campo2'][$i];
        $cuenta = $_POST['campo5'][$i];
        $valor  = $_POST['campo6'][$i];
        $valorp  = $_POST['campo7'][$i];
        $tipo    = $_POST['campo4'][$i];
        $mes = $month;
        $year = $year;
        $up_ejer = "UPDATE `libro` SET `ref` = '".$cod_cuenta."', "
                . "`cuenta` = '".$cuenta."', `fecha` = '".$fecha."', `debe` = '".$valor."',"
                . " `haber` = '".$valorp."',t_cuenta_idt_cuenta='".  trim($tipo)."', "
                . "`grupo` = '".trim($tipo)."',mes='".$mes."',"
                . "year='".$year."', logeo_idlogeo ='".$idlogeobl."' "
                . " WHERE `libro`.`idlibro` = '".$idt_corrientes."';";
        mysqli_query($con, $up_ejer);
        $a++;
    }
    
        if (mysqli_connect_errno()) {
    print_r("insert failed: %s\n<br />", mysqli_error($con));
} else {
    print_r("Cambios realizados con exito....\n");
    }
    
    
//    include '../../../../PanelAdminLimitado/Clases/guardahistorialdoc.php';
//    $accion = "/ CONTABILIDAD / UPDATA / Actualizo el asiento numero " . $asiento;
//    generaLogs($user, $accion);
    
    mysqli_close($c);
    
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

