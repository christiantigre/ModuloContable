<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
include '../../../Clases/acentos.php'; 
if (!$_SESSION) {
        echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../login.php"
</script>';
    }
//rutas
$carpeta = '../../../';
require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$conn = $dbi->conexion();
$idlogeobl = $_SESSION['id_user'];
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];
$date = date("Y-m-d");
$dia = date("d");
$mes = date("month");

include '../../Clases/guardahistorial.php';
$accion = "/ CONTABILIDAD / Estado de resultados / Visualizó estado de resultados";
generaLogs($user, $accion);
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
                        $objClase->view_logcontabilidad();
                        ?>

                    </a>
                </div>
                <!-- /.navbar-header -->
                <?PHP
                require('../../../../templates/Clases/menus.php');
                $objMenu = new menus();
                $objMenu->menu_header($carpeta, $user, $id);
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
                                Estado de Resultados
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form name="Estadoderesultados" id="Estadoderesultados" action="cont_EstResultUtil.php" method="post">
                                        <center>
                                            <h1>Estado de Resultados</h1>                  
                                            <h3>Al <?php echo $dia ?> de <?php echo translateMonth($mes) ?> del <?php echo $year ?></h3>
                                            <div style="float: left;" class="menu"> 
                                                <!--<ul class="nav" id="nav">-->
                                                    <!--<a href="ajustesasientos.php" title="AJUSTES" class="glyphicon glyphicon-text-background"><i class=" btn btn-outline btn-info glyphicon glyphicon-edit"></i></a>-->
                                                <button type="submit" title="IMPRIMIR" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_blresUtil(<?Php echo $idlogeobl; ?>)"></button>
                                                <!--</ul>-->
                                            </div>
                                            <div class="mensaje"></div>
                                            <!--carga de el balance de resultados por grupos-->
                                            <?php
                                            $sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
                                            $resul_param = $conn->query($sqlparametro);
                                            if ($resul_param->num_rows > 0) {
                                                while ($clase_param = $resul_param->fetch_assoc()) {
                                                    $parametro_contador = $clase_param['cont'];
                                                }
                                            } else {
                                                echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
                                            }

                                            echo '<table width="100%" class="table table-striped table-bordered table-hover">';
                                            echo "<br>";
                                            echo '<tr>';
                                            echo '<th colspan="3">' . $cod_clasesq . ' ' . $nom_clase . '</th>';
                                            echo '<td style="display:none"></td>';
                                            echo '<td style="display:none"></td>';
                                            echo '<td style="display:none"></td>';
                                            echo '</tr>';

          
//                                           SQL INGRESOS
                                            $select_ct = "SELECT codigo,cuenta,total FROM estadoresultados where codigo between '4.' and '4.99.99.99.' ORDER BY codigo ASC";
                                            $resulgrupos = mysqli_query($conn, $select_ct)or trigger_error("Query Failed! SQL: $select_ct - Error: " . mysqli_error($mysqli), E_USER_ERROR);

//                                           SQL COSTOS Y GASTOS
                                            $select_cg = "SELECT codigo,cuenta,total FROM estadoresultados where codigo between '5.' and '5.99.99.99.' ORDER BY codigo ASC";
                                            $resulgruposcg = mysqli_query($conn, $select_cg)or trigger_error("Query Failed! SQL: $select_cg - Error: " . mysqli_error($mysqli), E_USER_ERROR);

                                            $sql_utl = 'Select (Select Sum(total) From estadoresultados where codigo="4.") - (Select Sum(total) From estadoresultados where codigo="5.") Total';
                                            $resulsumas = mysqli_query($conn, $sql_utl)or trigger_error("Query Failed! SQL: $sql_utl - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                            $rows = mysqli_fetch_array($resulsumas);
                                            $utilidad = $rows['Total'];

                                            while ($row2 = mysqli_fetch_array($resulgrupos)) {
                                                $str = strlen($row2['codigo']);
                                                echo '<tr>
                                                        <td>' . $row2['codigo'] . '</td>
                                                        <td>' . $row2['cuenta'] . '</td>';
                                                if ($str == 2) {
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                                                } elseif ($str == 4) {
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                                                    echo '<td></td>';
                                                } elseif ($str == 6) {
                                                    echo '<td></td>';
                                                    echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                } elseif ($str == 8) {
                                                    echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                }
                                                echo '</tr>';
                                            }

                                            while ($row3 = mysqli_fetch_array($resulgruposcg)) {
                                                $str = strlen($row3['codigo']);
                                                echo '<tr>
                                                        <td>' . $row3['codigo'] . '</td>
                                                        <td>' . $row3['cuenta'] . '</td>';
                                                if ($str == 2) {
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td>' . number_format($row3['total'], 2, '.', '') . '</td>';
                                                } elseif ($str == 4) {
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td>' . number_format($row3['total'], 2, '.', '') . '</td>';
                                                    echo '<td></td>';
                                                } elseif ($str == 6) {
                                                    echo '<td></td>';
                                                    echo '<td>' . number_format($row3['total'], 2, '.', '') . '</td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                } elseif ($str == 8) {
                                                    echo '<td>' . number_format($row3['total'], 2, '.', '') . '</td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                }
                                                echo '</tr>';
                                            }
                                                
                                            if (isset($utilidad)) {
                                                $utilidad = $utilidad;
                                            } else {
                                                $utilidad = '0.00';
                                            }
                                            echo '<tr>'
                                            . '<td></td>'
                                            . '<td>UTILIDAD</td>'
                                            . '<td></td>'
                                            . '<td></td>'
                                            . '<td></td>'
                                            . '<td>' .
                                            number_format($utilidad, 2, '.', '') . '</td>'
                                            . '</tr>';
                                            echo '</table>';
                                            ?>
                                            <!--fin carga de el balance de resultados por grupos-->


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
        <script src="js/jslevel.js"></script>
        <script src="../../../../js/script.js"></script>
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
