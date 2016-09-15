<?php

error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
$c = $dbi->conexion();
$mes = date('F');
$year = date("Y");
$id_usuario = $_SESSION['username'];
$user = strtoupper ( $id_usuario );
$idlogeobl = $_SESSION['id_user'];


$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($c), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
    }
}




$sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` ej,`concepto` c,fecha as f,saldodebe as sald,saldohaber as salh FROM `num_asientos` "
        . "WHERE `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' and year ='" . $year . "'"
        . " and `t_ejercicio_idt_corrientes` >1  order by ej desc";
$result_grupo = mysqli_query($c, $sqlbuscagrupos) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($c), E_USER_ERROR);
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

    $verfechaservidor = "SELECT DATE(NOW()) as fech_server";
    $resfserver = mysqli_query($c, $verfechaservidor);
    while ($rowf_ser = mysqli_fetch_array($resfserver)) {
        $fech_server = $rowf_ser['fech_server'];
    }
        $pos = explode('-',$fech_server);
        $y_serv = $pos[0];
        $m_serv = $pos[1];
        $cadena_fecha = $y_serv.'-'.$m_serv.'-01';
        
        $pos_f = explode('-', $fecha);
        $y_fech = $pos_f[0];
        $m_fech = $pos_f[1];
        
        
//    $verf_fechas = "SELECT DATEDIFF('".$fecha."', '".$cadena_fecha."') as n_dias";
//    $resdif = mysqli_query($c, $verf_fechas);
//    while ($rowf_dif = mysqli_fetch_array($resdif)) {
//        $diferencia = $rowf_dif['n_dias'];
//    }

    echo '<table width="85%" class="table" style="padding:5px;width: 960px;">';
    echo '<tr><th colspan="5" style="text-align: center;vertical-align: middle;"> Ref : ' . $codgrupo 
    . '  <a href="detallecuentaasientos.php?id_asientourl=' . $idasiento . '&fechaurl=' . $fecha . '">'
    . '  <img src="./images/detail.png" alt="Ver" title="Detalles" /> </a>';
    if ($m_serv == $m_fech) {
        echo '<a href="updatass.php?id_asientourl=' . $idasiento . '&fechaurl=' . $fecha . '&idlogeo=' . $idlogeobl . '" onclick="listar();" "><img src="./images/database_edit.png" alt="Editar" title="Editar" /></a>';
    }  else {
        echo '';
    }

    if ($saldodb != 0.00) {
        echo '<a target="_blank" href="ajustesasientos.php?idlogeo=';
        echo $idlogeobl;
        echo '&id_asientourl=';
        echo $idasiento;
        echo '&fech_url=';
        echo $fecha . ' " class="btn btn-danger">Realizar Ajuste</a>';
    } elseif ($saldohb != 0.00) {
        echo '<a target="_blank" href="ajustesasientos.php?idlogeo=';
        echo $idlogeobl;
        echo '&id_asientourl=';
        echo $idasiento;
        echo '&fech_url=';
        echo $fecha . ' " class="btn btn-danger">Realizar Ajuste</a>';
    }
    echo '</th>'
    . '</tr>';
    echo '<input name="valor" type="hidden" id="valor" value="';
    echo $codgrupo;
    echo '"/>';

    $n = 0;
    $sql_cuentasgrupos = "SELECT idlibro,`asiento` , `fecha` , `ref` , `cuenta` ,  debe,  haber, `t_bl_inicial_idt_bl_inicial` , grupo
FROM `libro`
WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'
AND `asiento` =" . $codgrupo . " and year='" . $year . "'
 ORDER BY asiento";
    $result2 = mysqli_query($c, $sql_cuentasgrupos);
    while ($r2 = mysqli_fetch_array($result2)) {
        echo '<tr>';
        echo '<td width="5%" style="display:none">  ' . $r2['idlibro'] . '   </td>';
        echo '<td width="15%">  ' . $r2['fecha'] . '   </td>';
        echo '<td width="15%">  ' . $r2['ref'] . '   </td>';
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
