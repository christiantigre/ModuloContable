<?php
session_start();
$user=$_SESSION['username'];
require('../../fpdf/fpdf.php');
include_once '../../Clases/Conectar.php';
$dbi = new Conectar();
$db = $dbi->conexion();
$variableresponsable = $_GET['idlogeo'];
$id_asientourl = $_GET['id_asientourl'];
$feurl = $_GET['fechaurl'];
$date = date("Y-m-j");
$user = $_SESSION['username'];
$variablerespo = $user;

include '../../../templates/PanelAdminLimitado/Clases/guardahistorialcuentas.php';
    $accion="/ IMPRIMIR / Impresión de asiento ".$id_asientourl." fecha ".$date;
    generaLogs($user, $accion);

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
    }
}
$resDH = mysqli_query($db,"SELECT sum( j.debe ) AS d, sum( j.haber) AS h
FROM totasientos j
JOIN num_asientos n
WHERE j.asiento = n.t_ejercicio_idt_corrientes
AND j.asiento =".$id_asientourl."
AND j.fecha='".$feurl."' ");
while ($row4 = mysqli_fetch_array($resDH)) {
    $ddetall = $row4['d'];  
    $hdetall = $row4['h'];
}
  
$sqlcargaconcepto = mysqli_query($db,"SELECT n.`idnum_asientos` AS id, n.`t_ejercicio_idt_corrientes` as ej,
    n.`concepto` c,  n.fecha AS f
FROM `num_asientos` n
JOIN totasientos e
WHERE n.fecha = '".$feurl."'
AND n.`t_ejercicio_idt_corrientes` ='".$id_asientourl."'
GROUP BY `t_ejercicio_idt_corrientes`");
while ($row2 = mysqli_fetch_array($sqlcargaconcepto)) {
    $codgrupopdfas = $row2['ej']; 
    $concepto = $row2['c'];
    $f = $row2['f'];
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
$ruta = "../../../images/uploads/";
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
$dire = str_replace("ÃƒÂ±", "ñ", $dir);
$pdf->Cell(165, 7, 'Empresa :' . $nom_emp . '                    Direccion :' . utf8_decode($dire) . '                    Correo :' . $mail, '', 2, 'L');
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
$sql_transac = mysqli_query($db,"SELECT * FROM `totasientos`
 WHERE `balance`='".$maxbalancedato."'
 and asiento=".$id_asientourl." and fecha='".$feurl."' ");

while ($productos2 = mysqli_fetch_array($sql_transac)) {
    $pdf->Cell(15, 8, $productos2['cod_cuenta'], 0);
    $pdf->Cell(50, 8, utf8_decode($productos2['cuenta']), 0);
    $pdf->Cell(25, 8, $productos2['fecha'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['debe'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['haber'], 0);
    $pdf->Ln(8);
}
$pdf->Ln(8);
$pdf->Cell(50, 8, 'Total Debe :    ' . $ddetall . '      Total Haber :    ' . $hdetall);
$pdf->Ln(8);
$pdf->Cell(25, 8, 'Concepto : ' .utf8_decode($concepto) , 0);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(8);
$pdf->Ln(8);
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