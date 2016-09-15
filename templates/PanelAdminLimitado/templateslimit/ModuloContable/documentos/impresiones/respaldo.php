<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.

 *  */
$sqlcargaconcepto = mysqli_query($c,"SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` ej,`concepto` c,"
        . "fecha as f FROM `num_asientos` WHERE"
        . " `t_bl_inicial_idt_bl_inicial`='".$maxbalancedato."' AND year ='".$year."'"
        . " order by '".$cadena."' ");
while ($row2 = mysqli_fetch_array($sqlcargaconcepto)) {
    $codgrupopdf = $row2['ej']; //echo "<script>alert('".$codgrupopdf."')</script>";
    $concepto = $row2['c'];
    $pdf->SetFillColor(224, 235, 255);
    $pdf->Cell(179, 5, utf8_decode('Asiento ' . $codgrupopdf), 1, 1, 'C', true);
    $pdf->Ln(8);
    $sql_transac = mysqli_query($c,"SELECT `ejercicio` , `idt_corrientes` , `fecha` , `cod_cuenta` , `cuenta` , `valor` AS debe,
    `valorp` AS haber, `t_bl_inicial_idt_bl_inicial` , tipo
FROM `t_ejercicio`
WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'
AND `ejercicio` =" . $codgrupopdf . "
AND year = '" . $year . "'
");

    while ($productos2 = mysqli_fetch_array($sql_transac)) {
        $pdf->Cell(15, 8, $productos2['cod_cuenta'], 0);
        $pdf->Cell(90, 8, $productos2['cuenta'], 0);
        $pdf->Cell(25, 8, $productos2['fecha'], 0);
        $pdf->Cell(25, 8, ' ' . $productos2['debe'], 0);
        $pdf->Cell(25, 8, ' ' . $productos2['haber'], 0);
        $pdf->Ln(8);
    }

    $pdf->Cell(25, 8, 'Concepto : ' . $concepto, 0);
    $pdf->Ln(8);
}




$sqlcargaconceptol = mysqli_query($c,"SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` ej,`concepto` c,fecha as f FROM `num_asientos` 
            WHERE `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' AND `t_ejercicio_idt_corrientes` !=1"
        . " and year ='" . $year . "'");
while ($row2 = mysqli_fetch_array($sqlcargaconceptol)) {
    $codgrupopdfl = $row2['ej']; //echo "<script>alert('".$codgrupopdf."')</script>";
    $conceptol = $row2['c'];
    $pdf->SetFillColor(224, 235, 255);
    $pdf->Cell(179, 5, utf8_decode('Asiento ' . $codgrupopdfl), 1, 1, 'C', true);
    $pdf->Ln(8);
    $sql_transacl = mysqli_query($c,"SELECT idlibro,`asiento` , `fecha` , `ref` , `cuenta` ,  debe,  haber, `t_bl_inicial_idt_bl_inicial` , grupo
FROM `libro`
WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'
AND `asiento` =" . $codgrupopdfl . " and year='" . $year . "'
 ");

    while ($productos2l = mysqli_fetch_array($sql_transacl)) {
        $pdf->Cell(15, 8, $productos2l['ref'], 0);
        $pdf->Cell(90, 8, $productos2l['cuenta'], 0);
        $pdf->Cell(25, 8, $productos2l['fecha'], 0);
        $pdf->Cell(25, 8, ' ' . $productos2l['debe'], 0);
        $pdf->Cell(25, 8, ' ' . $productos2l['haber'], 0);
        $pdf->Ln(8);
    }

    $pdf->Cell(25, 8, 'Concepto : ' . $conceptol, 0);
    $pdf->Ln(8);
}