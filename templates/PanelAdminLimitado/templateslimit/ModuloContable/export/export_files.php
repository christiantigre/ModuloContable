<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../../login.php"
</script>';
}
//rutas
$carpeta = '../../../../';
require '../../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$idlogeobl = $_SESSION['id_user'];
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];
$date = date("Y-m-d");

$hh = "../../../";
$sess = '../../../../';
$raiz = '../../../';
$carpetas = '../../../';

include '../../../Clases/guardahistorialimp.php';
$accion = "/ REPORTES / EXPORTAR / Ingreso a reportes";
generaLogs($user, $accion);
$mes = date('F');
$year = date('Y');
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

        <title>:: DOCUMENTOS ::</title>

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
                    <a class="navbar-brand" rel="home" href="" title="Buy Sell Rent Everyting">
                        <?Php
                        require('../../../../../templates/Clases/empresa.php');
                        $objClase = new Empresa;
                        ?>
                        <img src="../../../../../images/uploads/<?Php $objClase->logo_cl(); ?>" class="img-responsive img-rounded" style="width:329px;height: 50px; margin-top: -15px;"/>


                    </a>
                </div>
                <!-- /.navbar-header -->
                <?PHP
                require('../../../../../templates/Clases/menus.php');
                $objMenu = new menus();
                include_once '';
                $objMenu->menu_header_root($hh, $sess, $user, $id);
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
                                Exportar
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form id="formulariodetalles" name="formulariodetalles" method="post" action="export_files.php">
                                        <input type="hidden" name="idlog" id="idlog" value="<?Php echo $idlogeobl; ?>" />
                                        <input type="hidden" name="fechabi" id="fechabi" value="<?Php echo $year; ?>" />
                                            <input type="hidden" name="asiento_num" id="asiento_num" value="<?Php echo 1; ?>" />
                                            <table class="table table-hover">   
                                            <tr>
                                                <td><strong>Documento</strong></td>
                                                <td><strong>PDF</strong></td>
                                                <td><strong>EXCEL</strong></td>
                                                <td><strong>WORD</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Balance inicial</strong></td>
                                                <td><button class="btn btn-outline btn-danger" name="impasiento" id="impasiento" onclick="imp_pdf(this.id);"><img src="../../../../../images/pdf.png" width="30" height="30" alt="pdf"/></button></td>
                                                <td><button class="btn btn-outline btn-success" name="ex_ini" id="ex_ini" onclick="exp_ex(this.id);"><img src="../../../../../images/excel.png" width="30" height="30" alt="pdf"/></button></td>
                                                <td><button class="btn btn-outline btn-primary" name="wd_in" id="wd_in" onclick="exp_wd(this.id);"><img src="../../../../../images/word.png" width="30" height="30" alt="pdf"/></button></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Libro</strong></td>
                                                <td><button class="btn btn-outline btn-danger" name="balanceimp" id="balanceimp" onclick="imp_pdf(this.id);"><img src="../../../../../images/pdf.png" width="30" height="30" alt="pdf"/></button></td>
                                                <td><button class="btn btn-outline btn-success" name="ex_as" id="ex_as" onclick="exp_ex(this.id);"><img src="../../../../../images/excel.png" width="30" height="30" alt="pdf"/></button></td>
                                                <td><button class="btn btn-outline btn-primary" name="as_as" id="wd_as" onclick="exp_wd(this.id);"><img src="../../../../../images/word.png" width="30" height="30" alt="pdf"/></button></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Mayor general</strong></td>
                                                <td><button class="btn btn-outline btn-danger" name="impmayor" id="impmayor" onclick="imp_pdf(this.id);"><img src="../../../../../images/pdf.png" width="30" height="30" alt="pdf"/></button></td>
                                                <td><button class="btn btn-outline btn-success" name="ex_my" id="ex_my" onclick="exp_ex(this.id);"><img src="../../../../../images/excel.png" width="30" height="30" alt="pdf"/></button></td>
                                                <td><button class="btn btn-outline btn-primary" name="wd_my" id="wd_my" onclick="exp_wd(this.id);"><img src="../../../../../images/word.png" width="30" height="30" alt="pdf"/></button></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Estado de Situaci&oacute;n Financiera</strong></td>
                                                <td><button class="btn btn-outline btn-danger" name="impSituacionFinanciera" id="impSituacionFinanciera" onclick="imp_pdf(this.id);"><img src="../../../../../images/pdf.png" width="30" height="30" alt="pdf"/></button></td>
                                                <td><button class="btn btn-outline btn-success" name="ex_bresl" id="ex_bresl"  onclick="exp_ex(this.id);"><img src="../../../../../images/excel.png" width="30" height="30" alt="pdf"/></button></td>
                                                <td><button class="btn btn-outline btn-primary" name="wd_bresl" id="wd_bresl"  onclick="exp_wd(this.id);"><img src="../../../../../images/word.png" width="30" height="30" alt="pdf"/></button></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Estado de resultados</strong></td>
                                                <td><button class="btn btn-outline btn-danger" name="impsituacionfinal" id="impsituacionfinal" onclick="imp_pdf(this.id);"><img src="../../../../../images/pdf.png" width="30" height="30" alt="pdf"/></button></td>
                                                <td><button class="btn btn-outline btn-success" name="ex_stfnl" id="ex_stfnl" onclick="exp_ex(this.id)"><img src="../../../../../images/excel.png" width="30" height="30" alt="pdf"/></button></td>
                                                <td><button class="btn btn-outline btn-primary" name="wd_stfnl" id="wd_stfnl" onclick="exp_wd(this.id)"><img src="../../../../../images/word.png" width="30" height="30" alt="pdf"/></button></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Plan de cuentas</strong></td>
                                                <td><button class="btn btn-outline btn-danger" name="impplan" id="impplan" onclick="imp_pdf(this.id);"><img src="../../../../../images/pdf.png" width="30" height="30" alt="pdf"/></button></td>
                                                <td><button class="btn btn-outline btn-success" name="ex_pl" id="ex_pl" onclick="exp_ex(this.id)"><img src="../../../../../images/excel.png" width="30" height="30" alt="pdf"/></button></td>
                                                <td><button class="btn btn-outline btn-primary" name="wd_pl" id="wd_pl" onclick="exp_wd(this.id)"><img src="../../../../../images/word.png" width="30" height="30" alt="pdf"/></button></td>
                                            </tr>
                                            <?php
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
        <script src="../../../../../js/script.js"></script>
        <script src="../../../../../js/imp_files.js"></script>
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
