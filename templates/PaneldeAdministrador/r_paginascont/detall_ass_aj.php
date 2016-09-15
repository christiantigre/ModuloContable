<?php
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../login.php"
</script>';
}
$idlogeobl = $_SESSION['id_user'];$user = $_SESSION['loginu'];
$ass = $_GET['ass'];
$y = $_GET['y'];
$month = $_GET['m'];
$d = $_GET['d'];
if ($month == '1') {
    $month = "01";
} elseif ($month == "2") {
    $month = "02";
} elseif ($month == "3") {
    $month = "03";
} elseif ($month == "4") {
    $month = "04";
} elseif ($month == "5") {
    $month = "05";
} elseif ($month == "6") {
    $month = "06";
} elseif ($month == "7") {
    $month = "07";
} elseif ($month == "8") {
    $month = "08";
} elseif ($month == "9") {
    $month = "09";
} elseif ($month == "10") {
    $month = "10";
} elseif ($month == "11") {
    $month = "11";
} elseif ($month == "12") {
    $month = "12";
}
$fecha = $y . '-' . $month . '-' . $d;
//include '../../Clases/guardahistorial.php';
//$accion = "/ CONTABILIDAD / Ajustes / Visualizó asiento de ajuste # ".$ass;
//generaLogs($user, $accion);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Asientos de ajuste # <?Php echo $ass;
echo '  - / -  ';
?> Fecha : <?Php echo $fecha; ?></div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <?Php
                        require '../../../templates/Clases/Conectar.php';
                        $year = date("Y");
                        $dbi = new Conectar();
                        $sqlmaxingreso = "SELECT max(`idt_bl_inicial`) as id FROM `t_bl_inicial`";
                        $query1 = $dbi->execute($sqlmaxingreso);
                        while ($rw = $dbi->fetch_row($query1)) {
                            $maxbalancedato = trim($rw['id']);
                        }

                        $sqlbuscagrupos = "SELECT `idnum_asientos_ajustes` AS id, `t_ejercicio_idt_corrientes` ej, `concepto` c, fecha AS f, saldodebe AS sald, saldohaber AS salh
FROM `num_asientos_ajustes`
WHERE t_bl_inicial_idt_bl_inicial = '" . $maxbalancedato . "'
AND year = '" . $year . "' AND fecha = '" . $fecha . "' and t_ejercicio_idt_corrientes = '" . $ass . "'
ORDER BY `t_ejercicio_idt_corrientes`";
                        $query2 = $dbi->execute($sqlbuscagrupos);
                        $a = 1;
                        while ($rw2 = $dbi->fetch_row($query2)) {
                            $idasiento = $rw2['id'];
                            $concepto = $rw2['c'];
                            $ass = $rw2['ej'];
                            $fech = $rw2['f'];
                            ?>
                            <!--odd gradeX  even gradeC  gradeA-->
                            <br>
                            <thead>
                                <tr>
                                    <th colspan="5" class="center text-center danger">Ref : <?Php
                                        echo $ass;
                                        ?> 
                                        <input type="hidden" id="fecha_<?Php echo $a; ?>" name="fecha_<?Php echo $a; ?>" value="<?Php echo $fech; ?>" />
                                        <input type="hidden" id="ass_<?Php echo $a; ?>" name="ass_<?Php echo $a; ?>" value="<?Php echo $ass; ?>" />
                                        <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" 
                                        onclick="imp_ajs_detall(<?Php echo $ass; ?>,<?Php echo $y; ?>,<?Php echo $month; ?>,<?Php echo $d; ?>,<?Php echo $idlogeobl; ?>)"></button>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Cod Cuenta</th>
                                    <th>Cuenta</th>
                                    <th>Debe</th>
                                    <th>Haber</th>
                                </tr>
                            </thead>

                            <?Php
                            $sqlsumresDH = "SELECT sum(`valor`) AS d, sum(`valorp`) AS h
                                            FROM `ajustesejercicio` WHERE  `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'"
                                    . " AND `ejercicio` =" . $ass. " and year='" . $year . "' ";
                            $resDH = $dbi->execute($sqlsumresDH);
                            while ($row1 = $dbi->fetch_row($resDH)) {
                                $ddetall = $row1['d'];  //echo "<script>alert(".$ddetall.")</script>";
                                $hdetall = $row1['h'];
                            }

                            $sql_cuentasgrupos = "SELECT `ejercicio` , `idajustesejercicio` , `fecha` , `cod_cuenta` as ref, `cuenta` ,
                                                `valor` AS debe, `valorp` AS haber, `t_bl_inicial_idt_bl_inicial` , tipo,`logeo_idlogeo`,`year`
                                                    FROM `ajustesejercicio` WHERE  `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'"
                                    . " AND `ejercicio` =" . $ass . " and year='" . $year . "'
                                                ORDER BY ejercicio";
                            $query3 = $dbi->execute($sql_cuentasgrupos);
                            while ($rw3 = $dbi->fetch_row($query3)) {
                                $id_ej = $rw3['idajustesejercicio'];
                                $fech = $rw3['fecha'];
                                $cod_cta = $rw3['ref'];
                                $cta = $rw3['cuenta'];
                                $deb = $rw3['debe'];
                                $hab = $rw3['haber'];
                                ?>

                                <tbody>
                                    <tr class="odd gradeX">
                                        <td><?Php echo $fech ?></td>
                                        <td><?Php echo $cod_cta ?></td>
                                        <td><?Php echo utf8_decode($cta); ?></td>
                                        <td class="center"><?Php echo $deb ?></td>
                                        <td class="center"><?Php echo $hab ?></td>
                                    </tr>

    <?Php } ?>
                                <tr>
                                    <th colspan="5">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Concepto
                                </div>
                                <div class="panel-body">
                                    <p><?Php echo utf8_decode($concepto); ?></p>
                                </div>
                            </div>
                            <tr><th colspan="3">Total<td><?Php echo $ddetall; ?></td><td><?Php echo $hdetall; ?></td></th></tr>
                            <?php
                            $a++;
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
