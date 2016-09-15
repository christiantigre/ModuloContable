<?php
date_default_timezone_set("America/Guayaquil");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function generaLogs($usuario,$accion){
    $hora=str_pad(date("Y-m-d H:i:s"),20," "); 
    $usuario=strtoupper(str_pad($usuario,10," "));
    $accion=strtoupper(str_pad($accion,50," "));
    $cadena=$hora.$usuario.$accion;
    $pre="";
    $date=date("j-m-Y"); 
    $fileName=$pre.$date;
    $f = fopen("../../../hss/$fileName","a");
        fputs($f,$cadena."\r\n") or die("Historial panel...No se pudo crear o insertar el fichero");
    fclose($f);
}
