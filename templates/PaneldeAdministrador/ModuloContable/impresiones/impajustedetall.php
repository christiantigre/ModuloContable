<?php

session_start();
require('../../../fpdf/fpdf.php');
include_once '../../../Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$db = $dbi->conexion();
$variableresponsable = $_GET['idlogeo'];
$user = $_SESSION['username'];
$variablerespo = $_SESSION['username'];

//$feurl = $_GET['fechaurl'];
if (isset($feurl)) {
    $feurl = $_GET['fechaurl'];
} else {
    $y = $_GET['y'];
    $m = $_GET['m'];
    $d = $_GET['d'];
    if ($m == '1') {
    $ms = '01';
}
if ($m == '2') {
    $ms = '02';
}
if ($m == '3') {
    $ms = '03';
}
if ($m == '4') {
    $ms = '04';
}
if ($m == '5') {
    $ms = '05';
}
if ($m == '6') {
    $ms = '06';
}
if ($m == '7') {
    $ms = '07';
}
if ($m == '8') {
    $ms = '08';
}
if ($m == '9') {
    $ms = '09';
}
if ($m == '10') {
    $ms = '10';
}
if ($m == '11') {
    $ms = '11';
}
if ($m == '12') {
    $ms = '12';
}
    $feurl = $y.'-'.$ms.'-'.$d;
}
$date = date("Y-m-j");
$mes = date('F');
$year = date("Y");
$idasientourl = $_GET['id_asientourl'];
//include '../../../Clases/guardahistorialimp.php';
//$accion = " / IMP / Impresion asiento ajuste " . $idasientourl;
//generaLogs($user, $accion);
$sql_selectultimoingreso = mysqli_query($c, "SELECT max(idlibro) as lasting FROM `libro`");
while ($rwultimoingresodeasiento = mysqli_fetch_array($sql_selectultimoingreso)) {
    $id_asientourl = $rwultimoingresodeasiento['lasting'];
}

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($db), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];
    }
}


$sqlcargaconcepto = mysqli_query($c, "SELECT `idnum_asientos_ajustes` AS id, `t_ejercicio_idt_corrientes` ej,
    `concepto` c, fecha AS f, saldodebe AS sald, saldohaber AS salh
FROM `num_asientos_ajustes` 
WHERE
 t_bl_inicial_idt_bl_inicial = '" . $maxbalancedato . "' and t_ejercicio_idt_corrientes = " . $idasientourl . "
AND year = '" . $year . "'
ORDER BY `t_ejercicio_idt_corrientes`");
while ($row2 = mysqli_fetch_array($sqlcargaconcepto)) {
    $codgrupopdfas = $row2['ej'];
    $concepto = $row2['c'];
    $sdebe2 = $row2['sald'];
    $shaber2 = $row2['salh'];
}
$sqlcargasuma = mysqli_query($c, "SELECT sum(valor) as sd,SUM(valorp) as sh "
        . "FROM `ajustesejercicio` WHERE `ejercicio`=" . $idasientourl . " and `fecha`='" . $feurl . "' ");
while ($rows = mysqli_fetch_array($sqlcargasuma)) {
    $sdebe = $rows['sd'];
    $shaber = $rows['sh'];
}
//echo "<script>alert('.$codgrupopdf.')</script>";
$datosempresa = mysqli_query($c, "SELECT * FROM `empresa`");
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
$ruta = "../../../../images/uploads/";
if ($foto != "") {
    $img = $ruta . "" . $foto;
    $for = strstr($tipo, '/', true);
    $tip = substr(strstr($tipo, '/'), 1);
    $pdf->Image($img, 10, 3, 190, 20, $tip);
} Else {
    $pdf->Image("../../../images/fondoAzul.png", 10, 3, 190, 20, "png");
}
$pdf->Cell(18, 10, '', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(15);

$pdf->Cell(165, 7, 'Empresa :' . $nom_emp . '                    Direccion :' . $dir . '                    Correo :' . $mail, '', 2, 'L');
$pdf->Cell(165, 7, 'Ruc :' . $ruc . '                                                 Emitido :' . date("d-m-Y H:i") . '                                    Por :' . $variablerespo, '', 2, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'Comprobante de Asiento generado', 0);
$pdf->Ln(22);
$pdf->Cell(0, 4, 'Pagina ' . $pdf->PageNo(), 'T', 1, 'R');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'Cod.', 0);
$pdf->Cell(50, 8, 'Cuenta', 0);
$pdf->Cell(25, 8, 'Fecha', 0);
$pdf->Cell(25, 8, 'Debe', 0);
$pdf->Cell(25, 8, 'Haber', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$sql_transac = mysqli_query($c, "SELECT * FROM `ajustesejercicio`
 WHERE `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "'
 and ejercicio=" . $codgrupopdfas . " and fecha='" . $feurl . "' ");

$pdf->SetFillColor(224, 235, 255);
$pdf->Cell(179, 5, utf8_decode('Asiento ' . $codgrupopdfas), 1, 1, 'C', true);
$pdf->Ln(8);

while ($productos2 = mysqli_fetch_array($sql_transac)) {
    $pdf->Cell(15, 8, $productos2['cod_cuenta'], 0);
    $pdf->Cell(50, 8, $productos2['cuenta'], 0);
    $pdf->Cell(25, 8, $productos2['fecha'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['valor'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['valorp'], 0);
    $pdf->Ln(8);
}
$pdf->Ln(8);
$pdf->Cell(50, 8, 'Total Debe :    ' . $sdebe);
$pdf->Ln(4);
$pdf->Cell(50, 8, 'Total Haber :    ' . $shaber);
$pdf->Ln(4);
$pdf->Ln(4);
$pdf->Cell(25, 8, 'Concepto : ' . $concepto, 0);
$pdf->SetFont('Arial', 'B', 8);
//$pdf->SetY(-20);
//Arial italic 8
$pdf->Ln(8);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(250, 4, 'Firma Cliente :__________________________                            Responsable:__________________________', '', 1, 'C');
//Arial italic 8
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(250, 2, strtoupper($propi), '', 1, 'L');
$pdf->Cell(250, 5, strtoupper($func), '', 1, 'L');
//Arial italic 8
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(195, 4, '', 'T', 0, 'L');

$pdf->Output();
mysqli_close($db);
?>