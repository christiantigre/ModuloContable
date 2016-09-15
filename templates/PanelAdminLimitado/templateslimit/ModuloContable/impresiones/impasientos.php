<?php
session_start();

    date_default_timezone_set("America/Guayaquil");

require('../../../../fpdf/fpdf.php');
include_once '../../../../Clases/Conectar.php';
$dbi = new Conectar();
$db = $dbi->conexion();
$variableresponsable = $_SESSION['id_user'];
$feurl = $_GET['fech_url'];
$id_asientourl= $_GET['id_asientourl'];
$user = $_SESSION['username'];
$variablerespo = $_SESSION['username'];

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($db), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];     
    }
}

$resDH = mysqli_query($db," SELECT sum( j.debe ) AS d, sum( j.haber ) AS h
FROM libro j
JOIN num_asientos n
WHERE j.asiento = n.t_ejercicio_idt_corrientes
AND j.asiento =".$id_asientourl."
AND j.t_bl_inicial_idt_bl_inicial =".$maxbalancedato.""
        . " ");
while ($row4 = mysqli_fetch_array($resDH)) {
    $ddetall = $row4['d'];  //echo "<script>alert(".$ddetall.")</script>";
    $hdetall = $row4['h'];
}


$sqlcargaconcepto = mysqli_query($db,"SELECT n.`idnum_asientos` AS id, n.`t_ejercicio_idt_corrientes` as ej,
    n.`concepto` as c
FROM `num_asientos` n 
WHERE n.fecha = '".$feurl."' and t_ejercicio_idt_corrientes='".$id_asientourl."' ");
while ($row2 = mysqli_fetch_array($sqlcargaconcepto)) {
    $codgrupopdfas = $row2['ej']; 
    $concepto = $row2['c'];
}

$datosempresa = mysqli_query($db,"SELECT * FROM `empresa`");

while ($row = mysqli_fetch_array($datosempresa)) {
    $nom_emp = $row['nombre'];
    $dir = $row['direccion'];
    $mail = $row['email'];
    $ruc = $row['ruc'];
    $tel = $row['telefono'];
    $func = $row['funcion'];
    $logo = $row['logo'];
    $foto = $row['nomimg'];
    $tipo = $row['tipo'];
    $propi = $row['propietario'];
}
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$ruta = "../../../../../images/uploads/";
if ($foto != "") {
    $img = $ruta . "" . $foto;
    $for = strstr($tipo, '/', true);
    $tip = substr(strstr($tipo, '/'), 1);
    $pdf->Image($img, 10, 3, 80, 20, $tip);
} Else {
    $pdf->Image("../../../../images/fondoAzul.png", 10, 3, 80, 20, "png");
}
$pdf->Cell(18, 10, '', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(15);
//define("_MQ_CODAL",$dir);
$dire = str_replace("ÃƒÂ±", "ñ", $dir);
//$pdf->Cell(40,10,utf8_decode(_MQ_CODAL).":",0,0,'L'); 
//$dire = utf8_decode(_MQ_CODAL);
//$dire =  utf8_decode($dir);
//$pdf->Cell(63, 7, 'Empresa: ' . $nom_emp, 0, 0, 'L'); 
$pdf->Cell(126, 7, 'Direccion : ' . \utf8_decode($dire), 0, 0, 'L');
$pdf->Cell(63, 7, 'Correo : ' . $mail, 0, 1, 'R');
$pdf->Cell(63, 7, 'Ruc : ' . $ruc, 0, 0, 'L');
$pdf->Cell(63, 7, 'Emitido : ' . date("d-m-Y H:i"), 0, 0, 'C'); 
$pdf->Cell(63, 7, 'Por : ' . $variablerespo, 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 11);
//$pdf->Cell(70, 8, '', 0);
$pdf->Cell(0, 8, 'Comprobante de Asiento generado', 0, 1, 'C');
//$pdf->Ln(10);
  $pdf->Cell(0, 7, 'ASIENTO #: ' .$id_asientourl , 0, 1, 'C');
//$pdf->Ln(10);
$pdf->Cell(0, 8, 'Pagina ' . $pdf->PageNo(), 'T', 1, 'R');
$pdf->Cell(0, 5, '', 'T', 1);
$pdf->SetFont('Arial', 'BU', 8);
$pdf->Cell(20, 8, 'Cod.', 0);
$pdf->Cell(95, 8, 'Cuenta', 0);
$pdf->Cell(15, 8, 'Fecha', 0);
$pdf->Cell(30, 8, 'Debe', 0, 0, 'R');
$pdf->Cell(30, 8, 'Haber', 0, 0, 'R');
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$sql_transac = mysqli_query($db,"SELECT * FROM `libro` WHERE "
        . "`t_bl_inicial_idt_bl_inicial`='".$maxbalancedato."'"
        . " and asiento=".$id_asientourl." and fecha='".$feurl."' ");

while ($productos2 = mysqli_fetch_array($sql_transac)) {
    $pdf->Cell(20, 2, $productos2['ref'], 0, 0, 'L');
    $pdf->Cell(95, 2, $productos2['cuenta'], 0, 0, 'L');
    $pdf->Cell(15, 2, $productos2['fecha'], 0, 0, 'L');
    $pdf->Cell(30, 2, ' ' . number_format(($productos2['debe']), 2), 0, 0, 'R');
    $pdf->Cell(30, 2, ' ' . number_format(($productos2['haber']), 2), 0, 1, 'R');
    $pdf->Ln(2);
}
$pdf->Ln(5);
$pdf->Cell(0, 5, '', 'T', 1);
$pdf->Cell(115, 5, '', 0, 0);
$pdf->Cell(15, 5, 'TOTALES:', 0);
$pdf->Cell(30, 5, number_format($ddetall, 2), 0, 0, 'R');
$pdf->Cell(30, 5, number_format($hdetall, 2), 0, 1, 'R');
$pdf->Ln(8);
$pdf->Cell(0, 5, 'Concepto : ' . \utf8_decode($concepto), 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(20);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(250, 4, 'Firma Cliente :__________________________                            Responsable:__________________________', '', 1, 'C');

$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(250, 2, strtoupper($propi), '', 1, 'L');
$pdf->Cell(250, 5, strtoupper($func), '', 1, 'L');
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(195, 4, '', 'T', 0, 'L');

$pdf->Output();
mysqli_close($db);
?>