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
$variableresponsable = $_GET['idlogeo'];
$date = date("Y-m-j");
$feurl = date("Y");
$variablerespo = $_SESSION['username'];
$user = $_SESSION['username'];

include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
$accion = " / Documentos / Imprimio mayor periodo " . $feurl;
generaLogs($user, $accion);

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_errno($c), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];
    }
}
$resDH = mysqli_query($c, "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as sdeb, "
        . "sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as shab,"
        . "sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sldeu,"
        . "sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as slacr FROM vistabalanceresultadosajustados WHERE "
        . "`t_bl_inicial_idt_bl_inicial`='".$maxbalancedato."'");
while ($row4 = mysqli_fetch_array($resDH)) {
    $ddetall = $row4['sdeb'];  //echo "<script>alert(".$ddetall.")</script>";
    $hdetall = $row4['shab'];
    $deudor = $row4['sldeu'];
    $acreedor = $row4['slacr'];
}

$sqlcargaconcepto = mysqli_query($c, "SELECT `cod_cuenta` as cod, `cuenta` as cu , sum( debe ) as de , 
    sum( haber ) as h , `balance`  , `grupo` , `year`
FROM `totasientos`
WHERE `year` = '" . $feurl . "'
GROUP BY `cod_cuenta` order by cod_cuenta");
while ($row2 = mysqli_fetch_array($sqlcargaconcepto)) {
    $cod = $row2['cod'];
    $cu = $row2['cu'];
    $d = $row2['de'];
    $h = $row2['h'];
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
    $pdf->Image($img, 10, 3, 190, 20, $tip);
} Else {
    $pdf->Image("../../../../images/fondoAzul.png", 10, 3, 190, 20, "png");
}
$pdf->Cell(18, 10, '', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(15);
$dire = str_replace("ÃƒÂ±", "ñ", $dir);
$pdf->Cell(165, 7, 'Empresa : ' . $nom_emp . '                    Direccion : ' . utf8_decode($dire) . '                    Correo : ' . $mail, '', 2, 'L');
$pdf->Cell(165, 7, 'Ruc : ' . $ruc . '                                                 Emitido : ' . date("d-m-Y H:i") . '                                    Por : ' . strtoupper($variablerespo), '', 2, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'LIBRO MAYOR', 0);
$pdf->Ln(22);
$pdf->Cell(0, 4, 'Pagina ' . $pdf->PageNo(), 'T', 1, 'R');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'Cod.', 0);
$pdf->Cell(90, 8, 'Cuenta', 0);
//$pdf->Cell(25, 8, 'Fecha', 0);
$pdf->Cell(25, 8, 'Debe', 0);
$pdf->Cell(25, 8, 'Haber', 0);
$pdf->Cell(25, 8, 'Deudor', 0);
$pdf->Cell(25, 8, 'Acreedor', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$sql_transac = mysqli_query($c, "SELECT `cod_cuenta`, `cuenta`, 
    sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0)) as sdeb, 
    sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0)) as shab, 
    sum(COALESCE(debe_aj, 0)+COALESCE(debe,0)) - sum(COALESCE(haber_aj, 0) + COALESCE(haber, 0)) as sldeu, 
    CONCAT('0.00') as slacr FROM vistabalanceresultadosajustados WHERE `t_bl_inicial_idt_bl_inicial` = '".$maxbalancedato."' 
    group BY cod_cuenta, cod_cuenta_aj HAVING sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0))>sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0))
UNION
SELECT `cod_cuenta`, `cuenta`, sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0)) as sdeb, sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0)) as shab,
CONCAT('0.00') as slacr, sum(COALESCE(haber_aj, 0) + COALESCE(haber, 0))-sum(COALESCE(debe_aj, 0)+COALESCE(debe,0)) as sldeu  FROM vistabalanceresultadosajustados WHERE 
`t_bl_inicial_idt_bl_inicial` = '".$maxbalancedato."' group BY cod_cuenta, cod_cuenta_aj HAVING sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0))<sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0))
order by cod_cuenta");

while ($productos2 = mysqli_fetch_array($sql_transac)) {
    $pdf->Cell(15, 8, $productos2['cod_cuenta'], 0);
    $pdf->Cell(90, 8, $productos2['cuenta'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['sdeb'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['shab'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['sldeu'], 0);
    $pdf->Cell(25, 8, ' ' . $productos2['slacr'], 0);
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
$pdf->Cell(250, 2, strtoupper($propi), '', 1, 'L');
$pdf->Cell(250, 5, strtoupper($func), '', 1, 'L');
//Arial italic 8
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(195, 4, '', 'T', 0, 'L');

$pdf->Output();
?>