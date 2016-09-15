<?php

session_start();
$_SESSION['username'];
require('../../../fpdf/fpdf.php');
include '../../../Clases/Conectar.php';
//include './fpdfclass/construc.php';
//$objconstruc = new PDFC;
//$constr=$objconstruc->Header();
$dbi = new Conectar();
$c = $dbi->conexion();
$variableresponsable = $_GET['idlogeo'];
$mes = date('F');
$year = date("Y");
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
//include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
//$accion = "Docs Imp catalogo de cuentas";
//generaLogs($user, $accion);
$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($c), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];
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
$ruta = "../../../../images/uploads/";
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

$pdf->Cell(165, 7, 'Empresa :' . $nom_emp . '                    Direccion :' . $dir . '                    Correo :' . $mail, '', 2, 'L');
$pdf->Cell(165, 7, 'Ruc :' . $ruc . '                                                 Emitido :' . date("d-m-Y H:i") . '                                    Por :' . $_SESSION['username'], '', 2, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'CATALAGO DE CUENTAS');
$pdf->Ln(22);
$pdf->Cell(0, 4, 'Pagina ' . $pdf->PageNo(), 'T', 1, 'R');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 8, 'Cod.', 0);
$pdf->Cell(60, 8, 'Cuenta', 0);
$pdf->Cell(40, 8, 'Descripcion', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);

$sqlcargaconcepto = mysqli_query($c, "SELECT idt_plan_de_cuentas, cod_cuenta as c, nombre_cuenta_plan as n, `descripcion_cuenta_plan` as d
FROM `t_plan_de_cuentas`
ORDER BY cod_cuenta");
while ($row2 = mysqli_fetch_array($sqlcargaconcepto)) {
    $codcuenta = $row2['c'];
    $comcuenta = $row2['n'];
    $descripcuenta = $row2['d'];
    $carpeta = str_replace('.', '', $codcuenta, $n);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(20, 5, utf8_decode('' . $codcuenta));
    if ($n == 0) {
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 5, utf8_decode('' . $comcuenta));
    }
    if ($n == 1) {
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 5, utf8_decode('' . $comcuenta));
    }
    if ($n == 2) {
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(60, 5, utf8_decode('   ' . $comcuenta));
    }
    if ($n == 3) {
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(100, 5, utf8_decode('      ' . $comcuenta));
    }
    if ($n == 4) {
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(120, 5, utf8_decode('             ' . $comcuenta));
    }
    if ($n == 5) {
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(140, 5, utf8_decode('                  ' . $comcuenta));
    }
    if ($n == 6) {
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(160, 5, utf8_decode('                       ' . $comcuenta));
    }
    $pdf->Cell(40, 5, utf8_decode('                            ' . $descripcuenta));
    $pdf->Ln(5);
}



$pdf->Ln(8);
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
$pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'C');
$pdf->Output();
mysqli_close($c);
?>