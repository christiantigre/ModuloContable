<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
$user = $_SESSION['username'];
$user = strtoupper($user);
require('../../../../../templates/Clases/Conectar.php');
$dbi = new Conectar();
$c = $dbi->conexion();
//rutas
$carpeta = '../../../../';
include '../../../../PanelAdminLimitado/Clases/guardahistorialdoc.php';
$accion = " / Plan de cuentas / sub-cuentas / Ingreso al registro de sub cuentas";
generaLogs($user, $accion);
if (isset($_POST["submit"])) {
    $btntu = $_POST["submit"];
    if ($btntu == "Enviar") {
        require('../../../../Clases/cliente.class.php');
        $nombre_cuenta = htmlspecialchars(trim($_POST['nombre_cuenta']));
        $cod_grupo = htmlspecialchars(trim($_POST['newcod_grupo']));
        $descrip_cuenta = htmlspecialchars(trim($_POST['descrip_cuenta']));
        $t_clase_cod_clase = htmlspecialchars(trim($_POST['cod_clasetxt']));
        $cod_obtenidogrupo = htmlspecialchars(trim($_POST['codgrupo']));
        $objGrupo = new Clase;
        if ($objGrupo->insertarsubcuenta(array($nombre_cuenta, $cod_grupo, $descrip_cuenta, $t_clase_cod_clase, $cod_obtenidogrupo)) == true) {
            if ($objGrupo->insertarcuenta_plansub(array($nombre_cuenta, $cod_grupo, $descrip_cuenta, $t_clase_cod_clase, $cod_obtenidogrupo)) == true) {
                echo '<script language = javascript>
alert("Guardado, exitosamente en Sub-Cuentas y Plan de Cuentas")
self.location = "sb_cta.php"
</script>';
            } else {
                echo '<script language = javascript>
alert("Ocurrio un error, no se guardo en el Plan de Cuentas...")
self.location = "sb_cta.php"
</script>';
            }
        } else {
            echo '<script language = javascript>
alert("Ocurrio un error, verifique los campos...")
self.location = "sb_cta.php"
</script>';
        }
    } else if ($btntu == "Codigo") {
        $c = $dbi->conexion();
        $cod_clase = $_POST['t_clase_cod_clase'];
        $cod_clase = $cod_clase . '.';
        echo '<script>alert($cod_clase);</script>';
        $stu = " SELECT cod_subcuenta as codigo FROM `t_subcuenta` WHERE `t_cuenta_cod_cuenta` ='" . $cod_clase . "'  ";
        $stu1 = "select * from t_cuenta";
        $query = mysqli_query($c, $stu);
        $queryclases = mysqli_query($c, $stu1);
        $row = mysqli_fetch_array($query);
        $idcod = $row['codigo'];
        echo "<script>alert($cod_clase)</script>";
        if ($idcod == "") {
            $c = $dbi->conexion();
            $cod_clase = $_POST['t_clase_cod_clase'];
            $cod_clase = $cod_clase;
            $stu = "SELECT count( * )+1 AS codigo FROM `t_subcuenta` WHERE `t_cuenta_cod_cuenta` ='" . $cod_clase . "'  ";
            $query = mysqli_query($c, $stu);
            $row = mysqli_fetch_array($query);
            $idcod = $row['codigo'];
            $codigo_generado = $cod_clase . $idcod;
            $idcod = $codigo_generado . '.';
            $cod_clasetxt = $cod_clase;
            mysqli_close($c);
        } else {
            $c = $dbi->conexion();
            $cod_clase = $_POST['t_clase_cod_clase'];
            $cod_clase = $cod_clase . '.';
            $stu = "  SELECT count( * ) +1 AS Siguiente, concat( (t_cuenta_cod_cuenta), (count( * ) +1 )) AS Codigo FROM `t_subcuenta` WHERE `t_cuenta_cod_cuenta` = '" . $cod_clase . "'  ";
            $query = mysqli_query($c, $stu);
            $row = mysqli_fetch_array($query);
            $idsig = $row['Siguiente'];
            $idcod = $row['Codigo'];
            $cod_clasetxt = $cod_clase;
            mysqli_close($c);
        }
    }
}
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
//                $objMenu->menu_header_level_ctas($_SESSION['loginu'], $idlogeobl);
                ?>
                <!-- /.navbar-top-links -->
                <div class="navbar-default sidebar" role="navigation">
                    <?PHP
                    $objMenu->menu_indexadmin_row($carpeta);
//                    $objMenu->menu_h_level_ccfrm();
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
                                Nueva Sub Cuenta
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form id="frmClienteNuevo" name="frmClaseNuevo" method="post" action="sb_cta.php">        
                                        <center>  <strong>Ingreso de Nueva Sub Cuenta</strong> </center>
                                        <div class="form-group">
                                            <label>Seleccione a que clase pertenecer&aacute;    : </label> <br/> 
                                            <input type="hidden" id="codgrupo" name="codgrupo" value=""/>
                                            <select class="form-control" name="t_clase_cod_clase" id="t_clase_cod_clase" 
                                                    size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo();"><!--generar_codigo_grupo()-->
                                                        <?php
                                                        $c = $dbi->conexion();
                                                        $consulgrupo = "SELECT * FROM `t_cuenta` order by cod_cuenta";
                                                        $queryclases = mysqli_query($c, $consulgrupo);
                                                        while ($arreglorepalmtu = mysqli_fetch_array($queryclases)) {
                                                            if ($_POST['t_clase_cod_clase'] == $arreglorepalmtu['cod_cuenta']) {
                                                                echo "<option value='" . $arreglorepalmtu['cod_cuenta'] . "' selected>&nbsp;&nbsp;" . $arreglorepalmtu['nombre_cuenta'] . "</option>";
                                                            } else {
                                                                ?>
                                                        <option class="form-control" value="<?php echo $arreglorepalmtu['cod_cuenta'] ?>"><?php echo $arreglorepalmtu['nombre_cuenta'] ?></option>     
                                                        <?php
                                                    }
                                                }
                                                mysqli_close($c);
                                                ?>
                                            </select>
                                        </div>
                                        <center> <h6>Genere su c&oacute;digo.</h6></center> 
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" name="submit" id="buttoncodificar" value="Codigo" />
                                        </div>
                                        <div class="form-group">
                                            <label>C&oacute;digo </label><br />
                                            <input class="form-control" type="text" name="newcod_grupo" id="newcod_grupo" value="<?php echo $idcod; ?>" readonly="readonly"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre :</label><br />
                                            <input class="form-control" type="text" onclick="cargacodgrupo();" name="nombre_cuenta" id="nombre_cuenta" />
                                            <input class="form-control" type="hidden" name="cod_clasetxt" id="cod_clasetxt" value="<?php echo $cod_clasetxt; ?>" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Grupo </label><br/>
                                            <input class="form-control" type="text" readonly="readonly" id="nombredelgrupo" name="nombredelgrupo"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Descripcion </label><br />
                                            <input class="form-control" type="text" name="descrip_cuenta" id="descrip_cuenta" />
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success" name="submit" id="buttonenviar" value="Enviar" />
                                        </div>
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
        <script src="../../../../../js/jquery.functions.js"></script>
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
