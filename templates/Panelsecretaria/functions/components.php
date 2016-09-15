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

class components_sec {
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

                        ?> 
                        <input type="hidden" id="fecha_<?Php echo $a; ?>" name="fecha_<?Php echo $a; ?>" value="<?Php echo $fech; ?>" />
                        <input type="hidden" id="ass_<?Php echo $a; ?>" name="ass_<?Php echo $a; ?>" value="<?Php echo $ass; ?>" />
<!--                        <button type="button" data-toggle="modal" data-target="#myModal"
                                class="btn btn-outline btn-info glyphicon glyphicon-eye-open" onclick="r_detall_asin(<?Php echo $a; ?>);"></button>-->
                        <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="sec_imp_assin_ass(<?Php echo $a; ?>)"></button>
                        <!--<button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-wrench" onclick="conf_ass(<?Php
                        echo $ass;
                        echo $fech;
                        ?>)"></button>-->
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

                        <input type="hidden" id="fechain_<?Php echo $b; ?>" name="fechain_<?Php echo $b; ?>" value="<?Php echo $fech; ?>" />
                        <input type="hidden" id="assin_<?Php echo $b; ?>" name="assin_<?Php echo $b; ?>" value="<?Php echo $assi; ?>" />
<!--                        <button type="button" data-toggle="modal" data-target="#myModal" 
                                class="btn btn-outline btn-info glyphicon glyphicon-eye-open" onclick="r_detall_asini(<?Php echo $b; ?>);"></button>
                        <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="r_imp_assin(<?Php echo $b; ?>)"></button>-->
                        
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

}
