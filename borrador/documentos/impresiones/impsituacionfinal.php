<?php
session_start();
require('../../../fpdf/fpdf.php');
include '../../../Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$variableresponsable = $_GET['prmlg'];
$year = $_GET['fechaurl'];
$consulresposable = mysqli_query($c, "SELECT l.username, u.tipo_user, l.idlogeo, concat( us.nombre, ' ', us.apellido ) AS responsable
FROM logeo l
JOIN user_tipo u
JOIN usuario us
WHERE l.user_tipo_iduser_tipo = u.iduser_tipo
AND us.idusuario = l.usuario_idusuario
AND l.idlogeo='$variableresponsable' ");
while ($row1 = mysqli_fetch_array($consulresposable)) {
    $variablerespo = $row1['responsable'];
    $user= $row1['username'];
}


//include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
//    $accion="Imprimio Situacion final";
//    generaLogs($user, $accion);



$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($c), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
    }
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
$pdf->Image('../../../../images/logo.png', 10, 3, 190, 20, 'png');
$pdf->Cell(18, 10, '', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(15);

$pdf->Cell(165, 7, 'Empresa :' . $nom_emp . '                    Direccion :' . $dir . '                    Correo :' . $mail, '', 2, 'L');
$pdf->Cell(165, 7, 'Ruc :' . $ruc . '                                                 Emitido :' . date("d-m-Y H:i") . '                                    Por :' . $_SESSION['username'], '', 2, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'SITUACION FINAL', 0);
$pdf->Ln(22);
$pdf->Cell(0, 4, 'Pagina ' . $pdf->PageNo(), 'T', 1, 'R');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'Cod.', 0);
$pdf->Cell(60, 8, 'Cuenta', 0);
$pdf->Cell(55, 8, 'SUMAS', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'Cod.', 0);
$pdf->Cell(40, 8, 'Cuenta', 0);
$pdf->Cell(9, 8, 'Debe', 0);
$pdf->Cell(16, 8, 'Haber', 0);
$pdf->Cell(12, 8, 'Deudor', 0);
$pdf->Cell(18, 8, 'Acreedor', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$sql_transac = mysqli_query($c, "SELECT * FROM t_clase");
while ($productos2 = mysqli_fetch_array($sql_transac)) {
    $codigo_de_clase = $productos2['cod_clase'];
    $pdf->SetFont('Arial', 'BI', 7);
    $pdf->Cell(50, 8, $productos2['nombre_clase'], 0, 0, 'L');
    $pdf->Ln(8);
    $sql_carga_grupos = mysqli_query($c, "SELECT g.nombre_grupo AS grupo, g.cod_grupo AS cod FROM `vistaautomayorizacion` v JOIN t_grupo g JOIN t_clase c WHERE g.cod_grupo = v.`tipo` 
                        AND c.cod_clase=g.t_clase_cod_clase AND 
                        `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "' AND year = '" . $year . "' "
            . "AND c.cod_clase = '" . $codigo_de_clase . "' GROUP BY cod_grupo");
    $pdf->SetFont('Arial', 'B', 8);
    while ($row2 = mysqli_fetch_array($sql_carga_grupos)) {
        $codigo_de_grupo = $row2['cod'];
        $pdf->Cell(50, 5, $row2['grupo'], 0, 1, 'L');
        $sql_carga_balance = mysqli_query($c, "SELECT `cod_cuenta` , `cuenta` , `t_bl_inicial_idt_bl_inicial` AS b, `tipo` , `year` , `mes` , (
coalesce( debe_aj, 0 )
) + ( coalesce( debe, 0 ) ) AS sumdebe, (
coalesce( haber_aj, 0 )
) + ( coalesce( haber, 0 ) ) AS sumhaber, (
coalesce( `slddeudor_aj` , 0 )
) + ( coalesce( `sld_deudor` , 0 ) ) AS slddeudor, (
coalesce( `sldacreedor_aj` , 0 )
) + ( coalesce( `sld_acreedor` , 0 ) ) AS sldacreedor
FROM `vistabalanceresultadosajustados`
WHERE year = '".$year."'
AND tipo = '".$codigo_de_grupo."'
GROUP BY cod_cuenta");
        while ($row3 = mysqli_fetch_array($sql_carga_balance)) {
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(15, 4, $row3['cod_cuenta'], 0);
            $pdf->Cell(40, 4, $row3['cuenta'], 20);
            $pdf->Cell(13, 4, $row3['sumdebe'], 0);
            $pdf->Cell(13, 4, $row3['sumhaber'], 0);
            $pdf->Cell(15, 4, $row3['slddeudor'], 0);
            $pdf->Cell(15, 4, $row3['sldacreedor'], 0);
            $pdf->Ln(8);
        }
        
        $sumasgrupos=mysqli_query($c,"SELECT `cod_cuenta` , `cuenta` , `t_bl_inicial_idt_bl_inicial` AS b, `tipo` , `year` , `mes` , Sum( (
coalesce( debe_aj, 0 ) ) + ( coalesce( debe, 0 ) )
) AS sumdebe, SUM( (
coalesce( haber_aj, 0 ) ) + ( coalesce( haber, 0 ) )
) AS sumhaber, SUM( `sld_deudor` ) AS slddeu, SUM( `sld_acreedor` ) AS sldacree
FROM `vistabalanceresultadosajustados`
WHERE year = '".$year."'
AND tipo = '".$row2['cod']."'
GROUP BY tipo");
        while ($row5 = mysqli_fetch_array($sumasgrupos)) {
             $pdf->SetFont('Arial', 'BI', 8);
            $pdf->Cell(250, 3, '    SUMAS DE : '.$row2['grupo'], '', 1, 'L');
            $pdf->Cell(250, 2, '                                                                    '.$row5['sumdebe'].' - '.$row5['sumhaber'].' - '.$row5['slddeu'].' - '.$row5['sldacree'].'','', 1, 'L');
        }           
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 8);
    }
}

$pdf->Ln(8);
$pdf->Ln(8);
$sql_cargasumas = mysqli_query($c, "SELECT (
coalesce( debe_aj, 0 )
) + ( coalesce( debe, 0 ) ) AS sumdebe, (
coalesce( haber_aj, 0 )
) + ( coalesce( haber, 0 ) ) AS sumhaber, sum( sld_deudor ) AS deudor, sum( sld_acreedor ) AS acreedor
FROM `vistabalanceresultadosajustados`
WHERE year = '" . $year . "'
GROUP BY year");
$pdf->Cell(55, 8, '                                                                                                     Sumas                                        ', 0);
$pdf->Ln(4);
$pdf->Cell(55, 8, 'Total :', 0);
while ($row4 = mysqli_fetch_array($sql_cargasumas)) {
    $pdf->Cell(25, 8, $row4['sumdebe'], 0);
    $pdf->Cell(25, 8, $row4['sumhaber'], 0);
    $pdf->Cell(25, 8, $row4['deudor'], 0);
    $pdf->Cell(25, 8, $row4['acreedor'], 0);
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(8);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(250, 2, 'VLADIMIR ENDERICA', '', 1, 'L');
$pdf->Cell(250, 5, 'AUTOMOTORES ', '', 1, 'L');
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(195, 4, '', 'T', 0, 'L');

$pdf->Output();
mysqli_close($c);
?>