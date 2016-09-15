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
require '../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$conn = $dbi->conexion();
$idlogeobl = $_SESSION['id_user'];
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];
$date = date("Y-m-d");

$hh = '../';
$sess = '../../';
$raiz = '../../';
$carpetas = '../../../';
//include '../../Clases/guardahistorial.php';
//$accion = "/ contabilidad / Situacion Final / Visualizó la Situacion Final";
//generaLogs($user, $accion);
$mes = date('F');
$year = date('Y');

$consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
$query_bl = mysqli_query($c, $consul_bal_inicial);
$row = mysqli_fetch_array($query_bl);
$idcod = $row['contador'];
$idcod_sig = $row['Siguiente'];

$contador_de_asientosSQL = "select count(year)+1 as CON from num_asientos"
        . " where `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "'";
$query_contador = mysqli_query($c, $contador_de_asientosSQL);
$row_cont = mysqli_fetch_array($query_contador);
$contador_ass = $row_cont['CON'];
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;" charset=UTF-8">
        <meta http-equiv="Content-Type" content="text/html;" charset=ISO-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="CONT APP">
        <meta name="author" content="CT">

        <title>:: CONTABILIDAD ::</title>

        <!-- Bootstrap Core CSS -->
        <link href="../../../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../../../css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="../../../css/plugins/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../../../css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="../../../css/plugins/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../../../css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" rel="home" href="ini_cont.php" title="Buy Sell Rent Everyting">
                        <?Php
                        require('../../../templates/Clases/empresa.php');
                        $objClase = new Empresa;
                        ?>
                        <img src="../../../images/uploads/<?Php $objClase->logo_cl(); ?>" class="img-responsive img-rounded" style="width:329px;height: 50px; margin-top: -15px;"/>

                    </a>
                </div>
                <!-- /.navbar-header -->
                <?PHP
                require('../../../templates/Clases/menus.php');
                $objMenu = new menus();
                $objMenu->menu_header_root($hh, $sess, $user, $id);
                ?>
                <!-- /.navbar-top-links -->
                <div class="navbar-default sidebar" role="navigation">
                    <?PHP
                    $objMenu->menu_admin($raiz, $carpetas);
                    ?>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-12">
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                Situaci&oacute;n Final
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form name="BalancedeComprobacion" id="BalancedeComprobacion" action="cont_stfnl.php" method="post">

                                        <script>
                                            function cierredeperiodo()
                                            {
                                                var answer = confirm("Desea realizar el cierre del periodo y generar el nuevo periodo");
                                                if (answer) {
                                                    var miVariableJS = $("#texto").val();
                                                    if (miVariableJS == 0)
                                                    {
                                                        alert("El periodo ya esta cerrado");
                                                    }
                                                    else {
                                                        $.post("cierraperiodo.php", {"texto": miVariableJS},
                                                        function (respuesta) {
                                                            document.getElementById('texto').value = respuesta;
                                                            alert(respuesta);
                                                            creartabla();
                                                        });
                                                    }
                                                } else {
                                                    alert("El cierre del periodo se ha cancelado...");
                                                }

                                            }

                                            function creartabla()
                                            {
                                                var paginanuevobalance = "cont_new_bl.php";
                                                location.href = paginanuevobalance;

                                            }
                                        </script>    
                                        <center>
                                            <h1>Situaci&oacute;n Final</h1>
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
                                            <button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_stfnl(<?Php echo $idlogeobl; ?>)"></button>

                                            <?php
                                            $c = $dbi->conexion();
                                            $muestraboton = "SELECT `estado` FROM `t_bl_inicial` WHERE year='" . $year . "' and idt_bl_inicial='" . $maxbalancedato . "'";
                                            $res = mysqli_query($c, $muestraboton);
                                            while ($data = mysqli_fetch_array($res)) {
                                                $estado = $data['estado'];
                                                if ($data['estado'] == "1") {
                                                    ?>
                                                    <input type="button" name="cierrecontabilidad" onclick="cierredeperiodo();" id="cierrecontabilidad" class="btn" value="Cierre de Periodo"/>
                                                    <?php
                                                } else {
                                                    echo "<input type='button' name='cierrecontabilidad' id='cierrecontabilidad' class='btn' disabled='true' value='Cierre de Periodo'/>";
                                                }
                                            }
                                            $c->close();
                                            ?>    
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
                                            $selecclases = "SELECT nombre_clase as clase,cod_clase FROM `t_clase`";
                                            $resulclases = mysqli_query($c, $selecclases) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                            while ($rwclases = mysqli_fetch_assoc($resulclases)) {
                                                $nom_clase = $rwclases['clase'];
                                                $cod_clasesq = $rwclases['cod_clase'];
                                                echo '<table class="table table-striped table-bordered table-hover">';
                                                echo '<tr class="success">';
                                                echo '<th colspan="3"></th>';
                                                echo '<th colspan="2" class="thsaldos"><center>Sumas</center></th>';
                                                echo '<th colspan="2" class="thsaldosa"><center>Saldos</center></th>';
                                                echo '<th colspan="2" class="thsaldos"><center>Sumas Ajustes</center></th>';
                                                echo '<th colspan="2" class="thsaldosa"><center>Saldos Ajustes</center></th>';
                                                echo '<th colspan="2" class="thsaldosb"><center>Resultados</center></th>';
                                                echo '</tr>';
                                                echo '<tr class="danger"><th class="l1" colspan="14"><center>' . $nom_clase . '</center></th></tr>';
                                                echo '<td style="display:none"><input name="valor" type="hidden" id="valor" value="';
                                                echo $cod_clasesq;
                                                echo '"/></td>';
                                                $sql_cargagrupos = "SELECT g.nombre_grupo AS grupo, g.cod_grupo AS cod
                                        FROM `hoja_de_trabajo` v JOIN t_grupo g JOIN t_clase c
                                        WHERE g.cod_grupo = v.`tipo` AND c.cod_clase = g.t_clase_cod_clase
                                        AND v.`t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "'
                                        AND v.year = '" . $year . "' AND c.cod_clase = '" . $cod_clasesq . "' GROUP BY cod_grupo";
                                                $resulgrupos = mysqli_query($c, $sql_cargagrupos)or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                                while ($row2 = mysqli_fetch_array($resulgrupos)) {
                                                    echo '<tr class="warning"><th colspan="14">' . $row2['grupo'] . '</th></tr>';
                                                    echo '<td style="display:none"><input name="valorg" type="hidden" id="valorg" value="';
                                                    echo $row2['cod'];
                                                    echo '"/></td>';
                                                    echo '<tr>
                                        <th style="display:none">id</th>
                                        <th>Fecha</th>
                                        <th>Ref.</th>
                                        <th>Cuenta</th>
                                        <th>Debe</th>
                                        <th>Haber</th>
                                        <th>Sld. Deudor</th>
                                        <th>Sld. Acreedor</th>
                                        <th>Ajuste. Deudor</th>
                                        <th>Ajuste. Acreedor</th>
                                        <th>Sld. Deudor</th>
                                        <th>Sld. Acreedor</th>
                                        <th>Activos</th>
                                        <th>Pasivos</th>
                                    </tr>';
                                                    $sql_cargacuentas = "SELECT v.fecha AS f, v.cod_cuenta AS codcuenta, v.cuenta AS cuen, v.debe, v.haber,"
                                                            . " v.`t_bl_inicial_idt_bl_inicial` AS balance, v.tipo AS grupo,v.sld_deudor AS slddeudor,"
                                                            . " v.sld_acreedor AS sldacreedor, v.debe_aj, v.haber_aj, v.slddeudor_aj, v.sldacreedor_aj,"
                                                            . " v.sum_deudor, v.sum_acreedor,"
                                                            . " v.year, v.mes,g.nombre_grupo AS nomgrupo, g.cod_grupo AS codgrupo, g.`t_clase_cod_clase` AS codrelacionclase "
                                                            . "FROM hoja_de_trabajo v JOIN t_grupo g "
                                                            . "WHERE v.`tipo` = g.cod_grupo and year='" . $year . "' and t_bl_inicial_idt_bl_inicial='" . $parametro_contador . "'"
                                                            . " and v.tipo='" . $row2['cod'] . "' and t_clase_cod_clase = '" . $cod_clasesq . "' order by tipo";
                                                    $resultcargacuentas = mysqli_query($c, $sql_cargacuentas) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                                    while ($rwcuentas = mysqli_fetch_assoc($resultcargacuentas)) {
                                                        echo '<tr>';
                                                        echo '<td >' . $rwcuentas['f'] . '</td>';
                                                        echo '<td>' . $rwcuentas['codcuenta'] . '</td>';
                                                        echo '<td>' . $rwcuentas['cuen'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['debe'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['haber'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['slddeudor'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['sldacreedor'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['debe_aj'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['haber_aj'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['slddeudor_aj'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['sldacreedor_aj'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['sum_deudor'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['sum_acreedor'] . '</td>';
                                                        echo '</tr>';
                                                    }



                                                    $sql_sumastot = " SELECT sum( `debe` ) AS sumdebe, sum( `haber` ) AS sumhaber, sum( `sld_deudor` ) AS sumslddeudo,
    sum( `sld_acreedor` ) AS sumsldacreedor, sum( `debe_aj` ) AS sumajdebe,sum(`haber_aj` )  AS sumajhaber,
 sum(  `slddeudor_aj` )  AS sumajslddeudor, sum( `sldacreedor_aj`) AS sumajsldacreedor, 
 sum( `sum_deudor` ) AS resdebe, sum( `sum_acreedor` ) AS reshaber
FROM `hoja_de_trabajo`
WHERE `t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "'
AND year = '" . $year . "'
AND `tipo` = '" . $row2['cod'] . "'  ";
                                                    $resultsumaajustes = mysqli_query($c, $sql_sumastot);
                                                    while ($row = mysqli_fetch_array($resultsumaajustes)) {
                                                        $sumdebe = number_format($row['sumdebe'], 2, '.', '');
                                                        $sumhaber = number_format($row['sumhaber'], 2, '.', '');
                                                        $sumslddeudo = number_format($row['sumslddeudo'], 2, '.', '');
                                                        $sumsldacreedor = number_format($row['sumsldacreedor'], 2, '.', '');
                                                        
                                                        $resdebe= number_format($row['resdebe'], 2, '.', '');
                                                        $reshaber= number_format($row['reshaber'], 2, '.', '');
                                                        echo '<tr>';
                                                        echo '<th colspan="3" style="background-color: #E0ECFF;">SUMAS DE ' . $row2['grupo'] . "-" . $row2['cod'] . '</th>';
                                                        echo '<td style="background-color: #FFFFFF;>1</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $sumdebe . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>3</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $sumhaber . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>5</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $sumslddeudo . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>7</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $sumsldacreedor . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>8</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $row['sumajdebe'] . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>10</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $row['sumajhaber'] . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>12</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $row['sumajslddeudor'] . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>14</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $row['sumajsldacreedor'] . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>16</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $resdebe . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>18</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $reshaber . '</td>';
                                                        echo '</tr>';
                                                    }
                                                }
                                                echo '</table>';
                                            }
                                            ?>

                                            <table>
                                                <tr>
                                                    <?Php
                                                    $sql_sumastotfin = "  SELECT sum( `debe` ) AS sumdebe, sum( `haber` ) AS sumhaber, sum( `sld_deudor` ) AS sumslddeudor, sum( `sld_acreedor` ) AS sumsldacreedor, sum( `debe_aj` ) AS sumajdebe, sum( `haber_aj` ) AS sumajhaber, sum( `slddeudor_aj` ) AS sumajslddeudor, sum( `sldacreedor_aj` ) AS sumajsldacreedor, sum( `sum_deudor` ) AS resdebe, sum( `sum_acreedor` ) AS reshaber
FROM `hoja_de_trabajo`
WHERE `t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "'
AND year = '" . $year . "'  ";
                                                    $resultsumaajustesfin = mysqli_query($c, $sql_sumastotfin);
                                                    while ($rowf = mysqli_fetch_array($resultsumaajustesfin)) {
                                                        $sumdebe = $rowf['sumdebe'];
                                                        $sumhaber = $rowf['sumhaber'];
                                                        $sumslddeudor = $rowf['sumslddeudor'];
                                                        $sumsldacreedor = $rowf['sumsldacreedor'];
                                                        $sumajdebe = $rowf['sumajdebe'];
                                                        $sumajhaber = $rowf['sumajhaber'];
                                                        $sumajslddeudor = $rowf['sumajslddeudor'];
                                                        $sumajsldacreedor = $rowf['sumajsldacreedor'];
                                                        $resdebe = $rowf['resdebe'];
                                                        $reshaber = $rowf['reshaber'];

                                                        $sumdebe = number_format($sumdebe, 2, '.', '');
                                                        $sumhaber = number_format($sumhaber, 2, '.', '');
                                                        $sumslddeudor = number_format($sumslddeudor, 2, '.', '');
                                                        $sumsldacreedor = number_format($sumsldacreedor, 2, '.', '');
                                                        $sumajdebe = number_format($sumajdebe, 2, '.', '');
                                                        $sumajhaber = number_format($sumajhaber, 2, '.', '');
                                                        $sumajslddeudor = number_format($sumajslddeudor, 2, '.', '');
                                                        $sumajsldacreedor = number_format($sumajsldacreedor, 2, '.', '');
                                                        $resdebe = number_format($resdebe, 2, '.', '');
                                                        $reshaber = number_format($reshaber, 2, '.', '');
                                                    }
                                                    ?>
                                                    <th colspan="6">Total </th>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="col-xs-10 form-group has-success">
                                                            <label>Debe</label>
                                                            <input type="text"  class="form-control info" readonly="readonly" required="required" name="tdebe" id="tdebe" value="<?php echo $sumdebe ?>" placeholder="0.00" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-xs-10 form-group has-success">
                                                            <label>Haber</label>
                                                            <input type="text"  class="form-control info" readonly="readonly" required="required" name="thaber" id="thaber" value="<?php echo $sumhaber ?>" placeholder="0.00" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-xs-10 form-group has-success">
                                                            <label>Deudor</label>
                                                            <input type="text" class="form-control info" readonly="readonly" required="required" name="tdeudor" id="tdeudor" value="<?php echo $sumslddeudor ?>" placeholder="0.00" />    
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-xs-10 form-group has-success">
                                                            <label>Acreedor</label>
                                                            <input type="text"  class="form-control info" readonly="readonly" required="required" name="tacreedor" id="tacreedor" value="<?php echo $sumsldacreedor ?>" placeholder="0.00" />
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6">Total Ajustes </th>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="col-xs-10 form-group has-warning">
                                                            <label>Aj.Debe </label>
                                                            <input type="text" class="form-control warning" readonly="readonly" required="required" name="tdebe" id="tdebe" value="<?php echo $sumajdebe ?>" placeholder="0.00" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-xs-10 form-group has-warning">
                                                            <label>Aj.Haber </label>
                                                            <input type="text" class="form-control warning" readonly="readonly" required="required" name="thaber" id="thaber" value="<?php echo $sumajhaber ?>" placeholder="0.00" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-xs-10 form-group has-warning">
                                                            <label>Aj.Deudor </label>
                                                            <input type="text"  class="form-control warning" readonly="readonly" required="required" name="tacreedor" id="tacreedor" value="<?php echo $sumajsldacreedor ?>" placeholder="0.00" />    
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-xs-10 form-group has-warning">
                                                            <label>Aj.Acreedor </label>
                                                            <input type="text" class="form-control warning" readonly="readonly" required="required" name="thaber" id="thaber" value="<?php echo $sumajhaber ?>" placeholder="0.00" />
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6">Final </th>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="col-xs-10 form-group has-danger">
                                                            <label>Total </label>
                                                            <input type="text" class="form-control warning" readonly="readonly" required="required" name="resdebe" id="resdebe" value="<?php echo $resdebe ?>" placeholder="0.00" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-xs-10 form-group has-danger">
                                                            <label>Total </label>
                                                            <input type="text" class="form-control warning" readonly="readonly" required="required" name="resdebe" id="resdebe" value="<?php echo $reshaber ?>" placeholder="0.00" />
                                                        </div>
                                                    </td>
                                                    <?Php $c->close(); ?>
                                                </tr>
                                            </table>
                                        </center>

                                    </form>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        <!-- jQuery -->
        <script src="../../../js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../../../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../../js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->

        <!-- DataTables JavaScript -->
        <script src="../../../js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="../../../js/plugins/dataTables/dataTables.bootstrap.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../../../js/sb-admin-2.js"></script>
        <script src="../../../js/js.js"></script>
        <script src="js/jslevel.js"></script>
        <script src="../../../js/script.js"></script>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">DETALLE DE ASIENTO</h4>
                    </div>
                    <div class="modal-body" id="caja">

                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
