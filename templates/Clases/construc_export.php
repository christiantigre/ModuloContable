<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;

/**
 * Description of construc_export
 *
 * @author ANDRES
 */
class construc_export {

    function tab_as($c) {
        ?>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">

            <?Php
            $year = date('Y');
            $num_ass = '1';
            $q_ass = "SELECT idnum_asientos as id,concepto as c, t_ejercicio_idt_corrientes as ej, fecha as f  FROM `num_asientos` WHERE `t_ejercicio_idt_corrientes`='" . $num_ass . "' and year ='" . $year . "' ";
            $res_ass = mysqli_query($c, $q_ass);
            $r_ass = mysqli_fetch_array($res_ass);
            $ass = $r_ass['ej'];
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
                    $r_sumdebe = num($sumdebe);
                    $r_sumhaber = num($sumhaber);
                }
                while ($rw3 = mysqli_fetch_assoc($query3)) {
                    $id_ej = $rw3['idt_corrientes'];
                    $fech = $rw3['fecha'];
                    $cod_cta = $rw3['cod_cuenta'];
                    $cta = $rw3['cuenta'];
                    $deb = $rw3['debe'];
                    $hab = $rw3['haber'];
                    $string = $rw3['cuenta'];
                    $debe = $rw3['debe'];
                    $haber = $rw3['haber'];
                    $cdn_acentos = limpiar($string);
                    $r_deb = num($debe);
                    $r_hab = num($haber);
                    ?>
                    <tbody>
                        <tr class="odd gradeX">
                            <td><?Php echo $fech ?></td>
                            <td><?Php echo $cod_cta ?></td>
                            <td><?Php echo $cdn_acentos ?></td>
                            <td class="center"><?Php echo $r_deb ?></td>
                            <td class="center"><?Php echo $r_hab ?></td>
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
                        <label><?Php echo $r_sumdebe; ?></label>
                    </td>
                    <td>
                        <label><?Php echo $r_sumhaber; ?></label>
                    </td>
                </tr>
                <?php
            }
            $b++;
            ?>
        </table>
        <?Php
    }

    function tab_in($dbi) {
        ?>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <?Php
            $year = date("Y");
            $sqlmaxingreso = "SELECT max(`idt_bl_inicial`) as id FROM `t_bl_inicial`";
            $query1 = $dbi->execute($sqlmaxingreso);
            while ($rw = $dbi->fetch_row($query1)) {
                $maxbalancedato = trim($rw['id']);
            }


            $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` as ej,`concepto` as c,fecha as f FROM `num_asientos` "
                    . "WHERE `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' and year ='" . $year . "' and `t_ejercicio_idt_corrientes` >1  order by ej desc";
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

                            $verfechaservidor = "SELECT DATE(NOW()) as fech_server";
                            $resfserver = $dbi->execute($verfechaservidor);
                            while ($rowf_ser = $dbi->fetch_row($resfserver)) {
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
                            <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-outline btn-info glyphicon glyphicon-eye-open" onclick="detall_asin(<?Php echo $a; ?>);"></button>
                            <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print"
                                    onclick="imp_assin_ass(<?Php echo $a; ?>)"></button>
                            <!--<button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-wrench" onclick="conf_ass(<?Php
                            echo $ass;
                            echo $fech;
                            ?>)"></button>-->
                            <?Php
                            if ($m_serv == $m_fech) {
                                echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" '
                                . 'href="./templateslimit/ModuloContable/up_ass.php?id_asientourl=' . $ass . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
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
FROM `libro`
WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'
AND `asiento` =" . $ass . " and year='" . $year . "'
 ORDER BY asiento";
                $query3 = $dbi->execute($sql_cuentasgrupos);
                while ($rw3 = $dbi->fetch_row($query3)) {
                    $id_ej = $rw3['idlibro'];
                    $fech = $rw3['fecha'];
                    $cod_cta = $rw3['ref'];
                    $cta = $rw3['cuenta'];
                    $deb = $rw3['debe'];
                    $hab = $rw3['haber'];

                    $deb = num($deb);
                    $hab = num($hab);
                    $cta = limpiar($cta);
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
                <?php
                $a++;
            }
            ?>  


            <?Php
            $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` ej,`concepto` c,fecha as f FROM `num_asientos` "
                    . "WHERE `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' and year ='" . $year . "' and `t_ejercicio_idt_corrientes`=1  order by ej";
            $query2 = $dbi->execute($sqlbuscagrupos);
            $b = 1;
            while ($rw2 = $dbi->fetch_row($query2)) {
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
                            $resfserveri = $dbi->execute($verfechaservidori);
                            while ($rowf_seri = $dbi->fetch_row($resfserveri)) {
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
                            <button type="button" data-toggle="modal" data-target="#myModal" 
                                    class="btn btn-outline btn-info glyphicon glyphicon-eye-open" onclick="detall_asini(<?Php echo $b; ?>);"></button>
                            <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_assin(<?Php echo $b; ?>)"></button>
                            <?Php
                            if ($m_servi == $m_fechi) {
                                echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" href="./templateslimit/ModuloContable/up_ass_in.php?id_asientourl=' . $assi . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
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
                $sql_cuentasgrupos = "SELECT `ejercicio` , `idt_corrientes` , `fecha` , `cod_cuenta` , `cuenta` , `valor` AS debe, `valorp` AS haber, `t_bl_inicial_idt_bl_inicial` , tipo
FROM `t_ejercicio` WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "' AND `ejercicio` =" . $assi . " and year='" . $year . "' ORDER BY ejercicio";
                $query3 = $dbi->execute($sql_cuentasgrupos);
                while ($rw3 = $dbi->fetch_row($query3)) {
                    $id_ej = $rw3['idt_corrientes'];
                    $fech = $rw3['fecha'];
                    $cod_cta = $rw3['cod_cuenta'];
                    $cta = $rw3['cuenta'];
                    $deb = $rw3['debe'];
                    $hab = $rw3['haber'];
                    $deb = num($deb);
                    $hab = num($hab);
                    $cta = limpiar($cta);
                    ?>

                    <tbody>
                        <tr class="odd gradeX">
                            <td><?Php echo $fech ?></td>
                            <td><?Php echo $cod_cta ?></td>
                            <td><?Php echo $cta ?></td>
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
                <?php
            }
            $b++;
            ?>
        </th>
        </tr>
        </tbody>
        <?Php
        $sql_totales = "SELECT e.year, e.`t_bl_inicial_idt_bl_inicial` AS balance, sum( e.`debe` ) AS d, 
            sum( e.`haber` ) AS h
FROM `libro` e
WHERE 
e.`t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'
AND e.year = '" . $year . "'
GROUP BY e.`t_bl_inicial_idt_bl_inicial` ";
        $sql_totalesbalance = "SELECT e.year,e.`t_bl_inicial_idt_bl_inicial` as balance,
            sum( e.`valor` ) as debe_b, sum( e.`valorp` ) as haber_b
FROM `t_ejercicio` e
where e.year='" . $year . "' and e.t_bl_inicial_idt_bl_inicial='" . $maxbalancedato . "'
group by e.`t_bl_inicial_idt_bl_inicial`";

        $res_tot = $dbi->execute($sql_totales) or die(mysqli_errno($dbi));
        $res_totb = $dbi->execute($sql_totalesbalance) or die(mysqli_errno($dbi));
        $f_tot = $dbi->fetch_row($res_tot);
        $f_totb = $dbi->fetch_row($res_totb);

        $d = $f_tot['d'];
        $h = $f_tot['h'];

        $ta = $f_totb['debe_b'];
        $pp = $f_totb['haber_b'];

        $td = $d + $ta;
        $th = $h + $pp;

        $td = num($td);
        $th = num($th);
        ?>
        <tr>
            <td colspan="3"><label>Suma : </label></td>
            <td><?php echo $td; ?></td>
            <td><?php echo $th; ?></td>
        </tr>
        <?Php
        mysqli_close($dbi);
        ?>
        </table>
        <?Php
    }

    function tab_in_num_as($dbi, $ass, $fecha) {
        ?>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <?Php
            $year = date("Y");
            $sqlmaxingreso = "SELECT max(`idt_bl_inicial`) as id FROM `t_bl_inicial`";
            $query1 = $dbi->execute($sqlmaxingreso);
            while ($rw = $dbi->fetch_row($query1)) {
                $maxbalancedato = trim($rw['id']);
            }

            $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` as ej,`concepto` as c,fecha as f FROM `num_asientos` "
                    . "WHERE `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' and year ='" . $year . "' "
                    . "and `t_ejercicio_idt_corrientes` ='" . $ass . "' and fecha ='" . $fecha . "'  order by ej desc";
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

                            $verfechaservidor = "SELECT DATE(NOW()) as fech_server";
                            $resfserver = $dbi->execute($verfechaservidor);
                            while ($rowf_ser = $dbi->fetch_row($resfserver)) {
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
                            <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-outline btn-info glyphicon glyphicon-eye-open" onclick="detall_asin(<?Php echo $a; ?>);"></button>
                            <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print"
                                    onclick="imp_assin_ass(<?Php echo $a; ?>)"></button>
                            <!--<button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-wrench" onclick="conf_ass(<?Php
                            echo $ass;
                            echo $fech;
                            ?>)"></button>-->
                            <?Php
                            if ($m_serv == $m_fech) {
                                echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" '
                                . 'href="./templateslimit/ModuloContable/up_ass.php?id_asientourl=' . $ass . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
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
                $sql_cuentasgrupos = "SELECT idt_corrientes as id,ejercicio as `asiento` , `fecha` , cod_cuenta as `ref` ,
                    `cuenta` ,valor as  debe,valorp as  haber, `t_bl_inicial_idt_bl_inicial` ,tipo as grupo
FROM `t_ejercicio`
WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'
AND `ejercicio` =" . $ass . " and year='" . $year . "' and fecha ='" . $fech . "'
 ORDER BY ejercicio";
                $query3 = $dbi->execute($sql_cuentasgrupos);
                while ($rw3 = $dbi->fetch_row($query3)) {
                    $id_ej = $rw3['id'];
                    $fech = $rw3['fecha'];
                    $cod_cta = $rw3['ref'];
                    $cta = $rw3['cuenta'];
                    $deb = $rw3['debe'];
                    $hab = $rw3['haber'];

                    $deb = num($deb);
                    $hab = num($hab);
                    $cta = limpiar($cta);
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
                <?php
                $a++;
            }
            ?>  
        </th>
        </tr>
        </tbody>
        <?Php
        $sql_totales = "SELECT e.year, e.`t_bl_inicial_idt_bl_inicial` AS balance, sum( e.`valor` ) AS d, 
            sum( e.`valorp` ) AS h
FROM `t_ejercicio` e
WHERE 
e.`t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'
AND `ejercicio` =" . $ass . " and year='" . $year . "' and fecha ='" . $fech . "'
GROUP BY e.`t_bl_inicial_idt_bl_inicial` ";

        $res_tot = $dbi->execute($sql_totales) or die(mysqli_errno($dbi));
        $f_tot = $dbi->fetch_row($res_tot);

        $d = $f_tot['d'];
        $h = $f_tot['h'];

        $d = num($d);
        $h = num($h);
        ?>
        <tr>
            <td colspan="3"><label>Suma : </label></td>
            <td><?php echo $d; ?></td>
            <td><?php echo $h; ?></td>
        </tr>
        <?Php
        mysqli_close($dbi);
        ?>
        </table>
        <?Php
    }

    function tab_asiento($dbi, $ass, $fecha) {
        ?>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <?Php
            $year = date("Y");
            $sqlmaxingreso = "SELECT max(`idt_bl_inicial`) as id FROM `t_bl_inicial`";
            $query1 = $dbi->execute($sqlmaxingreso);
            while ($rw = $dbi->fetch_row($query1)) {
                $maxbalancedato = trim($rw['id']);
            }

            $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` as ej,`concepto` as c,fecha as f FROM `num_asientos` "
                    . "WHERE `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' and year ='" . $year . "' "
                    . "and `t_ejercicio_idt_corrientes` ='" . $ass . "' and fecha ='" . $fecha . "'  order by ej desc";
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

                            $verfechaservidor = "SELECT DATE(NOW()) as fech_server";
                            $resfserver = $dbi->execute($verfechaservidor);
                            while ($rowf_ser = $dbi->fetch_row($resfserver)) {
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
                            <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-outline btn-info glyphicon glyphicon-eye-open" onclick="detall_asin(<?Php echo $a; ?>);"></button>
                            <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print"
                                    onclick="imp_assin_ass(<?Php echo $a; ?>)"></button>
                            <!--<button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-wrench" onclick="conf_ass(<?Php
                            echo $ass;
                            echo $fech;
                            ?>)"></button>-->
                            <?Php
                            if ($m_serv == $m_fech) {
                                echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" '
                                . 'href="./templateslimit/ModuloContable/up_ass.php?id_asientourl=' . $ass . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
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
                $sql_cuentasgrupos = "SELECT idlibro as id, `asiento` , `fecha` , `ref` ,
                    `cuenta` , debe,haber, `t_bl_inicial_idt_bl_inicial` , grupo
FROM `libro`
WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'
AND `asiento` =" . $ass . " and year='" . $year . "' and fecha ='" . $fech . "'
 ORDER BY asiento";
                $query3 = $dbi->execute($sql_cuentasgrupos);
                while ($rw3 = $dbi->fetch_row($query3)) {
                    $id_ej = $rw3['id'];
                    $fech = $rw3['fecha'];
                    $cod_cta = $rw3['ref'];
                    $cta = $rw3['cuenta'];
                    $deb = $rw3['debe'];
                    $hab = $rw3['haber'];

                    $deb = num($deb);
                    $hab = num($hab);
                    $cta = limpiar($cta);
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
                <?php
                $a++;
            }
            ?>  
        </th>
        </tr>
        </tbody>
        <?Php
        $sql_totales = "SELECT e.year, e.`t_bl_inicial_idt_bl_inicial` AS balance, sum( e.`debe` ) AS d, 
            sum( e.`haber` ) AS h
FROM `libro` e
WHERE 
e.`t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'
AND `asiento` =" . $ass . " and year='" . $year . "' and fecha ='" . $fech . "'
GROUP BY e.`t_bl_inicial_idt_bl_inicial` ";

        $res_tot = $dbi->execute($sql_totales) or die(mysqli_errno($dbi));
        $f_tot = $dbi->fetch_row($res_tot);

        $d = $f_tot['d'];
        $h = $f_tot['h'];

        $d = num($d);
        $h = num($h);
        ?>
        <tr>
            <td colspan="3"><label>Suma : </label></td>
            <td><?php echo $d; ?></td>
            <td><?php echo $h; ?></td>
        </tr>
        <?Php
        mysqli_close($dbi);
        ?>
        </table>
        <?Php
    }

    function tab_my_cta($c, $cta, $bl, $y) {
        $consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
        $query_bl = mysqli_query($c, $consul_bal_inicial);
        $row = mysqli_fetch_array($query_bl);
        $idcod = $row['contador'];
        $idcod_sig = $row['Siguiente'];
        $year = date('Y');
        ?>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <?Php
            session_start();
//        $c = $this->conec_base();
            $year = date("Y");
            $sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
            $resul_param = mysqli_query($c, $sqlparametro);
            $dataparametro = mysqli_fetch_array($resul_param);
            $parametro_contador = $dataparametro['cont'];
            if ($parametro_contador == "") {
                echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
            }
            $sql_bactual_libro = "SELECT MIN(fecha) as Min_p, MAX(fecha) as Max_p FROM `v_mayorizacionaux` where t_bl_inicial_idt_bl_inicial = '" . $parametro_contador . "' ";
            $result_bl_lib = mysqli_query($c, $sql_bactual_libro);
            $clase_bl_lib = mysqli_fetch_array($result_bl_lib);
            $Min_p = $clase_bl_lib['Min_p'];
            $Max_p = $clase_bl_lib['Max_p'];

            $valores = "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, 
        sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,
        sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sldeu,
        sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as slacr FROM vistabalanceresultadosajustados WHERE 
        `t_bl_inicial_idt_bl_inicial`='" . $bl . "' and year='" . $y . "' and cod_cuenta='" . $cta . "'";
            $res_valores = mysqli_query($c, $valores);
            while ($dato_fila = mysqli_fetch_assoc($res_valores)) {
                $mayor_debe = $dato_fila['debe'];
                $mayor_haber = $dato_fila['haber'];
                $mayor_sldue = $dato_fila['sldeu'];
                $mayor_sldacr = $dato_fila['slacr'];
                $mayor_debe = num($mayor_debe);
                $mayor_haber = num($mayor_haber);
                $mayor_sldue = num($mayor_sldue);
                $mayor_sldacr = num($mayor_sldacr);
            }
            ?>
            <form name="form_ejercicio" id="form_ejercicio" method="post" action="">
                <fieldset>
                    <br/>
                    <strong><label>Contbl :</label><?php echo $parametro_contador; ?> 
                        <label> Desde :</label><?php echo $Min_p; ?> 
                        <label>  - Hasta :</label><?php echo $Max_p; ?></strong>
                    <br/>
                    <div class="contenedoresm">

                        <center>

                            <table id="table1" name="table1" > 

                                <thead>
                                    <tr>
                                        <td>Fecha</td>
                                        <td>Cod.</td>
                                        <td>Cuenta</td>
                                        <td>Debe</td>
                                        <td>Haber</td>
                                        <td># Ass</td>
                                        <td>Concepto</td>
                                    </tr>
                                </thead>
                                <!--Zona Upload de cuentas para mayor-->
                                <?Php
                                $cargamayor = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`valor` , v.`valorp` , "
                                        . "v.`t_bl_inicial_idt_bl_inicial` , v.ejercicio AS j, n.concepto "
                                        . "FROM `v_mayorizacionaux` v JOIN num_asientos n WHERE "
                                        . "v.ejercicio = n.t_ejercicio_idt_corrientes AND "
                                        . "v.`t_bl_inicial_idt_bl_inicial` = n.t_bl_inicial_idt_bl_inicial and"
                                        . " v.t_bl_inicial_idt_bl_inicial='" . $bl . "' AND"
                                        . " v.cod_cuenta = '" . $cta . "' AND v.year = '" . $y . "'";
//                                ajustes
                                $sqlaj = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`debe` , v.`haber` ,"
                                        . " v.`balance` , v.ejercicio AS j, n.concepto FROM `vmayorizacionajustes` v"
                                        . " JOIN num_asientos_ajustes n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes"
                                        . " AND v.`balance` = n.t_bl_inicial_idt_bl_inicial and v.balance='" . $bl . "'"
                                        . " AND v.cod_cuenta = '" . $cta . "' AND v.year = '" . $y . "'";
                                $resultaj = mysqli_query($c, $sqlaj);


                                $result = mysqli_query($c, $cargamayor);
                                while ($row = mysqli_fetch_row($result)) {
                                    $f = $row[0];
                                    $cd_cta = $row[1];
                                    $cta = $row[2];
                                    $deb = $row[3];
                                    $hab = $row[4];
                                    $ej = $row[6];
                                    $concep = $row[7];
                                    $cta = limpiar($cta);
                                    $concep = limpiar($concep);
                                    $deb = num($deb);
                                    $hab = num($hab);
                                    echo "<tbody>";
                                    echo "<tr>";
                                    echo "<td style='width:5px;'>" . $f . "</td>";
                                    echo "<td style='width:150px;'>" . $cd_cta . "</td>";
                                    echo "<td style='width:20px;'>" . $cta . "</td>";
                                    echo "<td style='width:20px;'>" . $deb . "</td>";
                                    echo "<td style='width:20px;'>" . $hab . "</td>";
                                    echo "<td>" . $ej . "</td>";
                                    echo "<td>" . $concep . "</td>";
                                    echo "</tr>";
                                    echo "</tbody>";
                                }
                                ?>
                            </table>  

                            <h1>AJUSTES</h1>
                            <table id="table1" name="table1" > 

                                <thead>
                                    <tr>
                                        <td>Fecha</td>
                                        <td>Cod.</td>
                                        <td>Cuenta</td>
                                        <td>Debe</td>
                                        <td>Haber</td>
                                        <td>Concepto</td>
                                        <td>Asiento </td>
                                    </tr>
                                </thead>
                                <?php
                                while ($rowj = mysqli_fetch_row($resultaj)) {
                                    $dj = $rowj[3];
                                    $hj = $rowj[4];
                                    $ctaj = $rowj[2];
                                    $ctaj = limpiar($ctaj);
                                    $dj = num($dj);
                                    $hj = num($hj);
                                    echo "<tbody>";
                                    echo "<tr>";
                                    echo "<td style='width:5px;'>" . $rowj[0] . "</td>";
                                    echo "<td style='width:5px;'>" . $rowj[1] . "</td>";
                                    echo "<td style='width:150px;'>" . $ctaj . "</td>";
                                    echo "<td style='width:20px;'>" . $dj . "</td>";
                                    echo "<td style='width:20px;'>" . $hj . "</td>";
                                    echo "<td style='width:20px;'>" . $rowj[7] . "</td>";
                                    echo "<td>" . $rowj[6] . "</td>";
                                    echo "</tr>";
                                    echo "</tbody>";
                                }
                                ?>
                            </table>
                        </center>

                        <table class="table1">
                            <tr>
                                <td style='width:15px;'> </td>
                                <td style='width:15px;'>Sumas :</td>
                                <td style='width:10px;'><?php echo $mayor_debe ?></td>
                                <td style='width:10px;'><?php echo $mayor_haber ?></td>
                                <td style='width:10px;'><?php echo $mayor_sldue ?></td>
                                <td style='width:10px;'><?php echo $mayor_sldacr ?></td>
                            </tr>
                        </table>


                    </div>
                </fieldset>
            </form>
        </table>
        <?Php
    }

    function tab_my($c) {
        $consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
        $query_bl = mysqli_query($c, $consul_bal_inicial);
        $row = mysqli_fetch_array($query_bl);
        $idcod = $row['contador'];
        $idcod_sig = $row['Siguiente'];
        $year = date('Y');
        ?>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <?Php
            session_start();
//        $c = $this->conec_base();
            $year = date("Y");
            $sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
            $resul_param = mysqli_query($c, $sqlparametro);
            $dataparametro = mysqli_fetch_array($resul_param);
            $parametro_contador = $dataparametro['cont'];
            if ($parametro_contador == "") {
                echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
            }
            $sql_bactual_libro = "SELECT MIN(fecha) as Min_p, MAX(fecha) as Max_p FROM `v_mayorizacionaux` where t_bl_inicial_idt_bl_inicial = '" . $parametro_contador . "' ";
            $result_bl_lib = mysqli_query($c, $sql_bactual_libro);
            $clase_bl_lib = mysqli_fetch_array($result_bl_lib);
            $Min_p = $clase_bl_lib['Min_p'];
            $Max_p = $clase_bl_lib['Max_p'];

            $valores = "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, "
                    . "sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,"
                    . "sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sld_deudor,"
                    . "sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as sld_acreedor FROM vistabalanceresultadosajustados WHERE "
                    . "`t_bl_inicial_idt_bl_inicial`='" . $parametro_contador . "' and year='" . $year . "'";
            $res_valores = mysqli_query($c, $valores);
            while ($resultb = mysqli_fetch_assoc($res_valores)) {
                $Tdebe = $resultb['debe'];
                $Thaber = $resultb['haber'];
                $Sdeudor = $resultb['sld_deudor'];
                $Sacreedor = $resultb['sld_acreedor'];
                $Tdebe = num($Tdebe);
                $Thaber = num($Thaber);
                $Sdeudor = num($Sdeudor);
                $Sacreedor = num($Sacreedor);
            }
            ?>
            <form name="form_ejercicio" id="form_ejercicio" method="post" action="">
                <fieldset>
                    <br/>
                    <strong><label>Contbl :</label><?php echo $parametro_contador; ?> 
                        <label> Desde :</label><?php echo $Min_p; ?> 
                        <label>  - Hasta :</label><?php echo $Max_p; ?></strong>
                    <br/>
                    <div class="contenedoresm">

                        <center>

                            <table id="table1" name="table1" > 

                                <thead>
                                    <tr>
                                        <td>Cod.</td>
                                        <td>Cuenta</td>
                                        <td>Debe</td>
                                        <td>Haber</td>
                                        <td>Deudor</td>
                                        <td>Acreedor</td>
                                    </tr>
                                </thead>
                                <!--Zona Upload de cuentas para mayor-->
                                <?Php
                                $cargamayor = "SELECT `t_bl_inicial_idt_bl_inicial`,`tipo`,`cod_cuenta`, `cuenta`, 
    sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0)) as sdeb, 
    sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0)) as shab, 
    sum(COALESCE(debe_aj, 0)+COALESCE(debe,0)) - sum(COALESCE(haber_aj, 0) + COALESCE(haber, 0)) as sldeu, 
    CONCAT('0.00') as slacr FROM vistabalanceresultadosajustados WHERE `t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "' and year='" . $year . "'
    group BY cod_cuenta, cod_cuenta_aj HAVING sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0))>sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0))
UNION
SELECT `t_bl_inicial_idt_bl_inicial`,`tipo`,`cod_cuenta`, `cuenta`, sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0)) as sdeb, sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0)) as shab,
CONCAT('0.00') as slacr, sum(COALESCE(haber_aj, 0) + COALESCE(haber, 0))-sum(COALESCE(debe_aj, 0)+COALESCE(debe,0)) as sldeu  FROM vistabalanceresultadosajustados WHERE 
`t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "' and year='" . $year . "' group BY cod_cuenta, cod_cuenta_aj HAVING sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0))<sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0))
order by cod_cuenta";
                                $result = mysqli_query($c, $cargamayor);
                                while ($row = mysqli_fetch_row($result)) {
                                    $d = $row[4];
                                    $h = $row[5];
                                    $deu = $row[6];
                                    $acr = $row[7];
                                    $cta = $row[3];
                                    $cta = limpiar($cta);
                                    $d = num($d);
                                    $h = num($h);
                                    $deu = num($deu);
                                    $acr = num($acr);
                                    echo "<tbody>";
                                    echo "<tr>";
                                    echo "<td style='width:5px;'>" . $row[2] . "</td>";
                                    echo "<td style='width:150px;'>" . $cta . "</td>";
                                    echo "<td style='width:20px;'>" . $d . "</td>";
                                    echo "<td style='width:20px;'>" . $h . "</td>";
                                    echo "<td style='width:20px;'>" . $deu . "</td>";
                                    echo "<td>" . $acr . "</td>";
                                    echo "</tr>";
                                    echo "</tbody>";
                                }
                                ?>

                            </table>  
                        </center>

                        <table class="table1">
                            <tr>
                                <td style='width:15px;'> </td>
                                <td style='width:15px;'>Sumas :</td>
                                <td style='width:10px;'><?php echo $Tdebe ?></td>
                                <td style='width:10px;'><?php echo $Thaber ?></td>
                                <td style='width:10px;'><?php echo $Sdeudor ?></td>
                                <td style='width:10px;'><?php echo $Sacreedor ?></td>
                            </tr>
                        </table>

                        <!--<h1> AJUSTES </h1>-->


                    </div>
                </fieldset>
            </form>
        </table>
        <?Php
    }

    function tab_my_by_cta($c, $cta) {
        $consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
        $query_bl = mysqli_query($c, $consul_bal_inicial);
        $row = mysqli_fetch_array($query_bl);
        $idcod = $row['contador'];
        $idcod_sig = $row['Siguiente'];
        $year = date('Y');
        ?>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <?Php
            session_start();
//        $c = $this->conec_base();
            $year = date("Y");
            $sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
            $resul_param = mysqli_query($c, $sqlparametro);
            $dataparametro = mysqli_fetch_array($resul_param);
            $parametro_contador = $dataparametro['cont'];
            if ($parametro_contador == "") {
                echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
            }
            $sql_bactual_libro = "SELECT MIN(fecha) as Min_p, MAX(fecha) as Max_p FROM `v_mayorizacionaux` where t_bl_inicial_idt_bl_inicial = '" . $parametro_contador . "' ";
            $result_bl_lib = mysqli_query($c, $sql_bactual_libro);
            $clase_bl_lib = mysqli_fetch_array($result_bl_lib);
            $Min_p = $clase_bl_lib['Min_p'];
            $Max_p = $clase_bl_lib['Max_p'];

            $valores = "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, 
        sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,
        sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sldeu,
        sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as slacr FROM vistabalanceresultadosajustados WHERE 
        `t_bl_inicial_idt_bl_inicial`='" . $parametro_contador . "' and year='" . $year . "' and cod_cuenta='" . $cta . "'";
            $res_valores = mysqli_query($c, $valores);
            while ($resultb = mysqli_fetch_assoc($res_valores)) {
                $Tdebe = $resultb['debe'];
                $Thaber = $resultb['haber'];
                $Sdeudor = $resultb['sldeu'];
                $Sacreedor = $resultb['slacr'];
                $Tdebe = num($Tdebe);
                $Thaber = num($Thaber);
                $Sdeudor = num($Sdeudor);
                $Sacreedor = num($Sacreedor);
            }
            ?>
            <form name="form_ejercicio" id="form_ejercicio" method="post" action="">
                <fieldset>
                    <br/>
                    <strong><label>Contbl :</label><?php echo $parametro_contador; ?> 
                        <label> Desde :</label><?php echo $Min_p; ?> 
                        <label>  - Hasta :</label><?php echo $Max_p; ?></strong>
                    <br/>
                    <div class="contenedoresm">

                        <center>

                            <table id="table1" name="table1" > 

                                <thead>
                                    <tr>
                                        <td>Fecha</td>
                                        <td>Cod.</td>
                                        <td>Cuenta</td>
                                        <td>Debe</td>
                                        <td>Haber</td>
                                        <td>Concepto</td>
                                        <td>Asiento </td>
                                    </tr>
                                </thead>
                                <!--Zona Upload de cuentas para mayor-->
                                <?Php
                                $cargamayor = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`valor` , v.`valorp` ,"
                                        . " v.`t_bl_inicial_idt_bl_inicial` , v.ejercicio AS j, n.concepto FROM"
                                        . " `v_mayorizacionaux` v JOIN num_asientos n WHERE"
                                        . " v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`t_bl_inicial_idt_bl_inicial` = "
                                        . "n.t_bl_inicial_idt_bl_inicial and v.t_bl_inicial_idt_bl_inicial='" . $parametro_contador . "' "
                                        . "AND v.cod_cuenta = '" . $cta . "' AND v.year = '" . $year . "'";

                                $sqlaj = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`debe` , v.`haber` ,"
                                        . " v.`balance` , v.ejercicio AS j, n.concepto FROM `vmayorizacionajustes` v"
                                        . " JOIN num_asientos_ajustes n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes"
                                        . " AND v.`balance` = n.t_bl_inicial_idt_bl_inicial and v.balance='" . $parametro_contador . "'"
                                        . " AND v.cod_cuenta = '" . $cta . "' AND v.year = '" . $year . "'";

                                $result = mysqli_query($c, $cargamayor);

                                $resultaj = mysqli_query($c, $sqlaj);

                                while ($row = mysqli_fetch_row($result)) {
                                    $d = $row[3];
                                    $h = $row[4];
                                    $cta = $row[2];
                                    $cta = limpiar($cta);
                                    $d = num($d);
                                    $h = num($h);
                                    echo "<tbody>";
                                    echo "<tr>";
                                    echo "<td style='width:5px;'>" . $row[0] . "</td>";
                                    echo "<td style='width:5px;'>" . $row[1] . "</td>";
                                    echo "<td style='width:150px;'>" . $cta . "</td>";
                                    echo "<td style='width:20px;'>" . $d . "</td>";
                                    echo "<td style='width:20px;'>" . $h . "</td>";
                                    echo "<td style='width:20px;'>" . $row[7] . "</td>";
                                    echo "<td>" . $row[6] . "</td>";
                                    echo "</tr>";
                                    echo "</tbody>";
                                }
                                ?>

                            </table>  
                            <?Php
                            ?>
                            <h1>AJUSTES</h1>
                            <table id="table1" name="table1" > 

                                <thead>
                                    <tr>
                                        <td>Fecha</td>
                                        <td>Cod.</td>
                                        <td>Cuenta</td>
                                        <td>Debe</td>
                                        <td>Haber</td>
                                        <td>Concepto</td>
                                        <td>Asiento </td>
                                    </tr>
                                </thead>
                                <?php
                                while ($rowj = mysqli_fetch_row($resultaj)) {
                                    $dj = $rowj[3];
                                    $hj = $rowj[4];
                                    $ctaj = $rowj[2];
                                    $ctaj = limpiar($ctaj);
                                    $dj = num($dj);
                                    $hj = num($hj);
                                    echo "<tbody>";
                                    echo "<tr>";
                                    echo "<td style='width:5px;'>" . $rowj[0] . "</td>";
                                    echo "<td style='width:5px;'>" . $rowj[1] . "</td>";
                                    echo "<td style='width:150px;'>" . $ctaj . "</td>";
                                    echo "<td style='width:20px;'>" . $dj . "</td>";
                                    echo "<td style='width:20px;'>" . $hj . "</td>";
                                    echo "<td style='width:20px;'>" . $rowj[7] . "</td>";
                                    echo "<td>" . $rowj[6] . "</td>";
                                    echo "</tr>";
                                    echo "</tbody>";
                                }
                                ?>
                            </table>
                            <?Php
                            ?>

                        </center>
                        <h1></h1>
                        <table class="table1">
                            <tr style='width:10px;'>DEBE <?php echo $Tdebe ?></tr>
                            <tr style='width:10px;'>HABER <?php echo $Thaber ?></tr>
                            <tr style='width:10px;'>DEUDOR <?php echo $Sdeudor ?></tr>
                            <tr style='width:10px;'>ACREEDOR <?php echo $Sacreedor ?></tr>                                
                        </table>

                        <!--<h1> AJUSTES </h1>-->


                    </div>
                </fieldset>
            </form>
        </table>
        <?Php
    }

    function b_res($conn) {
        $date = date('Y-m-d');
        $year = date('Y');
        ?>
        <form name="BalancedeComprobacion" id="BalancedeComprobacion" action="ex_bresl.php" method="post">
            <center>
                <h1>ESTADO DE SITUACI&Oacute;N FINANCIERA</h1>
                <h3>Hasta la fecha <?php echo $date ?> del <?php echo $year ?></h3>

                <div class="mensaje"></div>
                <!--carga de el balance de resultados por grupos-->
                <?php
                $sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
                $resul_param = $conn->query($sqlparametro);
                if ($resul_param->num_rows > 0) {
                    while ($clase_param = $resul_param->fetch_assoc()) {
                        $parametro_contador = $clase_param['cont'];
                    }
                } else {
                    echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
                }
//                cambios
//                cambios
//                cambios
                echo '<table width="100%" class="table table-striped table-bordered table-hover">';
                echo "<br>";
                echo '<tr>';
                echo '<th colspan="3"></th>';
                echo '<td style="display:none"></td>';
                echo '<td style="display:none"></td>';
                echo '<td style="display:none"></td>';
                echo '</tr>';
                $select_ct = "SELECT codigo,cuenta,total FROM estadoresultados where codigo <='3.1.1.2.' ORDER BY codigo ASC";
                $resulgrupos = mysqli_query($conn, $select_ct)or trigger_error("Query Failed! SQL: $select_ct - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                while ($row2 = mysqli_fetch_array($resulgrupos)) {
                    $str = strlen($row2['codigo']);
                    echo '<tr>
                                                        <td>' . $row2['codigo'] . '</td>
                                                        <td>' . $row2['cuenta'] . '</td>';
                    if ($str == 2) {
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                    } elseif ($str == 4) {
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                        echo '<td></td>';
                    } elseif ($str == 6) {
                        echo '<td></td>';
                        echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    } elseif ($str == 8) {
                        echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
                ?>
                <!--fin carga de el balance de resultados por grupos-->



            </center>

        </form>
        <?Php
    }

    function st_fnl($dbi) {
        $date = date('Y-m-d');
        $year = date('Y');
        ?>
        <form name="BalancedeComprobacion" id="BalancedeComprobacion" action="ex_stfnl.php" method="post">
            <center>
                <table>
                    <h1>ESTADO DE RESULTADOS</h1>
                    <?php
                    $c = $dbi->conexion();
                    $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
                    $result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($c), E_USER_ERROR);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $maxbalancedato = $row['id'];
                        }
                    }
                    $c->close();
                    ?>
                    <input type="hidden" value="<?php echo $maxbalancedato; ?>" id="texto"/>

                    <div class="mensaje"></div>
                    <input type="hidden" value="<?php echo $estado; ?>"/>
                    <?Php
                    $c = $dbi->conexion();
                    $sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
                    $resul_param = $c->query($sqlparametro);
                    if ($resul_param->num_rows > 0) {
                        while ($clase_param = $resul_param->fetch_assoc()) {
                            $parametro_contador = $clase_param['cont'];
                        }
                    } else {
                        echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
                    }

                    echo '<table width="100%" class="table table-striped table-bordered table-hover">';
                                            echo "<br>";
                                            echo '<tr>';
                                            echo '<th colspan="3">' . $cod_clasesq . ' ' . $nom_clase . '</th>';
                                            echo '<td style="display:none"></td>';
                                            echo '<td style="display:none"></td>';
                                            echo '<td style="display:none"></td>';
                                            echo '</tr>';

//                                           SQL INGRESOS
                                            $select_ct = "SELECT codigo,cuenta,total FROM estadoresultados where codigo between '4.' and '4.99.99.99.' ORDER BY codigo ASC";
                                            $resulgrupos = mysqli_query($conn, $select_ct)or trigger_error("Query Failed! SQL: $select_ct - Error: " . mysqli_error($mysqli), E_USER_ERROR);

//                                           SQL COSTOS Y GASTOS
                                            $select_cg = "SELECT codigo,cuenta,total FROM estadoresultados where codigo between '5.' and '5.99.99.99.' ORDER BY codigo ASC";
                                            $resulgruposcg = mysqli_query($conn, $select_cg)or trigger_error("Query Failed! SQL: $select_cg - Error: " . mysqli_error($mysqli), E_USER_ERROR);

                                            $datosIngreso = array(); 
                                            while ($row2 = mysqli_fetch_array($resulgrupos)) {
                                                $numIng = mysqli_num_rows($resulgrupos);
                                                $str = strlen($row2['codigo']);
                                                echo '<tr>
                                                        <td>' . $row2['codigo'] . '</td>
                                                        <td>' . $row2['cuenta'] . '</td>';
                                                if ($str == 2) {
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                                                    
                                                    for ($i=0; $i<=count($numIng); $i++){
                                                        $datosIngreso[] = $row2['total'];
                                                    } 

                                                } elseif ($str == 4) {
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                                                    echo '<td></td>';
                                                } elseif ($str == 6) {
                                                    echo '<td></td>';
                                                    echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                } elseif ($str == 8) {
                                                    echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                }
                                                echo '</tr>';
                                            }
                                            $datosGastos = array(); 
                                            while ($row3 = mysqli_fetch_array($resulgruposcg)) {
                                                $numGas = mysqli_num_rows($resulgruposcg);
                                                $str = strlen($row3['codigo']);
                                                echo '<tr>
                                                        <td>' . $row3['codigo'] . '</td>
                                                        <td>' . $row3['cuenta'] . '</td>';
                                                if ($str == 2) {
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td>' . number_format($row3['total'], 2, '.', '') . '</td>';
                                                    for ($j=0; $j<=count($numGas); $j++){
                                                        $datosGastos[] = $row3['total'];
                                                    } 
                                                } elseif ($str == 4) {
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td>' . number_format($row3['total'], 2, '.', '') . '</td>';
                                                    echo '<td></td>';
                                                } elseif ($str == 6) {
                                                    echo '<td></td>';
                                                    echo '<td>' . number_format($row3['total'], 2, '.', '') . '</td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                } elseif ($str == 8) {
                                                    echo '<td>' . number_format($row3['total'], 2, '.', '') . '</td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                }
                                                echo '</tr>';
                                            }

                                            $utilidad = $datosIngreso[0] - $datosGastos[0];

                                            if (isset($utilidad)) {
                                                $utilidad = $utilidad;
                                            } else {
                                                $utilidad = '0.00';
                                            }
                                            echo '<tr>'
                                            . '<td></td>'
                                            . '<td>UTILIDAD</td>'
                                            . '<td></td>'
                                            . '<td></td>'
                                            . '<td></td>'
                                            . '<td>' .
                                            number_format($utilidad, 2, '.', '') . '</td>'
                                            . '</tr>';
                                            echo '</table>'
                                            
                                        

                    
                    ?>
            </center>

        </form>
        <?Php
    }

    function pln($consulta) {
        ?>
        <form name="BalancedeComprobacion" id="BalancedeComprobacion" action="ex_pl.php" method="post">
            <center>
                <table class="table table-striped table-bordered table-hover">

                    <tr>
                        <th>Cod Cta.</th>
                        <th  colspan="10">Cuenta</th>
                    </tr>
                    <?php
                    if ($consulta) {
                        while ($clase = mysqli_fetch_array($consulta)) {
                            ?>
                            <tr id="fila-<?php echo $clase['idt_plan_de_cuentas'] ?>">
                                <td><?php echo $clase['cod_cuenta'] ?></td>
                                <td>
                                    <?php
                                    $ruta = $clase['nombre_cuenta_plan'];
                                    $cont = $clase['cod_cuenta'];
                                    $dato = str_replace('.', '', $cont, $n);
                                    $carpeta = str_replace('.', '', $ruta, $reemplazos);
                                    if ($n == 0) {
                                        echo '<td class="danger" >';
                                        echo $carpeta;
                                        echo '</td>';
                                    }
                                    if ($n == 1) {
                                        echo '<td class="danger" >';
                                        echo $carpeta;
                                        echo '</td>';
                                    }
                                    if ($n == 2) {
                                        echo '<td class="warning" >  &nbsp; &nbsp; &nbsp; &nbsp;    ';
                                        echo $carpeta;
                                        echo '</td>';
                                    }
                                    if ($n == 3) {
                                        echo '<td class="success" >&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;';
                                        echo $carpeta;
                                        echo '</td>';
                                    }
                                    if ($n == 4) {
                                        echo '<td class="info" >&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ';
                                        echo $carpeta;
                                        echo '</td>';
                                    }
                                    if ($n == 5) {
                                        echo '<td >&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;';
                                        echo $carpeta;
                                        echo '</td>';
                                    }
                                    if ($n == 6) {
                                        echo '<td class="default" >&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp';
                                        echo $carpeta;
                                        echo '</td>';
                                    }
                                    ?>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </center>
        </form>
        <?Php
    }

}
