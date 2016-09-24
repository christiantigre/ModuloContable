<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
if (!$_SESSION) {
    echo '<script language = javascript>alert("Usuario no autenticado")
            self.location = "../../../login.php"</script>';
}
require('../../../../fpdf/fpdf.php');
include_once '../../../../Clases/Conectar.php';
include '../../../../Clases/acentos.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$db = $dbi->conexion();
$variablerespo = $_SESSION['loginu'];
$year = date("Y");
$datemin = $_GET['datemin'];
$datemax = $_GET['datemax'];
//echo $datemin.' - '.$datemax;

$consulta = "SELECT max( idt_bl_inicial ) as id,year as yearcont FROM `t_bl_inicial`";
$result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($db), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];
        $yearcont = $row['yearcont'];
    }
}


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
    $pdf->Image($img, 10, 3, 80, 20, $tip);
} Else {
    $pdf->Image("../../../../images/fondoAzul.png", 10, 3, 80, 20, "png");
}
$pdf->Cell(18, 10, '', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(15);
$dire = str_replace("ÃƒÂ±", "ñ", $dir);
$pdf->Cell(126, 7, 'Direccion : ' . \utf8_decode($dire), 0, 0, 'L');
$pdf->Cell(63, 7, 'Correo : ' . $mail, 0, 1, 'R');
$pdf->Cell(63, 7, 'Ruc : ' . $ruc, 0, 0, 'L');
$pdf->Cell(63, 7, 'Emitido : ' . date("d-m-Y H:i"), 0, 0, 'C');
$pdf->Cell(63, 7, 'Por : ' . $variablerespo, 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 7, ' ESTADO DE SITUACION FINANCIERA', 0, 1, 'C');
$datemn = explode('-', $datemin);
$diadesde = $datemn[2];
$mesdesde = $datemn[1];
$yeardesde = $datemn[0];
$datemx = explode('-', $datemax);
$diahastamx = $datemx[2];
$meshastamx = $datemx[1];
$yearhastamx = $datemx[0];
if ($yeardesde == $yearhastamx) {
    $yearfiltro = $yeardesde;
} else {
    $yearfiltro = date('Y');
}
$pdf->Cell(0, 7, ' Del ' . $diadesde . ' de ' . MonthNumber($mesdesde) . ' Al ' . $diahastamx . ' de ' . MonthNumber($meshastamx) . ' del ' . $yearfiltro, 0, 1, 'C');
$pdf->Cell(0, 8, 'Pagina ' . $pdf->PageNo(), 'T', 1, 'R');
$pdf->Cell(0, 5, '', 'T', 1);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(8);
$sql_ingresos = "SELECT * FROM tempestadoresultados where fecha between '" . $datemin . "' and '" . $datemax . "' and codigo <='3.1.1.2.' ORDER BY codigo ASC";


$sql_carga_balance = mysqli_query($c, $sql_ingresos);
$datosIngreso = array();
while ($row3 = mysqli_fetch_array($sql_carga_balance)) {
    $numIng = mysqli_num_rows($sql_carga_balance);
    $str = strlen($row3['codigo']);
    $pdf->Cell(15, 0, $row3['codigo'], 0);
    $pdf->Cell(90, 0, $row3['cuenta'], 20);
    if ($str == 2) {
        $pdf->Cell(90, 0, round($row3['total'], 2, 1), 0, 1, 'R');
        for ($i = 0; $i <= count($numIng); $i++) {
            $datosIngreso[] = $row3['total'];
        }
    } elseif ($str == 4) {
        $pdf->Cell(75, 0, round($row3['total'], 2, 1), 0, 1, 'R');
    } elseif ($str == 6) {
        $pdf->Cell(60, 0, round($row3['total'], 2, 1), 0, 1, 'R');
    } elseif ($str == 8) {
        $pdf->Cell(45, 0, round($row3['total'], 2, 1), 0, 1, 'R');
        $pdf->Ln(8);
        $ctsmovimiento = "SELECT * FROM `agrupacion` WHERE subcuenta='" . $row3['codigo'] . "'";
        $resulmv = mysqli_query($c, $ctsmovimiento)or trigger_error("Query Failed! SQL: $ctsmovimiento - Error: " . mysqli_error($mysqli), E_USER_ERROR);
        while ($row4 = mysqli_fetch_array($resulmv)) {
            $pdf->Cell(15, 0, $row4['referencia'], 0);
            $cts = "SELECT nombre_cuenta_plan FROM `t_plan_de_cuentas` WHERE cod_cuenta='" . $row4['referencia'] . "'";
            $resulct = mysqli_query($c, $cts)or trigger_error("Query Failed! SQL: $cts- Error: " . mysqli_error($mysqli), E_USER_ERROR);
            while ($row5 = mysqli_fetch_array($resulct)) {
                $pdf->Cell(90, 0, $row5['nombre_cuenta_plan'], 20);
//                $pdf->Ln(8);
            }
            if ($row4['deudor'] > $row4['acreedor']) {
                $total = $row4['deudor'];
            } elseif ($row4['acreedor'] > $row4['deudor']) {
                $total = ('-' . $row4['acreedor']);
            }
            $pdf->Cell(35, 0, round($total, 2, 1), 0, 1, 'R');
            $pdf->Ln(8);
        }
    }
    $pdf->Ln(8);
}

$pdf->Ln(8);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(8);
$pdf->Cell(250, 4, 'Firma Cliente :__________________________                            Responsable:__________________________', '', 1, 'C');
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(250, 2, strtoupper($propi), '', 1, 'L');
$pdf->Cell(250, 5, strtoupper($func), '', 1, 'L');
//Arial italic 8
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(195, 4, '', 'T', 0, 'L');

$pdf->Output();
mysqli_close($db);
mysqli_close($c);
include '../../../Clases/guardahistorialimp.php';
$accion = " / IMP / Impresion Situacion Final desde " . $datemin . " hasta " . $datemax;
generaLogs($variablerespo, $accion);
?>

