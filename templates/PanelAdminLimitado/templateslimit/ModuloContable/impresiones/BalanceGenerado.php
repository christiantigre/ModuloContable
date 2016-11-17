<?php

session_start();
if (!$_SESSION) {
    echo '<script language = javascript>alert("Usuario no autenticado")
    self.location = "../../../login.php"</script>';
}
require('../../../../fpdf/fpdf.php');
include_once '../../../../Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$db = $dbi->conexion();
$variablerespo = $_SESSION['loginu'];
$year = date("Y");

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($db), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];
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
$pdf->Cell(0, 7, ' BALANCE INICIAL DEL PERIODO ', 0, 1, 'C');
$pdf->Cell(0, 8, 'Pagina ' . $pdf->PageNo(), 'T', 1, 'R');
$pdf->Cell(0, 5, '', 'T', 1);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(8);
$pdf->Cell(20, 0, 'Cod.', 0);
$pdf->Cell(105, 0, 'Cuenta', 0);
$pdf->Cell(25, 0, 'Debe', 0, 0, 'R');
$pdf->Cell(25, 0, 'Haber', 0, 0, 'R');
$pdf->Ln(8);

$sql_carga_balance = mysqli_query($db, "SELECT 
    v.fecha AS f, v.cod_cuenta AS codcuenta, p.nombre_cuenta_plan AS cuenta, v.tipo AS grupo, v.sum_deudor, v.sum_acreedor
    FROM hoja_de_trabajo v
    JOIN t_grupo g
    JOIN t_plan_de_cuentas p
    WHERE v.`tipo` = g.cod_grupo
    AND p.cod_cuenta = v.cod_cuenta
    AND v.year = '" . $year . "'
    AND v.t_bl_inicial_idt_bl_inicial = '" . $maxbalancedato . "'
    ORDER BY tipo");
while ($row3 = mysqli_fetch_array($sql_carga_balance)) {
    $pdf->Cell(20, 0, $row3['codcuenta'], 0);
    $pdf->Cell(120, 0, $row3['cuenta'], 20);
    $pdf->Cell(25, 0, number_format(($row3['sum_deudor']), 2), 20);
    $pdf->Cell(25, 0, number_format(($row3['sum_acreedor']), 2), 20);
    $pdf->Ln(8);
}

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
?>