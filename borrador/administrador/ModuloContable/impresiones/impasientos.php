<?php
require('../../../../fpdf/fpdf.php');
require('../../../../../php/conexion.php'); 
$variableresponsable = $_GET['idlogeo'];
$feurl = $_GET['fech_url'];
$id_asientourl= $_GET['id_asientourl'];
//echo "<script>alert('.$id_asientourl.')</script>";
$consulresposable = mysql_query("SELECT l.username, u.tipo_user, l.idlogeo, concat( us.nombre, ' ', us.apellido ) AS responsable
FROM logeo l
JOIN user_tipo u
JOIN usuario us
WHERE l.user_tipo_iduser_tipo = u.iduser_tipo
AND us.idusuario = l.usuario_idusuario
AND l.idlogeo='$variableresponsable' ");
while ($row1 = mysql_fetch_array($consulresposable)) {
    $variablerespo = $row1['responsable'];
}

$db = new mysqli("localhost", "root", "alberto2791", "condata");
$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
    }
}

$resDH = mysql_query(" SELECT sum( j.debe ) AS d, sum( j.haber ) AS h
FROM libro j
JOIN num_asientos n
WHERE j.asiento = n.t_ejercicio_idt_corrientes
AND j.asiento =".$id_asientourl."
AND j.t_bl_inicial_idt_bl_inicial =".$maxbalancedato.""
        . " ");
while ($row4 = mysql_fetch_array($resDH)) {
    $ddetall = $row4['d'];  //echo "<script>alert(".$ddetall.")</script>";
    $hdetall = $row4['h'];
}


$sqlcargaconcepto = mysql_query("SELECT n.`idnum_asientos` AS id, n.`t_ejercicio_idt_corrientes` as ej, n.`concepto` as c,
concat( u.nombre,' ', u.apellido ) AS Empleado, s.tipo_user AS Cargo
FROM `num_asientos` n JOIN libro e JOIN logeo l JOIN usuario u JOIN user_tipo s
WHERE e.asiento = n.t_ejercicio_idt_corrientes AND e.fecha = n.fecha
AND e.logeo_idlogeo = l.user_tipo_iduser_tipo AND l.usuario_idusuario = u.idusuario
AND s.iduser_tipo = l.user_tipo_iduser_tipo
AND n.fecha = '".$feurl."' and e.asiento=".$id_asientourl." GROUP BY `t_ejercicio_idt_corrientes`");
while ($row2 = mysql_fetch_array($sqlcargaconcepto)) {
    $codgrupopdfas = $row2['ej']; 
    $concepto = $row2['c'];
}
//echo "<script>alert('.$codgrupopdfas.')</script>";
$datosempresa = mysql_query("SELECT `nombre`,`direccion`,`email`,`ruc`,`telefono`,`funcion`,`logo` FROM `empresa`");
while ($row = mysql_fetch_array($datosempresa)) {
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
$pdf->Image('../../../../../images/logo.png', 10, 3, 190, 20, 'png');
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
$sql_transac = mysql_query("SELECT * FROM `libro`
 WHERE `t_bl_inicial_idt_bl_inicial`='".$maxbalancedato."' and asiento=".$id_asientourl." and fecha='".$feurl."' ");

while ($productos2 = mysql_fetch_array($sql_transac)) {
    $pdf->Cell(15, 8, $productos2['ref'], 0);
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