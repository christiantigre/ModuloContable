<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$c = $dbi->conexion();
if (isset($_POST['bsearch_ass'])) {
    $num_ass = $_POST['num_ass'];
//    $accion = "/ BUSQUEDA / asientos / busqueda por N# ass :" . $num_ass;
//    generaLogs($user, $accion);
    echo "Busqueda por asiento : " . $num_ass;
    $q_ass = "SELECT idnum_asientos as id,concepto as c, t_ejercicio_idt_corrientes as ej, fecha as f  FROM `num_asientos` WHERE `t_ejercicio_idt_corrientes`='" . $num_ass . "' and year ='" . $year . "' ";
    $res_ass = mysqli_query($c, $q_ass);
    $r_ass = mysqli_fetch_array($res_ass);
    $ass = $r_ass['ej'];
    if ($ass == 1) {// echo '<script>alert("Balance inicial")</script>';
        $b = 1;
        $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` ej,`concepto` c,fecha as f FROM `num_asientos` "
                . "WHERE year ='" . $year . "' and `t_ejercicio_idt_corrientes`='" . $ass . "'  order by ej";
        $query2 = mysqli_query($c, $sqlbuscagrupos);
        while ($rw2 = mysqli_fetch_assoc($query2)) {
            $idasiento = $rw2['id'];
            $concepto = $rw2['c'];
            $assi = $rw2['ej'];
            $fech = $rw2['f'];
            ?>
            <!--odd gradeX  even gradeC  gradeA-->
            <thead>
                <tr>
                    <th colspan="5" class="center text-center danger">Ref : <?Php echo $assi ?>

                        <?Php
                        $verfechaservidori = "SELECT DATE(NOW()) as fech_server";
                        $resfserveri = mysqli_query($c, $verfechaservidori);
                        while ($rowf_seri = mysqli_fetch_assoc($resfserveri)) {
                            $fech_serveri = $rowf_seri['fech_server'];
                        }
                        $posi = explode('-', $fech_serveri);
                        $y_servi = $posi[0];
                        $m_servi = $posi[1];
                        $cadena_fechai = $y_servi . '-' . $m_servi . '-01';

                        $pos_fi = explode('-', $fech);
                        $y_fechi = $pos_fi[0];
                        $m_fechi = $pos_fi[1];
                        ?>

                        <input type="hidden" id="fechain_<?Php echo $b; ?>" name="fechain_<?Php echo $b; ?>" value="<?Php echo $fech; ?>" />
                        <input type="hidden" id="assin_<?Php echo $b; ?>" name="assin_<?Php echo $b; ?>" value="<?Php echo $assi; ?>" />
                        <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_assin_search(<?Php echo $b; ?>)"></button>
                        <?Php
                        if ($m_servi == $m_fechi) {
                            echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" href="./up_ass_in.php?id_asientourl=' . $assi . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
                        } else {
                            echo ' ';
                        }
                        ?>
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
            $sql_cuentasgrupos = "SELECT `ejercicio` , `idt_corrientes` , `fecha` , `cod_cuenta` , `cuenta` , `valor` AS debe, `valorp` AS haber, `t_bl_inicial_idt_bl_inicial` , tipo FROM `t_ejercicio` WHERE  `ejercicio` =" . $assi . " and year='" . $year . "' ORDER BY ejercicio";
            $query3 = mysqli_query($c, $sql_cuentasgrupos);

            $sql_sumas = "SELECT sum(`valor`) as d, sum(`valorp`) as h FROM `t_ejercicio` WHERE `ejercicio`=" . $assi . " and `year`='" . $year . "' ";
            $m_res = mysqli_query($c, $sql_sumas);
            while ($row1 = mysqli_fetch_assoc($m_res)) {
                $sumdebe = $row1['d'];
                $sumhaber = $row1['h'];
            }

            while ($rw3 = mysqli_fetch_assoc($query3)) {
                $id_ej = $rw3['idt_corrientes'];
                $fech = $rw3['fecha'];
                $cod_cta = $rw3['cod_cuenta'];
                $cta = $rw3['cuenta'];
                $deb = $rw3['debe'];
                $hab = $rw3['haber'];
                ?>

                <tbody>
                    <tr class="odd gradeX">
                        <td><?Php echo $fech ?></td>
                        <td><?Php echo $cod_cta ?></td>
                        <td><?Php echo utf8_decode($cta) ?></td>
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
                    <p class="concepto" id="concepto"><?Php echo $concepto; ?></p>
                </div>
            </div>
            <tr>
                <td colspan="3">Total</td>
                <td>
                    <label><?Php echo $sumdebe; ?></label>
                </td>
                <td>
                    <label><?Php echo $sumhaber; ?></label>
                </td>
            </tr>
            <?php
        }
        $b++;
    } else {//echo '<script>alert("Asientos varios")</script>';
        $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` as ej,`concepto` as c,fecha as f FROM `num_asientos` "
                . "WHERE year ='" . $year . "' and `t_ejercicio_idt_corrientes` ='" . $ass . "'  order by ej desc";
        $query2 = mysqli_query($c, $sqlbuscagrupos);
        $a = 1;
        while ($rw2 = mysqli_fetch_assoc($query2)) {
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

                        $verfechaservidor = "SELECT DATE(NOW()) as fech_server";
                        $resfserver = mysqli_query($c, $verfechaservidor);
                        while ($rowf_ser = mysqli_fetch_assoc($resfserver)) {
                            $fech_server = $rowf_ser['fech_server'];
                        }
                        $pos = explode('-', $fech_server);
                        $y_serv = $pos[0];
                        $m_serv = $pos[1];
                        $cadena_fecha = $y_serv . '-' . $m_serv . '-01';

                        $pos_f = explode('-', $fech);
                        $y_fech = $pos_f[0];
                        $m_fech = $pos_f[1];

                        list($y, $m, $d) = explode("-", $fech);
                        ?> 
                        <input type="hidden" id="fecha_<?Php echo $a; ?>" name="fecha_<?Php echo $a; ?>" value="<?Php echo $fech; ?>" />
                        <input type="hidden" id="ass_<?Php echo $a; ?>" name="ass_<?Php echo $a; ?>" value="<?Php echo $ass; ?>" />
                        <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_assin_ass_search(<?Php echo $a; ?>)"></button>
                        <!--<button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-wrench" onclick="conf_ass(<?Php
                        echo $ass;
                        echo $fech;
                        ?>)"></button>-->
                        <?Php
                        if ($m_serv == $m_fech) {
                            echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" href="./up_ass.php?id_asientourl=' . $ass . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
                        } else {
                            echo ' ';
                        }
                        ?>
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
            $sql_cuentasgrupos = "SELECT idlibro,`asiento` , `fecha` , `ref` , `cuenta` ,  debe,  haber, `t_bl_inicial_idt_bl_inicial` , grupo
FROM `libro` WHERE `asiento` =" . $ass . " and year='" . $year . "' ORDER BY asiento";
            $query3 = mysqli_query($c, $sql_cuentasgrupos);

            $sql_sumas = "SELECT sum(`debe`) as d, sum(`haber`) as h FROM `libro` WHERE `asiento`=" . $ass . " and `year`='" . $year . "' ";
            $m_res = mysqli_query($c, $sql_sumas);
            while ($row1 = mysqli_fetch_assoc($m_res)) {
                $sumdebe_as = $row1['d'];
                $sumhaber_as = $row1['h'];
            }

            while ($rw3 = mysqli_fetch_assoc($query3)) {
                $id_ej = $rw3['idlibro'];
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
                    <p><?Php echo $concepto; ?></p>
                </div>
            </div>

            <tr>
                <td colspan="3">Total</td>
                <td>
                    <label><?Php echo $sumdebe_as; ?></label>
                </td>
                <td>
                    <label><?Php echo $sumhaber_as; ?></label>
                </td>
            </tr>
            <?php
            $a++;
        }
    }
}



if (isset($_POST['bsearch_fech'])) {//echo '<script>alert("B por fech")</script>';
    $datetimepicker1 = $_POST['datetimepicker1'];
//    $accion = "/ BUSQUEDA / asientos / busqueda por fecha de ingreso :" . $datetimepicker1;
//    generaLogs($user, $accion);
    echo "Busqueda por fecha : " . $datetimepicker1;
    $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` as ej,`concepto` as c,fecha as f FROM `num_asientos` "
            . "WHERE year ='" . $year . "' and `fecha` ='" . $datetimepicker1 . "' and t_ejercicio_idt_corrientes !=1  order by ej desc";
    $query2 = mysqli_query($c, $sqlbuscagrupos);
    $a = 1;
    while ($rw2 = mysqli_fetch_assoc($query2)) {
        $idasiento = $rw2['id'];
        $concepto = $rw2['c'];
        $ass = $rw2['ej'];
        $fech = $rw2['f'];
        ?>
        <thead>
            <tr>
                <th colspan="5" class="center text-center danger">Ref : <?Php
                    echo $ass;

                    $verfechaservidor = "SELECT DATE(NOW()) as fech_server";
                    $resfserver = mysqli_query($c, $verfechaservidor);
                    while ($rowf_ser = mysqli_fetch_assoc($resfserver)) {
                        $fech_server = $rowf_ser['fech_server'];
                    }
                    $pos = explode('-', $fech_server);
                    $y_serv = $pos[0];
                    $m_serv = $pos[1];
                    $cadena_fecha = $y_serv . '-' . $m_serv . '-01';

                    $pos_f = explode('-', $fech);
                    $y_fech = $pos_f[0];
                    $m_fech = $pos_f[1];

                    list($y, $m, $d) = explode("-", $fech);
                    ?> 
                    <input type="hidden" id="fecha_<?Php echo $a; ?>" name="fecha_<?Php echo $a; ?>" value="<?Php echo $fech; ?>" />
                    <input type="hidden" id="ass_<?Php echo $a; ?>" name="ass_<?Php echo $a; ?>" value="<?Php echo $ass; ?>" />
                    <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_assin_ass_search(<?Php echo $a; ?>)"></button>
                    <!--<button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-wrench" onclick="conf_ass(<?Php
                    echo $ass;
                    echo $fech;
                    ?>)"></button>-->
                    <?Php
                    if ($m_serv == $m_fech) {
                        echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" href="./up_ass.php?id_asientourl=' . $ass . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
                    } else {
                        echo ' ';
                    }
                    ?>
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
        $sql_cuentasgrupos = "SELECT idlibro,`asiento` , `fecha` , `ref` , `cuenta` ,  debe,  haber, `t_bl_inicial_idt_bl_inicial` , grupo
FROM `libro` WHERE `asiento` =" . $ass . " and year='" . $year . "' ORDER BY asiento";
        $query3 = mysqli_query($c, $sql_cuentasgrupos);

        $sql_sumas = "SELECT sum(`debe`) as d, sum(`haber`) as h FROM `libro` WHERE `asiento`=" . $ass . " and `year`='" . $year . "' ";
        $m_res = mysqli_query($c, $sql_sumas);
        while ($row1 = mysqli_fetch_assoc($m_res)) {
            $sumdebe_as = $row1['d'];
            $sumhaber_as = $row1['h'];
        }

        while ($rw3 = mysqli_fetch_assoc($query3)) {
            $id_ej = $rw3['idlibro'];
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
                <p><?Php echo $concepto; ?></p>
            </div>
        </div>

        <tr>
            <td colspan="3">Total</td>
            <td>
                <label><?Php echo $sumdebe_as; ?></label>
            </td>
            <td>
                <label><?Php echo $sumhaber_as; ?></label>
            </td>
        </tr>
        <?php
        $a++;
    }
}


if (isset($_POST['bsearch_prd'])) {//    echo '<script>alert("B por periodo")</script>';
    $datetimepicker1min = $_POST['datetimepicker1min'];
    $datetimepicker1max = $_POST['datetimepicker1max'];
//    $accion = "/ BUSQUEDA / asientos / busqueda entre fechas : desde " . $datetimepicker1min . ' hasta :' . $datetimepicker1max;
//    generaLogs($user, $accion);
    echo "Busqueda " . 'entre ' . $datetimepicker1min . ' / ' . $datetimepicker1max;
    $q_ass = "SELECT * FROM `num_asientos` WHERE `fecha` BETWEEN '" . $datetimepicker1min . "' and '" . $datetimepicker1max . "'  ";
    $res_ass = mysqli_query($c, $q_ass);
    while ($row2 = mysqli_fetch_assoc($res_ass)) {// echo '<script>alert("'.$ass.'")</script>';
        $ass = $row2['t_ejercicio_idt_corrientes'];
    }
    if ($ass == 1) {// echo '<script>alert("Balance inicial")</script>';
        $b = 1;
        $bini = 1;
        $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` as ej,`concepto` as c,fecha as f FROM `num_asientos` "
                . "WHERE year ='" . $year . "' and t_ejercicio_idt_corrientes =" . $bini . " order by ej";
        $query2 = mysqli_query($c, $sqlbuscagrupos);
        while ($rw2 = mysqli_fetch_assoc($query2)) {
            $idasiento = $rw2['id'];
            $concepto = $rw2['c'];
            $assi = $rw2['ej'];
            $fech = $rw2['f'];
            ?>
            <!--odd gradeX  even gradeC  gradeA-->
            <thead>
                <tr>
                    <th colspan="5" class="center text-center danger">Ref : <?Php echo $assi ?>
                        <?Php
                        $verfechaservidori = "SELECT DATE(NOW()) as fech_server";
                        $resfserveri = mysqli_query($c, $verfechaservidori);
                        while ($rowf_seri = mysqli_fetch_assoc($resfserveri)) {
                            $fech_serveri = $rowf_seri['fech_server'];
                        }
                        $posi = explode('-', $fech_serveri);
                        $y_servi = $posi[0];
                        $m_servi = $posi[1];
                        $cadena_fechai = $y_servi . '-' . $m_servi . '-01';

                        $pos_fi = explode('-', $fech);
                        $y_fechi = $pos_fi[0];
                        $m_fechi = $pos_fi[1];
                        ?>
                        <input type="hidden" id="fechain_<?Php echo $b; ?>" name="fechain_<?Php echo $b; ?>" value="<?Php echo $fech; ?>" />
                        <input type="hidden" id="assin_<?Php echo $b; ?>" name="assin_<?Php echo $b; ?>" value="<?Php echo $assi; ?>" />
                        <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_assin_search(<?Php echo $b; ?>)"></button>
                        <?Php
                        if ($m_servi == $m_fechi) {
                            echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" href="./up_ass_in.php?id_asientourl=' . $assi . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
                        } else {
                            echo ' ';
                        }
                        ?>
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
            $sql_cuentasgrupos = "SELECT `ejercicio` , `idt_corrientes` , `fecha` , `cod_cuenta` , `cuenta` , `valor` AS debe, `valorp` AS haber, `t_bl_inicial_idt_bl_inicial` , tipo "
                    . "FROM `t_ejercicio` WHERE ejercicio=" . $bini . " ORDER BY ejercicio";
            $query3 = mysqli_query($c, $sql_cuentasgrupos);

            $sql_sumas = "SELECT sum(`valor`) as d, sum(`valorp`) as h FROM `t_ejercicio` WHERE `ejercicio`=" . $assi . " and `year`='" . $year . "' ";
            $m_res = mysqli_query($c, $sql_sumas);
            while ($row_ej = mysqli_fetch_assoc($m_res)) {
                $sumdebe_ej = $row_ej['d'];
                $sumhaber_ej = $row_ej['h'];
            }

            while ($rw3 = mysqli_fetch_assoc($query3)) {
                $id_ej = $rw3['idt_corrientes'];
                $fech = $rw3['fecha'];
                $cod_cta = $rw3['cod_cuenta'];
                $cta = $rw3['cuenta'];
                $deb = $rw3['debe'];
                $hab = $rw3['haber'];
                ?>

                <tbody>
                    <tr class="odd gradeX">
                        <td><?Php echo $fech ?></td>
                        <td><?Php echo $cod_cta ?></td>
                        <td><?Php echo utf8_decode($cta) ?></td>
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
                    <p class="concepto" id="concepto"><?Php echo $concepto; ?></p>
                </div>
            </div>
            </th>
            </tr>
            <tr>
                <td colspan="3">Total</td>
                <td>
                    <label><?Php echo $sumdebe_ej; ?></label>
                </td>
                <td>
                    <label><?Php echo $sumhaber_ej; ?></label>
                </td>
            </tr>
            <?php
        }
        $b++;
    } else {//echo '<script>alert("Asientos varios")</script>';
        $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` as ej,`concepto` as c,fecha as f FROM `num_asientos` "
                . "WHERE year ='" . $year . "' and `fecha` BETWEEN '" . $datetimepicker1min . "' and '" . $datetimepicker1max . "' and t_ejercicio_idt_corrientes !=1  order by ej desc";
        $query2 = mysqli_query($c, $sqlbuscagrupos);
        $a = 1;
        while ($rw2 = mysqli_fetch_assoc($query2)) {
            $idasiento = $rw2['id'];
            $concepto = $rw2['c'];
            $assj = $rw2['ej'];
            $fech = $rw2['f'];
            ?>
            <thead>
                <tr>
                    <th colspan="5" class="center text-center danger">Ref : <?Php
                        echo $assj;

                        $verfechaservidor = "SELECT DATE(NOW()) as fech_server";
                        $resfserver = mysqli_query($c, $verfechaservidor);
                        while ($rowf_ser = mysqli_fetch_assoc($resfserver)) {
                            $fech_server = $rowf_ser['fech_server'];
                        }
                        $pos = explode('-', $fech_server);
                        $y_serv = $pos[0];
                        $m_serv = $pos[1];
                        $cadena_fecha = $y_serv . '-' . $m_serv . '-01';

                        $pos_f = explode('-', $fech);
                        $y_fech = $pos_f[0];
                        $m_fech = $pos_f[1];

                        list($y, $m, $d) = explode("-", $fech);
                        ?> 
                        <input type="hidden" id="fecha_<?Php echo $a; ?>" name="fecha_<?Php echo $a; ?>" value="<?Php echo $fech; ?>" />
                        <input type="hidden" id="ass_<?Php echo $a; ?>" name="ass_<?Php echo $a; ?>" value="<?Php echo $assj; ?>" />
                        <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_assin_ass_search(<?Php echo $a; ?>)"></button>
                        <!--<button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-wrench" onclick="conf_ass(<?Php
                        echo $ass;
                        echo $fech;
                        ?>)"></button>-->
                        <?Php
                        if ($m_serv == $m_fech) {
                            echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" href="./up_ass.php?id_asientourl=' . $assj . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
                        } else {
                            echo ' ';
                        }
                        ?>
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
            $sql_cuentasgrupos = "SELECT idlibro,`asiento` , `fecha` , `ref` , `cuenta` ,  debe,  haber, `t_bl_inicial_idt_bl_inicial` , grupo
FROM `libro` WHERE year='" . $year . "' and asiento=" . $assj . " ORDER BY asiento";
            $query3 = mysqli_query($c, $sql_cuentasgrupos);

            $sql_sumas = "SELECT sum(`debe`) as d, sum(`haber`) as h FROM `libro` WHERE `asiento`=" . $assj . " and `year`='" . $year . "' ";
            $m_res = mysqli_query($c, $sql_sumas);
            while ($row1 = mysqli_fetch_assoc($m_res)) {
                $sumdebe_as = $row1['d'];
                $sumhaber_as = $row1['h'];
            }

            while ($rw3 = mysqli_fetch_assoc($query3)) {
                $id_ej = $rw3['idlibro'];
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
                    <p><?Php echo $concepto; ?></p>
                </div>
            </div>

            <tr>
                <td colspan="3">Total</td>
                <td>
                    <label><?Php echo $sumdebe_as; ?></label>
                </td>
                <td>
                    <label><?Php echo $sumhaber_as; ?></label>
                </td>
            </tr>
            <?php
            $a++;
        }
    }
}



if (isset($_POST['bsearch_ms'])) {
    $opciones = $_REQUEST['opciones'];
    $optionsRadios = $_REQUEST['optionsRadios'];
    list($num, $mes) = explode("-", $opciones);
//    echo '<script>alert("' . $optionsRadios . '")</script>';
//    echo '<script>alert("' . $num . '")</script>';
    if ($num == '1') {
        $num = "01";
    } elseif ($num == "2") {
        $num = "02";
    } elseif ($num == "3") {
        $num = "03";
    } elseif ($num == "4") {
        $num = "04";
    } elseif ($num == "5") {
        $num = "05";
    } elseif ($num == "6") {
        $num = "06";
    } elseif ($num == "7") {
        $num = "07";
    } elseif ($num == "8") {
        $num = "08";
    } elseif ($num == "9") {
        $num = "09";
    } elseif ($num == "10") {
        $num = "10";
    } elseif ($num == "11") {
        $num = "11";
    } elseif ($num == "12") {
        $num = "12";
    }

    $d = 32;

    if ($optionsRadios == '=') {
        $tipo_bs = "Durante";
//        $accion = "/ BUSQUEDA / asientos / busqueda " . $tipo_bs . " - mes : " . $mes;
//        generaLogs($user, $accion);
        echo "Busqueda " . $tipo_bs . ' / ' . $mes;
        $sql_dr = "SELECT * FROM `num_asientos` WHERE `mes`='" . $mes . "'";
        $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` as ej,`concepto` as c,fecha as f FROM `num_asientos` "
                . "WHERE year ='" . $year . "' and `mes` ='" . $mes . "' and t_ejercicio_idt_corrientes !=1 order by ej desc";
        $query2 = mysqli_query($c, $sqlbuscagrupos);
        $a = 1;
        while ($rw2 = mysqli_fetch_assoc($query2)) {
            $idasiento = $rw2['id'];
            $concepto = $rw2['c'];
            $ass = $rw2['ej'];
            $fech = $rw2['f'];
            ?>
            <thead>
                <tr>
                    <th colspan="5" class="center text-center danger">Ref : <?Php
                        echo $ass;

                        $verfechaservidor = "SELECT DATE(NOW()) as fech_server";
                        $resfserver = mysqli_query($c, $verfechaservidor);
                        while ($rowf_ser = mysqli_fetch_assoc($resfserver)) {
                            $fech_server = $rowf_ser['fech_server'];
                        }
                        $pos = explode('-', $fech_server);
                        $y_serv = $pos[0];
                        $m_serv = $pos[1];
                        $cadena_fecha = $y_serv . '-' . $m_serv . '-01';

                        $pos_f = explode('-', $fech);
                        $y_fech = $pos_f[0];
                        $m_fech = $pos_f[1];

                        list($y, $m, $d) = explode("-", $fech);
                        ?> 
                        <input type="hidden" id="fecha_<?Php echo $a; ?>" name="fecha_<?Php echo $a; ?>" value="<?Php echo $fech; ?>" />
                        <input type="hidden" id="ass_<?Php echo $a; ?>" name="ass_<?Php echo $a; ?>" value="<?Php echo $ass; ?>" />
                        <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_assin_ass_search(<?Php echo $a; ?>)"></button>
                        <!--<button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-wrench" onclick="conf_ass(<?Php
                        echo $ass;
                        echo $fech;
                        ?>)"></button>-->
                        <?Php
                        if ($m_serv == $m_fech) {
                            echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" href="./up_ass.php?id_asientourl=' . $ass . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
                        } else {
                            echo ' ';
                        }
                        ?>
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
            $sql_cuentasgrupos = "SELECT idlibro,`asiento` , `fecha` , `ref` , `cuenta` ,  debe,  haber, `t_bl_inicial_idt_bl_inicial` , grupo
FROM `libro` WHERE `asiento` =" . $ass . " and year='" . $year . "' ORDER BY asiento";
            $query3 = mysqli_query($c, $sql_cuentasgrupos);

            $sql_sumas = "SELECT sum(`debe`) as d, sum(`haber`) as h FROM `libro` WHERE `asiento`=" . $ass . " and `year`='" . $year . "' ";
            $m_res = mysqli_query($c, $sql_sumas);
            while ($row1 = mysqli_fetch_assoc($m_res)) {
                $sumdebe_as = $row1['d'];
                $sumhaber_as = $row1['h'];
            }

            while ($rw3 = mysqli_fetch_assoc($query3)) {
                $id_ej = $rw3['idlibro'];
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
                    <p><?Php echo $concepto; ?></p>
                </div>
            </div>

            <tr>
                <td colspan="3">Total</td>
                <td>
                    <label><?Php echo $sumdebe_as; ?></label>
                </td>
                <td>
                    <label><?Php echo $sumhaber_as; ?></label>
                </td>
            </tr>
            <?php
            $a++;
        }
    }


    if ($optionsRadios == '>') {
        $tipo_bs = "Antes";
//        $accion = "/ BUSQUEDA / asientos / busqueda " . $tipo_bs . " - mes : " . $mes;
//        generaLogs($user, $accion);
        $fecha = $year . '-' . $num . '-' . $d; //         echo '<script>alert("' . $fecha . '")</script>';
        echo "Busqueda " . $tipo_bs . ' / ' . $mes;
        $sql_dr = "SELECT * FROM `num_asientos` WHERE `fecha` <='" . $fecha . "'";
        $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` as ej,`concepto` as c,fecha as f FROM `num_asientos` "
                . "WHERE year ='" . $year . "' and `fecha` <='" . $fecha . "' and t_ejercicio_idt_corrientes !=1 order by ej desc";
        $query2 = mysqli_query($c, $sqlbuscagrupos);
        $a = 1;
        while ($rw2 = mysqli_fetch_assoc($query2)) {
            $idasiento = $rw2['id'];
            $concepto = $rw2['c'];
            $ass = $rw2['ej'];
            $fech = $rw2['f'];
            ?>
            <thead>
                <tr>
                    <th colspan="5" class="center text-center danger">Ref : <?Php
                        echo $ass;

                        $verfechaservidor = "SELECT DATE(NOW()) as fech_server";
                        $resfserver = mysqli_query($c, $verfechaservidor);
                        while ($rowf_ser = mysqli_fetch_assoc($resfserver)) {
                            $fech_server = $rowf_ser['fech_server'];
                        }
                        $pos = explode('-', $fech_server);
                        $y_serv = $pos[0];
                        $m_serv = $pos[1];
                        $cadena_fecha = $y_serv . '-' . $m_serv . '-01';

                        $pos_f = explode('-', $fech);
                        $y_fech = $pos_f[0];
                        $m_fech = $pos_f[1];

                        list($y, $m, $d) = explode("-", $fech);
                        ?> 
                        <input type="hidden" id="fecha_<?Php echo $a; ?>" name="fecha_<?Php echo $a; ?>" value="<?Php echo $fech; ?>" />
                        <input type="hidden" id="ass_<?Php echo $a; ?>" name="ass_<?Php echo $a; ?>" value="<?Php echo $ass; ?>" />
                        <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_assin_ass_search(<?Php echo $a; ?>)"></button>
                        <!--<button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-wrench" onclick="conf_ass(<?Php
                        echo $ass;
                        echo $fech;
                        ?>)"></button>-->
                        <?Php
                        if ($m_serv == $m_fech) {
                            echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" href="./up_ass.php?id_asientourl=' . $ass . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
                        } else {
                            echo ' ';
                        }
                        ?>
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
            $sql_cuentasgrupos = "SELECT idlibro,`asiento` , `fecha` , `ref` , `cuenta` ,  debe,  haber, `t_bl_inicial_idt_bl_inicial` , grupo
FROM `libro` WHERE `asiento` =" . $ass . " and year='" . $year . "' ORDER BY asiento";
            $query3 = mysqli_query($c, $sql_cuentasgrupos);

            $sql_sumas = "SELECT sum(`debe`) as d, sum(`haber`) as h FROM `libro` WHERE `asiento`=" . $ass . " and `year`='" . $year . "' ";
            $m_res = mysqli_query($c, $sql_sumas);
            while ($row1 = mysqli_fetch_assoc($m_res)) {
                $sumdebe_as = $row1['d'];
                $sumhaber_as = $row1['h'];
            }

            while ($rw3 = mysqli_fetch_assoc($query3)) {
                $id_ej = $rw3['idlibro'];
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
                    <p><?Php echo $concepto; ?></p>
                </div>
            </div>

            <tr>
                <td colspan="3">Total</td>
                <td>
                    <label><?Php echo $sumdebe_as; ?></label>
                </td>
                <td>
                    <label><?Php echo $sumhaber_as; ?></label>
                </td>
            </tr>
            <?php
            $a++;
        }
    }
    if ($optionsRadios == '<') {
        $tipo_bs = "Después";
//        $accion = "/ BUSQUEDA / asientos / busqueda " . $tipo_bs . " - mes : " . $mes;
//        generaLogs($user, $accion);
        $fecha = $year . '-' . $num . '-' . $d;
        echo "Busqueda " . $tipo_bs . ' / ' . $mes;
        $sql_dr = "SELECT * FROM `num_asientos` WHERE `fecha` >='" . $fecha . "'";
        $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` as ej,`concepto` as c,fecha as f FROM `num_asientos` "
                . "WHERE year ='" . $year . "' and `fecha` >='" . $fecha . "' and t_ejercicio_idt_corrientes !=1 order by ej desc";
        $query2 = mysqli_query($c, $sqlbuscagrupos);
        $a = 1;
        while ($rw2 = mysqli_fetch_assoc($query2)) {
            $idasiento = $rw2['id'];
            $concepto = $rw2['c'];
            $ass = $rw2['ej'];
            $fech = $rw2['f'];
            ?>
            <thead>
                <tr>
                    <th colspan="5" class="center text-center danger">Ref : <?Php
                        echo $ass;

                        $verfechaservidor = "SELECT DATE(NOW()) as fech_server";
                        $resfserver = mysqli_query($c, $verfechaservidor);
                        while ($rowf_ser = mysqli_fetch_assoc($resfserver)) {
                            $fech_server = $rowf_ser['fech_server'];
                        }
                        $pos = explode('-', $fech_server);
                        $y_serv = $pos[0];
                        $m_serv = $pos[1];
                        $cadena_fecha = $y_serv . '-' . $m_serv . '-01';

                        $pos_f = explode('-', $fech);
                        $y_fech = $pos_f[0];
                        $m_fech = $pos_f[1];

                        list($y, $m, $d) = explode("-", $fech);
                        ?> 
                        <input type="hidden" id="fecha_<?Php echo $a; ?>" name="fecha_<?Php echo $a; ?>" value="<?Php echo $fech; ?>" />
                        <input type="hidden" id="ass_<?Php echo $a; ?>" name="ass_<?Php echo $a; ?>" value="<?Php echo $ass; ?>" />
                        <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_assin_ass_search(<?Php echo $a; ?>)"></button>
                        <!--<button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-wrench" onclick="conf_ass(<?Php
                        echo $ass;
                        echo $fech;
                        ?>)"></button>-->
                        <?Php
                        if ($m_serv == $m_fech) {
                            echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" href="./up_ass.php?id_asientourl=' . $ass . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
                        } else {
                            echo ' ';
                        }
                        ?>
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
            $sql_cuentasgrupos = "SELECT idlibro,`asiento` , `fecha` , `ref` , `cuenta` ,  debe,  haber, `t_bl_inicial_idt_bl_inicial` , grupo
FROM `libro` WHERE `asiento` =" . $ass . " and year='" . $year . "' ORDER BY asiento";
            $query3 = mysqli_query($c, $sql_cuentasgrupos);

            $sql_sumas = "SELECT sum(`debe`) as d, sum(`haber`) as h FROM `libro` WHERE `asiento`=" . $ass . " and `year`='" . $year . "' ";
            $m_res = mysqli_query($c, $sql_sumas);
            while ($row1 = mysqli_fetch_assoc($m_res)) {
                $sumdebe_as = $row1['d'];
                $sumhaber_as = $row1['h'];
            }

            while ($rw3 = mysqli_fetch_assoc($query3)) {
                $id_ej = $rw3['idlibro'];
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
                    <p><?Php echo $concepto; ?></p>
                </div>
            </div>

            <tr>
                <td colspan="3">Total</td>
                <td>
                    <label><?Php echo $sumdebe_as; ?></label>
                </td>
                <td>
                    <label><?Php echo $sumhaber_as; ?></label>
                </td>
            </tr>
            <?php
            $a++;
        }
    }
}