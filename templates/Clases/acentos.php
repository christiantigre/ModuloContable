<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function num($num) {
    $num = str_replace(".", ",", $num);
    return $num;
}

function limpiar($String) {
    $String = str_replace(array('á', 'à', 'â', 'ã', 'ª', 'ä'), "a", $String);
    $String = str_replace(array('Á', 'À', 'Â', 'Ã', 'Ä'), "A", $String);
    $String = str_replace(array('Í', 'Ì', 'Î', 'Ï'), "I", $String);
    $String = str_replace(array('í', 'ì', 'î', 'ï'), "i", $String);
    $String = str_replace(array('é', 'è', 'ê', 'ë'), "e", $String);
    $String = str_replace(array('É', 'È', 'Ê', 'Ë'), "E", $String);
    $String = str_replace(array('ó', 'ò', 'ô', 'õ', 'ö', 'º'), "o", $String);
    $String = str_replace(array('Ó', 'Ò', 'Ô', 'Õ', 'Ö'), "O", $String);
    $String = str_replace(array('ú', 'ù', 'û', 'ü'), "u", $String);
    $String = str_replace(array('Ú', 'Ù', 'Û', 'Ü'), "U", $String);
    $String = str_replace(array('[', '^', '´', '`', '¨', '~', ']'), "", $String);
    $String = str_replace("ç", "c", $String);
    $String = str_replace("Ç", "C", $String);
    $String = str_replace("ñ", "ñ", $String);
    $String = str_replace("ÃƒÂ±", "ñ", $String);
    $String = str_replace("Ã±", "ñ", $String);
    $String = str_replace("aÂ", "a", $String);
    $String = str_replace("eÂ", "e", $String);
    $String = str_replace("iÂ", "i", $String);
    $String = str_replace("oÂ", "o", $String);
    $String = str_replace("uÂ", "u", $String);
    $String = str_replace("Ñ", "N", $String);
    $String = str_replace("Ã‘", "Ñ", $String);
    $String = str_replace("‘", "Ñ", $String);
    $String = str_replace("Ý", "Y", $String);
    $String = str_replace("ý", "y", $String);

    $String = str_replace("&aacute;", "a", $String);
    $String = str_replace("&Aacute;", "A", $String);
    $String = str_replace("&eacute;", "e", $String);
    $String = str_replace("&Eacute;", "E", $String);
    $String = str_replace("&iacute;", "i", $String);
    $String = str_replace("&Iacute;", "I", $String);
    $String = str_replace("&oacute;", "o", $String);
    $String = str_replace("&Oacute;", "O", $String);
    $String = str_replace("&uacute;", "u", $String);
    $String = str_replace("&Uacute;", "U", $String);
    return $String;
}

function translateMonth($mes) {
    if ($mes == "January")
        $mes = "Enero";
    if ($mes == "February")
        $mes = "Febrero";
    if ($mes == "March")
        $mes = "Marzo";
    if ($mes == "April")
        $mes = "Abril";
    if ($mes == "May")
        $mes = "Mayo";
    if ($mes == "June")
        $mes = "Junio";
    if ($mes == "July")
        $mes = "Julio";
    if ($mes == "August")
        $mes = "Agosto";
    if ($mes == "September")
        $mes = "Septiembre";
    if ($mes == "October")
        $mes = "Octubre";
    if ($mes == "November")
        $mes = "Noviembre";
    if ($mes == "December")
        $mes = "Diciembre";
    return $mes;
}

function MonthNumber($mes) {
    if ($mes == "01")
        $mes = "Enero";
    if ($mes == "02")
        $mes = "Febrero";
    if ($mes == "03")
        $mes = "Marzo";
    if ($mes == "04")
        $mes = "Abril";
    if ($mes == "05")
        $mes = "Mayo";
    if ($mes == "06")
        $mes = "Junio";
    if ($mes == "07")
        $mes = "Julio";
    if ($mes == "08")
        $mes = "Agosto";
    if ($mes == "09")
        $mes = "Septiembre";
    if ($mes == "10")
        $mes = "Octubre";
    if ($mes == "11")
        $mes = "Noviembre";
    if ($mes == "12")
        $mes = "Diciembre";
    return $mes;
}


