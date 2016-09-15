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
//rutas
$carpeta = '../../../';
require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$conn = $dbi->conexion();
$idlogeobl = $_SESSION['id_user'];
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];
$date = date("Y-m-d");
include '../../Clases/guardahistorial.php';
$accion = "/ CONTABILIDAD / Balance Resultados / Visualizó balance de resultados";
generaLogs($user, $accion);
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
        <link href="../../../../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../../../../css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="../../../../css/plugins/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../../../../css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="../../../../css/plugins/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../../../../css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                        require('../../../../templates/Clases/empresa.php');
                        $objClase = new Empresa;
                        $objClase->view_logcontabilidad();
                        ?>

                    </a>
                </div>
                <!-- /.navbar-header -->
                <?PHP
                require('../../../../templates/Clases/menus.php');
                $objMenu = new menus();
                $objMenu->menu_header($carpeta, $user, $id);
                ?>
                <!-- /.navbar-top-links -->
                <div class="navbar-default sidebar" role="navigation">
                    <?PHP
                    $objMenu->menu_indexadmin_row($carpeta);
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
                                Balance de comprobac&oacute;n
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form name="BalancedeComprobacion" id="BalancedeComprobacion" action="cont_bresult.php" method="post">
                                        <center>
                                            <h1>Balance de Comprobaci&oacute;n</h1>
                                            <h3>Hasta la fecha <?php echo $date ?> del <?php echo $year ?></h3>
                                            <div style="float: left;" class="menu"> 
                                                <!--<ul class="nav" id="nav">-->
                                                    <!--<a href="ajustesasientos.php" title="AJUSTES" class="glyphicon glyphicon-text-background"><i class=" btn btn-outline btn-info glyphicon glyphicon-edit"></i></a>-->
                                                <a href="cont_aj_ass.php" title="AJUSTES" class="glyphicon glyphicon-text-background"><i class=" btn btn-outline btn-info glyphicon glyphicon-edit"></i></a>
                                                    <button type="submit" title="IMPRIMIR ASIENTO" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_blres(<?Php echo $idlogeobl; ?>)"></button>
                                                <!--</ul>-->
                                            </div>
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
                                            $sql_cargaclases = "SELECT nombre_clase as clase,cod_clase FROM `t_clase`";
                                            $resulclases = mysqli_query($conn, $sql_cargaclases) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                            while ($rwclases = mysqli_fetch_assoc($resulclases)) {
                                                $nom_clase = $rwclases['clase'];
                                                $cod_clasesq = $rwclases['cod_clase'];
                                                echo '<table width="100%" class="table table-striped table-bordered table-hover">';
                                                echo '<tr>';
                                                echo '<th colspan="3"></th>';
                                                echo '<td style="display:none"></td>';
                                                echo '<td style="display:none"></td>';
                                                echo '<th colspan="2" class="thsaldos"><center>Sumas</center></th>';
                                                echo '<th colspan="2" class="thsaldosa"><center>Saldos</center></th>';
                                                echo '<th colspan="2" class="thsaldos"><center>Sumas Ajustes</center></th>';
                                                echo '<th colspan="2" class="thsaldosa"><center>Saldos Ajustes</center></th>';
                                                echo '</tr>';
                                                echo '<tr><th class="l1" colspan="14"><center>' . $nom_clase . '</center></th></tr>';
                                                echo '<td style="display:none"><input name="valor" type="hidden" id="valor" value="';
                                                echo $cod_clasesq;
                                                echo '"/></td>';
                                                $sql_cargagrupos = "SELECT g.nombre_grupo AS grupo, g.cod_grupo AS cod FROM `vistaautomayorizacion` v JOIN t_grupo g JOIN t_clase c WHERE g.cod_grupo = v.`tipo` 
                                        AND c.cod_clase=g.t_clase_cod_clase AND `t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "' AND year = '" . $year . "' "
                                                        . "AND c.cod_clase = '" . $cod_clasesq . "' GROUP BY cod_grupo";
                                                $resulgrupos = mysqli_query($conn, $sql_cargagrupos)or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                                while ($row2 = mysqli_fetch_array($resulgrupos)) {
                                                    echo '<tr><th colspan="14">' . $row2['grupo'] . '</th></tr>';
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
                                    </tr>';

                                                    $sql_cargacuentas = "SELECT v.fecha AS f, v.cod_cuenta AS codcuenta, v.cuenta AS cuen, v.debe, v.haber,"
                                                            . " v.`t_bl_inicial_idt_bl_inicial` AS balance, v.tipo AS grupo,v.sld_deudor AS slddeudor, v.sld_acreedor AS sldacreedor,"
                                                            . " v.year, v.mes,g.nombre_grupo AS nomgrupo, g.cod_grupo AS codgrupo, g.`t_clase_cod_clase` AS codrelacionclase "
                                                            . "FROM vistaautomayorizacion v JOIN t_grupo g "
                                                            . "WHERE v.`tipo` = g.cod_grupo and year='" . $year . "' and t_bl_inicial_idt_bl_inicial='" . $parametro_contador . "'"
                                                            . " and v.tipo='" . $row2['cod'] . "' and t_clase_cod_clase = '" . $cod_clasesq . "' order by tipo";

                                                    $resultcargacuentas = mysqli_query($conn, $sql_cargacuentas) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                                    while ($rwcuentas = mysqli_fetch_assoc($resultcargacuentas)) {
                                                        echo '<tr>';
                                                        echo '<td >' . $rwcuentas['f'] . '</td>';
                                                        echo '<td>' . $rwcuentas['codcuenta'] . '</td>';
                                                        echo '<td>' . $rwcuentas['cuen'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['debe'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['haber'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['slddeudor'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $rwcuentas['sldacreedor'] . '</td>';
                                                        $sql_cargaajustes = "SELECT v.fecha AS f, v.cod_cuenta AS codcuenta, v.cuenta AS cuen, v.debe, v.haber,
                                                v.`balance` AS balance, v.grupo AS grupo,v.sld_deudor AS sld_deudor, v.sld_acreedor AS sld_acreedor,v.year,
                                                v.mes,g.nombre_grupo AS nomgrupo,g.cod_grupo AS codgrupo,g.`t_clase_cod_clase` AS codrelacionclase FROM vautomayorizacionajustes v JOIN t_grupo g 
                                                WHERE v.`grupo` = g.cod_grupo and year='" . $year . "' and balance='" . $parametro_contador . "' "
                                                                . "and v.grupo='" . $row2['cod'] . "' and t_clase_cod_clase = '" . $cod_clasesq . "' and v.cod_cuenta='" . $rwcuentas['codcuenta'] . "'  order by grupo";
                                                        $resultajustes = mysqli_query($conn, $sql_cargaajustes) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                                        $row1 = mysqli_fetch_assoc($resultajustes);
                                                        echo '<td style="background-color: window;color:black;">' . $row1['debe'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $row1['haber'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $row1['sld_deudor'] . '</td>';
                                                        echo '<td style="background-color: window;color:black;">' . $row1['sld_acreedor'] . '</td>';
                                                        echo '</tr>';
                                                    }


                                                    $sql_sumasdegrupos = "SELECT sum( v.debe ) AS sumdebe, sum( v.haber ) AS sumhaber,
sum( v.sld_deudor ) AS sumslddeudor, sum( v.sld_acreedor ) AS sumsldacreedor
FROM vistaautomayorizacion v JOIN t_grupo g WHERE v.`tipo` = g.cod_grupo AND year = '" . $year . "' AND t_bl_inicial_idt_bl_inicial = '" . $parametro_contador . "'
AND t_clase_cod_clase = '" . $cod_clasesq . "' AND `tipo` = '" . $row2['cod'] . "'";

//                                        sumas de ajustes
                                                    $sql_sumasajustes = " SELECT sum( v.debe ) AS sumdebe, sum( v.haber ) AS sumhaber,
sum( v.sld_deudor ) AS sumslddeudor, sum( v.sld_acreedor ) AS sumsldacreedor
FROM vautomayorizacionajustes v
JOIN t_grupo g
WHERE v.`grupo` = g.cod_grupo
AND v.year = '" . $year . "'
AND v.balance = '" . $parametro_contador . "'
AND g.t_clase_cod_clase = '" . $cod_clasesq . "'
AND v.`grupo` = '" . $row2['cod'] . "' ";
                                                    $resultsumaajustes = mysqli_query($conn, $sql_sumasajustes);

                                                    $resultsumasst = mysqli_query($conn, $sql_sumasdegrupos) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                                    while ($resultsumas = mysqli_fetch_assoc($resultsumasst)) {
                                                        $row3 = mysqli_fetch_assoc($resultsumaajustes);
//                                                        $sumdebe = $resultsumas['sumdebe'];
//                                                        $sumhaber = $resultsumas['sumhaber'];
//                                                        $sumdeudorsld = $resultsumas['sumslddeudor'];
//                                                        $sumhabersld = $resultsumas['sumsldacreedor'];
                                                        $sumdebe = number_format($resultsumas['sumdebe'], 2, '.', '');
                                                        $sumhaber = number_format($resultsumas['sumhaber'], 2, '.', '');
                                                        $sumdeudorsld = number_format($resultsumas['sumslddeudor'], 2, '.', '');
                                                        $sumhabersld = number_format($resultsumas['sumsldacreedor'], 2, '.', '');
                                                        
                                                        $sumdebej = number_format($row3['sumdebe'], 2, '.', '');
                                                        $sumhaberj = number_format($row3['sumhaber'], 2, '.', '');
                                                        $sumdeudorsldj = number_format($row3['sumslddeudor'], 2, '.', '');
                                                        $sumhabersldj = number_format($row3['sumsldacreedor'], 2, '.', '');
                                                        echo '<tr>';
                                                        echo '<th colspan="3" style="background-color: #E0ECFF;">SUMAS DE ' . $row2['grupo'] . "-" . $row2['cod'] . '</th>';
                                                        echo '<td style="background-color: #FFFFFF;>1</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $sumdebe . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>3</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $sumhaber . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>5</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $sumdeudorsld . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>7</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $sumhabersld . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>8</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $sumdebej . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>10</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $sumhaberj . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>12</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $sumdeudorsldj . '</td>';
                                                        echo '<td style="background-color: #FFFFFF;>14</td>';
                                                        echo '<td style="background-color: #FFFFFF;>' . $sumhabersldj . '</td>';
                                                        echo '</tr>';
                                                    }
                                                }
                                                echo '</table>';
                                                //$n++;
                                            }
                                            ?>
                                            <!--fin carga de el balance de resultados por grupos-->


                                            <!--Inicia tabla de resultados en campos-->
                                            <table>
                                                <!--Inicia funcion de botones-->
                                                <?Php
                                                ?>
                                                <!--termina funcion de botones-->
                                                <table class="table table-striped table-bordered table-hover">
                                                    <tr>
                                                        <?php
                                                        $c = $dbi->conexion();
                                                        $sqlsumastotal = "SELECT
sum( `debe_aj` ) AS s_deb_aj, sum( `haber_aj` ) AS sum_hab_aj, sum( `slddeudor_aj` ) AS sum_slddeu_aj, sum( `sldacreedor_aj` ) AS sum_slsacreed_aj,
sum( `debe` ) AS sumdebe, sum( `haber` ) AS sumhaber, sum( `sld_deudor` ) AS sumslddeud, sum( `sld_acreedor` ) AS sumsldacreed, 
sum( sum_deudor ) AS sumatotdeb, sum( sum_acreedor ) AS sumatothab
FROM `hoja_de_trabajo`
WHERE year = '" . $year . "'and t_bl_inicial_idt_bl_inicial = '" . $parametro_contador . "'
GROUP BY `t_bl_inicial_idt_bl_inicial` ";
                                                        $resums = mysqli_query($c, $sqlsumastotal);
                                                        while ($row = mysqli_fetch_assoc($resums)) {
                                                            $Tdebebr = $row['sumdebe'];
                                                            $Thaberbr = $row['sumhaber'];
                                                            $Sdeudorbr = $row['sumslddeud'];
                                                            $Sacreedorbr = $row['sumsldacreed'];
                                                            $Tdebeajbr = $row['s_deb_aj'];
                                                            $Thaberajbr = $row['sum_hab_aj'];
                                                            $Sslddeudorajbr = $row['sum_slddeu_aj'];
                                                            $Ssldacreedorajbr = $row['sum_slsacreed_aj'];

                                                            $Tdebebr = number_format($Tdebebr, 2, '.', '');
                                                            $Thaberbr = number_format($Thaberbr, 2, '.', '');
                                                            $Sdeudorbr = number_format($Sdeudorbr, 2, '.', '');
                                                            $Sacreedorbr = number_format($Sacreedorbr, 2, '.', '');
                                                            $Tdebeajbr = number_format($Tdebeajbr, 2, '.', '');
                                                            $Thaberajbr = number_format($Thaberajbr, 2, '.', '');
                                                            $Sslddeudorajbr = number_format($Sslddeudorajbr, 2, '.', '');
                                                            $Ssldacreedorajbr = number_format($Ssldacreedorajbr, 2, '.', '');
                                                        }
                                                        mysqli_close($c);
                                                        ?>

                                                    <tr>
                                                        <th colspan="6">Total :</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <div class="col-xs-10 form-group has-success">
                                                                <label>Debe</label>
                                                                <input type="text"  class="form-control info" readonly="readonly" required="required" name="tdebe" id="tdebe" value="<?php echo $Tdebebr ?>" placeholder="0.00" />
                                                            </div>
                                                        </td>    
                                                        <td>    
                                                            <div class="col-xs-10 form-group has-success">
                                                                <label>Haber</label>
                                                                <input type="text" class="form-control info" readonly="readonly" required="required" name="thaber" id="thaber" value="<?php echo $Thaberbr ?>" placeholder="0.00" />
                                                            </div>
                                                        </td>       
                                                        <td>       
                                                            <div class="col-xs-10 form-group has-success">
                                                                <label>Duedor</label>
                                                                <input type="text" class="form-control info" readonly="readonly" required="required" name="tacreedor" id="tacreedor" value="<?php echo $Sacreedorbr ?>" placeholder="0.00" />
                                                            </div>
                                                        </td>    

                                                        <td>       
                                                            <div class="col-xs-10 form-group has-success">
                                                                <label>Acreedor</label>
                                                                <input type="text" class="form-control info" readonly="readonly" required="required" name="tdeudor" id="tdeudor" value="<?php echo $Sdeudorbr ?>" placeholder="0.00" />
                                                            </div>
                                                        </td>    

                                                    </tr>    
                                                    <tr> 
                                                        <th colspan="6">Total Ajustes :</th>
                                                        <td></td>
                                                        <td></td>
                                                        <td>       
                                                            <div class="col-xs-10 form-group has-warning">
                                                                <label>Aj.Debe</label>
                                                                <input type="text" class="form-control warning" readonly="readonly" required="required" name="tdebe" id="tdebe" value="<?php echo $Tdebeajbr ?>" placeholder="0.00" />
                                                            </div>
                                                        </td>       
                                                        <td>       
                                                            <div class="col-xs-10 has-warning">
                                                                <label>Aj.Haber </label>
                                                                <input type="text" class="form-control warning" readonly="readonly" required="required" name="thaber" id="thaber" value="<?php echo $Thaberajbr ?>" placeholder="0.00" />
                                                            </div>
                                                        </td>       
                                                        <td>       
                                                            <div class="col-xs-10 has-warning">
                                                                <label>Aj.Deudor </label>
                                                                <input type="text" class="form-control warning" readonly="readonly" required="required" name="tdeudor" id="tdeudor" value="<?php echo $Sslddeudorajbr ?>" placeholder="0.00" />
                                                            </div>
                                                        </td>       
                                                        <td>       
                                                            <div class="col-xs-10 has-warning">
                                                                <label>Aj.Acreedor </label>
                                                                <input type="text" class="form-control warning" readonly="readonly" required="required" name="tacreedor" id="tacreedor" value="<?php echo $Ssldacreedorajbr ?>" placeholder="0.00" />
                                                            </div>
                                                    </tr>
                                                    </td>       

                                                    <input type="hidden" value="<?php echo $resultdato ?>" name="bl" id="bl"/>
                                                    </td>
                                                    </tr>
                                                </table>


                                                <!--Termina tabla de resultados en campos-->

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
        <script src="../../../../js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../../../../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../../../js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->

        <!-- DataTables JavaScript -->
        <script src="../../../../js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="../../../../js/plugins/dataTables/dataTables.bootstrap.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../../../../js/sb-admin-2.js"></script>
        <script src="../../../../js/js.js"></script>
        <script src="js/jslevel.js"></script>
        <script src="../../../../js/script.js"></script>
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
