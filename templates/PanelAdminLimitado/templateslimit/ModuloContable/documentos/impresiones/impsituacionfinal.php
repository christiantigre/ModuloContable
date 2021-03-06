<?php
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>alert("Usuario no autenticado")
            self.location = "../../../../../../login.php"</script>';
}
date_default_timezone_set("America/Guayaquil");
require('../../../../../fpdf/fpdf.php');
include '../../../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$variableresponsable = $_GET['prmlg'];
$year = date("Y");
$variablerespo = $_SESSION['username'];
$user = $_SESSION['username'];


include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
    $accion="Imprimio Situacion final";
    generaLogs($user, $accion);



$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($c), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
    }
}

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
$ruta = "../../../../../../images/uploads/";
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
$pdf->Cell(0, 7, ' ESTADO DE RESULTADOS', 0, 1, 'C');
$pdf->Cell(0, 8, 'Pagina ' . $pdf->PageNo(), 'T', 1, 'R');
$pdf->Cell(0, 5, '', 'T', 1);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(8);
$sql_ingresos = "SELECT codigo,cuenta,total FROM estadoresultados where codigo between '4.' and '4.99.99.99.' ORDER BY codigo ASC";

$sql_carga_balance = mysqli_query($c, $sql_ingresos);
$datosIngreso = array(); 
while ($row3 = mysqli_fetch_array($sql_carga_balance)) {
    $numIng = mysqli_num_rows($sql_carga_balance);
    $str = strlen($row3['codigo']);
    $pdf->Cell(15, 0, $row3['codigo'], 0);
    $pdf->Cell(90, 0, $row3['cuenta'], 20);
    if ($str == 2) {
        $pdf->Cell(90, 0, round($row3['total'], 2, 1), 0, 1, 'R');
        for ($i=0; $i<=count($numIng); $i++){
            $datosIngreso[] = $row3['total'];
        } 
    } elseif ($str == 4) {
        $pdf->Cell(65, 0, round($row3['total'], 2, 1), 0, 1, 'R');
    } elseif ($str == 6) {
        $pdf->Cell(40, 0, round($row3['total'], 2, 1), 0, 1, 'R');
    } elseif ($str == 8) {
        $pdf->Cell(15, 0, round($row3['total'], 2, 1), 0, 1, 'R');
    }
    $pdf->Ln(8);
}

$pdf->Ln(8);
$sql_gastos = "SELECT codigo,cuenta,total FROM estadoresultados where codigo between '5.' and '5.99.99.99.' ORDER BY codigo ASC";

$sql_carga_gastos = mysqli_query($c, $sql_gastos);
$datosGastos = array(); 
while ($row4 = mysqli_fetch_array($sql_carga_gastos)) {
    $numGas = mysqli_num_rows($sql_carga_gastos);
    $str = strlen($row4['codigo']);
    $pdf->Cell(15, 0, $row4['codigo'], 0);
    $pdf->Cell(90, 0, $row4['cuenta'], 20);
    if ($str == 2) {
        $pdf->Cell(90, 0, round($row4['total'], 2, 1), 0, 1, 'R');
        for ($j=0; $j<=count($numGas); $j++){
           $datosGastos[] = $row4['total'];
        } 
    } elseif ($str == 4) {
        $pdf->Cell(65, 0, round($row4['total'], 2, 1), 0, 1, 'R');
    } elseif ($str == 6) {
        $pdf->Cell(40, 0, round($row4['total'], 2, 1), 0, 1, 'R');
    } elseif ($str == 8) {
        $pdf->Cell(15, 0, round($row4['total'], 2, 1), 0, 1, 'R');
    }
    $pdf->Ln(8);
}

$utilidad = $datosIngreso[0] - $datosGastos[0];
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(125, 0, "UTILIDAD", 0, 1, 'R');
$pdf->Cell(195, 0, round($utilidad, 2, 1), 0, 1, 'R');


$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(8);
$pdf->Ln(8);
$pdf->Cell(250, 4, 'Firma Cliente :__________________________                            Responsable:__________________________', '', 1, 'C');
//Arial italic 8
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(250, 2, strtoupper($propi), '', 1, 'L');
$pdf->Cell(250, 5, strtoupper($func), '', 1, 'L');
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(195, 4, '', 'T', 0, 'L');

$pdf->Output();
?>