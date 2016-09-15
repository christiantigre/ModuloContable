<!DOCTYPE html>
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;

session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../login.php"
</script>';
}
require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$user = $_SESSION['loginu'];
$idlogeo = $_SESSION['id_user'];
$year= date("Y");
$id_usuario = $user;
$consulgrupo = "SELECT * FROM `t_grupo`";
$queryclases = mysqli_query($c,$consulgrupo);
//$consulta = "SELECT l.username, u.tipo_user, l.idlogeo
//FROM logeo l
//JOIN user_tipo u
//WHERE l.user_tipo_iduser_tipo = u.iduser_tipo
//AND l.username = '" . $id_usuario . "'";
//$resultado = mysqli_query($c,$consulta) or die(mysqli_errno($c));
//$fila = mysqli_fetch_array($resultado);
//$user = $fila['username'];
//$type_user = $fila['tipo_user'];
//$idlogeo = $fila['idlogeo'];


include '../../Clases/guardahistorial.php';
    $accion="Ingreso a contabilidad";
    generaLogs($user, $accion);



$sqlmaxingreso = "SELECT max(`idt_bl_inicial`) as u FROM `t_bl_inicial`";
$resul_ultimo = mysqli_query($c,$sqlmaxingreso);
if ($rw = mysqli_fetch_row($resul_ultimo)) {
    $ultimoingreso = trim($rw[0]);
}


$rs = mysqli_query($c,"SELECT MAX(idt_bl_inicial) AS id FROM t_bl_inicial");
if ($row = mysqli_fetch_row($rs)) {
    $maxbalance = trim($row[0]);
}
//$rsmaxlib = mysql_query("SELECT MAX(idres_librodiario) AS id FROM res_librodiario", $conex);
//if ($rowmaxlib = mysql_fetch_row($rsmaxlib)) {
//    $maxlibr = trim($row[0]);
//}

$sql_totales = "SELECT e.year, e.`t_bl_inicial_idt_bl_inicial` AS balance, sum( e.`debe` ) AS d, sum( e.`haber` ) AS h
FROM `libro` e
WHERE 
e.`t_bl_inicial_idt_bl_inicial` = '".$maxbalance."'
AND e.year = '".$year."'
GROUP BY e.`t_bl_inicial_idt_bl_inicial` ";
$sql_totalesbalance = "SELECT e.year,e.`t_bl_inicial_idt_bl_inicial` as balance, sum( e.`valor` ) as debe_b, sum( e.`valorp` ) as haber_b
FROM `t_ejercicio` e
where e.year='".$year."' and e.t_bl_inicial_idt_bl_inicial='".$maxbalance."'
group by e.`t_bl_inicial_idt_bl_inicial`";
$res_tot = mysqli_query($c,$sql_totales) or die(mysqli_errno($c));
$res_totb = mysqli_query($c,$sql_totalesbalance) or die(mysqli_errno($c));
$f_tot = mysqli_fetch_array($res_tot);
$f_totb = mysqli_fetch_array($res_totb);

$d = $f_tot['d'];
$h = $f_tot['h'];

$ta = $f_totb['debe_b'];
$pp = $f_totb['haber_b'];

$td = $d + $ta;
$th = $h + $pp;



mysqli_close($c);

?>
<html>
    <head>
        <title>Diario</title>
        <link href="../../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <link href="../../../../css/style.csss" rel='stylesheet' type='text/css' />
        <script src="../../../../js/jquery.min.js"></script>
        <link href="../../../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <script src="../../../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../../../js/jquery.functions.js" type="text/javascript"></script>
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
                            <ul class="nav" id="nav">
                                <li><a href="../../index_admin.php">Panel</a></li>
                                <li><a href="../catalogodecuentas.php">Plan de Ctas</a></li>
                                <li><a href="documentos/documentos.php">Documentos</a></li>								
                                <div class="clearfix"></div>
                            </ul>
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
                                                    <?php echo $user; ?> 
                                                </strong>
                                            </span>
                                            <input type="hidden" id="idlogeotxt" name="idlogeotxt" value="<?Php echo $idlogeo;?>"
                                        </div>
                                    </td>            
                                    <!--<td colspan="2"><div align="right">Acceso de: <span class="Estilo6"><strong>
                                    <?php
                                    //echo $type_user; 
                                    ?> 
                                    </strong></span></div></td>-->
                                    <td>&nbsp;</td>
                                    <td colspan="2"><div align="left"><a href="../../../../templates/logeo/desconectar_usuario.php"><img src="../../../../images/logout.png" title="Salir" alt="Salir" /></a> </div></td>
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
                                <li><a href="star_balance.php">B Inicial</a></li>
                                <li><a href="Bl_inicial.php">Asientos</a></li>
                                <li><a href="automayorizacion.php">Mayorizacion</a></li>
                                <li><a href="balancederesultados.php">B. Comprobaci&oacute;n</a></li>								
                                <li><a href="estadoresultados.php">E. Resultados</a></li>								
                                <li><a href="situacionfinal.php">S. Final</a></li>								
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
                <?Php    
                include './cargatablabinicialallibro.php';
                include_once './cargatabladeasientos.php';
                ?>
                            <table>
                                <tr>
                                    <td><label>Total debe</label></td>
                                    <td><input readonly="readonly" style="text-align: right" type="text" id="totd" name="totd" placeholder="Tot. debe" value="<?php echo $td; ?>" required></td>
                                    <td><label>Total haber</label></td>
                                    <td><input readonly="readonly" style="text-align: right" type="text" id="toth" name="toth" placeholder="Tot. haber" value="<?php echo $th; ?>" required></td>
                                </tr>
                            </table>
                                
                                <a target="_blank" href="./impresiones/balanceimp.php?idlogeo=<?Php echo $idlogeo;?>&ddetall=<?php echo $td?>&hdetall=<?php echo $th?> " class="btn btn-danger">Exportar a PDF</a>
                        </form>
                        </div>
                    </center>
                </div>
            </div>
        </div>        
    </body>
</html>	
