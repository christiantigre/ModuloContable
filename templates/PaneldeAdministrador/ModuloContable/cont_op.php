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
$idlogeobl = $_SESSION['id_user'];
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];
$date = date("Y-m-d");

$hh = '../';
$sess = '../../';
$raiz = '../../';
$carpetas = '../../../';
//include '../../Clases/guardahistorial.php';
//$accion = "/ CONTABILIDAD / busquedas / Ingreso a busquedas";
//generaLogs($user, $accion);
$mes = date('F');
$year = date('Y');

$consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
$query_bl = mysqli_query($c, $consul_bal_inicial);
$row = mysqli_fetch_array($query_bl);
$idcod = $row['contador'];
$idcod_sig = $row['Siguiente'];
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
                                Buscar
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form name="form_ejercicio" role="form" id="form_ejercicio" method="post" action="cont_op.php">
                                        <fieldset>

                                            <table  class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Por asiento</th>
                                                        <th>Por fecha</th>
                                                        <th>Por per&iacute;odos</th>
                                                        <th>Por mes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-default" id="bsearch_ass" name="bsearch_ass" onclick="return buscar_ass();">BUSCAR</button>
                                                            </div>
                                                            <div class="col-xs-5 form-group">
                                                                <label>N# Asiento :</label>
                                                                <input type="text" class="form-control" name="num_ass" id="num_ass" value=""  />
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-default" id="bsearch_fech" name="bsearch_fech" onclick="return buscar_fech();">BUSCAR</button>
                                                            </div>
                                                            <div class="col-xs-5 form-group">
                                                                <label>Fecha :</label>
                                                                <input type="text" class="form-control" id="datetimepicker1" name="datetimepicker1" value=""/>
                                                                <link rel="stylesheet" type="text/css" href="../../../datepicker/jquery.datetimepicker.css"/>
                                                                <script src="../../../datepicker/jquery.js"></script>
                                                                <script src="../../../datepicker/jquery.datetimepicker.full.js"></script>
                                                                <script>
                                                                    jQuery.datetimepicker.setLocale('es');
                                                                    jQuery('#datetimepicker1').datetimepicker({
                                                                        i18n: {
                                                                            de: {
                                                                                months: [
                                                                                    'Enero', 'Febrero', 'Marzo', 'Abril',
                                                                                    'Mayo', 'Junio', 'Julio', 'Agosto',
                                                                                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',
                                                                                ],
                                                                                dayOfWeek: [
                                                                                    "So.", "Mo", "Di", "Mi",
                                                                                    "Do", "Fr", "Sa.",
                                                                                ]
                                                                            }
                                                                        },
                                                                        timepicker: false,
                                                                        format: 'Y-m-d'
                                                                    });
                                                                </script>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-default" id="bsearch_prd" name="bsearch_prd" onclick="return buscar_prd();">BUSCAR</button>
                                                            </div>
                                                            <div class="col-xs-6 form-group">                                                            
                                                                <label>Fecha m&iacute;n:</label>
                                                                <input type="text" class="form-control" id="datetimepicker1min" name="datetimepicker1min" value=""/>
                                                                <script>
                                                                    jQuery.datetimepicker.setLocale('es');
                                                                    jQuery('#datetimepicker1min').datetimepicker({
                                                                        i18n: {
                                                                            de: {
                                                                                months: [
                                                                                    'Enero', 'Febrero', 'Marzo', 'Abril',
                                                                                    'Mayo', 'Junio', 'Julio', 'Agosto',
                                                                                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',
                                                                                ],
                                                                                dayOfWeek: [
                                                                                    "So.", "Mo", "Di", "Mi",
                                                                                    "Do", "Fr", "Sa.",
                                                                                ]
                                                                            }
                                                                        },
                                                                        timepicker: false,
                                                                        format: 'Y-m-d'
                                                                    });
                                                                </script>
                                                                <!--                                                        </div>
                                                                                                                        <div class="col-xs-5 form-group">                                                            -->
                                                                <label>Fecha m&aacute;x:</label>
                                                                <input type="text" class="form-control" id="datetimepicker1max" name="datetimepicker1max" value=""/>
                                                                <script>
                                                                    jQuery.datetimepicker.setLocale('es');
                                                                    jQuery('#datetimepicker1max').datetimepicker({
                                                                        i18n: {
                                                                            de: {
                                                                                months: [
                                                                                    'Enero', 'Febrero', 'Marzo', 'Abril',
                                                                                    'Mayo', 'Junio', 'Julio', 'Agosto',
                                                                                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',
                                                                                ],
                                                                                dayOfWeek: [
                                                                                    "So.", "Mo", "Di", "Mi",
                                                                                    "Do", "Fr", "Sa.",
                                                                                ]
                                                                            }
                                                                        },
                                                                        timepicker: false,
                                                                        format: 'Y-m-d'
                                                                    });
                                                                </script>
                                                            </div>

                                                        </td>

                                                        <td>
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-default" id="bsearch_ms" name="bsearch_ms" onclick="return buscar_ms();">BUSCAR</button>
                                                            </div>
                                                            <div class="col-xs-8 form-group">                                                          
                                                                <label>Mes :</label>
                                                                <select class="form-control" id="opciones" name="opciones">
                                                                    <?php
                                                                    $c = $dbi->conexion();
                                                                    $q_mes = "SELECT * FROM `mes` ORDER BY `mes_id` desc ";
                                                                    $res_mes = mysqli_query($c, $q_mes);
                                                                    while ($dt_mes = mysqli_fetch_array($res_mes)) {
                                                                        $id_m = $dt_mes['mes_id'];
                                                                        echo "<option value='" . $dt_mes['mes_id'] .'-'.$dt_mes['mes']. "' >";
                                                                        echo $dt_id['mes_id'] . '      ' . utf8_decode($dt_mes['mes']);
                                                                        echo '</option>';
                                                                    }mysqli_close($c);
                                                                    ?>
                                                                </select>
                                                                <fieldset>
                                                                    <div class="form-group">
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="optionsRadios" id="optionsRadios" value="=" checked>Durante
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="optionsRadios" id="optionsRadios" value=">">Antes
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="optionsRadios" id="optionsRadios" value="<">Despu&eacute;s
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </fieldset>

                                        <!--tab ass encontrados-->
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <?Php
                                            include_once './r_scriptsPHP/search.php';
                                            ?>                                        
                                        </table>

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
