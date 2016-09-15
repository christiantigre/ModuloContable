<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
$user = $_SESSION['username'];
$user = strtoupper($user);
require('../../../../templates/Clases/Conectar.php');
$dbi = new Conectar();
$conn = $dbi->conexion();
$hh = '../../';
$sess = '../../../';
$raiz = '../../../../';
$carpetas = '../../../../';
include '../../../../templates/PanelAdminLimitado/Clases/guardahistorial.php';
$accion = "/ Plan de cuentas / grupos / Ingreso al registro de grupos";
generaLogs($user, $accion);
//$conn->close();
if (isset($_REQUEST["submit"])) {
    $btntu = $_REQUEST["submit"];
    if ($btntu == "Enviar") {
        require('../../../../templates/Clases/cliente.class.php');
        $nombre_grupo = htmlspecialchars(trim($_REQUEST['nombre_grupo']));
        $cod_grupo = htmlspecialchars(trim($_REQUEST['newcod_grupo']));
        $descrip_grupo = htmlspecialchars(trim($_REQUEST['descrip_grupo']));
        $t_clase_cod_clase = htmlspecialchars(trim($_REQUEST['cod_clasetxt']));
        $objGrupo = new Clase;
        if ($nombre_grupo == "" or $cod_grupo == "") {
            echo "<script> alert('Complete los campos');</script>";
        } else {
            if ($objGrupo->insertargrupo(array($nombre_grupo, $cod_grupo, $descrip_grupo, $t_clase_cod_clase)) == true) {
                if ($objGrupo->insertargrupo_plan(array($nombre_grupo, $cod_grupo, $descrip_grupo, $t_clase_cod_clase)) == true) {
                    $accion = "Plan de cuentas / grupos / nuevo grupo agregado : / " . $nombre_grupo;
                    generaLogs($user, $accion);
                } else {
                    echo "<script> alert('Error, no se guardo el registro en el Plan de Cuentas');</script>";
                }
                echo '<script language = javascript>
alert("Guardado, exitosamente en Grupos y Plan de Cuentas")
self.location = "gpr.php"
</script>';
            } else {
                echo "<script> alert('Error, no se guardo el registro');</script>";
            }
        }
    } else if ($btntu == "Codigo") {
        $cod_clase = $_REQUEST['t_clase_cod_clase'];
        $c = $dbi->conexion();
        $stu = " SELECT cod_grupo as codigo FROM `t_grupo` WHERE `t_clase_cod_clase` ='" . $cod_clase . "'  ";
        $stu1 = "select * from t_clase";
        $query = mysqli_query($c, $stu);
        $queryclases = mysqli_query($c, $stu1);
        $row = mysqli_fetch_array($query);
        $idcod = $row['codigo'];
        if ($idcod == "") {
            $c = $dbi->conexion();
            $cod_clase = $_REQUEST['t_clase_cod_clase'];
            $stu = "SELECT count( * ) +1 AS codigo
FROM `t_cuenta`
WHERE `t_grupo_cod_grupo` = '" . $cod_clase . "'  ";
            $query = mysqli_query($c, $stu);
            $row = mysqli_fetch_array($query);
            $idcod = $row['codigo'];
            $codigo_generado = $cod_clase . $idcod . '.';
            $idcod = $codigo_generado;
            $cod_clasetxt = $cod_clase;
            mysqli_close($c);
        } else {
            $c = $dbi->conexion();
            $cod_clase = $_REQUEST['t_clase_cod_clase'];
            $stu = " SELECT count( * ) +1 AS Siguiente, concat( (t_clase_cod_clase), (count( * ) +1 ))"
                    . " AS Codigo FROM `t_grupo` WHERE `t_clase_cod_clase` =" . $cod_clase . "  ";
            $query = mysqli_query($c, $stu);
            $row = mysqli_fetch_array($query);
            $idsig = $row['Siguiente'];
            $idcod = $row['Codigo'];
            $cod_clasetxt = $cod_clase;
            $codigo_generado = $idcod . '.';
            $idcod = $codigo_generado;
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
                        ?>
                        <img src="../../../../images/uploads/<?Php $objClase->logo_cl(); ?>" class="img-responsive img-rounded" style="width:329px;height: 50px; margin-top: -15px;"/>
                    </a>
                </div>
                <!-- /.navbar-header -->
                <?PHP
                require('../../../../templates/Clases/menus.php');
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
                    <div class="col-lg-6">
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                Nuevo Grupo
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form id="frmClienteNuevo" name="frmClaseNuevo" method="post" action="gpr.php">        
                                        <center>  <strong>Ingreso de Nuevo Grupo</strong> </center>
                                        <div class="form-group">
                                            <label>Selecciones a que clase pertenecer&aacute;    : </label> <br/> 
                                            <select class="form-control" name="t_clase_cod_clase" id="t_clase_cod_clase" size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo();"><!--generar_codigo_grupo()-->
                                                <?php
                                                $consulclases = "select * from t_clase";
                                                $queryclases = mysqli_query($conn, $consulclases);
                                                while ($arreglorepalmtu = mysqli_fetch_array($queryclases)) {
                                                    if ($_POST['t_clase_cod_clase'] == $arreglorepalmtu['cod_clase']) {
                                                        echo "<option value='" . $arreglorepalmtu['cod_clase'] . "' selected>&nbsp;&nbsp;" . $arreglorepalmtu['nombre_clase'] . "</option>";
                                                    } else {
                                                        ?>
                                                        <option class="form-control" value="<?php echo $arreglorepalmtu['cod_clase'] ?>">
                                                        <?php echo $arreglorepalmtu['nombre_clase'] ?></option>     
                                                        <?php
                                                    }
                                                }
                                                mysqli_close($conn);
                                                ?>
                                            </select>
                                        </div>
                                        <center> <h6>Genere su c&oacute;digo.</h6></center> 
                                        <div class="form-group">
                                            <input type="submit" name="submit" class="btn btn-primary" id="buttoncodificar" value="Codigo" />
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre :</label><br />
                                            <input class="form-control" type="text" name="nombre_grupo" id="nombre_grupo" />
                                            <input class="form-control" type="hidden" name="cod_clasetxt" id="cod_clasetxt" value="<?php echo $cod_clasetxt; ?>" />

                                        </div>
                                        <div class="form-group">
                                            <label>C&oacute;digo </label><br />
                                            <input class="form-control" type="text" name="newcod_grupo" id="newcod_grupo" value="<?php echo $idcod; ?>" readonly="readonly"/>
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Descripcion </label><br />
                                            <input class="form-control" type="text" name="descrip_grupo" id="descrip_grupo" />
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
        <script src="../../../../js/script.js"></script>
        <script src="../../../../js/jquery.functions.js"></script>
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
