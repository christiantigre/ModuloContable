<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of components
 *
 * @author ANDRES
 */
if (!isset($_SESSION)) {
    session_start();
}

class components {

//root
    function body_adm() {
        require '../../templates/Clases/Conectar.php';
        $year = date("Y");
        $dbi = new Conectar();
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
                        <button type="button" data-toggle="modal" data-target="#myModal"
                                class="btn btn-outline btn-info glyphicon glyphicon-eye-open" onclick="r_detall_asin(<?Php echo $a; ?>);"></button>
                        <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="r_imp_assin_ass(<?Php echo $a; ?>)"></button>
                        <!--<button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-wrench" onclick="conf_ass(<?Php
                        echo $ass;
                        echo $fech;
                        ?>)"></button>-->
                        <?Php
                        if ($m_serv == $m_fech) {
                            echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" href="./ModuloContable/up_ass.php?id_asientourl=' . $ass . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
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
                                class="btn btn-outline btn-info glyphicon glyphicon-eye-open" onclick="r_detall_asini(<?Php echo $b; ?>);"></button>
                        <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="r_imp_assin(<?Php echo $b; ?>)"></button>
                        <?Php
                        if ($m_servi == $m_fechi) {
                            echo '<a class="btn btn-outline btn-info glyphicon glyphicon-wrench" href="./ModuloContable/up_ass_in.php?id_asientourl=' . $assi . '&fechaurl=' . $fech . '" onclick="listar();" "></a>';
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
        ?>
        <tr>
            <td colspan="3"><label>Suma : </label></td>
            <td><input class="form-control" readonly="readonly" style="text-align: right" type="text" id="totd" name="totd" placeholder="Tot. debe" value="<?php echo $td; ?>" required></td>
            <td><input class="form-control" readonly="readonly" style="text-align: right" type="text" id="toth" name="toth" placeholder="Tot. haber" value="<?php echo $th; ?>" required></td>
        </tr>
        <?Php
        mysqli_close($dbi);
    }

//    cont
    function body_tab() {
        ?>

        <table class="table table-striped table-bordered table-hover" id="dataTables-example_sin">
            <input type="hidden" name="idlog" id="idlog" value="<?Php echo $id; ?>" />
            <input type="hidden" name="fechabi" id="fechabi" value="<?Php echo $year; ?>" />
            <input type="hidden" name="asiento_num" id="asiento_num" value="<?Php echo 1; ?>" />
            <input type="hidden" name="fecham" id="fecham" value="<?Php echo $year; ?>" />
            <input type="hidden" name="fechacom" id="fechacom" value="<?Php echo $year; ?>" />
            <?Php
            require '../../templates/Clases/Conectar.php';
            $year = date("Y");
            $dbi = new Conectar();
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
        ?>
        <tr>
            <td colspan="3"><label>Suma : </label></td>
            <td><input class="form-control" readonly="readonly" style="text-align: right" type="text" id="totd" name="totd" placeholder="Tot. debe" value="<?php echo $td; ?>" required></td>
            <td><input class="form-control" readonly="readonly" style="text-align: right" type="text" id="toth" name="toth" placeholder="Tot. haber" value="<?php echo $th; ?>" required></td>
        </tr>

        </table>
        <?Php
        mysqli_close($dbi);
    }

    function body_ls() {
        ?>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th>Asiento</th>
                    <th>Fecha</th>
                    <th>Mes</th>
                    <th>Concepto</th>
                    <th>Estado</th>
                    <th>VER</th>
                    <th>EDITAR</th>
                    <th>PDF</th>
                    <th>EXC</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require '../../templates/Clases/Conectar.php';
                $year = date("Y");
                $dbi = new Conectar();
                $sqlmaxingreso = "SELECT max(`idt_bl_inicial`) as id FROM `t_bl_inicial`";
                $query1 = $dbi->execute($sqlmaxingreso);
                while ($rw = $dbi->fetch_row($query1)) {
                    $maxbalancedato = trim($rw['id']);
                }

                $sql = "SELECT * FROM `num_asientos` where t_bl_inicial_idt_bl_inicial = '" . $maxbalancedato . "' and year = '" . $year . "'";
                $ej = $dbi->execute($sql);
                $a = 1;
                $b = 2;
                while ($row = $dbi->fetch_row($ej)) {
                    $id = $row['idnum_asientos'];
                    $asiento = $row['t_ejercicio_idt_corrientes'];
                    $fecha = $row['fecha'];
                    $mes = $row['mes'];
                    $concep = $row['concepto'];
                    if ($asiento == "1") {
                        ?>

                        <tr class="gradeA">
                    <input type="hidden" id="fechain_<?Php echo $a; ?>" name="fechain_<?Php echo $a; ?>" value="<?Php echo $fecha; ?>" />
                    <input type="hidden" id="assin_<?Php echo $a; ?>" name="assin_<?Php echo $a; ?>" value="<?Php echo $id; ?>" />
                    <input type="hidden" id="tar" name="tar" value="<?Php echo $asiento; ?>" />
                    <input type="hidden" id="fh" name="fh" value="<?Php echo $fecha; ?>" />
                    <td><?Php echo $asiento ?></td>
                    <td><?Php echo $fecha ?></td>
                    <td class="center"><?Php echo $mes ?></td>
                    <td class="center"><?Php echo $concep ?></td>
                    <td class="center"><?Php
                        $qryass_cuad = 'SELECT sum(debe) as debe, sum(haber) as haber FROM `libro` WHERE asiento="' . $asiento . '" ';
                        $ej_ass = $dbi->execute($qryass_cuad);
                        while ($rw_ass = $dbi->fetch_row($ej_ass)) {
                            $debe_ass = $rw_ass['debe'];
                            $haber_ass = $rw_ass['haber'];
                            if ($debe_ass == $haber_ass) {
                                echo "Cuadrado";
                            } else {
                                echo "Descuadrado";
                            }
                        }
                        ?></td>
                    <td class="center"><button type="button" title="VIEW" data-toggle="modal" data-target="#myModal" class="btn btn-outline btn-info glyphicon glyphicon-eye-open " onclick="detall_asini(<?Php echo $a; ?>);"></button></td>
                    <td class="center"><a class="btn btn-outline btn-info glyphicon glyphicon-wrench " title="UPDATE" href="./templateslimit/ModuloContable/up_ass_in.php?id_asientourl=<?Php echo $asiento ?>&fechaurl=<?Php echo $fecha ?>" onclick="listar();" ></a></td>
                    <td class="center"><button type="submit" title="PRINT" class="btn btn-outline btn-danger " onclick="imp_assin(<?Php echo $a; ?>)"><img src="../../images/pdf.png" width="30" height="30" alt="pdf"/></button></td>
                    <td class="center"><button type="submit" title="PRINT" name="ex_as_num" id="ex_as_num" class="btn btn-outline btn-success" onclick="exp_wd_num_as(this.id)"><img src="../../images/excel.png" width="30" height="30" alt="excel"/></button></td>
                </tr>


                <?Php
            } else {
                ?>

                <tr class="gradeA">
                <input type="hidden" id="fecha_<?Php echo $b; ?>" name="fecha_<?Php echo $b; ?>" value="<?Php echo $fecha; ?>" />
                <input type="hidden" id="ass_<?Php echo $b; ?>" name="ass_<?Php echo $b; ?>" value="<?Php echo $id; ?>" />                
                <input type="hidden" id="tara_<?Php echo $b; ?>" name="tara_<?Php echo $b; ?>" value="<?Php echo $asiento; ?>" />
                <input type="hidden" id="fha_<?Php echo $b; ?>" name="fha_<?Php echo $b; ?>" value="<?Php echo $fecha; ?>" />
                <td><?Php echo $asiento ?></td>
                <td><?Php echo $fecha ?></td>
                <td class="center"><?Php echo $mes ?></td>
                <td class="center"><?Php echo $concep ?></td>
                <td class="center"><?Php
                    $qryass_cuad = 'SELECT sum(debe) as debe, sum(haber) as haber FROM `libro` WHERE asiento="' . $asiento . '" ';
                    $ej_ass = $dbi->execute($qryass_cuad);
                    while ($rw_ass = $dbi->fetch_row($ej_ass)) {
                        $debe_ass = $rw_ass['debe'];
                        $haber_ass = $rw_ass['haber'];

                        if ($debe_ass == $haber_ass) {
                            echo "<p class='btn-success'>";
                            echo "(D)".$debe_ass;
                            echo "<br />";
                            echo "(H)".$haber_ass;
                            echo "</p>";
                        } else {
                            echo "<p class='btn-danger'>";
                            echo "(D)".$debe_ass;
                            echo "<br />";
                            echo "(H)".$haber_ass;
                            echo "</p>";
                        }
                    }
                    ?></td>
                <td class="center"><button type="button" data-toggle="modal" title="VIEW" data-target="#myModal" class="btn btn-outline btn-info glyphicon glyphicon-eye-open " onclick="detall_asin(<?Php echo $b; ?>);"></button></td>
                <td class="center"><a class="btn btn-outline btn-info glyphicon glyphicon-wrench" title="UPDATE" href="./templateslimit/ModuloContable/up_ass.php?id_asientourl=<?Php echo $asiento ?>&fechaurl=<?Php echo $fecha ?>" onclick="listar();" ></a></td>
                <td class="center"><button type="submit" class="btn btn-outline btn-danger " title="PRINT" onclick="imp_assin_ass(<?Php echo $b; ?>)"><img src="../../images/pdf.png" width="30" height="30" alt="pdf"/></button></td>
                <td class="center"><button type="submit" class="btn btn-outline btn-success" title="PRINT" name="ex_asiento" id="ex_asiento" onclick="exp_asiento(this.id, <?Php echo $b; ?>)"><img src="../../images/excel.png" width="30" height="30" alt="excel"/></button></td>
                </tr>


                <?Php
            }
            $b++;
        }
        $a++;
        ?>

        </tbody>
        </table>
        <?Php
    }

    function ass_where() {
        require '../../templates/Clases/Conectar.php';
        $year = date("Y");
        $dbi = new Conectar();
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
                        ?> 
                        <input type="hidden" id="fecha_<?Php echo $a; ?>" name="fecha_<?Php echo $a; ?>" value="<?Php echo $fech; ?>" />
                        <input type="hidden" id="ass_<?Php echo $a; ?>" name="ass_<?Php echo $a; ?>" value="<?Php echo $ass; ?>" />
                        <button type="button" data-toggle="modal" data-target="#myModal" 
                                class="btn btn-outline btn-info glyphicon glyphicon-eye-open" onclick="detall_asin(<?Php echo $a; ?>);"></button>
                        <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_asin(<?Php echo $fech; ?>)"></button>
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
            <?php
            $a++;
        }
    }

//    fin body tabla bal ini
}
