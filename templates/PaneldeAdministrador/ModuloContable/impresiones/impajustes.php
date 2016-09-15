<?php

require('../../../../fpdf/fpdf.php');
include_once '../../../../Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$db = $dbi->conexion();
$variableresponsable = $_GET['idlogeo'];
$feurl = $_GET['fechaurl'];
$date = date("Y-m-j");
$mes = date('F');
$year = date("Y");
$idasientourl = $_GET['id_asientourl'];
$consulresposable = mysqli_query($db,"SELECT l.username, u.tipo_user, l.idlogeo, concat( us.nombre, ' ', us.apellido ) AS responsable
FROM logeo l
JOIN user_tipo u
JOIN usuario us
WHERE l.user_tipo_iduser_tipo = u.iduser_tipo
AND us.idusuario = l.usuario_idusuario
AND l.idlogeo='$variableresponsable' ");
while ($row1 = mysqli_fetch_array($consulresposable)) {
    $variablerespo = $row1['responsable'];
}

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($db), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];    
    }
}

$datosempresa = mysqli_query($db,"SELECT `nombre`,`direccion`,`email`,`ruc`,`telefono`,`funcion`,`logo` FROM `empresa`");
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


$sqlcargaconcepto = mysqli_query($db,"SELECT n.t_ejercicio_idt_corrientes as ej, n.concepto as c FROM `num_asientos_ajustes` n "
        . " where num_asientos_idnum_asientos='" . $idasientourl . "' ");
while ($row2 = mysqli_fetch_array($sqlcargaconcepto)) {
    $codgrupopdfas = $row2['ej'];
    $concepto = $row2['c'];

    $sql_transac = mysqli_query($db,"SELECT * FROM `ajustesejercicio` WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'
AND ejercicio =" . $codgrupopdfas . " AND mes = '" . $mes . "' AND year = '" . $year . "' AND fecha = '" . $feurl . "'"
            . "and num_asientos_ajustes_idnum_asientos_ajustes='".$idasientourl."' ");

    while ($productos2 = mysqli_fetch_array($sql_transac)) {
        $pdf->Cell(15, 8, $productos2['cod_cuenta'], 0);
        $pdf->Cell(50, 8, $productos2['cuenta'], 0);
        $pdf->Cell(25, 8, $productos2['fecha'], 0);
        $pdf->Cell(25, 8, ' ' . $productos2['valor'], 0);
        $pdf->Cell(25, 8, ' ' . $productos2['valorp'], 0);
        $pdf->Ln(8);
    }    
    $pdf->Cell(25, 8, 'Concepto : ' . $concepto, 0);    
    $pdf->Ln(8);
}


$pdf->Ln(8);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(250, 4, 'Firma Cliente :__________________________                            Responsable:__________________________', '', 1, 'C');

$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(250, 2, strtoupper($propi), '', 1, 'L');
$pdf->Cell(250, 5, strtoupper($func), '', 1, 'L');

$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(195, 4, '', 'T', 0, 'L');
$pdf->Output();
mysqli_close($db);
?>