<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
$user = $_SESSION['username'];
require('../../../../../templates/Clases/Conectar.php');
$dbi = new Conectar();
$conn = $dbi->conexion();
$sql = " SELECT count( `cod_clase` ) +1 AS id FROM t_clase ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = trim($row["id"]);
    }
}
//rutas
$carpeta = '../../../../';
include '../../../../PanelAdminLimitado/Clases/guardahistorialdoc.php';
$accion = "/ Plan de cuentas / clases / Ingreso al registro de clases";
generaLogs($user, $accion);
$conn->close();
if (isset($_POST['submit'])) {
    require('../../../Clases/admin.class.php');
    $nombre_clase = htmlspecialchars(trim($_POST['nombre_clase']));
    $cod_clase = htmlspecialchars(trim($_POST['cod_clase']));
    $cod_clasefn = $cod_clase . '.';
    $descrip_class = htmlspecialchars(trim($_POST['descrip_class']));

    $objClase = new ClaseAdmin;
    if ($objClase->insertarAdmin(array($nombre_clase, $cod_clasefn, $descrip_class)) == true) {
        if ($objClase->insertar_planAdmin(array($nombre_clase, $cod_clasefn, $descrip_class)) == true) {
            echo '<script language = javascript>
alert("Guardado, exitosamente en Clases y Plan de Cuentas")
self.location = "../../cuentas/cc_clss.php"
</script>';
            include '../../../../PanelAdminLimitado/Clases/guardahistorialdoc.php';
            $accion = "Plan de cuentas / clases / nueva cuenta agregada : / " . $nombre_clase;
            generaLogs($user, $accion);
        }
    }
} else {
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
            <link href="../../../../../css/bootstrap.min.css" rel="stylesheet">

            <!-- MetisMenu CSS -->
            <link href="../../../../../css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

            <!-- Timeline CSS -->
            <link href="../../../../../css/plugins/timeline.css" rel="stylesheet">

            <!-- Custom CSS -->
            <link href="../../../../../css/sb-admin-2.css" rel="stylesheet">

            <!-- Morris Charts CSS -->
            <link href="../../../../../css/plugins/morris.css" rel="stylesheet">

            <!-- Custom Fonts -->
            <link href="../../../../../css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                            require('../../../../../templates/Clases/empresa.php');
                            $objClase = new Empresa;
                            $objClase->view_logcontabilidad_ctas();
                            ?>

                        </a>
                    </div>
                    <!-- /.navbar-header -->
                    <?PHP
                    require('../../../../../templates/Clases/menus.php');
                    $objMenu = new menus();
                     $objMenu->menu_header($carpeta, $_SESSION['loginu'], $idlogeobl);
//                    $objMenu->menu_header_level_ctas($_SESSION['loginu'], $idlogeobl);
                    ?>
                    <!-- /.navbar-top-links -->
                    <div class="navbar-default sidebar" role="navigation">
                        <?PHP
                        $objMenu->menu_indexadmin_row($carpeta);
//                        $objMenu->menu_h_level_ccfrm();
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
                        <div class="col-lg-6">
                            <div class="panel panel-default">

                                <div class="panel-heading">
                                    Nueva Clases
                                </div>

                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <form id="frmClienteNuevo" name="frmClaseNuevo" method="post" action="clss.php" >
                                            <center>  <strong>Ingreso de Nueva Clase</strong> </center>
                                            <div class="form-group">
                                                <label>Nombre :</label>
                                                <input class="form-control" type="text" required="required" id="nombre_clase" name="nombre_clase" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>Descripci&oacute;n :</label>
                                                <input class="form-control" type="text" required="required" id="descrip_class" name="descrip_class" value="">
                                            </div>
                                            <p>
                                                <input  readonly="readonly" class="text" type="hidden" 
                                                        name="cod_clase" id="cod_clase" required="required" style="text-align:center" value="<?Php print $id ?>"/>
                                            </p>
                                            <p>

                                            <p>
                                                <input type="submit" name="submit" class="btn btn-success" id="button" value="Enviar"/>
                                                <label></label>
                                            </p>
                                        </form>
                                        <?php
                                    }
                                    ?>
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
        <script src="../../../../../js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../../../../../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../../../../js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->

        <!-- DataTables JavaScript -->
        <script src="../../../../../js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="../../../../../js/plugins/dataTables/dataTables.bootstrap.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../../../../../js/sb-admin-2.js"></script>
        <script src="../../../../../js/js.js"></script>
        <script src="js/jslevel.js"></script>
        <script src="../../../../../js/script.js"></script>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">NUEVA CLASE</h4>
                    </div>
                    <div class="modal-body" id="caja">

                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
