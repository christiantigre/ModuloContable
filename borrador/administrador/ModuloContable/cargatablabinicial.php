<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$year = date("Y");
$id_usuario = $_SESSION['username'];
$user = $_SESSION['loginu'];
$idlogeobl = $_SESSION['id_user'];

//echo "<script>alert('".$idlogeobl."')</script>";

$db = new mysqli("localhost", $_SESSION['loginu'], $_SESSION['clave'], "condata");
$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
    }
}
$sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` ej,`concepto` c,fecha as f,saldodebe as sald,saldohaber as salh FROM `num_asientos` "
        . "WHERE `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' and year ='" . $year . "' and `t_ejercicio_idt_corrientes`=1  order by ej";
$result_grupo = mysqli_query($db, $sqlbuscagrupos) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
echo '<center>';

echo '<table style="padding:5px;background:#555;color:#fff;width: 960px;">';
echo '<tr>';
echo '<td style="display:none">id</td>';
echo '<td>Fecha</td>';
echo '<td>Codigo</td>';
echo '<td>Cuenta</td>';
echo '<td>Debe</td>';
echo '<td>Haber</td>';
echo '</tr>';
//eje

while ($rw = mysqli_fetch_assoc($result_grupo)) {
    $idasiento = $rw['id']; //echo "<script>alert('".$nombre_grupo."')</script>";
    $nombre_grupo = $rw['c']; //echo "<script>alert('".$nombre_grupo."')</script>";
    $codgrupo = $rw['ej']; //echo "<script>alert('".$nombre_grupo."')</script>";
    $fecha = $rw['f'];
    $saldodb = $rw['sald'];
    $saldohb = $rw['salh'];
    echo '<table width="85%" class="table" style="padding:5px;width: 960px;">';
    echo '<tr><th colspan="5" style="text-align: center;vertical-align: middle;"> Ref : ' . $codgrupo . ''
    . '<a href="detallecuenta.php?id_asientourl=' . $idasiento . '&fechaurl=' . $fecha . '&idlogeo='.$idlogeobl.'">'
    . '<img src="./images/detail.png" alt="Ver" title="Detalles" /> </a>';

    if ($saldodb != 0.00) {
        echo '<li><a target="_blank" href="ajustesasientos.php?idlogeo=';
        echo $idlogeobl;
        echo '&id_asientourl=';
        echo $idasiento;
        echo '&fech_url=';
        echo $fecha . ' " class="btn btn-danger">Realizar Ajuste</a>';
    }elseif ($saldohb != 0.00) {
        echo '<a target="_blank" href="ajustesasientos.php?idlogeo=';
        echo $idlogeobl;
        echo '&id_asientourl=';
        echo $idasiento;
        echo '&fech_url=';
        echo $fecha . ' " class="btn btn-danger">Ajustar</a>'
                . '</li>';
    }
    echo '</th>'
    . '</tr>';
    echo '<input name="valor" type="hidden" id="valor" value="';
    echo $codgrupo;
    echo '"/>';

    $n = 0;
    $sql_cuentasgrupos = "SELECT `ejercicio` , `idt_corrientes` , `fecha` , `cod_cuenta` , `cuenta` , `valor` AS debe, `valorp` AS haber, `t_bl_inicial_idt_bl_inicial` , tipo
FROM `t_ejercicio`
WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'
AND `ejercicio` =" . $codgrupo . " and year='" . $year . "'
ORDER BY ejercicio";
    $result2 = mysqli_query($db, $sql_cuentasgrupos);
    while ($r2 = mysqli_fetch_array($result2)) {
        echo '<tr>';
        echo '<td width="5%" style="display:none">  ' . $r2['idt_corrientes'] . '   </td>';
        echo '<td width="15%">  ' . $r2['fecha'] . '   </td>';
        echo '<td width="15%">  ' . $r2['cod_cuenta'] . '   </td>';
        echo '<td width="35%">  ' . $r2['cuenta'] . '   </td>';
        echo '<td width="10%">  ' . $r2['debe'] . '   </td>';
        echo '<td width="10%">  ' . $r2['haber'] . '   </td>';
        echo '</tr>';
    }
    echo '<tr>';
    echo '<th colspan="6" style="background-color: #ddd;"> Concepto :'
    . '<textarea class="form-control" id="textarea_as" name="textarea_as" rows="1" cols="30">' . $nombre_grupo . '</textarea></th>';
    //echo '' . $nombre_grupo . '';
    echo '</tr>';
    echo '</table>';
    $n++;
}

echo '</table>';
echo '</center>';
