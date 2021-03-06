<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
if (!$_SESSION) {
    echo '<script language = javascript>
    alert("usuario no autenticado")
    self.location = "../../../../login.php"
</script>';
}
//CARGANDO PAG//
echo "<script>jsShowWindowLoad('Cargando...');</script>";
//rutas
include '../../../Clases/acentos.php';

$carpeta = '../../../';
require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$conn = $dbi->conexion();
$idlogeobl = $_SESSION['id_user'];
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];
$date = date("Y-m-d");
include '../../Clases/guardahistorial.php';
$accion = "/ contabilidad / Estado de resultados / Visualizó el estado de resultados";
generaLogs($user, $accion);
$mes = date('F');
$year = date('Y');
$uno = "0";
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

    <!--Cargando-->    
    <script src="../../../../js/load_only.js"></script>

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
    <!--onload="jsShowWindowLoad('Cargando...');"-->
<!--<div id="imgLOAD" style="text-align:center;">
<b>Cargando...</b>
<img src="URL de la imagen" />
</div>-->
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
                            <form name="BalancedeComprobacion" id="BalancedeComprobacion" action="cont_stfnl.php" method="post">

                                <script>
                                    function cierredeperiodo()
                                    {
                                        var answer = confirm("Desea realizar el cierre del periodo y generar el nuevo periodo");
                                        if (answer) {
                                            var miVariableJS = $("#texto").val();
                                            if (miVariableJS == 0)
                                            {
                                                alert("El periodo ya esta cerrado");
                                            }
                                            else {
                                                $.post("cierraperiodo.php", {"texto": miVariableJS},
                                                    function (respuesta) {
                                                        document.getElementById('texto').value = respuesta;
                                                        alert(respuesta);
                                                        creartabla();
                                                    });
                                            }
                                        } else {
                                            alert("El cierre del periodo se ha cancelado...");
                                        }

                                    }

                                    function creartabla()
                                    {
                                        var paginanuevobalance = "cont_new_bl.php";
                                        location.href = paginanuevobalance;

                                    }
                                </script>    
                                <center>
                                    <?php
                                    $c = $dbi->conexion();
                                    $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
                                    $result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($c), E_USER_ERROR);
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $maxbalancedato = $row['id'];
                                        }
                                    }
                                    $c->close();
                                    ?>
                                    <link rel="stylesheet" type="text/css" href="../../../../datepicker/jquery.datetimepicker.css"/>
                                    <script src="../../../../datepicker/jquery.js"></script>
                                    <script src="../../../../datepicker/jquery.datetimepicker.full.js"></script>

                                    <div style="float: left;" class="menu"> 

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h1 class="page-header">Estado de Resultados</h1>
                                            </div>
                                            <!-- /.col-lg-12 -->
                                        </div>
                                        <!-- /.row -->
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="panel panel-success">
                                                    <div class="panel-heading">
                                                        Filtrar por fecha
                                                    </div>
                                                    <div class="panel-body">
                                                        <p>
                                                            <input type="text" autocomplete="off" placeholder="Fecha desde" class="form-control" id="datetimepicker1min" name="datetimepicker1min" value=""/>
                                                            <script>
                                                                jQuery.datetimepicker.setLocale('es');
                                                                jQuery('#datetimepicker1min').datetimepicker({
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
                                                                });
                                                            </script>

                                                            <!--<label>Hasta :</label>-->
                                                            <input type="text" autocomplete="off" placeholder="Fecha hasta" class="form-control" id="datetimepicker1max" name="datetimepicker1max" value=""/>
                                                            <script>
                                                                jQuery.datetimepicker.setLocale('es');
                                                                jQuery('#datetimepicker1max').datetimepicker({
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
                                                                });
                                                            </script>
                                                            <br>
                                                            <div class="form-group">
                                                                <button type="submit" onclick="return cvereficarvalores(this)" class="btn btn-success" id="submit" name="submit" value="periodos">BUSCAR</button>
                                                                <script>

                                                                    function cvereficarvalores() {

                                                                        if (document.BalancedeComprobacion.datetimepicker1min.value.length == 0) {
                                                                            alert("Seleccione desde que fecha buscar");
                                                                            document.BalancedeComprobacion.datetimepicker1min.focus();
                                                                            return false;
                                                                        }

                                                                        if (document.BalancedeComprobacion.datetimepicker1max.value.length == 0) {
                                                                            alert("Seleccione hasta que fecha buscar");
                                                                            document.BalancedeComprobacion.datetimepicker1max.focus();
                                                                            return false;
                                                                        }
                                                                        document.BalancedeComprobacion.submit();
                                                                        return true;

                                                                    }

                                                                    function cvereficarmes() {

                                                                    }

                                                                </script>
                                                            </div>
                                                        </p>
                                                    </div>
                                                    <div class="panel-footer">

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.col-lg-4 -->
                                            <div class="col-lg-4">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Buscar por mes
                                                    </div>
                                                    <div class="panel-body">
                                                        <p>
                                                            <div class="col-xs-8 form-group">  
                                                                <div class="form-group">
                                                                    <select class="form-control" id="opciones" name="opciones">
                                                                        <?php
                                                                        $c = $dbi->conexion();
                                                                        $q_mes = "SELECT * FROM `mes` ORDER BY `mes_id` desc ";
                                                                        $res_mes = mysqli_query($c, $q_mes);
                                                                        while ($dt_mes = mysqli_fetch_array($res_mes)) {
                                                                            $id_m = $dt_mes['mes_id'];
                                                                            echo "<option value='" . $dt_mes['mes_id'] . '-' . $dt_mes['mes'] . "' >";
                                                                            echo $dt_id['mes_id'] . '      ' . utf8_decode($dt_mes['mes']);
                                                                            echo '</option>';
                                                                        }mysqli_close($c);
                                                                        ?>
                                                                    </select> 
                                                                </div>
                                                                <div class="form-group">
                                                                    <button type="submit" onclick="return cvereficarmes(this)" class="btn btn-default" id="submit" name="submit" value="BUSCAR">BUSCAR</button>
                                                                </div>
                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-default" id="submit" name="submit" value="todo">Hasta la fecha</button>
                                                                </div>
                                                            </div>
                                                        </p>
                                                    </div>
                                                    <div class="panel-footer">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.col-lg-4 -->
                                            <div class="col-lg-4">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading">
                                                        Acciónes
                                                    </div>
                                                    <div class="panel-body">
                                                        <p>
                                                            <div class="col-xs-8 form-group-sm">
                                                                <div class="form-group">
                                                                    <button type="button" title="IMPRIMIR TODO EL ESTADO DE RESULTADOS" id="imp" name="imp" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_blresUtil(<?Php echo $idlogeobl; ?>)"></button>
                                                                    <br>
                                                                </div>
                                                            </div> 
                                                            <div class="col-xs-8 form-group">
                                                                <div class="form-group">
                                                                    <?php
                                                                    $c = $dbi->conexion();
                                                                    $muestraboton = "SELECT `estado` FROM `t_bl_inicial` WHERE year='" . $year . "' and idt_bl_inicial='" . $maxbalancedato . "'";
                                                                    $res = mysqli_query($c, $muestraboton);
                                                                    while ($data = mysqli_fetch_array($res)) {
                                                                        $estado = $data['estado'];
                                                                        if ($data['estado'] == "1") {
                                                                            ?>
                                                                            <input type="button" name="cierrecontabilidad" onclick="cierredeperiodo();" id="cierrecontabilidad" class="btn btn-outline btn-info glyphicon glyphicon-print" value="Cierre de Periodo"/>
                                                                            <?php
                                                                        } else {
                                                                            echo "<input type='button' name='cierrecontabilidad' id='cierrecontabilidad' class='btn btn-outline btn-info glyphicon glyphicon-print' disabled='true' value='Cierre de Periodo'/>";
                                                                        }
                                                                    }
                                                                    $c->close();
                                                                    ?>  
                                                                </div>
                                                            </div> 
                                                        </p>
                                                    </div>
                                                    <div class="panel-footer">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.col-lg-4 -->
                                        </div>



                                    </div>  


                                    <?Php
                                    if (isset($_POST["submit"])) {
                                        $btntu = $_POST["submit"];
                                        if ($btntu == "BUSCAR") {
                                            $opciones = htmlspecialchars(trim($_POST['opciones']));
//                                                    echo '<script>alert('.$opciones.')</script>';
                                            $uno = strstr($opciones, '-', true);
                                            $dos = substr(strstr($opciones, '-'), 1);
//                                                    echo '<script>alert("' . $dos . '")</script>';
                                            ?>


                                            <input type="hidden" value="<?php echo $maxbalancedato; ?>" id="texto"/>
                                            <input type="hidden" value="<?php echo $uno; ?>" id="mes"/>

                                            <div class="mensaje"></div>
                                            <input type="hidden" value="<?php echo $estado; ?>"/>
                                            <?Php
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
                                            echo '<table width="100%" class="table table-striped table-bordered table-hover">';

                                            echo "<br>";
                                            echo '<tr>';
                                            echo "<th colspan='3'> $cod_clasesq    $nom_clase  ";
                                            echo " <h3>Por el mes de ";
                                            echo translateMonth($dos);
                                            echo " del ";
                                            echo $year;
                                            echo "</h3>";
                                            echo '</th>';
                                            echo '<td style="display:none"></td>';
                                            echo '<td style="display:none"></td>';
                                            echo '<td style="display:none"></td>';
                                            echo '</tr>';


//                                           SQL INGRESOS and mes<='8'
                                            $select_ct = "SELECT codigo,cuenta,total FROM estadoresultados where codigo between '4.' and '4.99.99.99.' and mes='" . $uno . "' ORDER BY codigo ASC";
                                            $resulgrupos = mysqli_query($conn, $select_ct)or trigger_error("Query Failed! SQL: $select_ct - Error: " . mysqli_error($mysqli), E_USER_ERROR);

//                                           SQL COSTOS Y GASTOS
                                            $select_cg = "SELECT codigo,cuenta,total FROM estadoresultados where codigo between '5.' and '5.99.99.99.' and mes='" . $uno . "' ORDER BY codigo ASC";
                                            $resulgruposcg = mysqli_query($conn, $select_cg)or trigger_error("Query Failed! SQL: $select_cg - Error: " . mysqli_error($mysqli), E_USER_ERROR);

                                            $datosIngreso = array();
                                            while ($row2 = mysqli_fetch_array($resulgrupos)) {
                                                $numIng = mysqli_num_rows($resulgrupos);
                                                if (!empty($numIng)) {
                                                    $str = strlen($row2['codigo']);
                                                    echo '<tr>
                                                    <td>' . $row2['codigo'] . '</td>
                                                    <td>' . $row2['cuenta'] . '</td>';
                                                    if ($str == 2) {
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td>' . number_format($row2['total'], 2, '.', '') . '</td>';

                                                        for ($i = 0; $i <= count($numIng); $i++) {
                                                            $datosIngreso[] = $row2['total'];
                                                        }
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
                                                } else {
                                                    echo '<script>alert("NO HAY INGRESOS")</script>';
                                                }



//echo "<script>alert('".$numIng."')</script>";
                                            }
                                            $datosGastos = array();
                                            while ($row3 = mysqli_fetch_array($resulgruposcg)) {
                                                $numGas = mysqli_num_rows($resulgruposcg);
                                                if (!empty($numGas)) {
                                                    $str = strlen($row3['codigo']);
                                                    echo '<tr>
                                                    <td>' . $row3['codigo'] . '</td>
                                                    <td>' . $row3['cuenta'] . '</td>';
                                                    if ($str == 2) {
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td>' . number_format($row3['total'], 2, '.', '') . '</td>';
                                                        for ($j = 0; $j <= count($numGas); $j++) {
                                                            $datosGastos[] = $row3['total'];
                                                        }
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
                                                } else {
                                                    echo '<script>alert("NO HAY GASTOS")</script>';
                                                }
                                            }

                                            $utilidad = $datosIngreso[0] - $datosGastos[0];

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
                                        }
                                        if ($btntu == "todo") {
                                            include_once './tab_my/statusresultall.php';
                                        }
                                        if ($btntu == "periodos") {
                                            $datetimepickermin = $_POST['datetimepicker1min'];
                                            $datetimepickermax = $_POST['datetimepicker1max'];
                                            require '../../Clases/filtroestadoresultados.php';
                                            $objFilEstRes = new filtroestadoresultados();
                                            $objFilEstRes->filtroporperiodos($datetimepickermin, $datetimepickermax, $dbi);
                                        }
                                    } else {
                                        require('./tab_my/statusresultall.php');
                                    }
                                    ?>
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
<style>
    #WindowLoad
    {
        position:fixed;
        top:0px;
        left:0px;
        z-index:3200;
        filter:alpha(opacity=65);   
        -moz-opacity:65;   
        opacity:0.65;
        background:#999;
    }
</style>
</body>

</html>
