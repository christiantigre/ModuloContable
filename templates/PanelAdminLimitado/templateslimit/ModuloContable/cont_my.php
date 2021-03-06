<?php
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
$accion = "/ CONTABILIDAD / Mayorizacion / Ingreso a mayorización";
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


$valores = "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, "
        . "sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,"
        . "sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sld_deudor,"
        . "sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as sld_acreedor FROM vistabalanceresultadosajustados WHERE "
        . "`t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "'";
$res_valores = mysqli_query($c, $valores);
while ($resultb = mysqli_fetch_assoc($res_valores)) {
    $Tdebe = $resultb['debe'];
    $Thaber = $resultb['haber'];
    $Sdeudor = $resultb['sld_deudor'];
    $Sacreedor = $resultb['sld_acreedor'];
    $Tdebe = number_format($Tdebe, 2, '.', '');
    $Thaber = number_format($Thaber, 2, '.', '');
    $Sdeudor = number_format($Sdeudor, 2, '.', '');
    $Sacreedor = number_format($Sacreedor, 2, '.', '');
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

        <!--<link href="../../../../css/plugins/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
        <link href="../../../../css/plugins/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

        <script src="../../../../js/plugins/jquery-1.12.3.js"></script>
        <script src="../../../../js/plugins/jquery.dataTables.min.js"></script>
        <script src="../../../../js/plugins/dataTables.buttons.min.js"></script>
        <script src="../../../../js/plugins/buttons.flash.min.js"></script>
        <script src="../../../../js/plugins/jszip.min.js"></script>
        <script src="../../../../js/plugins/pdfmake.min.js"></script>
        <script src="../../../../js/plugins/vfs_fonts.js"></script>
        <script src="../../../../js/plugins/buttons.html5.min.js"></script>
        <script src="../../../../js/plugins/buttons.print.min.js"></script>-->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!--<script>
            $(document).ready(function () {
                $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            });
        </script>-->

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
                                Mayorizaci&oacute;n de cuentas
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form id="formulariodetalles" name="formulariodetalles" method="post" action="cont_my.php">
                                        <!-- /.row -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Busquedas
                                                    </div>
                                                    <!-- .panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="panel-group" id="accordion">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Por Cuentas</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseOne" class="panel-collapse collapse"> <!--panel-collapse collapse in-->
                                                                    <div class="panel-body">
                                                                        <table class="table table-hover">
                                                                            <tr>
                                                                                <td>
                                                                                    <label>Buscar cuenta :</label>
                                                                                </td>
                                                                                <td>
                                                                                    <datalist id="cuenta">
                                                                                        <?php
                                                                                        $query = "SELECT DISTINCT (cuenta) AS dif_cuentas, cod_cuenta as cod FROM vistabalanceresultadosajustados WHERE `t_bl_inicial_idt_bl_inicial` ='" . $idcod . "'";
                                                                                        $resul1 = mysqli_query($c, $query);
                                                                                        while ($dato1 = mysqli_fetch_array($resul1)) {
                                                                                            $cod1 = $dato1['cod_cauxiliar'];
                                                                                            echo "<option value='" . $dato1['cod'] . "' >";
                                                                                            echo $dato1['cod'] . '      ' . utf8_decode($dato1['dif_cuentas']);
                                                                                            echo '</option>';
                                                                                        }
//                                                        mysqli_close($c);
                                                                                        ?>
                                                                                    </datalist>
                                                                                    <div class="form-group">
                                                                                        <input autocomplete="off" type="text" list="cuenta" id="cta" name="cta" class="form-control">
                                                                                    </div>
                                                                                </td>
                                                                                <td> <input id="submit" class="btn btn-success" name="submit" type="submit" value="Detalle"/>
                                                                                    <input id="submit" class="btn btn-default" name="submit" type="submit" value="-"/> </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>
                                                                                    <label>Cuentas Utilizadas</label>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                    $c = $dbi->conexion();
                                                                                    $SQLtipobaldh = "SELECT DISTINCT (cuenta) AS dif_cuentas, cod_cuenta as cod FROM vistabalanceresultadosajustados WHERE `t_bl_inicial_idt_bl_inicial` ='" . $idcod . "'";
                                                                                    $query_tipo_bldh = mysqli_query($c, $SQLtipobaldh);
                                                                                    ?>
                                                                                    <select name="tip_cuentadh" id="tip_cuentadh" class='form-control' size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo()
                                                                                                    ;"><!--generar_codigo_grupo()-->
                                                                                                <?php
                                                                                                while ($arreglot_cuendh = mysqli_fetch_array($query_tipo_bldh)) {
                                                                                                    if ($_POST['tip_cuentadh'] == $arreglot_cuendh['cod']) {
                                                                                                        echo "<option value='" . $arreglot_cuendh['cod'] . "' selected>&nbsp;&nbsp;" . utf8_encode($arreglot_cuendh['dif_cuentas']) . "</option>";
                                                                                                    } else {
                                                                                                        ?>
                                                                                                <option class="text" value="<?php echo $arreglot_cuendh['cod'] ?>">
                                                                                                    <?php echo $arreglot_cuendh['dif_cuentas'] ?></option>     
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                                <td> <input id="submit" class="btn btn-success" name="submit" type="submit" value="Detalle por cuenta"/>
                                                                                    <input id="submit" class="btn btn-default" name="submit" type="submit" value="-"/> </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Por Períodos</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseTwo" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        <!--cuenta-->
                                                                        <tr>
                                                                            <td><label>Por Fechas :</label></td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <label>Desde :</label>
                                                                                    <input autocomplete="off" type="text" class="form-control" id="datetimepicker" name="datetimepicker" value="" width="10"/>
                                                                                    <link rel="stylesheet" type="text/css" href="../../../../datepicker/jquery.datetimepicker.css"/>
                                                                                    <script src="../../../../datepicker/jquery.js"></script>
                                                                                    <script src="../../../../datepicker/jquery.datetimepicker.full.js"></script>
                                                                                    <script>
                                                                                        jQuery.datetimepicker.setLocale('es');
                                                                                        jQuery('#datetimepicker').datetimepicker({
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



                                                                                <div class="form-group">
                                                                                    <label>Hasta :</label>
                                                                                    <input autocomplete="off" type="text" class="form-control" id="datetimepicker1" name="datetimepicker1" value="" width="65"/>
                                                                                    <!--                                                        <link rel="stylesheet" type="text/css" href="../../../../datepicker/jquery.datetimepicker.css"/>
                                                                                                                                            <script src="../../../../datepicker/jquery.js"></script>-->
                                                                                                                                            <!--<script src="../../../../datepicker/jquery.datetimepicker.full.js"></script>-->
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
                                                                                <input id="submit" class="btn btn-success" name="submit" type="submit" value="Buscar"/>
                                                                                <input id="submit" class="btn btn-default" name="submit" type="submit" value="-"/>    
                                                                                <!--<input id="submit" class="btn btn-success" name="submit" type="submit" value="Fecha - Cuenta"/>-->
                                                                            </td>


                                                                        </tr>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Filtrar Período y Cuenta</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseThree" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        Filtar peíodo y cuenta
                                                                        <tr>
                                                                        <br>
                                                                        <td>
                                                                            <label>Cuenta :</label>
                                                                        </td>
                                                                        <td>
                                                                            <datalist id="cuenta">
                                                                                <?php
                                                                                $query = "SELECT DISTINCT (cuenta) AS dif_cuentas, cod_cuenta as cod FROM vistabalanceresultadosajustados WHERE `t_bl_inicial_idt_bl_inicial` ='" . $idcod . "'";
                                                                                $resul1 = mysqli_query($c, $query);
                                                                                while ($dato1 = mysqli_fetch_array($resul1)) {
                                                                                    $cod1 = $dato1['cod_cauxiliar'];
                                                                                    echo "<option value='" . $dato1['cod'] . "' >";
                                                                                    echo $dato1['cod'] . '      ' . utf8_decode($dato1['dif_cuentas']);
                                                                                    echo '</option>';
                                                                                }
//                                                        mysqli_close($c);
                                                                                ?>
                                                                            </datalist>
                                                                            <div class="form-group">
                                                                                <input autocomplete="off" type="text" list="cuenta" id="ctapp" name="ctapp" class="form-control">
                                                                            </div>
                                                                        </td>
                                                                        </tr>
                                                                        <!--cuenta-->
                                                                        <tr>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <label>Desde :</label>
                                                                                    <input autocomplete="off" type="text" class="form-control" id="datetimepickerpd" name="datetimepickerpd" value="" width="10"/>
                                                                                    <!--                                                        <link rel="stylesheet" type="text/css" href="../../../../datepicker/jquery.datetimepicker.css"/>
                                                                                                                                            <script src="../../../../datepicker/jquery.js"></script>
                                                                                                                                            <script src="../../../../datepicker/jquery.datetimepicker.full.js"></script>-->
                                                                                    <script>
                                                                                        jQuery.datetimepicker.setLocale('es');
                                                                                        jQuery('#datetimepickerpd').datetimepicker({
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



                                                                                <div class="form-group">
                                                                                    <label>Hasta :</label>
                                                                                    <input autocomplete="off" type="text" class="form-control" id="datetimepicker1ph" name="datetimepicker1ph" value="" width="65"/>
                                                                                    <!--                                                        <link rel="stylesheet" type="text/css" href="../../../../datepicker/jquery.datetimepicker.css"/>
                                                                                                                                            <script src="../../../../datepicker/jquery.js"></script>
                                                                                                                                            <script src="../../../../datepicker/jquery.datetimepicker.full.js"></script>-->
                                                                                    <script>
                                                                                        jQuery.datetimepicker.setLocale('es');
                                                                                        jQuery('#datetimepicker1ph').datetimepicker({
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
                                                                                <input id="submit" class="btn btn-success" name="submit" type="submit" value="FILTRO"/>
                                                                                <input id="submit" class="btn btn-default" name="submit" type="submit" value="-"/>    
                                                                                <!--<input id="submit" class="btn btn-success" name="submit" type="submit" value="Fecha - Cuenta"/>-->
                                                                            </td>


                                                                        </tr>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <!-- /.col-lg-12 -->
                                        </div>
                                        <!-- /.row -->


                                        <!--<table class="table table-hover">-->   


                                            <!--<tr>-->                  

                                        <?php
                                        if (isset($_POST["submit"])) {
                                            $btntu = $_POST["submit"];
                                            if ($btntu == "Detalle por cuenta") {
                                                $tip_cuentadh = htmlspecialchars(trim($_POST['tip_cuentadh']));
                                                $result = mysqli_query($c, "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`valor` , v.`valorp` , v.`t_bl_inicial_idt_bl_inicial` , v.ejercicio AS j, n.concepto FROM `v_mayorizacionaux` v JOIN num_asientos n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`t_bl_inicial_idt_bl_inicial` = n.t_bl_inicial_idt_bl_inicial and v.t_bl_inicial_idt_bl_inicial='" . $idcod . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "' ORDER BY v.fecha ASC");
                                                $sqlaj = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`debe` , v.`haber` , v.`balance` , v.ejercicio AS j, n.concepto FROM `vmayorizacionajustes` v JOIN num_asientos_ajustes n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`balance` = n.t_bl_inicial_idt_bl_inicial and v.balance='" . $idcod . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "' ORDER BY v.fecha ASC";
                                                $resulaj = mysqli_query($c, $sqlaj);
                                                $result_d_m_mayor = mysqli_query($c, "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, 
        sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,
        sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sldeu,
        sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as slacr FROM vistabalanceresultadosajustados WHERE 
        `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "' and cod_cuenta='" . $tip_cuentadh . "'");
                                                $dato_fila = mysqli_fetch_array($result_d_m_mayor);
                                                $mayor_debe = $dato_fila['debe'];
                                                $mayor_haber = $dato_fila['haber'];
                                                $mayor_sldue = $dato_fila['sldeu'];
                                                $mayor_sldacr = $dato_fila['slacr'];
//                                                        class='table table-hover' 
                                                echo '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
//                                                        echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";
//                                                        echo "<table id='example' class='display nowrap' width='100%' cellspacing='0'>";
                                                echo "<thead>";
                                                echo "<tr> <center> - T - "
                                                . "<a href='tab_my/my_dtll.php' title='AJUSTES' class='glyphicon glyphicon-text-background'>
                                                         <input type='hidden' name='cmp_my' id='cmp_my' value='" . $tip_cuentadh . "'>
                                                         <input type='hidden' name='year' id='year' value='" . $year . "'>
                                                         <input type='hidden' name='bl' id='bl' value='" . $idcod . "'>
                                                         
                                    
                                                    <i class=' btn btn-outline btn-info glyphicon glyphicon-resize-full'></i></a>";
                                                ?>
                                                <button type='submit' class='btn btn-outline btn-info glyphicon glyphicon-print' onclick='imp_taMay()'></button>
                                                <?Php
                                                echo "<hr> </tr>";
                                                echo "<tr class='success'>";
                                                echo "<th style='display:none'>Ejercicio</th>";
                                                echo "<th style='display:none'>balance</th>";
                                                echo "<th>Fecha</th>";
                                                echo "<th>Cod.</th>";
                                                echo "<th>Cuenta</th>";
                                                echo "<th>Debe</th>";
                                                echo "<th>Haber</th>";
                                                echo "<th>Concepto</th>";
                                                echo "<th>Asiento</th>";
                                                echo "<th>ACCION</th>";
                                                echo "</tr>";
                                                echo "</thead>";
                                                echo "<tbody>";
                                                $a = 1;
                                                while ($row = mysqli_fetch_row($result)) {
                                                    $concepto = utf8_decode($row[7]);
//                                                            class='warning'
                                                    echo "<tr class='gradeA warning' >";
                                                    echo "<td style='display:none'><input type='hidden' id='fechain_" . $a . "' value='$row[0]'>$row[0]</td>";
                                                    echo "<td style='display:none'><input type='hidden' id='assin_" . $a . "' value='$row[6]'>$row[6]</td>";
                                                    echo "<td>$row[0]</td>";
                                                    echo "<td>$row[1]</td>";
                                                    echo "<td>$row[2]</td>";
                                                    echo "<td>$row[3]</td>";
                                                    echo "<td>$row[4]</td>";
                                                    echo "<td>$concepto</td>";
                                                    echo "<td>$row[6]</td>";
                                                    echo "<td>";
                                                    if ($row[6] == '1') {
                                                        ?>
                                                        <?Php // echo $row[6]; ?>
                                                        <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                                class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_as_my(<?Php echo $a; ?>);'></button>

                                                        <?Php
                                                    } else {
                                                        ?>
                                                        <?Php //echo $row[6]; ?>
                                                        <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                                class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_asiento_my(<?Php echo $a; ?>);'></button>

                                                        <?Php
                                                    }
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    echo "</tbody>";
                                                    $a++;
                                                }
                                                echo "</table>";
                                                echo '<center><h5>AJUSTES</h5></center>';
//                                                            class='table table-hover'
                                                echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";
                                                echo "<tr class='success'>";
                                                echo "<td style='display:none'>Ejercicio</td>";
                                                echo "<td style='display:none'>balance</td>";
                                                echo "<td>Fecha</td>";
                                                echo "<td>Cod.</td>";
                                                echo "<td>Cuenta</td>";
                                                echo "<td>Debe</td>";
                                                echo "<td>Haber</td>";
                                                echo "<td>Concepto</td>";
                                                echo "</tr>";
                                                while ($rowaj = mysqli_fetch_row($resulaj)) {
                                                    echo "<tr class='warning'>";
                                                    echo "<td style='display:none'>$rowaj[6]</td>";
                                                    echo "<td style='display:none'>$rowaj[5]</td>";
                                                    echo "<td>$rowaj[0]</td>";
                                                    echo "<td>$rowaj[1]</td>";
                                                    echo "<td>$rowaj[2]</td>";
                                                    echo "<td>$rowaj[3]</td>";
                                                    echo "<td>$rowaj[4]</td>";
                                                    echo "<td>$rowaj[7]</td>";
                                                    echo "</tr>";
                                                }
                                                echo "</table>";
                                                ?>
                                                <table>
                                                    <tr class="info" >
                                                        <td>
                                                            <label>Total debe :</label>
                                                            <input type="text" readonly="readonly" id="campomayor_debe" name="campomayor_debe" class="form-control" value="<?php echo $mayor_debe ?>"/>
                                                        </td>
                                                        <td>
                                                            <label>Total haber :</label>
                                                            <input type="text" readonly=readonly id="campomayor_haber" name="campomayor_haber" class="form-control" value="<?php echo $mayor_haber ?>"/>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <?php
                                                $accion = "/ CONTABILIDAD / MAYORIZACION / VISUALIZÓ DETALLE CUENTA:" . $tip_cuentadh;
                                                generaLogs($user, $accion);
                                            }
                                            if ($btntu == "Detalle") {
//                                                    echo '<script>alert("ver")</script>';
                                                $tip_cuentadh = htmlspecialchars(trim($_POST['cta']));
                                                $result = mysqli_query($c, "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`valor` , v.`valorp` , v.`t_bl_inicial_idt_bl_inicial` , v.ejercicio AS j, n.concepto FROM `v_mayorizacionaux` v JOIN num_asientos n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`t_bl_inicial_idt_bl_inicial` = n.t_bl_inicial_idt_bl_inicial and v.t_bl_inicial_idt_bl_inicial='" . $idcod . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "' ORDER BY v.fecha ASC");
                                                $sqlaj = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`debe` , v.`haber` , v.`balance` , v.ejercicio AS j, n.concepto FROM `vmayorizacionajustes` v JOIN num_asientos_ajustes n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`balance` = n.t_bl_inicial_idt_bl_inicial and v.balance='" . $idcod . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "' ORDER BY v.fecha ASC";
                                                $resulaj = mysqli_query($c, $sqlaj);
                                                $result_d_m_mayor = mysqli_query($c, "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, 
        sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,
        sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sldeu,
        sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as slacr FROM vistabalanceresultadosajustados WHERE 
        `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "' and cod_cuenta='" . $tip_cuentadh . "'");
                                                $dato_fila = mysqli_fetch_array($result_d_m_mayor);
                                                $mayor_debe = $dato_fila['debe'];
                                                $mayor_haber = $dato_fila['haber'];
                                                $mayor_sldue = $dato_fila['sldeu'];
                                                $mayor_sldacr = $dato_fila['slacr'];
//                                                    class='table table-hover' 
                                                echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";
                                                echo "<tr> <center> - T - 
                                                        <a href='tab_my/my_dtll.php' title='AJUSTES' class='glyphicon glyphicon-text-background'>
                                                    <i class=' btn btn-outline btn-info glyphicon glyphicon-resize-full'></i></a>
                                                    <input type='hidden' name='cmp_my' id='cmp_my' value='" . $tip_cuentadh . "'>
                                                         <input type='hidden' name='year' id='year' value='" . $year . "'>
                                                         <input type='hidden' name='bl' id='bl' value='" . $idcod . "'>";
                                                ?>
                                                <button type='submit' class='btn btn-outline btn-info glyphicon glyphicon-print' onclick='imp_taMay()'></button>
                                                <button class="btn btn-outline btn-success" name="ex_my_by_cta" id="ex_my_by_cta" onclick="exp_ex_by_cta(this.id);">
                                                    <img src="../../../../images/excel.png" width="25" height="25" alt="Excel"/></button>

                                                <?Php
                                                echo "<hr></center> </tr>";
                                                echo "<tr class='success'>";
                                                echo "<td style='display:none'>Ejercicio</td>";
                                                echo "<td style='display:none'>balance</td>";
                                                echo "<td>Fecha</td>";
                                                echo "<td>Cod.</td>";
                                                echo "<td>Cuenta</td>";
                                                echo "<td>Debe</td>";
                                                echo "<td>Haber</td>";
                                                echo "<td>Concepto</td>";
                                                echo "<td>Asiento</td>";
                                                echo "<td>ACCION</td>";
                                                echo "</tr>";
                                                $a = 1;
                                                while ($row = mysqli_fetch_row($result)) {
                                                    $concepto = utf8_decode($row[7]);
                                                    echo "<tr class='warning'>";
                                                    echo "<td style='display:none'><input type='hidden' id='fechain_" . $a . "' value='$row[0]'>$row[6]</td>";
                                                    echo "<td style='display:none'><input type='hidden' id='assin_" . $a . "' value='$row[6]'>$row[5]</td>";
                                                    echo "<td>$row[0]</td>";
                                                    echo "<td>$row[1]</td>";
                                                    echo "<td>$row[2]</td>";
                                                    echo "<td>$row[3]</td>";
                                                    echo "<td>$row[4]</td>";
                                                    echo "<td>$concepto</td>";
                                                    echo "<td>$row[6]</td>";
                                                    echo "<td>";
                                                    if ($row[6] == '1') {
                                                        ?>
                                                        <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                                class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_as_my(<?Php echo $a; ?>);'></button>

                                                        <?Php
                                                    } else {
                                                        ?>
                                                        <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                                class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_asiento_my(<?Php echo $a; ?>);'></button>

                                                        <?Php
                                                    }
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    $a++;
                                                }
                                                echo "</table>";
                                                echo '<center><h5>AJUSTES</h5></center>';
                                                echo "<table class='table table-hover'>";
                                                echo "<tr class='success'>";
                                                echo "<td style='display:none'>Ejercicio</td>";
                                                echo "<td style='display:none'>balance</td>";
                                                echo "<td>Fecha</td>";
                                                echo "<td>Cod.</td>";
                                                echo "<td>Cuenta</td>";
                                                echo "<td>Debe</td>";
                                                echo "<td>Haber</td>";
                                                echo "<td>Concepto</td>";
                                                echo "</tr>";
                                                while ($rowaj = mysqli_fetch_row($resulaj)) {
                                                    echo "<tr class='warning'>";
                                                    echo "<td style='display:none'>$rowaj[6]</td>";
                                                    echo "<td style='display:none'>$rowaj[5]</td>";
                                                    echo "<td>$rowaj[0]</td>";
                                                    echo "<td>$rowaj[1]</td>";
                                                    echo "<td>$rowaj[2]</td>";
                                                    echo "<td>$rowaj[3]</td>";
                                                    echo "<td>$rowaj[4]</td>";
                                                    echo "<td>$rowaj[7]</td>";
                                                    echo "</tr>";
                                                }
                                                echo "</table>";
                                                ?>
                                                <table>
                                                    <tr class="info" >
                                                        <td>
                                                            <label>Total debe :</label>
                                                            <input type="text" readonly="readonly" id="campomayor_debe" name="campomayor_debe" class="form-control" value="<?php echo $mayor_debe ?>"/>
                                                        </td>
                                                        <td>
                                                            <label>Total haber :</label>
                                                            <input type="text" readonly=readonly id="campomayor_haber" name="campomayor_haber" class="form-control" value="<?php echo $mayor_haber ?>"/>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <?php
                                                $accion = "/ CONTABILIDAD / MAYORIZACION / VISUALIZÓ DETALLE CUENTA:" . $tip_cuentadh;
                                                generaLogs($user, $accion);
                                            }
                                            if ($btntu == "Buscar") {
//                                                    echo '<script>alert("buscar")</script>';
//                                                    $tip_cuentadh = htmlspecialchars(trim($_POST['cta']));
                                                $tdatepick = htmlspecialchars(trim($_POST['datetimepicker']));
                                                $tdatepick1 = htmlspecialchars(trim($_POST['datetimepicker1']));
                                                $search_date = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`valor` , v.`valorp` ,"
                                                        . " v.`t_bl_inicial_idt_bl_inicial` , v.ejercicio AS j, n.concepto FROM `v_mayorizacionaux` v"
                                                        . " JOIN num_asientos n WHERE v.fecha "
                                                        . "BETWEEN '" . $tdatepick . "' and '" . $tdatepick1 . "' and v.ejercicio = n.t_ejercicio_idt_corrientes "
                                                        . "AND v.`t_bl_inicial_idt_bl_inicial` = n.t_bl_inicial_idt_bl_inicial and "
                                                        . "v.t_bl_inicial_idt_bl_inicial='" . $idcod . "' AND v.year = '" . $year . "' ORDER BY v.fecha ASC ";
                                                $result = mysqli_query($c, $search_date);
                                                $sqlaj = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`debe` , v.`haber` , v.`balance` , v.ejercicio AS j, n.concepto"
                                                        . " FROM `vmayorizacionajustes` v JOIN num_asientos_ajustes n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND"
                                                        . " v.`balance` = n.t_bl_inicial_idt_bl_inicial and v.balance='" . $idcod . "' AND"
                                                        . " v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "' ORDER BY v.fecha ASC";
                                                $resulaj = mysqli_query($c, $sqlaj);
                                                $result_d_m_mayor = mysqli_query($c, "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, 
        sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,
        sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sldeu,
        sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as slacr FROM vistabalanceresultadosajustados WHERE `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "' and cod_cuenta='" . $tip_cuentadh . "'");
                                                $dato_fila = mysqli_fetch_array($result_d_m_mayor);
                                                $mayor_debe = $dato_fila['debe'];
                                                $mayor_haber = $dato_fila['haber'];
                                                $mayor_sldue = $dato_fila['sldeu'];
                                                $mayor_sldacr = $dato_fila['slacr'];
//                                                    class='table table-hover' 
                                                echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";
                                                echo "<tr> <center> - T - <a href='tab_my/my_dtll.php' title='AJUSTES' class='glyphicon glyphicon-text-background'>
                                                    <i class=' btn btn-outline btn-info glyphicon glyphicon-resize-full'></i></a>
                                                    <input type='hidden' name='cmp_my' id='cmp_my' value='" . $tip_cuentadh . "'>
                                                         <input type='hidden' name='year' id='year' value='" . $year . "'>
                                                         <input type='hidden' name='bl' id='bl' value='" . $idcod . "'>";
                                                ?>
                                                <button type='submit' class='btn btn-outline btn-info glyphicon glyphicon-print' onclick='imp_taMaydatafech()'></button>
                                                <?Php
                                                echo "<hr></center> </tr>";
                                                echo "<h3>Resultados de busqueda desde : " . $tdatepick . " hasta : " . $tdatepick1 . "</h3>";
                                                echo "<hr>";
                                                echo "<input type='hidden' id='fechai' value='" . $tdatepick . "'>";
                                                echo "<input type='hidden' id='fechaf' value='" . $tdatepick1 . "'>";
                                                echo "<tr class='success'>";
                                                echo "<td style='display:none'>Ejercicio</td>";
                                                echo "<td style='display:none'>balance</td>";
                                                echo "<td>Fecha</td>";
                                                echo "<td>Cod.</td>";
                                                echo "<td>Cuenta</td>";
                                                echo "<td>Debe</td>";
                                                echo "<td>Haber</td>";
                                                echo "<td>Concepto</td>";
                                                echo "<td>Asiento</td>";
                                                echo "<td>ACCION</td>";
                                                echo "</tr>";
                                                $a = 1;
                                                while ($row = mysqli_fetch_row($result)) {
                                                    $concepto = utf8_decode($row[7]);
                                                    echo "<tr class='warning'>";
                                                    echo "<td style='display:none'><input type='hidden' id='fechain_" . $a . "' value='$row[0]'>$row[6]</td>";
                                                    echo "<td style='display:none'><input type='hidden' id='assin_" . $a . "' value='$row[6]'>$row[5]</td>";
                                                    echo "<td>$row[0]</td>";
                                                    echo "<td>$row[1]</td>";
                                                    echo "<td>$row[2]</td>";
                                                    echo "<td>$row[3]</td>";
                                                    echo "<td>$row[4]</td>";
                                                    echo "<td>$concepto</td>";
                                                    echo "<td>$row[6]</td>";
                                                    echo "<td>";
                                                    if ($row[6] == '1') {
                                                        ?>
                                                        <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                                class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_as_my(<?Php echo $a; ?>);'></button>

                                                        <?Php
                                                    } else {
                                                        ?>
                                                        <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                                class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_asiento_my(<?Php echo $a; ?>);'></button>

                                                        <?Php
                                                    }
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    $a++;
                                                }
                                                echo "</table>";
                                                ?>

                                                <?php
                                                $accion = "/ CONTABILIDAD / MAYORIZACION / VISUALIZÓ MAYOR POR FECHA :" . $tdatepick . '-' . $tdatepick1;
                                                generaLogs($user, $accion);
                                            }
                                            if ($btntu == "FILTRO") {
                                                //                                                    echo '<script>alert("buscar")</script>';
                                                $tip_cuentadhp = htmlspecialchars(trim($_POST['ctapp']));
                                                $tdatepick = htmlspecialchars(trim($_POST['datetimepickerpd']));
                                                $tdatepick1 = htmlspecialchars(trim($_POST['datetimepicker1ph']));
                                                $search_date = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`valor` , v.`valorp` ,"
                                                        . " v.`t_bl_inicial_idt_bl_inicial` , v.ejercicio AS j, n.concepto FROM `v_mayorizacionaux` v"
                                                        . " JOIN num_asientos n WHERE v.fecha "
                                                        . "BETWEEN '" . $tdatepick . "' and '" . $tdatepick1 . "' and v.cod_cuenta='" . $tip_cuentadhp . "' and v.ejercicio = n.t_ejercicio_idt_corrientes "
                                                        . "AND v.`t_bl_inicial_idt_bl_inicial` = n.t_bl_inicial_idt_bl_inicial and "
                                                        . "v.t_bl_inicial_idt_bl_inicial='" . $idcod . "' AND v.year = '" . $year . "' ORDER BY v.fecha ASC ";
                                                $result = mysqli_query($c, $search_date);
                                                $sqlaj = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`debe` , v.`haber` , v.`balance` , "
                                                        . "v.ejercicio AS j, n.concepto FROM `vmayorizacionajustes` v JOIN num_asientos_ajustes n"
                                                        . " WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND "
                                                        . "v.`balance` = n.t_bl_inicial_idt_bl_inicial and v.balance='" . $idcod . "' "
                                                        . "AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "' ORDER BY v.fecha ASC";
                                                $resulaj = mysqli_query($c, $sqlaj);
                                                $result_d_m_mayor = mysqli_query($c, "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, 
        sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,
        sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sldeu,
        sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as slacr FROM vistabalanceresultadosajustados WHERE `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "' and cod_cuenta='" . $tip_cuentadh . "'");
                                                $dato_fila = mysqli_fetch_array($result_d_m_mayor);
                                                $mayor_debe = $dato_fila['debe'];
                                                $mayor_haber = $dato_fila['haber'];
                                                $mayor_sldue = $dato_fila['sldeu'];
                                                $mayor_sldacr = $dato_fila['slacr'];
//                                                    class='table table-hover' 
                                                echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";
                                                echo "<tr> <center> - T - <a href='tab_my/my_dtll.php' title='AJUSTES' class='glyphicon glyphicon-text-background'>
                                                    <i class=' btn btn-outline btn-info glyphicon glyphicon-resize-full'></i></a>
                                                    <input type='hidden' name='cmp_my' id='cmp_my' value='" . $tip_cuentadh . "'>
                                                         <input type='hidden' name='year' id='year' value='" . $year . "'>
                                                         <input type='hidden' name='bl' id='bl' value='" . $idcod . "'>";
                                                ?>
                                                <button type='submit' class='btn btn-outline btn-info glyphicon glyphicon-print' onclick='imp_taMaydatafechf()'></button>
                                                <?Php
                                                echo "<hr></center> </tr>";
                                                echo "<h3>Resultados de busqueda desde : " . $tdatepick . " hasta : " . $tdatepick1 . "</h3>";
                                                echo "<hr>";
                                                echo "<input type='hidden' id='fechai' value='" . $tdatepick . "'>";
                                                echo "<input type='hidden' id='fechaf' value='" . $tdatepick1 . "'>";
                                                echo "<input type='hidden' id='tip_cuentadhp' value='" . $tip_cuentadhp . "'>";
                                                echo "<tr class='success'>";
                                                echo "<td style='display:none'>Ejercicio</td>";
                                                echo "<td style='display:none'>balance</td>";
                                                echo "<td>Fecha</td>";
                                                echo "<td>Cod.</td>";
                                                echo "<td>Cuenta</td>";
                                                echo "<td>Debe</td>";
                                                echo "<td>Haber</td>";
                                                echo "<td>Concepto</td>";
                                                echo "<td>Asiento</td>";
                                                echo "<td>ACCION</td>";
                                                echo "</tr>";
                                                $a = 1;
                                                while ($row = mysqli_fetch_row($result)) {
                                                    $concepto = utf8_decode($row[7]);
                                                    echo "<tr class='warning'>";
                                                    echo "<td style='display:none'><input type='hidden' id='fechain_" . $a . "' value='$row[0]'>$row[6]</td>";
                                                    echo "<td style='display:none'><input type='hidden' id='assin_" . $a . "' value='$row[6]'>$row[5]</td>";
                                                    echo "<td>$row[0]</td>";
                                                    echo "<td>$row[1]</td>";
                                                    echo "<td>$row[2]</td>";
                                                    echo "<td>$row[3]</td>";
                                                    echo "<td>$row[4]</td>";
                                                    echo "<td>$concepto</td>";
                                                    echo "<td>$row[6]</td>";
                                                    echo "<td>";
                                                    if ($row[6] == '1') {
                                                        ?>
                                                        <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                                class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_as_my(<?Php echo $a; ?>);'></button>

                                                        <?Php
                                                    } else {
                                                        ?>
                                                        <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                                class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_asiento_my(<?Php echo $a; ?>);'></button>

                                                        <?Php
                                                    }
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    $a++;
                                                }
                                                echo "</table>";
                                                ?>

                                                <?php
                                                $accion = "/ CONTABILIDAD / MAYORIZACION / VISUALIZÓ MAYOR POR FECHA :" . $tdatepick . '-' . $tdatepick1;
                                                generaLogs($user, $accion);
                                            } else {
                                                
                                            }
                                        }
                                        ?>

                                        <!--</tr>-->
                                        </table>
                                    </form>
                                    <form name="form_ejercicio" role="form" id="form_ejercicio" method="post" action="ini_cont.php">
                                        <fieldset>
                                            <!--<legend-->
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
                                            <table id="table1" name="table1" class="table table-hover"> 

                                                <thead>
                                                    <tr class='success'>
                                                        <td style='display:none'>balance</td>
                                                        <td style='display:none'>Fecha</td>
                                                        <td><strong> Cod.</strong> </td>
                                                        <td><strong> Cuenta</strong> </td>
                                                        <td><strong>Debe</strong> </td>
                                                        <td><strong>Haber</strong> </td>
                                                        <td><strong>Deudor</strong> </td>
                                                        <td><strong>Acreedor</strong> </td>
                                                    </tr>
                                                </thead>








                                                <!--Zona Upload de cuentas para mayor incluidos ajustes-->
                                                <?Php
                                                $c = $dbi->conexion();
                                                $cargamayor = "SELECT `t_bl_inicial_idt_bl_inicial`,`tipo`,`cod_cuenta`, `cuenta`, 
    sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0)) as sdeb, 
    sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0)) as shab, 
    sum(COALESCE(debe_aj, 0)+COALESCE(debe,0)) - sum(COALESCE(haber_aj, 0) + COALESCE(haber, 0)) as sldeu, 
    CONCAT('0.00') as slacr FROM vistabalanceresultadosajustados WHERE `t_bl_inicial_idt_bl_inicial` = '" . $idcod . "' and year='" . $year . "'
    group BY cod_cuenta, cod_cuenta_aj HAVING sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0))>sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0))
UNION
SELECT `t_bl_inicial_idt_bl_inicial`,`tipo`,`cod_cuenta`, `cuenta`, sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0)) as sdeb, sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0)) as shab,
CONCAT('0.00') as slacr, sum(COALESCE(haber_aj, 0) + COALESCE(haber, 0))-sum(COALESCE(debe_aj, 0)+COALESCE(debe,0)) as sldeu  FROM vistabalanceresultadosajustados WHERE 
`t_bl_inicial_idt_bl_inicial` = '" . $idcod . "' and year='" . $year . "' group BY cod_cuenta, cod_cuenta_aj HAVING sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0))<sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0))
order by cod_cuenta";
                                                $result = mysqli_query($c, $cargamayor);
                                                while ($row = mysqli_fetch_row($result)) {
                                                    echo "<tbody>";
                                                    echo "<tr>";
                                                    //echo "<td style='display:none'>$row[5]</td>";
                                                    echo "<td style='display:none;'><input type='text' class='form-control' readonly='readonly' id='tipo' name='campo9[]' value='$row[1]'/></td>";
                                                    echo "<td style='display:none'><input type='text' class='form-control' readonly='readonly' id='t_bl_inicial_idt_bl_inicial' name='campo1[]' value='$row[0]'/></td>";
                                                    echo "<td style='display:none'><input type='text' class='form-control' readonly='readonly' id='fecha' name='campo2[]' value='$row[0]'/></td>";
                                                    echo "<td><input type='text' class='form-control' readonly='readonly' id='cod_cuenta' name='campo3[]' value='$row[2]'/></td>";
                                                    echo "<td><input type='text' class='form-control' readonly='readonly' id='cuenta' name='campo4[]'  value='$row[3]'/></td>";
                                                    echo "<td><input type='text' class='form-control' readonly='readonly' id='deb' name='campo5[]' value='$row[4]'/></td>";
                                                    echo "<td><input type='text' class='form-control' readonly='readonly' id='hab' name='campo6[]' value='$row[5]'/></td>";

                                                    echo "<td><input type='text' class='form-control' readonly='readonly' id='saldodeudor' name='campo7[]' onkeyup='validar(this.id);' value='";
                                                    echo $row[6];
                                                    echo "'/></td>";
                                                    echo "<td><input type='text' readonly='readonly' class='form-control' id='saldoacreedor' name='campo8[]' onkeyup='validar(this.id);' value='";
                                                    echo $row[7];
                                                    echo"'/></td>";
                                                    echo "</tr>";
                                                    echo "</tbody>";
                                                }
                                                mysqli_close($c);
                                                ?>






                                                <tr>
                                                <tfoot>
                                                <td></td>
                                                <td> <strong>Total :</strong> </td>
                                                <td>
                                                    <div class="col-xs-10 form-group has-success">
                                                        <input type="text" readonly="readonly"  class="form-control" name="tdebe" id="tdebe" value="<?php echo $Tdebe ?>"/> 
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-xs-10 form-group has-success">
                                                        <input type="text"  readonly="readonly" class="form-control info" name="thaber" id="thaber" value="<?php echo $Thaber ?>"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-xs-10 form-group has-success">
                                                        <input type="text" readonly="readonly"  class="form-control" name="tdeudor" id="tdeudor" value="<?php echo $Sdeudor ?>"/> 
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-xs-10 form-group has-success">
                                                        <input type="text"  readonly="readonly" class="form-control info" name="tacreedor" id="tacreedor" value="<?php echo $Sacreedor ?>"/>
                                                    </div>
                                                </td>
                                                </tfoot>            
                                                </tr>
                                            </table>    
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
        <script>
                                                    $(document).ready(function () {
                                                        $('#dataTables-example').dataTable();
                                                    });
        </script>
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
