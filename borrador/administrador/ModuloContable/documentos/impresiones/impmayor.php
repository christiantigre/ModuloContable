<?php

require('../../../../../fpdf/fpdf.php');
require('../../../../../../php/conexion.php');
include '../../../../Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$variableresponsable = $_GET['idlogeo'];
$feurl = $_GET['fechaurl'];
$date = date("Y-m-j");

$consulresposable = mysqli_query($c, "SELECT l.username, u.tipo_user, l.idlogeo, concat( us.nombre, ' ', us.apellido ) AS responsable
FROM logeo l
JOIN user_tipo u
JOIN usuario us
WHERE l.user_tipo_iduser_tipo = u.iduser_tipo
AND us.idusuario = l.usuario_idusuario
AND l.idlogeo='$variableresponsable' ");
while ($row1 = mysqli_fetch_array($consulresposable)) {
    $variablerespo = $row1['responsable'];
    $user = $row1['username'];
}

include '../../../../Clases/guardahistorial.php';
$accion = "Docs Imp mayor " . $id_asientourl . " f " . $date;
generaLogs($user, $accion);

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_errno($c), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];
    }
}
$resDH = mysqli_query($c, "SELECT (
coalesce( debe_aj, 0 )
) + ( coalesce( debe, 0 ) ) AS sumdebe, (
coalesce( haber_aj, 0 )
) + ( coalesce( haber, 0 ) ) AS sumhaber, sum( sld_deudor ) AS deudor, sum( sld_acreedor ) AS acreedor
FROM `vistabalanceresultadosajustados`
WHERE year = '" . $feurl . "'
GROUP BY year");
while ($row4 = mysqli_fetch_array($resDH)) {
    $ddetall = $row4['sumdebe'];  //echo "<script>alert(".$ddetall.")</script>";
    $hdetall = $row4['sumhaber'];
    $deudor = $row4['deudor'];
    $acreedor = $row4['acreedor'];
}

$sqlcargaconcepto = mysqli_query($c, "SELECT `cod_cuenta` as cod, `cuenta` as cu , sum( debe ) as de , 
    sum( haber ) as h , `balance`  , `grupo` , `year`
FROM `totasientos`
WHERE `year` = '" . $feurl . "'
GROUP BY `cod_cuenta` order by cod_cuenta");
while ($row2 = mysqli_fetch_array($sqlcargaconcepto)) {
    $cod = $row2['cod'];
    $cu = $row2['cu'];
    $d = $row2['d'];
    $h = $row2['h'];
}
$datosempresa = mysqli_query($c, "SELECT `nombre`,`direccion`,`email`,`ruc`,`telefono`,`funcion`,`logo` FROM `empresa`");
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
$pdf->Image('../../../../../../images/logo.png', 10, 3, 190, 20, 'png');
$pdf->Cell(18, 10, '', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(15);

$pdf->Cell(165, 7, 'Empresa :' . $nom_emp . '                    Direccion :' . $dir . '                    Correo :' . $mail, '', 2, 'L');
$pdf->Cell(165, 7, 'Ruc :' . $ruc . '                                                 Emitido :' . date("d-m-Y H:i") . '                                    Por :' . $variablerespo, '', 2, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'Balance Inicial', 0);
$pdf->Ln(22);
$pdf->Cell(0, 4, 'Pagina ' . $pdf->PageNo(), 'T', 1, 'R');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'Cod.', 0);
$pdf->Cell(50, 8, 'Cuenta', 0);
//$pdf->Cell(25, 8, 'Fecha', 0);
$pdf->Cell(25, 8, 'Debe', 0);
$pdf->Cell(25, 8, 'Haber', 0);
$pdf->Cell(25, 8, 'Deudor', 0);
$pdf->Cell(25, 8, 'Acreedor', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$sql_transac = mysqli_query($c, "SELECT `cod_cuenta` , `cuenta` , `t_bl_inicial_idt_bl_inicial` as b , `tipo` , `year` , `mes` , (
coalesce( debe_aj, 0 )
) + ( coalesce( debe, 0 ) ) AS sumdebe, (
coalesce( haber_aj, 0 )
) + ( coalesce( haber, 0 ) ) AS sumhaber, `sld_deudor` , `sld_acreedor`
FROM `vistabalanceresultadosajustados`
WHERE year = '" . $feurl . "'
GROUP BY cod_cuenta");

while ($productos2 = mysqli_fetch_array($sql_transac)) {
    $pdf->Cell(15, 8, $productos2['cod_cuenta'], 0);
    $pdf->Cell(50, 8, $productos2['cuenta'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['sumdebe'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['sumhaber'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['sld_deudor'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['sld_acreedor'], 0);
    $pdf->Ln(8);
}
$pdf->Ln(8);
$pdf->Cell(50, 8, 'Total Debe :    ' . $ddetall . '      Total Haber :    ' . $hdetall . '              Deudor :' . $deudor . '             Acreedor :' . $acreedor);
$pdf->Ln(8);
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