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
$conn = $dbi->conexion();
$idlogeobl = $_SESSION['id_user'];
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];
$date = date("Y-m-d");
//include '../../Clases/guardahistorial.php';
//$accion = " / Balance Inicial / Ingreso en balance inicial";
//generaLogs($user, $accion);
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
                    $objMenu->menu_contabilidad();
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
                                Balance Inicial para el nuevo per&iacute;odo
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form name="formulario" id="formulario" action="cont_new_bl.php" method="POST">
                                        <center>
                                            <h1>Balance Generado</h1>
                                            <?php
                                            $c = $dbi->conexion();
                                            $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
                                            $result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($c), E_USER_ERROR);
                                            if ($result) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $maxbalancedato = $row['id'];
                                                }
                                            }
                                            //$c->close();
                                            ?>
                                            <!--<input type="hidden" value="<?php echo $maxbalancedato; ?>" id="texto"/>-->
            <!--                                <a href="impresiones/imphojadetrabajo.php?prmlg=<?php echo $idlogeobl; ?>">
                                                <img src="./images/print.png" alt="Ver" title="Detalles" /> 
                                            </a>-->
                                            <input type="submit" name="savenewblini" onclick="rr_guardanewBalance()" 
                                                   id="savenewblini" class="btn" value="Guardar Nuevo Balance"/>
            <!--                                <input type="button" name="balanceactual" id="balanceactual" class="btn" value="Balance General Actual"/>-->
                                            <div class="mensaje"></div>
                                            <input type="hidden" value="<?php echo $estado; ?>"/>
                                            <input type="hidden" name="respuesta" id="respuesta" value=""/>
                                            <input type="hidden" name="idlogeobl" id="idlogeobl" value="<?php echo $idlogeobl; ?>"/>
                                            <?php
                                            $c = $dbi->conexion();
                                            $sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
                                            $resul_param = $c->query($sqlparametro);
                                            if ($resul_param->num_rows > 0) {
                                                while ($clase_param = $resul_param->fetch_assoc()) {
                                                    $parametro_contador = $clase_param['cont'];
                                                }
                                            } else {
                                                echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
                                            }
                                            $sql_sumyear = "SELECT year FROM `t_bl_inicial` where idt_bl_inicial='" . $maxbalancedato . "'";
                                            $data = mysqli_query($c, $sql_sumyear);
                                            $resdata = mysqli_fetch_assoc($data);
                                            $yearactual = $resdata['year'] + 1;
                                            ?>
                                            <input type="text"  readonly="readonly" class="form-control" name="yearsiguiente" id="yearsiguiente" value="El periodo a crear es :<?php echo $yearactual; ?>"/>
                                            <?Php
                                            $sql_carganuevobalance = "
SELECT v.fecha AS f, v.cod_cuenta AS codcuenta, p.nombre_cuenta_plan AS cuenta, v.tipo AS grupo, v.sum_deudor, v.sum_acreedor
FROM hoja_de_trabajo v
JOIN t_grupo g
JOIN t_plan_de_cuentas p
WHERE v.`tipo` = g.cod_grupo
AND p.cod_cuenta = v.cod_cuenta
AND v.year = '" . $year . "'
AND v.t_bl_inicial_idt_bl_inicial = '" . $maxbalancedato . "'
ORDER BY tipo";
                                            ?>

                                            <center>
                                                <table class="table table-striped table-bordered table-hover">
                                                    <tr>
                                                        <td>Fecha</td>
                                                        <td>Codigo</td>
                                                        <td>Cuenta</td>
                                                        <td>Debe</td>
                                                        <td>Haber</td>
                                                    </tr>
                                                    <?Php
                                                    $resul1 = mysqli_query($c, $sql_carganuevobalance);
                                                    while ($r2 = mysqli_fetch_array($resul1)) {
                                                        echo '<tr>';
                                                        echo '<td><div class="col-xs-7 form-group has-success">
                                                            <input readonly="readonly" class="form-control info" type="text" name="campo1[]" id="fecha" value=' . $date . '>
                                                        </div></td>';
//                                                        echo '<td><input readonly="readonly" class="form-control info" type="text" name="campo1[]" id="fecha" value=' . $date . '></td>';
                                                        echo '<td><div class="col-xs-7 form-group has-success">
                                                        <input readonly="readonly" class="form-control info" type="text" name="campo2[]" id="cod" value=' . $r2['codcuenta'] . '>
                                                        </div></td>';
//                                                        echo '<td><input readonly="readonly" class="form-control info" type="text" name="campo2[]" id="cod" value=' . $r2['codcuenta'] . '></td>';
                                                        echo '<td><div class="col-xs-14 form-group has-success">
                                                            <input type="text" readonly="readonly" class="form-control info" name="campo3[]" id="cuenta" value="' . $r2['cuenta'] . '">
                                                        </div></td>';
//                                                        echo '<td>';
//                                                        echo '<input type="text" readonly="readonly" class="form-control info" name="campo3[]" id="cuenta" style="width: 220px;" value="' . $r2['cuenta'] . '">';
//                                                        echo '</td>';
                                                        echo '<td><div class="col-xs-8 form-group has-success">
                                                            <input readonly="readonly" class="form-control info" type="text" name="campo4[]" id="deb" value=' . $r2['sum_deudor'] . '>
                                                        </div></td>';
//                                                        echo '<td><input readonly="readonly" class="form-control info" type="text" name="campo4[]" id="deb" value=' . $r2['sum_deudor'] . '></td>';
                                                        echo '<td><div class="col-xs-8 form-group has-success">
                                                            <input readonly="readonly" class="form-control info" type="text" name="campo5[]" id="hab" value=' . $r2['sum_acreedor'] . '>
                                                        </div></td>';
                                                        
//                                                        echo '<td><input readonly="readonly" class="form-control info" type="text" name="campo5[]" id="hab" value=' . $r2['sum_acreedor'] . '></td>';
                                                        echo '<td style="display:none"><input readonly="readonly" class="form-control info" type="text" name="campo6[]" id="tipo" value=' . $r2['grupo'] . '></td>';
                                                        echo '</tr>';
                                                    }
                                                    $c->close();
                                                    ?>

                                                    <tr>
                                                        <th colspan="6"> Concepto :
                                                            <textarea class="form-control" id="textarea_asnew" name="textarea_asnew" rows="1" cols="30">Balance actual a la fecha <?php echo $date; ?> por cierre de periodo <?php echo $year; ?>...
                                                            </textarea>
                                                        </th>
                                                    </tr>
                                                </table>
                                            </center>


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
