<?php
require('../../../../fpdf/fpdf.php');
require('../../../../../php/conexion.php'); 
include '../../../Clases/guardahistorialimp.php';
$variableresponsable = $_GET['prmlg'];
//$feurl = $_GET['fech_url'];
//$id_asientourl= $_GET['id_asientourl'];
$year = date("Y");
//echo "<script>alert('.$id_asientourl.')</script>";
$consulresposable = mysql_query("SELECT l.username, u.tipo_user, l.idlogeo, concat( us.nombre, ' ', us.apellido ) AS responsable
FROM logeo l
JOIN user_tipo u
JOIN usuario us
WHERE l.user_tipo_iduser_tipo = u.iduser_tipo
AND us.idusuario = l.usuario_idusuario
AND l.idlogeo='$variableresponsable' ");
while ($row1 = mysql_fetch_array($consulresposable)) {
    $variablerespo = $row1['responsable'];
    $user = $row1['username'];
}

$db = new mysqli("localhost", "root", "alberto2791", "condata");
$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
    }
}

    $accion="Imprimio situacion final";
    generaLogs($user, $accion);


$datosempresa = mysql_query("SELECT `nombre`,`direccion`,`email`,`ruc`,`telefono`,`funcion`,`logo` FROM `empresa`");
while ($row = mysql_fetch_array($datosempresa)) {
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
$pdf->Image('../../../../../images/logo.png', 10, 3, 190, 20, 'png');
$pdf->Cell(18, 10, '', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(15);

$pdf->Cell(165, 7, 'Empresa :' . $nom_emp . '                    Direccion :' . $dir . '                    Correo :' . $mail, '', 2, 'L');
$pdf->Cell(165, 7, 'Ruc :' . $ruc . '                                                 Emitido :' . date("d-m-Y H:i") . '                                    Por :' . $variablerespo, '', 2, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'Estado de Resultados', 0);
$pdf->Ln(22);
$pdf->Cell(0, 4, 'Pagina ' . $pdf->PageNo(), 'T', 1, 'R');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'Cod.', 0);
$pdf->Cell(60, 8, 'Cuenta', 0);
$pdf->Cell(55, 8, 'SUMAS', 0);
$pdf->Cell(45, 8, 'AJUSTES', 0);
$pdf->Cell(5, 8, 'TOTAL', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'Cod.', 0);
$pdf->Cell(40, 8, 'Cuenta', 0);
$pdf->Cell(9, 8, 'Debe', 0);
$pdf->Cell(16, 8, 'Haber', 0);
$pdf->Cell(12, 8, 'Deudor', 0);
$pdf->Cell(18, 8, 'Acreedor', 0);
$pdf->Cell(12, 8, 'Aj.debe', 0);
$pdf->Cell(19, 8, 'Aj.haber', 0);
$pdf->Cell(12, 8, 'Deudor', 0);
$pdf->Cell(17, 8, 'Acreedor', 0);
$pdf->Cell(12, 8, 'Activo', 0);
$pdf->Cell(25, 8, 'Pasivo', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$sql_transac = mysql_query("SELECT * FROM t_clase");
while ($productos2 = mysql_fetch_array($sql_transac)) {
    $codigo_de_clase = $productos2['cod_clase'];
    $pdf->SetFont('Arial', 'BI', 7);
    $pdf->Cell(50, 8, $productos2['nombre_clase'], 0, 0, 'L');
    $pdf->Ln(8);
            $sql_carga_grupos= mysql_query(" SELECT g.nombre_grupo AS grupo, g.cod_grupo AS cod FROM `vistaautomayorizacion` v JOIN t_grupo g JOIN t_clase c WHERE g.cod_grupo = v.`tipo` 
                        AND c.cod_clase=g.t_clase_cod_clase AND 
                        `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "' AND year = '" . $year . "' "
                       . "AND c.cod_clase = '" . $codigo_de_clase . "' GROUP BY cod_grupo");
                       $pdf->SetFont('Arial', 'B', 8);
               while ($row2 = mysql_fetch_array($sql_carga_grupos)) {
                   $codigo_de_grupo= $row2['cod'];
                   $pdf->Cell(50, 5, $row2['grupo'], 0, 1,'L');                 
                   $sql_carga_balance = mysql_query("SELECT `cod_cuenta` , `cuenta` , `debe` , `haber` ,
                       `t_bl_inicial_idt_bl_inicial` as balance , `tipo` , `sld_deudor` , `sld_acreedor` , `year` , `debe_aj` ,
                       `haber_aj` , `slddeudor_aj` , `sldacreedor_aj` , `sum_deudor` , `sum_acreedor`
                    FROM `hoja_de_trabajo` WHERE `t_bl_inicial_idt_bl_inicial` = '".$maxbalancedato."' AND `year` = '".$year."'
                    AND tipo = '".$codigo_de_grupo."'");
                   while ($row3 = mysql_fetch_array($sql_carga_balance)) {
                    $pdf->SetFont('Arial', 'B',6);
                        $pdf->Cell(15, 4, $row3['cod_cuenta'], 0);
                        $pdf->Cell(40, 4, $row3['cuenta'], 20);
                        $pdf->Cell(13, 4, $row3['debe'], 0);
                        $pdf->Cell(13, 4, $row3['haber'], 0);
                        //$pdf->Cell(50, 5, $row3['balance'], 0);
                        //$pdf->Cell(50, 5, $row3['tipo'], 0);
                        $pdf->Cell(15, 4, $row3['sld_deudor'], 0);
                        $pdf->Cell(15, 4, $row3['sld_acreedor'], 0);
                        //$pdf->Cell(501 5, $row3['year'], 0);
                        $pdf->Cell(15, 4, $row3['debe_aj'], 0);
                        $pdf->Cell(15, 4, $row3['haber_aj'], 0);
                        $pdf->Cell(15, 4, $row3['slddeudor_aj'], 0);
                        $pdf->Cell(15, 4, $row3['sldacreedor_aj'], 0);
                        $pdf->Cell(15, 4, $row3['sum_deudor'], 0);
                        $pdf->Cell(15, 4, $row3['sum_acreedor'], 0);
                        $pdf->Ln(8);
                   }
                   $pdf->SetFont('Arial', 'B',8);                  
                   
               }
}
$pdf->Ln(8);
//$pdf->Cell(50, 8, 'Total Debe :    ' . $ddetall . '      Total Haber :    ' . $hdetall);
$sql_cargasumas = mysql_query("SELECT
sum( `debe_aj` ) AS s_deb_aj, sum( `haber_aj` ) AS sum_hab_aj, sum( `slddeudor_aj` ) AS sum_slddeu_aj, 
sum( `sldacreedor_aj` ) AS sum_slsacreed_aj,
sum( `debe` ) AS sumdebe, sum( `haber` ) AS sumhaber, sum( `sld_deudor` ) AS sumslddeud, sum( `sld_acreedor` ) AS sumsldacreed, 
sum( sum_deudor ) AS sumatotdeb, sum( sum_acreedor ) AS sumatothab
FROM `hoja_de_trabajo`
WHERE year = '".$year."' and t_bl_inicial_idt_bl_inicial = '".$maxbalancedato."'
GROUP BY `t_bl_inicial_idt_bl_inicial`");
$pdf->Ln(8);
$pdf->Cell(55, 8, '                                                                                                     Sumas                                        Ajustes                                                             Total', 0);
$pdf->Ln(4);
$pdf->Cell(50, 8, 'Total :', 0);
$pdf->SetFont('Arial', 'B', 6);
while ($row4 = mysql_fetch_array($sql_cargasumas)) {
    $pdf->Cell(15, 8, $row4['sumdebe'], 0);
    $pdf->Cell(15, 8, $row4['sumhaber'], 0);
    $pdf->Cell(15, 8, $row4['sumslddeud'], 0);
    $pdf->Cell(15, 8, $row4['sumsldacreed'], 0);
    $pdf->Cell(15, 8, $row4['s_deb_aj'], 0);
    $pdf->Cell(15, 8, $row4['sum_hab_aj'], 0);
    $pdf->Cell(15, 8, $row4['sum_slddeu_aj'], 0);
    $pdf->Cell(15, 8, $row4['sum_slsacreed_aj'], 0);
    $pdf->Cell(15, 8, $row4['sumatotdeb'], 0);
    $pdf->Cell(15, 8, $row4['sumatothab'], 0);
}
//$pdf->Cell(25, 8, 'Concepto : ' . $concepto, 0);
$pdf->SetFont('Arial', 'B', 8);
//$pdf->SetY(-20);
//Arial italic 8
$pdf->Ln(8);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(250, 2, 'VLADIMIR ENDERICA', '', 1, 'L');
$pdf->Cell(250, 5, 'AUTOMOTORES ', '', 1, 'L');
//Arial italic 8
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(195, 4, '', 'T', 0, 'L');

$pdf->Output();
?>