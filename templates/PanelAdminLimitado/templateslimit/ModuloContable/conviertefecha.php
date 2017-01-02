<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$q_mes = "SELECT * FROM `libro` ";
$res_mes = mysqli_query($c, $q_mes);
//echo $fecha = date('Y-m-j').'-';
while ($dt_mes = mysqli_fetch_array($res_mes)) {
    $id_m = $dt_mes['fecha'];
    $ass = $dt_mes['asiento'];

//    echo $id_m;
//    echo "-";

    $pos_f = explode("-", $id_m);
    $uno = $pos_f[0];
    $dos = $pos_f[1];
    $tres = $pos_f[2];
//      echo $cadena = $tres."-".$dos."-".$uno;
    $cadena = $tres.'-'.$uno. '-' . $dos;
//    echo "-";
//    echo $ass;
//    echo '<br />';


//    echo $id_m; 
//    $fecha =  str_replace('/', '-', $id_m);
//    echo '<br />';
//    $pos = 
//    echo $fecha;    
    echo "UPDATE `libro` SET `fecha`='".$cadena."' WHERE `asiento`='$ass';";
    echo '<br />';
}mysqli_close($c);
