<?php
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../login.php"
</script>';
}
$user = $_SESSION['loginu'];
$ass = $_GET['ass'];
$fecha = $_GET['fecha'];
include '../../Clases/guardahistorial.php';
$accion = "/ CONTABILIDAD / Asientos / Visualizó asiento # ".$ass;
generaLogs($user, $accion);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Asiento # <?Php echo $ass;
echo '  - / -  '; ?> Fecha : <?Php echo $fecha; ?></div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <?Php
                        require '../../../../templates/Clases/Conectar.php';
                        $year = date("Y");
                        $dbi = new Conectar();
                        $sqlmaxingreso = "SELECT max(`idt_bl_inicial`) as id FROM `t_bl_inicial`";
                        $query1 = $dbi->execute($sqlmaxingreso);
                        while ($rw = $dbi->fetch_row($query1)) {
                            $maxbalancedato = trim($rw['id']);
                        }
                        $sqlsumresDH = "SELECT sum( j.valor ) AS d, sum( j.valorp ) AS h
FROM t_ejercicio j join num_asientos n
WHERE j.ejercicio=n.t_ejercicio_idt_corrientes
AND n.idnum_asientos=" . $ass . "
    and j.fecha = '".$fecha."'
AND j.t_bl_inicial_idt_bl_inicial='" . $maxbalancedato . "'
AND j.year = '" . $year . "' ";
                        $resDH = $dbi->execute($sqlsumresDH);
                        while ($row1 = $dbi->fetch_row($resDH)) {
                            $ddetall = $row1['d'];  //echo "<script>alert(".$ddetall.")</script>";
                            $hdetall = $row1['h'];
                        }

                        $sqlbuscagrupos = "SELECT n.`idnum_asientos` AS id, n.`t_ejercicio_idt_corrientes` as ej, n.`concepto` as c, n.fecha as f
FROM `num_asientos` n JOIN t_ejercicio e 
WHERE e.ejercicio = n.t_ejercicio_idt_corrientes AND e.fecha = n.fecha
AND n.fecha = '".$fecha."'
AND n.idnum_asientos = '".$ass."' AND e.year='".$year."'
GROUP BY `t_ejercicio_idt_corrientes`";
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
                                        <!--<button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_assini(<?Php echo $a; ?>)"></button>-->
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
                            $sql_cuentasgrupos = "SELECT `ejercicio` , `idt_corrientes` , `fecha` , `cod_cuenta` as ref ,
                                `cuenta` , `valor` AS debe, `valorp` AS haber, `t_bl_inicial_idt_bl_inicial` , tipo
FROM `t_ejercicio` WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "' AND `ejercicio` =" . $ass . " AND year='" . $year . "' ORDER BY ejercicio";
                            $query3 = $dbi->execute($sql_cuentasgrupos);
                            while ($rw3 = $dbi->fetch_row($query3)) {
                                $id_ej = $rw3['idt_corrientes'];
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
