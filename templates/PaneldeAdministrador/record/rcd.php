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
require('../../../templates/Clases/empresa.php');
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
//$accion = " / CONTABILIDAD / Ingreso en registro de balance inicial";
//generaLogs($user, $accion);
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
                    <div class="col-lg-12">
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                Historial
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form name="form_ejercicio" role="form" id="form_ejercicio" method="post" action="rcd.php">
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="form-horizontal">
                                                        <label>Fecha</label>
                                                        <input type="text" class="form-control" id="datetimepicker1" name="datetimepicker1" value="" required="required"/>
                                                        <input type="submit" name="submit" id="record" class="btn btn-success" value="Ver"/>
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
                                                                format: 'j-m-Y'
                                                            });</script>
                                                    </div>
                                                </div>
                                            </div>
                                            </label>
                                            <?Php
                                            echo '</br>';
                                            if (isset($_POST["submit"])) {
                                                $btntu = $_POST["submit"];
                                                if ($btntu == "Ver") {
                                                    $fecha_record = htmlspecialchars(trim($_POST['datetimepicker1']));
                                                    $nombre_archivo = "../../../hss/$fecha_record";
                                                    if (file_exists($nombre_archivo)) {
                                                        $rows = file($nombre_archivo);
                                                        array_shift($rows);
                                                        echo "<html><body><table border=1 class='table table-hover'>";
                                                        echo "<tr><th>Fecha-Accion</th></tr>";
                                                        foreach ($rows as $row) {
                                                            $fields = explode("|", $row);
                                                            echo "<tr>"
                                                            . "<td>" . $fields[0] . "</td>";
                                                        }
                                                        echo "</table></body></html>";
//                                                        $accion = " / HISTORIAL / Visualizo Historial de fecha " . $fecha2;
//                                                        generaLogs($_SESSION['username'], $accion);
                                                    } else {
                                                        $mensaje = "El archivo no existe";
                                                    }
                                                }
                                            }
                                            ?>
                                        </fieldset>

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
        <script src="../../PaneldeAdministrador/ModuloContable/js/r_jslevel.js"></script>

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
