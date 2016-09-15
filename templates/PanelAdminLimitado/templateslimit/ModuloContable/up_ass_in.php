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
$accion = "/ CONTABILIDAD / UPDATA BALANCE INICIAL/ Ingreso en actualizacion de asiento inicial";
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


$id_asientourl = $_GET['id_asientourl'];
$fechaurl = $_GET['fechaurl'];
if (isset($_GET['id_asientourl'])) {
    require('../../../Clases/cliente.class.php');
    $objCuenta = new Clase;
    $id_asientourl = $_GET['id_asientourl'];
    $fechaurl = $_GET['fechaurl'];
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
                    <form name="form" id="form" action="" method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="page-header">MODIFICAR ASIENTO # <?Php echo $_GET['id_asientourl'] ?></h1>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <!-- /.col-lg-12 -->
                            <div class="col-lg-12">
                                <div class="panel panel-default">

                                    <div class="panel-heading">
                                        Actualizar
                                    </div>

                                    <?Php
                                    $db = $dbi->conexion();
                                    $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
                                    $result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($db), E_USER_ERROR);
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
                                        }
                                    }
                                    $sqlsumresDH = "SELECT sum( j.valor ) AS d, sum( j.valorp ) AS h
FROM t_ejercicio j join num_asientos n
WHERE j.ejercicio=n.t_ejercicio_idt_corrientes
AND n.idnum_asientos=" . $id_asientourl . "
AND j.t_bl_inicial_idt_bl_inicial='" . $maxbalancedato . "'
AND j.year = '" . $year . "' ";
                                    $resDH = mysqli_query($db, $sqlsumresDH);
                                    while ($row1 = mysqli_fetch_array($resDH)) {
                                        $ddetall = $row1['d'];  //echo "<script>alert(".$ddetall.")</script>";
                                        $hdetall = $row1['h'];
                                    }
                                    
                                    if ($ddetall != $hdetall) {
                                        $sms="Valor incorrecto, el asiento debe ser cuadrado caso contrario la cantabilidad estará descuadrada.. bajo su responsabilidad.";
                                    }else{
                                        $sms = "El asiento no contiene errores, su edición corre por su responsabilidad...";
                                    }
                                    
                                    
                                    //AND e.fecha = n.fecha
                                    $sqlbuscagrupos = "SELECT n.`idnum_asientos` AS id,
                                        n.`t_ejercicio_idt_corrientes` ej, n.`concepto` as  c,
                                         n.fecha as fecha 
FROM `num_asientos` n JOIN t_ejercicio e 
WHERE e.ejercicio = n.t_ejercicio_idt_corrientes AND e.fecha = n.fecha
AND n.fecha = '" . $fechaurl . "'
AND n.idnum_asientos = '" . $id_asientourl . "' AND e.year='" . $year . "'
GROUP BY `t_ejercicio_idt_corrientes`";
                                    $result_grupo = mysqli_query($db, $sqlbuscagrupos) or trigger_error("Query Failed! SQL: $sqlbuscagrupos - Error: " . mysqli_error($db), E_USER_ERROR);

                                    while ($rw = mysqli_fetch_assoc($result_grupo)) {
                                        $idasiento = $rw['id'];
                                        $nombre_grupo = $rw['c'];
                                        $codgrupo = $rw['ej'];
                                        $f = $rw['fecha'];
                                        $d = $rw['d'];
                                        $h = $rw['h'];

                                        list($y, $m, $d) = explode("-", $f);
                                        $d; // Imprime 12
                                        $m; // Imprime 01
                                        $y; // Imprime 2005
                                        ?>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <!--<form name="form_ejerciciot" role="form" id="form_ejerciciot" method="post" action="up_ass_in.php">-->
                                                    <fieldset>
                                                        <!--<legend-->

                                                        <button data-toggle="modal" data-target="#myModal" type="button" class="btn btn-default" onclick="add_trs(
                                                        <?Php echo $_GET['id_asientourl']; ?>,
                                                        <?Php echo $y;?>,
                                                        <?Php echo $m; ?>,
                                                        <?Php echo $d; ?>,
                                                        <?Php echo $idcod; ?>
                                                            );">INSERTAR</button>
                                                        <input type="submit" name="update" id="update" class="btn btn-success" onclick="guardaas_level_asini()" value="GUARDAR"/>
                                                        <button type="button" class="btn btn-primary" onclick="reset_form()">CANCELAR</button>

                                                        <div class="alert fade in" data-alert="alert" id="alert-area" >
                                                             <label><?Php echo $sms; ?></label>
                                                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <!--</legend>-->
                                                        <div class="col-lg-12">
                                                            <div class="panel panel-default">
                                                                <div class="col-lg-3 col-md-6">
                                                                    <div class="panel-heading">
                                                                        <input type="hidden" name="idnumass" id="idnumass" value="<?Php echo $idasiento; ?>" readonly="readonly" />
                                                                        <input type="hidden" name="idlogeo" id="idlogeo" value="<?Php echo $idlogeous; ?>" readonly="readonly" />
                                                                        <?Php
//                                                                        echo '<br>';
//                                                                        echo "Ingreso :";
//                                                                        echo $f;
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-md-6">
                                                                    <div class="panel-heading">
                                                                        <label class="form">Fecha :</label>
                                                                        <input type="text" class="form-control datepicker" id="datetimepicker1" name="datetimepicker1" value="<?Php echo $f; ?>" readonly="readonly" required="required"/>

                                                                    </div>
                                                                </div>
                                                                <!-- /.panel-heading -->
                                                                <datalist id="cuent" >
                                                                    <?php
                                                                    $query = "select * from t_plan_de_cuentas";
                                                                    $resul1 = mysqli_query($db, $query);
                                                                    while ($dato1 = mysqli_fetch_array($resul1)) {
                                                                        $cod1 = $dato1['cod_cuenta'];
                                                                        echo "<option value='" . $dato1['cod_cuenta'] . "' >";
                                                                        echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                                                        echo '</option>';
                                                                    }
                                                                    ?>
                                                                </datalist>
                                                                <div class="panel-body">     
                                                                    <div class="table-responsive">     
                                                                        <table class="table table-hover" id="tabedit" name="tabedit">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th> # COD</th>
                                                                                    <th>CUENTA</th>
                                                                                    <th>DEBE</th>
                                                                                    <th>HABER</th>
                                                                                    <th style="display:none"><label>Grupo</label></th>
                                                                                </tr> 
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <?PHP
                                                                                    echo '<th colspan="3" style="text-align: center;vertical-align: middle;"> Ref : ' . $codgrupo . ' ';
                                                                                    echo ' <a class="btn btn-outline btn-info glyphicon glyphicon-print" href="impresiones/impasiento.php?id_asientourl=' . $idasiento . '&fechaurl=' . $f . '&idlogeo=' . $idlogeous . '"></a>';
                                                                                    echo '<th>';
                                                                                    ?>
                                                                                </tr>
                                                                                <?Php
                                                                                echo '<input name="valor" type="hidden" id="valor" value="';
                                                                                echo $codgrupo;
                                                                                echo '"/>';

                                                                                $n = 0;
                                                                                $cc = 1;
                                                                                $sql_cuentasgrupos = "SELECT `ejercicio` , `idt_corrientes` as id ,ejercicio as ej, `fecha` , 
                                        `cod_cuenta` , `cuenta` , `valor` AS debe, `valorp` AS haber, `t_bl_inicial_idt_bl_inicial` as balance , tipo, 
                                        logeo_idlogeo as log, mes, year
                                        FROM `t_ejercicio` WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "' "
                                                            . "AND `ejercicio` =" . $codgrupo . " AND year='" . $year . "' ORDER BY ejercicio";

                                                                                $result2 = mysqli_query($db, $sql_cuentasgrupos) or trigger_error("Query Failed! SQL: $sql_cuentasgrupos - Error: " . mysqli_error($db), E_USER_ERROR);
                                                                                while ($r2 = mysqli_fetch_array($result2)) {
                                                                                    ?>

                                                                                    <tr>
                                                                                        <td width="5%" style="display: none;"><?Php echo $r2['idt_corrientes']; ?>
                                                                                            <input type="text" class="form-control" name="idt_corrientes" id="idt_corrientes" value="<?Php echo $r2['id']; ?>"  />
                                                                                            <input type="text" class="form-control" name="campo1[]" id="idt_cont<?Php echo $cc; ?>" value="<?Php echo $r2['id']; ?>"  />
                                                                                        <td width="35%">
                                                                                            <?Php // echo $r2['cod_cuenta'];  ?>
                                                                                            </div>
                                                                                            <div class="input-group">
                                                                                                <input type="text" list="cuent" name="campo2[]" id="cuentfas<?Php echo $cc; ?>_1" class="form-control" value="<?Php echo $r2['cod_cuenta'] ?>" placeholder="Ingrese Cod Cuenta...">
                                                                                                <span class="input-group-btn">
                                                                                                    <button class="btn btn-default" onclick="ver(<?Php echo $cc; ?>), cont(<?Php echo $cc; ?>)" type="button" id="btnver">Ver!</button>
                                                                                                </span>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <?Php
                                                                                                $B_BUSCAR = "SELECT g.cod_grupo as grupo, g.nombre_grupo as nom FROM `t_plan_de_cuentas` p JOIN t_grupo g WHERE p.`t_grupo_cod_grupo` = g.cod_grupo AND `cod_cuenta` = '" . $r2['tipo'] . "'";
                                                                                                $rnom = mysqli_query($db, $B_BUSCAR);
                                                                                                $f = mysqli_fetch_array($rnom);
                                                                                                if ($f == 0) {//        echo 'Error de codigo';
                                                                                                    ?>                           
                                                                                                    <input type="hidden" class="form-control" name="campo3[]" id="grupofas<?Php echo $cc; ?>" readonly="readonly" value="Error de codigo"/> 
                                                                                                    <?Php echo "Error de codigo"; ?> 
                                                                                                    <?Php
                                                                                                } else {
                                                                                                    $dato = $f['grupo'];
                                                                                                    $dato1 = $f['nom'];
                                                                                                    $codcuenta = $dato;
                                                                                                    $nomcuenta = $dato1;
                                                                                                    ?>                           
                                                                                                    <input type="hidden" class="form-control" name="campo3[]" id="grupofas<?Php echo $cc; ?>" readonly="readonly" value="<?Php echo $nomcuenta; ?>"/> 
                                                                                                    <?Php // echo $nomcuenta; ?>
                                                                                                    <?Php
                                                                                                }
                                                                                                ?>
                                                                                                <?Php // echo $r2['tipo'];  ?>
                                                                                                <input type="hidden" class="form-control" name="campo4[]" readonly="readonly" id="codgrupofas<?Php echo $cc; ?>" value="<?Php echo $r2['tipo']; ?>"  >

                                                                                                </td>
                                                                                                <td width="25%">
                                                                                                    <input type="text" class="form-control" name="campo5[]" id="cuentafas<?Php echo $cc; ?>" value="<?Php echo $r2['cuenta']; ?>"  >
                                                                                                    <?Php // echo $r2['cuenta'];  ?></td>
                                                                                                <td width="10%"> 
                                                                                                    <input type="text" class="form-control" name="campo6[]" id="debe<?Php echo $cc; ?>_2" value="<?Php echo $r2['debe']; ?>" onkeyup="validarupd_t(this.id);"  >
                                                                                                    <?Php // echo $r2['debe'];  ?> </td>
                                                                                                <td width="10%"> 
                                                                                                    <input type="text" class="form-control" name="campo7[]" id="haber<?Php echo $cc; ?>_3" value="<?Php echo $r2['haber']; ?>" onkeyup="validaruph_t(this.id);"  >
                                                                                                    <input type="hidden" class="form-control" name="campo8[]" id="campo" value="<?Php echo $cc; ?>" />
                                                                                                </td>
                                                                                                <td>
<!--                                                                                                    <button class='btn btn-danger btn-sm' onclick='deleteRowini(this);'>
                                                                                                        <i class='glyphicon glyphicon-minus' ></i>
                                                                                                    </button>-->
                                                                                                </td>
                                                                                        <td>
                                                                                            <button type="button"  onclick="upmod_ini(this.id)" value="" name="up-<?Php echo $cc; ?>" id="up-<?Php echo $cc; ?>" >
                                                                                                <i class="glyphicon glyphicon-hand-left"></i>
                                                                                            </button>
                                                                                        </td>
                                                                                        <?Php
                                                                                        $r2['ej'];
                                                                                        $r2['balance'];
                                                                                        $r2['tipo'];
                                                                                        $r2['log'];
                                                                                        $r2['mes'];
                                                                                        $r2['year'];
                                                                                        ?>
                                                                                        <?Php
                                                                                        echo '</tr>';
                                                                                        $cc++;
                                                                                    }
                                                                                    $n++;
                                                                                }
                                                                                ?>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <td></td>
                                                                                <td> <strong>TOTAL : </strong> </td>
                                                                                <td><?Php // echo $ddetall;      ?>
                                                                                    <input type="text"  readonly="readonly" class="form-control" name="camposumadebet" id="camposumadebet" value="<?Php echo $ddetall; ?>"/>
                                                                                </td>
                                                                                <td><?Php // echo $hdetall;      ?>
                                                                                    <input type="text"  readonly="readonly" class="form-control" name="camposumahabert" id="camposumahabert" value="<?Php echo $hdetall; ?>"/>
                                                                                </td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                    <textarea class="form-control" id="textarea_as" name="textarea_as" rows="1" cols="30"><?Php echo utf8_decode($nombre_grupo) ?></textarea>

                                                                    </fieldset>


                                                                    <!--</form>-->
                                                                </div>
                                                                <!-- /.table-responsive -->
                                                            </div>
                                                            <!-- /.panel-body -->
                                                        </div>
                                                        <!-- /.panel -->
                                                    </div>
                                                    </div>
                                                    <!-- /.row -->
                                            </form>
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
                                                    <h4 class="modal-title" id="myModalLabel">AGREGAR TRANSACI&Oacute;N</h4>
                                                </div>
                                                <div class="modal-body" id="caja">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?Php } ?>
                                </body>

                                </html>
