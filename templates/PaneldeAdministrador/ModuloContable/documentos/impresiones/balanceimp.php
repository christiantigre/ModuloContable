<?php
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>alert("Usuario no autenticado")
            self.location = "../../../../../../login.php"</script>';
}
require('../../../../fpdf/fpdf.php');
include '../../../../../templates/Clases/Conectar.php';
date_default_timezone_set("America/Guayaquil");
$dbi = new Conectar();
$c = $dbi->conexion();
$variableresponsable = $_GET['idlogeo'];
$mes = date('F');
$year = date('Y');
$variablerespo = $_SESSION['username'];
$user = $_SESSION['username'];

//include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
//    $accion="Exporto libro diario";
//    generaLogs($user, $accion);

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($c), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
    }
}

$selectsumadedatosbalance = "SELECT sum(debe) as debe,sum(haber) as haber FROM `totasientos`"
        . " WHERE `balance`='".$maxbalancedato."' and year='".$year."'";
$rssumas = mysqli_query($c, $selectsumadedatosbalance) or trigger_error("Query Failed! SQL: $selectsumadedatosbalance - Error: " . mysqli_error($c), E_USER_ERROR);
if ($rssumas) {
    while ($row3 = mysqli_fetch_assoc($rssumas)) {
        $ddetall = $row3['debe'];
        $hdetall = $row3['haber'];
    }
}


$datosempresa = mysqli_query($c,"SELECT * FROM `empresa`");
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
    $pdf->Image($img, 10, 3, 190, 20, $tip);
} Else {
    $pdf->Image("../../../images/fondoAzul.png", 10, 3, 190, 20, "png");
}
$pdf->Cell(18, 10, '', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(15);

$pdf->Cell(165, 7, 'Empresa :' . $nom_emp . '                    Direccion :' . \utf8_decode($dir) . '                    Correo :' . $mail, '', 2, 'L');
$pdf->Cell(165, 7, 'Ruc :' . $ruc . '                                                 Emitido :' . date('d-m-Y H:i') . '                                    Por :' . $variablerespo, '', 2, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'Contabilidad Anual - ' . $year, 0);
$pdf->Ln(22);
$pdf->Cell(0, 4, 'Pagina ' . $pdf->PageNo(), 'T', 1, 'R');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'Cod.', 0);
$pdf->Cell(90, 8, 'Cuenta', 0);
$pdf->Cell(25, 8, 'Fecha', 0);
$pdf->Cell(25, 8, 'Debe', 0);
$pdf->Cell(25, 8, 'Haber', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);

$sqlcargaconcepto = mysqli_query($c,"SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` ej,`concepto` c,fecha as f FROM `num_asientos` 
            WHERE `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' AND `t_ejercicio_idt_corrientes` ='1' "
        . "and year ='" . $year . "' order by ej");
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
ORDER BY ejercicio");

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
        . " and year ='" . $year . "' order by ej");
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
 ORDER BY asiento");

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



$pdf->Ln(8);
$pdf->Cell(50, 8, 'Total Debe :    ' . $ddetall . '      Total Haber :    ' . $hdetall);
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
$pdf->Cell(250, 2, strtoupper($propi), '', 1, 'L');
$pdf->Cell(250, 5, strtoupper($func), '', 1, 'L');
//Arial italic 8
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(195, 4, '', 'T', 0, 'L');

$pdf->Output();
?>