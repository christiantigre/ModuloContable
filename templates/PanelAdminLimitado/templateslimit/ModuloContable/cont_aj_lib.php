<?php
date_default_timezone_set("America/Guayaquil");
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
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
$idlogeobl = $_SESSION['id_user'];
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];
$date = date("Y-m-d");
include '../../Clases/guardahistorial.php';
$accion = "/ CONTABILIDAD / Ajustes / Ingreso en asientos de ajustes";
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
                                Asientos de Ajuste
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form name="form_ejercicio" role="form" id="form_ejercicio" method="post" action="cont_aj_lib.php">
                                        <a href="cont_aj_ass.php"><i class="btn btn-success glyphicon glyphicon-plus"></i></a>
                                    
                                        <fieldset>
                                            <div id="contbajustes">
                                                <?Php
                                                $year = date("Y");
                                                $sqlbuscagrupos = "SELECT `idnum_asientos_ajustes` AS id, `t_ejercicio_idt_corrientes` ej, `concepto` c, fecha AS f,
                                                    saldodebe AS sald, saldohaber AS salh
FROM `num_asientos_ajustes`
WHERE t_bl_inicial_idt_bl_inicial = '" . $idcod . "'
AND year = '" . $year . "'
ORDER BY `t_ejercicio_idt_corrientes`";
                                                $result_grupo = mysqli_query($c, $sqlbuscagrupos) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                                echo '<center>';
                                                echo '<table class="table table-striped table-bordered table-hover">';
                                                echo '<tr>';
                                                echo '<td style="display:none">id</td>';
                                                echo '<td >Fecha</td>';
                                                echo '<td >Codigo</td>';
                                                echo '<td >Cuenta</td>';
                                                echo '<td >Debe</td>';
                                                echo '<td >Haber</td>';
                                                echo '</tr>'; //eje
                                                while ($rw = mysqli_fetch_assoc($result_grupo)) {
                                                    $idasiento = $rw['id']; //echo "<script>alert('".$nombre_grupo."')</script>";
                                                    $nombre_grupo = $rw['c']; //echo "<script>alert('".$nombre_grupo."')</script>";
                                                    $codgrupo = $rw['ej']; //echo "<script>alert('".$nombre_grupo."')</script>";
                                                    $fecha = $rw['f'];
                                                    $saldodb = $rw['sald'];
                                                    $saldohb = $rw['salh'];
                                                    echo '<table class="table table-striped table-bordered table-hover">';
                                                    echo '<tr><th colspan="5" style="text-align: center;vertical-align: middle;"> Ref : ' . $codgrupo;
//                                                    echo '<a href="impresiones/impajustedetall.php?id_asientourl=' . $idasiento . '&fechaurl=' . $fecha . '&idlogeo=' . $idlogeobl . '">'
//                                                    . '<img src="./images/print.png" alt="Imprimir Detalle" title="Imprimir Detalle" /> </a>';
                                                    list($year,$month,$dia) = explode("-",$fecha);
                                                    ?>
                                                
                                                <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-outline btn-info glyphicon glyphicon-eye-open" onclick="detall_asin_ajustes(<?Php echo $codgrupo; ?>,<?Php echo $year; ?>,<?Php echo $month; ?>,<?Php echo $dia; ?>);"></button>
                                                <button type="submit" title="IMPRIMIR ASIENTO" class="btn btn-outline btn-info glyphicon glyphicon-print" onclick="imp_ajs(<?Php echo $codgrupo; ?>,<?Php echo $year; ?>,<?Php echo $month; ?>,<?Php echo $dia; ?>,<?Php echo $idlogeobl; ?>)"></button>
                        
                                                <?Php
                                                    echo '</th>'
                                                    . '</tr>';
                                                    echo '<input name="valor" type="hidden" id="valor" value="';
                                                    echo $codgrupo;
                                                    echo '"/>';

                                                    $n = 0;
                                                    $sql_cuentasgrupos = "SELECT `ejercicio` , `idajustesejercicio` , `fecha` , `cod_cuenta` , `cuenta` ,
                                                `valor` AS debe, `valorp` AS haber, `t_bl_inicial_idt_bl_inicial` , tipo,`logeo_idlogeo`,`year`
                                                    FROM `ajustesejercicio` WHERE  `t_bl_inicial_idt_bl_inicial` = '" . $idcod . "' AND `ejercicio` =" . $codgrupo . " and year='" . $year . "'
                                                ORDER BY ejercicio";

                                                    $sql_sumasdeajusteasiento = "SELECT sum(`valor`) AS debe, sum(`valorp`) AS haber
                                            FROM `ajustesejercicio` WHERE  `t_bl_inicial_idt_bl_inicial` = '" . $idcod . "'"
                                                            . " AND `ejercicio` =" . $codgrupo . " and year='" . $year . "' ";
                                                    $resulsumasdeasientoajuste = mysqli_query($c, $sql_sumasdeajusteasiento);
                                                    while ($row1 = mysqli_fetch_assoc($resulsumasdeasientoajuste)) {
                                                        $debeaj = $row1['debe'];
                                                        $haberaj = $row1['haber'];
                                                    }


                                                    $result2 = mysqli_query($c, $sql_cuentasgrupos);
                                                    while ($r2 = mysqli_fetch_array($result2)) {
                                                        echo '<tr>';
                                                        echo '<td  style="display:none">  ' . $r2['dajustesejercicio'] . '   </td>';
                                                        echo '<td >  ' . $r2['fecha'] . '   </td>';
                                                        echo '<td >  ' . $r2['cod_cuenta'] . '   </td>';
                                                        echo '<td >  ' . $r2['cuenta'] . '   </td>';
                                                        echo '<td >  ' . $r2['debe'] . '   </td>';
                                                        echo '<td >  ' . $r2['haber'] . '   </td>';
                                                        echo '</tr>';
                                                    }
                                                    echo '<tr>';
                                                    echo '<th colspan="6" > Concepto :'
                                                    . '<textarea class="form-control" id="textarea_as" name="textarea_as" rows="1" cols="30">' . $nombre_grupo . '</textarea></th>';
                                                    //echo '' . $nombre_grupo . '';
                                                    echo '</tr>';
                                                    echo '<tr>';
                                                    echo '<th>';
                                                    echo '<td><label>Suma :</label></td>';
                                                    ?>
                                                    <td>
                                                        <div class="col-xs-8 form-group has-success">
                                                            <input type="text"  class="form-control info" readonly="readonly" required="required" name="tdebe" id="tdebe" value="<?php echo $debeaj ?>" placeholder="0.00" />
                                                        </div>
                                                    </td> 
                                                    <td>
                                                        <div class="col-xs-8 form-group has-success">
                                                            <input type="text"  class="form-control info" readonly="readonly" required="required" name="tdebe" id="tdebe" value="<?php echo $haberaj ?>" placeholder="0.00" />
                                                        </div>
                                                    </td> 
                                                    <?Php
                                                    echo '</th>';
                                                    echo '</tr>';
                                                    echo '</table>';
                                                    $n++;
                                                }

                                                echo '</table>';
                                                echo '</center>';
                                                ?>

                                                <!--Final Tabla de asiento por ajustar-->


                                            </div> 
                                        </fieldset>


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
                        <h4 class="modal-title" id="myModalLabel">DETALLE DE ASIENTOS DE AJUSTE</h4>
                    </div>
                    <div class="modal-body" id="caja">

                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
