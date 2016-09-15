<?php

session_start();
require('../../../../fpdf/fpdf.php');
$variableresponsable = $_SESSION['id_user'];
include_once '../../../../Clases/Conectar.php';
$dbi = new Conectar();
$db = $dbi->conexion();
$mes = date('F');
$year = date("Y");
$user = $_SESSION['username'];
$variablerespo = $_SESSION['username'];
$cta = $_GET['cod'];
$year = $_GET['year'];
$bl = $_GET['bl'];



$datosempresa = mysqli_query($db, "SELECT * FROM `empresa`");
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
    $pdf->Image("../../../../images/fondoAzul.png", 10, 3, 190, 20, "png");
}
$pdf->Cell(18, 10, '', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(15);
$ver_cta = "SELECT * FROM `t_plan_de_cuentas` WHERE `cod_cuenta`='" . $cta . "' ";
$res_ver = mysqli_query($db, $ver_cta) or trigger_error("Query Failed! SQL: $ver_cta - Error: " . mysqli_error($db), E_USER_ERROR);
if ($res_ver) {
    while ($row_cta = mysqli_fetch_assoc($res_ver)) {
        $cta_nom = $row_cta['nombre_cuenta_plan'];
    }
}
//$pdf->Cell(165, 7, 'datos:' . $cta, 2, 'L');
$direemp = str_replace("ÃƒÂ±", "ñ", $dir);
$pdf->Cell(165, 7, 'Empresa :' . $nom_emp . '                    Direccion :' . utf8_decode($direemp) . '                    Correo :' . $mail, '', 2, 'L');
$pdf->Cell(165, 7, 'Ruc :' . $ruc . '                                                 Emitido :' . date("d-m-Y H:i") . '                                    Por :' . $variablerespo, '', 2, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, utf8_decode('Mayorización '), 0);
$pdf->Ln(8);
$pdf->Cell(100, 8, $cta_nom . ' ', 0);
$pdf->Ln(22);
$pdf->Cell(0, 4, 'Pagina ' . $pdf->PageNo(), 'T', 1, 'R');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'FECHA', 0);
$pdf->Cell(25, 8, '# ASS', 0);
$pdf->Cell(25, 8, 'DEBE', 0);
$pdf->Cell(25, 8, 'HABER', 0);
$pdf->Cell(25, 8, 'CONCEPTO', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);

$sql_my = "SELECT v.`fecha` , v.`cuenta` as c , v.`valor` , v.`valorp` , v.`t_bl_inicial_idt_bl_inicial` , v.ejercicio AS j, n.concepto FROM `v_mayorizacionaux` v JOIN num_asientos n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`t_bl_inicial_idt_bl_inicial` = n.t_bl_inicial_idt_bl_inicial "
        . "and v.t_bl_inicial_idt_bl_inicial='" . $bl . "' AND v.cod_cuenta = '" . $cta . "' AND v.year = '" . $year . "'";
$sqlcargaconcepto = mysqli_query($db, $sql_my);

$sqlaj = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`debe` , v.`haber` , v.`balance` , v.ejercicio AS j,"
        . " n.concepto FROM `vmayorizacionajustes` v JOIN num_asientos_ajustes n WHERE "
        . "v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`balance` = n.t_bl_inicial_idt_bl_inicial and"
        . " v.balance='" . $bl . "' AND v.cod_cuenta = '" . $cta . "' AND v.year = '" . $year . "'";
                                                    $resulaj = mysqli_query($db, $sqlaj);

$result_d_m_mayor = mysqli_query($db, "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, 
        sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,
        sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sldeu,
        sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as slacr FROM vistabalanceresultadosajustados WHERE 
        `t_bl_inicial_idt_bl_inicial`='" . $bl . "' and year='" . $year . "' and cod_cuenta='" . $cta . "'");


while ($productos2l = mysqli_fetch_array($sqlcargaconcepto)) {
    $pdf->Cell(15, 8, $productos2l['fecha'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2l['j'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2l['valor'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2l['valorp'], 0);
    $dire = str_replace("ÃƒÂ±", "ñ", $productos2l['concepto']);
    $pdf->Cell(25, 8, ' ' . utf8_decode($dire), 0);
    $pdf->Ln(8);
}
$pdf->Cell(15, 8, 'AJUSTES', 0);
$pdf->Ln(8);
while ($productos2ll = mysqli_fetch_array($resulaj)) {
    $pdf->Cell(15, 8, $productos2ll['fecha'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2ll['j'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2ll['debe'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2ll['haber'], 0);
    $dire = str_replace("ÃƒÂ±", "ñ", $productos2ll['concepto']);
    $pdf->Cell(25, 8, ' ' . utf8_decode($dire), 0);
    $pdf->Ln(8);
}

$pdf->Ln(8);
$pdf->Cell(15, 8, 'DEBE', 0);
$pdf->Cell(25, 8, 'HABER', 0);
$pdf->Cell(25, 8, 'DEUDOR', 0);
$pdf->Cell(25, 8, 'ACREEDOR', 0);
$pdf->Ln(8);
while ($productos2l = mysqli_fetch_array($result_d_m_mayor)) {
    $pdf->Cell(15, 8, $productos2l['debe'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2l['haber'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2l['sldeu'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2l['slacr'], 0);
    $pdf->Ln(8);
}
$pdf->Ln(8);




$pdf->Ln(8);
//$pdf->Cell(50, 8, 'Total Debe :    ' . $mayor_debe . '      Total Haber :    ' . $mayor_haber);
$pdf->Ln(8);
//$pdf->Cell(50, 8, 'Total Deudor :    ' . $mayor_sldue . '      Total acreedor :    ' . $mayor_sldacr);
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
mysqli_close($db);
?>