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
$raiz = '../../../';
$carpetas = '../../../';
include '../../../templates/PanelAdminLimitado/Clases/guardahistorialcuentas.php';
$accion = "/ CUENTAS / plan de cuentas / Ingreso a plan de cuentas";
generaLogs($user, $accion);
$mes = date('F');
$year = date('Y');
require('../../../templates/Clases/cliente.class.php');
$objClase = new Clase;
$consulta = $objClase->mostrar_catalgogo_cuentas();
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
                    $objMenu->menu_admin($raiz, $carpetas)
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
                                Plan de Cuentas
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form name="form_ejercicio" role="form" id="form_ejercicio" method="post" action="cc_ini.php">
                                        <datalist id="cuenta">
                                            <?php
                                            $query = "select * from t_plan_de_cuentas order by cod_cuenta";
                                            $resul1 = mysqli_query($c, $query);
                                            while ($dato1 = mysqli_fetch_array($resul1)) {
                                                $cod1 = $dato1['cod_cuenta'];
                                                echo "<option value='" . $dato1['cod_cuenta'] . "' >";
                                                echo $dato1['cod_cuenta'] . '      ' . utf8_decode($dato1['nombre_cuenta_plan']);
                                                echo '</option>';
                                            }
                                            mysqli_close($c);
                                            ?>
                                        </datalist>
                                        <div class="form-group input-group">
                                            <input type="text" list="cuenta" id="cta" name="cta" class="form-control">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="submit" id="bsearch" name="bsearch"><i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                        <div class="form-group input-group">
                                            <button type="submit" id="todos" name="todos" title="TODOS" class="btn btn-primary glyphicon glyphicon glyphicon-list"></button>

                                            <button type="submit" title="IMPRIMIR CUENTAS" 
                                                    class="btn btn-outline btn-info glyphicon glyphicon-print"
                                                    onclick="impplancuenta_cc()"></button>
                                        </div>


                                        <?Php
                                        if (isset($_POST['bsearch'])) {
                                            ?>
                                            <table class="table table-striped table-bordered table-hover">
                                                <tr class="default">
                                                    <th>Nombre</th>
                                                    <th>Id</th>
                                                    <th>Codigo</th>
                                                </tr>
                                                <?php
                                                $conn = $dbi->conexion();
                                                if ($conn->connect_error) {
                                                    die("Connection failed: " . $conn->connect_error);
                                                }
                                                $sql = "select * from t_plan_de_cuentas where cod_cuenta='" . $_POST['cta'] . "'";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($clase = $result->fetch_assoc()) {
                                                        $nom_caux = $clase['nombre_cuenta_plan'];
                                                        ?>

                                                        <tr id="fila-<?php echo $clase['cod_cuenta']; ?>">
                                                            <td style="width: 15px;"><?php echo utf8_decode($nom_caux); ?></td>
                                                            <td><?php echo $clase['t_clase_cod_clase']; ?></td>
                                                            <td><?php echo $clase['cod_cuenta']; ?></td>
                                                            

                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                $conn->close();
                                                ?>
                                            </table>
                                            <?php
                                        } elseif (isset($_POST['todos'])) {
                                            ?>
                                            <table class="table table-striped table-bordered table-hover">

                                                <tr>
                                                    <th>Codigo Cta.</th>
                                                    <th align="right" colspan="10">Cuenta</th>
                                                </tr>
                                                <?php
                                                if ($consulta) {
                                                    while ($clase = mysqli_fetch_array($consulta)) {
                                                        ?>
                                                        <tr id="fila-<?php echo $clase['idt_plan_de_cuentas'] ?>">
                                                            <td><?php echo $clase['cod_cuenta'] ?></td>
                                                            <td>
                                                                <?php
                                                                $ruta = $clase['nombre_cuenta_plan'];
                                                                $cont = $clase['cod_cuenta'];
                                                                $dato = str_replace('.', '', $cont, $n);
                                                                $carpeta = str_replace('.', '', $ruta, $reemplazos);
                                                                if ($n == 0) {
                                                                    echo '<td class="danger">';
                                                                    echo $carpeta;
                                                                    echo '</td>';
                                                                }
                                                                if ($n == 1) {
                                                                    echo '<td class="danger" >';
                                                                    echo $carpeta;
                                                                    echo '</td>';
                                                                }
                                                                if ($n == 2) {
                                                                    echo '<td class="warning" >';
                                                                    echo $carpeta;
                                                                    echo '</td>';
                                                                }
                                                                if ($n == 3) {
                                                                    echo '<td class="success" >';
                                                                    echo $carpeta;
                                                                    echo '</td>';
                                                                }
                                                                if ($n == 4) {
                                                                    echo '<td class="info" >';
                                                                    echo $carpeta;
                                                                    echo '</td>';
                                                                }
                                                                if ($n == 5) {
                                                                    $cap = 70;
                                                                    $cc = strlen($carpeta);
                                                                    if ($cc > $cap) {
                                                                        echo '<td >';
                                                                        echo substr($carpeta, 0, $cap) . '...';
                                                                        echo '<a href="#modalform" rel="abrir" title="' . $clase['nombre_cuenta_plan'] . '">[más]</a></td>';
                                                                    } else {
                                                                        echo '<td >';
                                                                        echo $carpeta;
                                                                        echo '</td>';
                                                                    }
                                                                }
                                                                if ($n == 6) {
                                                                    echo '<td class="default" >';
                                                                    echo $carpeta;
                                                                    echo '</td>';
                                                                }
                                                                ?>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </table>
                                            <?Php
                                        } else {
                                            ?>
                                            <table class="table table-striped table-bordered table-hover">

                                                <tr>
                                                    <th>Codigo Cta.</th>
                                                    <th align="right" colspan="10">Cuenta</th>
                                                </tr>
                                                <?php
                                                if ($consulta) {
                                                    while ($clase = mysqli_fetch_array($consulta)) {
                                                        ?>
                                                        <tr id="fila-<?php echo $clase['idt_plan_de_cuentas'] ?>">
                                                            <td><?php echo $clase['cod_cuenta'] ?></td>
                                                            <td>
                                                                <?php
                                                                $ruta = $clase['nombre_cuenta_plan'];
                                                                $cont = $clase['cod_cuenta'];
                                                                $dato = str_replace('.', '', $cont, $n);
                                                                $carpeta = str_replace('.', '', $ruta, $reemplazos);
                                                                if ($n == 0) {
                                                                    echo '<td class="danger">';
                                                                    echo $carpeta;
                                                                    echo '</td>';
                                                                }
                                                                if ($n == 1) {
                                                                    echo '<td class="danger" >';
                                                                    echo $carpeta;
                                                                    echo '</td>';
                                                                }
                                                                if ($n == 2) {
                                                                    echo '<td class="warning" >';
                                                                    echo $carpeta;
                                                                    echo '</td>';
                                                                }
                                                                if ($n == 3) {
                                                                    echo '<td class="success" >';
                                                                    echo $carpeta;
                                                                    echo '</td>';
                                                                }
                                                                if ($n == 4) {
                                                                    echo '<td class="info" >';
                                                                    echo $carpeta;
                                                                    echo '</td>';
                                                                }
                                                                if ($n == 5) {
                                                                    $cap = 70;
                                                                    $cc = strlen($carpeta);
                                                                    if ($cc > $cap) {
                                                                        echo '<td >';
                                                                        echo substr($carpeta, 0, $cap) . '...';
                                                                        echo '<a href="#modalform" rel="abrir" title="' . $clase['nombre_cuenta_plan'] . '">[más]</a></td>';
                                                                    } else {
                                                                        echo '<td >';
                                                                        echo $carpeta;
                                                                        echo '</td>';
                                                                    }
                                                                }
                                                                if ($n == 6) {
                                                                    echo '<td class="default" >';
                                                                    echo $carpeta;
                                                                    echo '</td>';
                                                                }
                                                                ?>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </table>
                                            <?Php
                                        }
                                        ?>

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



