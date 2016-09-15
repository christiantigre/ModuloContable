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
$idlogeobl = $_SESSION['id_user'];
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];
$date = date("Y-m-d");
include '../../../../PanelAdminLimitado/Clases/guardahistorialdoc.php';
//rutas
$carpeta = '../../../';
if (isset($_GET['codigo'])) {
    $dato = $_GET['codigo'];

    $accion = " / Plan de cuentas / sub auxiliar / Ingreso a actualización de auxiliar id :" . $dato;
    generaLogs($user, $accion);
    include '../../../../../templates/Clases/Conectar.php';
    $dbi = new Conectar();
    $c = $dbi->conexion();
    $sql = "SELECT * FROM t_auxiliar where cod_cauxiliar='" . $_GET['codigo'] . "'";
    $reali = mysqli_query($c, $sql) or die(mysqli_errno($c));
    while ($row = mysqli_fetch_array($reali)) {
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
                        $objMenu->menu_header($carpeta, $user, $id);
//                        $objMenu->menu_header_level_ctas($_SESSION['loginu'], $idlogeobl);
                        ?>
                        <!-- /.navbar-top-links -->
                        <div class="navbar-default sidebar" role="navigation">
                            <?PHP
                            $objMenu->menu_indexadmin_row($carpeta);
//                            $objMenu->menu_h_level_ccfrm();
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
                            <div class="col-lg-8">
                                <div class="panel panel-default">

                                    <div class="panel-heading">
                                        Actualiza Cuenta Auxiliar
                                    </div>

                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <?Php
                                            ?>
                                            <form method="POST" action="up_data_aux.php" name="form_up" id="form_up">
                                                <input class="text" type="hidden" name="id" id="id" value="<?Php echo $row[1] ?>"/>
                                                <div class="form-group">
                                                    <label>Nombre<br />
                                                        <input class="form-control" type="text" name="nombre_cuenta" id="nombre_cuenta" value="<?Php echo utf8_decode($row[0]); ?>" readonly="readonly"/>
                                                    </label>
                                                </div>      
                                                <div class="form-group">
                                                    <label>Descripci&oacute;n<br />
                                                        <input class="form-control" type="text" name="descrip_cuenta" id="descrip_cuenta" value="<?Php echo $row[2] ?>" />
                                                    </label>
                                                </div>
                                                <table>
                                                    <div class="form-group">
                                                        <label>Veh&iacute;culo</br> 
                                                            <input type="text" name="v_placa" id="v_placa" class="form-control" placeholder="Ingrese placa" value="<?Php echo $row[7] ?>"/>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Cliente</br>
                                                            <input type="text" name="c_id" id="c_id" class="form-control" placeholder="Ingrese id" value="<?Php echo $row[8] ?>"/>
                                                        </label>
                                                    </div>
                                                </table>
                                                <div class="form-group">

                                                    <input type="submit" class="btn btn-success" name="submit" onclick="return confirmar();" id="submit" value="GUARDAR" />                         

                                                </div>
                                            <script>
                                                function confirmar() {
                                                    var formulario = document.getElementById("form_up");
                                                    var dato = formulario[0];
                                                    respuesta = confirm('¿Esta seguro que desea realizar los cambios?\n ');
                                                    if (respuesta) {
                                                        formulario.submit();
                                                        return true;
                                                    } else {
                                                        alert("No se aplicaran los cambios...!!!");
                                                        return false;
                                                    }
                                                }
                                            </script>


                                            </form>
                                            <?Php
                                        }
                                        mysqli_close($c);
                                    }
                                    if (isset($_REQUEST["submit"])) {
                                        $btntu = $_REQUEST["submit"];
                                        if ($btntu == "GUARDAR") {
                                            include '../../../../../templates/Clases/Conectar.php';
                                            $dbi = new Conectar();
                                            $c = $dbi->conexion();
                                            $nombre_cuenta = htmlspecialchars(trim($_POST['nombre_cuenta']));
                                            $descrip_cuenta = htmlspecialchars(trim($_POST['descrip_cuenta']));
                                            $v_placa = htmlspecialchars(trim($_POST['v_placa']));
                                            $c_id = htmlspecialchars(trim($_POST['c_id']));
                                            $id = htmlspecialchars(trim($_POST['id']));
                                            $sql_up = "UPDATE `t_auxiliar` SET `nombre_cauxiliar`='" . utf8_encode($nombre_cuenta) . "',`descrip_auxiliar`='$descrip_cuenta',"
                                                    . "`placa_id`='$v_placa',`cli_id`='$c_id' WHERE `cod_cauxiliar`='$id'";
                                            mysqli_query($c, $sql_up) or trigger_error("Query Failed! SQL: $sql_up - Error: " . mysqli_error($c), E_USER_ERROR);
                                            $accion = " / Plan de cuentas / sub auxiliar / Actualizó cuenta :" . $nombre_cuenta;
                                            generaLogs($user, $accion);
                                            echo '<script language = javascript>
alert("Datos guardados")
self.location = "../cc_aux.php"
</script>';
                                        }
                                    }
                                    ?>
                                </div>
                                <!--/.table-responsive -->
                            </div>
                            <!--/.panel-body -->
                        </div>
                        <!--/.panel -->
                    </div>
                </div>
                <!--/.row -->
            </div>
            <!--/#page-wrapper -->
        </div>
        <!--/#wrapper -->
        <!--jQuery -->
        <script src = "../../../../../js/jquery-1.11.0.js"></script>

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
                        <h4 class="modal-title" id="myModalLabel">ACTUALIZAR CUENTA</h4>
                    </div>
                    <div class="modal-body" id="caja">

                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
