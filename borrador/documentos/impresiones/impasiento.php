<?php
session_start();
require('../../../fpdf/fpdf.php');
//require('../../../php/conexion.php'); 
include '../../../Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$variableresponsable = $_GET['idlogeo'];
$id_asientourl = $_GET['id_asientourl'];
$feurl = $_GET['fechaurl'];
$date = date("Y-m-j");

$consulresposable = mysqli_query($c,"SELECT l.username, u.tipo_user, l.idlogeo, concat( us.nombre, ' ', us.apellido ) AS responsable
FROM logeo l
JOIN user_tipo u
JOIN usuario us
WHERE l.user_tipo_iduser_tipo = u.iduser_tipo
AND us.idusuario = l.usuario_idusuario
AND l.idlogeo='$variableresponsable' ");
while ($row1 = mysqli_fetch_array($consulresposable)) {
    $variablerespo = $row1['responsable'];
    $user=$row1['username'];
}

//include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
//    $accion="Impresion B Inicial ".$id_asientourl." f ".$date;
//    generaLogs($user, $accion);

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_errno($c), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
    }
}
$resDH = mysqli_query($c,"SELECT sum( j.debe ) AS d, sum( j.haber) AS h
FROM totasientos j
JOIN num_asientos n
WHERE j.asiento = n.t_ejercicio_idt_corrientes
AND j.asiento =".$id_asientourl."
AND j.year='".$feurl."' ");
while ($row4 = mysqli_fetch_array($resDH)) {
    $ddetall = $row4['d'];  //echo "<script>alert(".$ddetall.")</script>";
    $hdetall = $row4['h'];
}
  
$sqlcargaconcepto = mysqli_query($c,"SELECT n.`idnum_asientos` AS id, n.`t_ejercicio_idt_corrientes` ej, n.`concepto` c, concat( u.nombre, ' ', u.apellido ) AS Empleado, s.tipo_user AS Cargo, n.fecha AS f
FROM `num_asientos` n
JOIN totasientos e
JOIN logeo l
JOIN usuario u
JOIN user_tipo s
WHERE e.asiento = n.t_ejercicio_idt_corrientes
AND e.fecha = n.fecha
AND e.logeo = l.user_tipo_iduser_tipo
AND l.usuario_idusuario = u.idusuario
AND s.iduser_tipo = l.user_tipo_iduser_tipo
AND n.year = '".$feurl."'
AND n.`t_ejercicio_idt_corrientes` ='".$id_asientourl."'
GROUP BY `t_ejercicio_idt_corrientes`");
while ($row2 = mysqli_fetch_array($sqlcargaconcepto)) {
    $codgrupopdfas = $row2['ej']; 
    $concepto = $row2['c'];
    $f = $row2['f'];
}
//echo "<script>alert('.$codgrupopdf.')</script>";
$datosempresa = mysqli_query($c,"SELECT `nombre`,`direccion`,`email`,`ruc`,`telefono`,`funcion`,`logo` FROM `empresa`");
while ($row = mysqli_fetch_array($datosempresa)) {
    $nom_emp = $row['nombre'];
    $dir = $row['direccion'];
    $mail = $row['email'];
    $ruc = $row['ruc'];
    $tel = $row['telefono'];
    $func = $row['funcion'];
    $logo = $row['logo'];
}
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Image('../../../../images/logo.png', 10, 3, 190, 20, 'png');
$pdf->Cell(18, 10, '', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(15);

$pdf->Cell(165, 7, 'Empresa :' . $nom_emp . '                    Direccion :' . $dir . '                    Correo :' . $mail, '', 2, 'L');
$pdf->Cell(165, 7, 'Ruc :' . $ruc . '                                                 Emitido :' . date("d-m-Y H:i") . '                                    Por :' . $_SESSION['username'], '', 2, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'Balance Inicial', 0);
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
$sql_transac = mysqli_query($c,"SELECT * FROM `totasientos`
 WHERE `balance`='".$maxbalancedato."'
 and asiento=".$id_asientourl." and year='".$feurl."' ");

while ($productos2 = mysqli_fetch_array($sql_transac)) {
    $pdf->Cell(15, 8, $productos2['cod_cuenta'], 0);
    $pdf->Cell(50, 8, $productos2['cuenta'], 0);
    $pdf->Cell(25, 8, $productos2['fecha'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['debe'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['haber'], 0);
    $pdf->Ln(8);
}
$pdf->Ln(8);
$pdf->Cell(50, 8, 'Total Debe :    ' . $ddetall . '      Total Haber :    ' . $hdetall);
$pdf->Ln(8);
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
$pdf->Cell(250, 2, 'VLADIMIR ENDERICA', '', 1, 'L');
$pdf->Cell(250, 5, 'AUTOMOTORES ', '', 1, 'L');
//Arial italic 8
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(195, 4, '', 'T', 0, 'L');

$pdf->Output();
?>