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
$hh = '../';
$sess = '../../';
$raiz = '../../';
$carpetas = '../../../';
require '../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$idlogeobl = $_SESSION['id_user'];
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];
$date = date("Y-m-d");
//include '../../Clases/guardahistorial.php';
//$accion = "/ CONTABILIDAD / Ajustes / Ingreso en registro de asientos de ajuste";
//generaLogs($user, $accion);
$mes = date('F');
$year = date('Y');

$consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
$query_bl = mysqli_query($c, $consul_bal_inicial);
$row = mysqli_fetch_array($query_bl);
$idcod = $row['contador'];
$idcod_sig = $row['Siguiente'];

$sqlcontasiaj = "SELECT count(`t_ejercicio_idt_corrientes`)+1 as cont FROM `num_asientos_ajustes`";
$queryajustecont = mysqli_query($c, $sqlcontasiaj);
$rcontajustes = mysqli_fetch_array($queryajustecont);
$contador_ass = $rcontajustes['cont'];
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
                                Ajustes de Asientos
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form name="form_ejercicio" role="form" id="form_ejercicio" method="post" action="cont_aj_ass.php">
                                        <fieldset>
                                            <!--<legend-->

                                            <button type="button" class="btn btn-default" onclick="addasiento_level();">INSERTAR</button>
                                            <button type="submit" class="btn btn-success" onclick="guardaas_aj()">GUARDAR</button>
                                            <button type="button" class="btn btn-primary" onclick="reset_form()">CANCELAR</button>

                                            <div class="alert fade in" data-alert="alert" id="alert-area" >
                                                <a class="close" data-dismiss="alert" href="#">&times;</a>
                                            </div>
                                            <!--</legend>-->
                                            <input type="hidden" class="texto" name="balances_realizados" id="balances_realizados" value="<?Php echo $idcod; ?>"/>
                                            <input type="hidden" name="mes" id="mes" readonly="readonly" value="<?php echo $mes ?>"/>
                                            <input type="hidden" name="idlog" id="idlog" readonly="readonly" value="<?php echo $idlogeobl ?>"/>
                                            <datalist id="cuenta">
                                                <?php
                                                $c = $dbi->conexion();
                                                $query = "SELECT * FROM `t_plan_de_cuentas` order by `t_clase_cod_clase`,`t_grupo_cod_grupo`,`t_cuenta_cod_cuenta`,`t_subcuenta_cod_subcuenta`,`t_auxiliar_cod_cauxiliar`,`t_subauxiliar_cod_subauxiliar` DESC";
                                                $resul1 = mysqli_query($c, $query);
                                                while ($dato1 = mysqli_fetch_array($resul1)) {
                                                    $cod1 = $dato1['cod_cuenta'];
                                                    echo "<option value='" . $dato1['cod_cuenta'] . "' >";
                                                    echo $dato1['cod_cuenta'] . '      ' . utf8_decode($dato1['nombre_cuenta_plan']);
                                                    echo '</option>';
                                                }mysqli_close($c);
                                                ?>
                                            </datalist>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <label class="control-label">Cod. Cuenta</label>
                                                            <div class="input-group">
                                                                <input type="text" onblur="rr_compr_evento_level()" list="cuenta" name="cod_cuenta" id="cod_cuenta" class="form-control" value="" placeholder="Ingrese Cod Cuenta..."/>
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-default" onclick="" type="button" id="btnver">Ver!</button>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <label>Cuenta</label>
                                                                <input class="form-control" readonly="readonly" type="text" id="nom_cuenta" name="nom_cuenta" value="">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>Valor</label>
                                                            <div class="form-group input-group">
                                                                <input type="text" class="form-control" onkeyup="validar(this.id);
                                                                        Calcular();" id="valor" name="valor" value="">
                                                                <span class="input-group-addon">.00</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <label>Asiento # Num</label>
                                                                <input class="form-control" type="text" readonly="readonly" id="asiento_num" name="asiento_num" value="<?php echo $contador_ass ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <label>Fecha</label>
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
                                                                    });</script>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-xs-5">
                                                                <label>Grupo</label>
                                                                <input class="form-control" readonly="readonly" type="text" id="nom_grupo" name="nom_grupo" value="">
                                                            </div>
                                                            <div class="col-xs-2">
                                                                <label>Cod.</label>
                                                                <input class="form-control" readonly="readonly" type="text" id="cod_grupo" name="cod_grupo" value="">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <label>Tipo</label>
                                                                <?php
                                                                $db = $dbi->conexion();
                                                                $SQLtipobaldh = "SELECT * FROM tip_cuenta";
                                                                $query_tipo_bldh = mysqli_query($db, $SQLtipobaldh);
                                                                ?>
                                                                <select class="form-control" name="tip_cuentadh" id="tip_cuentadh">
                                                                    <?php while ($arreglot_cuendh = mysqli_fetch_array($query_tipo_bldh)) { ?>
                                                                        <option class="text" value="<?php echo $arreglot_cuendh['idtip_cuenta']; ?>">
                                                                            <?php echo $arreglot_cuendh['tipo']; ?></option>     
                                                                        <?php
                                                                    }
                                                                    mysqli_close($db);
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <label>Concepto de asiento</label>
                                                                <textarea class="form-control" placeholder="Concepto del Asiento..." maxlength="250" onkeyup="this.value = this.value.slice(0, 250)" id="textarea_asaj" name="textarea_asaj" cols="30" rows="3"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </fieldset>

                                        <table class="table table-hover" width="70%" border="0" align="center" cellpadding="0" cellspacing="0" class="tablaDatos" id="tblDatos">
                                            <tbody>   
                                                <tr>
                                            <thead>
                                            <td style="display:none">Asiento</td>
                                            <td>Cod_Cuenta</td>
                                            <td>Cuenta</td>
                                            <td>Fecha</td>
                                            <td>Debe</td>
                                            <td>Haber</td>
                                            <td style="display:none">bl</td>
                                            <td style="display:none">Grupo</td>
                                            <td style="display:none">log</td> 
                                            <td>    </td> 
                                            </thead>
                                            </tr>
                                            <tr id="datos">

                                            </tr> 

                                            <tr>
                                            <tfoot>
                                            <td></td>
                                            <td></td>
                                            <td> <strong>Total :</strong> </td>
                                            <td>
                                                <div class="col-xs-8 form-group has-success">
                                                    <input type="text" readonly="readonly"  class="form-control" name="camposumadebe" id="camposumadebe" value=""/> 
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-xs-8 form-group has-success">
                                                    <input type="text"  readonly="readonly" class="form-control info" name="camposumahaber" id="camposumahaber" value=""/>
                                                </div>
                                            </td>
                                            </tfoot>            
                                            </tr>
                                            </tbody>
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
        <script src="js/r_jslevel.js"></script>
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
