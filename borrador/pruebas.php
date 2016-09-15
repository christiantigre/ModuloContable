<?php
date_default_timezone_set("America/Guayaquil");
echo date("Y-m-d");
echo '';
echo '';
echo '';
echo date("Y-m-d H:i:s");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($ass == 1) {// echo '<script>alert("Balance inicial")</script>';
    $b = 1;
    $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` ej,`concepto` c,fecha as f FROM `num_asientos` "
            . "WHERE year ='" . $year . "' and `fecha`='" . $datetimepicker1 . "'  order by ej";
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

        $sql_sumas = "SELECT sum(`valor`) as d, sum(`valorp`) as h FROM `libro` WHERE `ejercicio`=" . $assi . " and `year`='" . $year . "' ";
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
            . "WHERE year ='" . $year . "' and `fecha` ='" . $datetimepicker1 . "'  order by ej desc";
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