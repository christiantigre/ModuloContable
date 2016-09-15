<!DOCTYPE html>
<!--Christian Tigre-->
<?php
require '../../../../Clases/Conectar.php';
$dbi = new Conectar();
$dbi = $dbi->conexion();
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "login.php"
</script>';
}
$year = date("Y");
$id_usuario = $_SESSION['username'];
$consulgrupo = "SELECT * FROM `t_grupo`";
$queryclases = mysqli_query($db, $consulgrupo);
$consulta = "SELECT l.username, u.tipo_user,l.idlogeo
FROM logeo l
JOIN user_tipo u
WHERE l.username = '" . $id_usuario . "'";
$resultado = mysqli_query($dbi, $consulta) or die(mysqli_errno($dbi));
$fila = mysqli_fetch_array($resultado);
$user = $fila['username'];
$type_user = $fila['tipo_user'];
$idlogeo = $fila['idlogeo'];


include '../../../Clases/guardahistorialsecretaria.php';
$accion = "Ingreso a contabilidad";
generaLogs($user, $accion);



$sqlmaxingreso = "SELECT max(`idt_bl_inicial`) as u FROM `t_bl_inicial`";
$resul_ultimo = mysqli_query($dbi, $sqlmaxingreso);
if ($rw = mysqli_fetch_row($resul_ultimo)) {
    $ultimoingreso = trim($rw[0]);
}


$rs = mysqli_query($dbi, "SELECT MAX(idt_bl_inicial) AS id FROM t_bl_inicial");
if ($row = mysqli_fetch_row($rs)) {
    $maxbalance = trim($row[0]);
}
$rsmaxlib = mysqli_query($dbi, "SELECT MAX(idres_librodiario) AS id FROM res_librodiario");
if ($rowmaxlib = mysqli_fetch_row($rsmaxlib)) {
    $maxlibr = trim($row[0]);
}

$sql_totales = "SELECT e.year, e.`t_bl_inicial_idt_bl_inicial` AS balance, sum( e.`debe` ) AS d, sum( e.`haber` ) AS h
FROM `libro` e
WHERE 
e.`t_bl_inicial_idt_bl_inicial` = '" . $maxbalance . "'
AND e.year = '" . $year . "'
GROUP BY e.`t_bl_inicial_idt_bl_inicial` ";
$sql_totalesbalance = "SELECT e.year,e.`t_bl_inicial_idt_bl_inicial` as balance, sum( e.`valor` ) as debe_b, sum( e.`valorp` ) as haber_b
FROM `t_ejercicio` e
where e.year='" . $year . "' and e.t_bl_inicial_idt_bl_inicial='" . $maxbalance . "'
group by e.`t_bl_inicial_idt_bl_inicial`";
$res_tot = mysqli_query($dbi, $sql_totales) or die(mysqli_errno($dbi));
$res_totb = mysqli_query($dbi, $sql_totalesbalance) or die(mysqli_errno($dbi));
$f_tot = mysqli_fetch_array($res_tot);
$f_totb = mysqli_fetch_array($res_totb);

$d = $f_tot['d'];
$h = $f_tot['h'];

$ta = $f_totb['debe_b'];
$pp = $f_totb['haber_b'];

$td = $d + $ta;
$th = $h + $pp;

?>
<html>
    <head>
        <title>Diario</title>
        <link href="../../../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <link href="../../../../../css/style.csss" rel='stylesheet' type='text/css' />
        <script src="../../../../../js/jquery.min.js"></script>
        <link href="../../../../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <script src="../../../../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../../../../js/jquery.functions.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#horizontalTab').easyResponsiveTabs({
                    type: 'default', //Types: default, vertical, accordion           
                    width: 'auto', //auto or any width like 600px
                    fit: true   // 100% fit in a container
                });
            });
            
            
        </script>	

    </head>
    <style>
        .contenedores{margin:60px auto;width:960px;font-family:sans-serif;font-size:15px}
        table {width:72%;box-shadow:0 0 10px #ddd;text-align:left}
        th {padding:5px;background:#555;color:#fff}
        td {padding:5px;border:solid #ddd;border-width:0 0 1px;}
        .editable span{display:block;}
        .editable span:hover {background:url(images/edit.png) 90% 50% no-repeat;cursor:pointer}
        .tablib{margin-right:187px;}
        td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
        a.enlace{display:inline-block;width:24px;height:24px;margin:0 0 0 5px;overflow:hidden;text-indent:-999em;vertical-align:middle}
        .guardar{background:url(images/save.png) 0 0 no-repeat}
        .cancelar{background:url(images/cancell.png) 0 0 no-repeat}

        .mensaje{display:block;text-align:center;margin:0 0 20px 0}
        .ok{display:block;padding:10px;text-align:center;background:green;color:#fff}
        .ko{display:block;padding:10px;text-align:center;background:red;color:#fff}
    </style>
    <body>
        <div id="contenedor">
            <center>
                <div id="menus">
                    <!--Menu contable-->
                    <div id="menu_contable">
                        <div class="menu">
                        </div>
                        <div>
                            <center><h1>Modulo de Contabilidad</h1></center>
                        </div>
                    </div>
                    <!--Menu general-->
                    <div id="menu_general">                
                        <div id="caja_us">
                            <table width="718" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>&nbsp;</tr>
                                <tr>
                                    <td colspan="2">
                                        <div align="right">Usuario: 
                                            <span class="Estilo6">
                                                <strong>
<?php echo $_SESSION['username']; ?> 
                                                </strong>
                                            </span>
                                            <input type="hidden" id="username" name="username" value="<?Php echo $user; ?>"
                                                   <input type="hidden" id="idlogeotxt" name="idlogeotxt" value="<?Php echo $idlogeo; ?>"
                                        </div>
                                    </td>           
                                    <td>&nbsp;</td>
                                    <td colspan="2"><div align="left"><a href="../../../../../templates/logeo/desconectar_usuario.php"><img src="../../../../../images/logout.png" title="Salir" alt="Salir" /></a> </div></td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp; 
                                    </td>
                                </tr>
                            </table>
                        </div>                
                        <div class="menu">
                            <ul class="nav" id="nav">
                                <li><a href="Bl_inicialsecre.php">Asientos</a></li>
                                <li class="current"><a href="index_modulo_contable.php">Panel</a></li>
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                    </div>
                </div>
            </center>
            <div id="cuerpo">
                <div id="banner_left"></div>
                <div id="formulario_bl">
                    <center>
                        <form name="inmodcontable" id="inmodcontable" action="index_modulo_contable.php" method="post">
                            <center>
                                <input type="hidden" name="maxbalance" id="maxbalance" value="<?php echo $maxbalance ?>"/>
                                <h1>Libro Diario</h1>
                                <div class="mensaje"></div>

                                <table id="tablib" class="tablib">
                                    <tr>
                                        <th style="display:none">balance</th>
                                        <th>Fecha</th>
                                        <th>Ref.</th>
                                        <th>Cuenta</th>
                                        <th>Debe</th>
                                        <th>Haber</th>
                                    </tr>
                                </table> 
                                <form>
<?Php

$consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
$result = mysqli_query($dbi, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
    }
}
$sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` ej,`concepto` c,fecha as f FROM `num_asientos` "
        . "WHERE `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' and year ='" . $year . "' and `t_ejercicio_idt_corrientes`=1  order by ej";
$result_grupo = mysqli_query($dbi, $sqlbuscagrupos) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
echo '<center>';

echo '<table style="padding:5px;background:#555;color:#fff;width: 960px;">';
//eje

while ($rw = mysqli_fetch_assoc($result_grupo)) {
    $idasiento = $rw['id']; //echo "<script>alert('".$nombre_grupo."')</script>";
    $nombre_grupo = $rw['c']; //echo "<script>alert('".$nombre_grupo."')</script>";
    $codgrupo = $rw['ej']; //echo "<script>alert('".$nombre_grupo."')</script>";
    $fecha = $rw['f'];
    echo '<table width="85%" class="table" style="padding:5px;width: 960px;">';
    echo '<tr><th colspan="5" style="text-align: center;vertical-align: middle;"> Ref : ' . $codgrupo . ''
    . '</th>'
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
    $result2 = mysqli_query($dbi, $sql_cuentasgrupos);
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






$sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` ej,`concepto` c,fecha as f,saldodebe as sald,saldohaber as salh FROM `num_asientos` "
        . "WHERE `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' and year ='" . $year . "' and `t_ejercicio_idt_corrientes` !=1  order by ej";
$result_grupo = mysqli_query($dbi, $sqlbuscagrupos) or trigger_error("Query Failed! SQL: $query - Error:"
                . " " . mysqli_error($dbi), E_USER_ERROR);
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
    . '';

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
    $result2 = mysqli_query($dbi, $sql_cuentasgrupos);
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
mysqli_close($dbi)
?>
                                </form>


                                <table>
                                    <tr>
                                        <td><label>Total debe</label></td>
                                        <td><input readonly="readonly" style="text-align: right" type="text" id="totd" name="totd" placeholder="Tot. debe" value="<?php echo $td; ?>" required></td>
                                        <td><label>Total haber</label></td>
                                        <td><input readonly="readonly" style="text-align: right" type="text" id="toth" name="toth" placeholder="Tot. haber" value="<?php echo $th; ?>" required></td>
                                    </tr>
                                </table>

                        </form>
                </div>
                </center>
            </div>
        </div>
    </div>        
</body>
</html>	
