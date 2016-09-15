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

class componentsass {

    //put your code here

//    fin body tabla balance inicial

    function body_tab_ass() {
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
        while ($rw2 = $dbi->fetch_row($query2)) {
            $idasiento = $rw2['id'];
            $concepto = $rw2['c'];
            $ass = $rw2['ej'];
            $fecha = $rw2['f'];
            ?>
            <!--odd gradeX  even gradeC  gradeA-->
            <br>
            <thead>
                <tr>
                    <th colspan="5" class="center text-center danger">Ref : <?Php echo $ass ?></th>
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
                    <p><?Php echo utf8_decode($concepto) ?></p>
                </div>
            </div>
        <?php } ?>
        </th>
        </tr>
        </tbody>
        <br>
        <?Php
        mysqli_close($dbi);
    }

}
