<!DOCTYPE html>
<?php
require '../../../../templates/Clases/Conectar.php';
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
$dbi = new Conectar();
$conex = $dbi->conexion();
session_start();
$mes = date('F');
$year = date("Y");
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../login.php"
</script>';
}

$id_usuario = $_SESSION['username'];
$consulgrupo = "SELECT * FROM `t_grupo`";
$queryclases = mysqli_query($conex, $consulgrupo);
$consulta = "SELECT l.username, u.tipo_user,l.idlogeo
FROM logeo l
JOIN user_tipo u
WHERE l.user_tipo_iduser_tipo = u.iduser_tipo and l.username = '" . $id_usuario . "'";
$resultado = mysqli_query($conex, $consulta) or die(mysqli_errno($conex));
while ($fila = mysqli_fetch_array($resultado)) {
    $user = $fila['username'];
    $type_user = $fila['tipo_user'];
    $idlogeous = $fila['idlogeo'];
}


include '../../Clases/guardahistorial.php';
$accion = " / Ingreso a modificación del asiento numero " . $_GET['id_asientourl'];
generaLogs($user, $accion);

mysqli_close($conex);

$id_asientourl = $_GET['id_asientourl'];
$fechaurl = $_GET['fechaurl'];
if (isset($_GET['id_asientourl'])) {
    require('../../../Clases/cliente.class.php');
    $objCuenta = new Clase;
    $id_asientourl = $_GET['id_asientourl'];
    $fechaurl = $_GET['fechaurl'];
    ?>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">
            <title>::EDIT::</title>
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
            <link href="../../../../css/plugins/dataTables.bootstrap.css" rel="stylesheet">
            <!-- Custom Fonts -->
            <link href="../../../../css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                $objMenu->menu_header_level($_SESSION['loginu'], $idlogeobl);
                ?>

                    <div class="navbar-default sidebar" role="navigation">
                        <div class="sidebar-nav navbar-collapse">
                            <ul class="nav" id="nav">
                                <li class="current"><a href="star_balance.php">B Inicial</a></li>
                                <li><a href="Bl_inicial.php">Asientos</a></li>
                                <li><a href="automayorizacion.php">Mayorizacion</a></li>
                                <li><a href="index_modulo_contable.php">Diario</a></li>
                                <li><a href="balancederesultados.php">B. Resultados</a></li>								
                                <li><a href="situacionfinal.php">Perdidas y Ganancias</a></li>								
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                        <!-- /.sidebar-collapse -->
                    </div>
                    <!-- /.navbar-static-side -->
                </nav>

                <div id="page-wrapper" >
                    
                        <form name="form" id="form" action="" method="post">
                    <div class="row">
                        <div class="col-lg-12">
                            <center>  <h1 class="page-header">MODIFICAR ASIENTO # <?Php echo $_GET['id_asientourl'] ?></h1> </center>
                        </div>
                        <!--                     <button class="btn btn-success" data-toggle="modal" data-target="#myModal" onclick="pago_alumno();">
                                                <i class="glyphicon glyphicon-edit"></i>
                                             </button>-->
                        <!-- /.col-lg-12 -->


                    </div>
                                                               
                                                        <div id="mensajebien" class="alert-success">
                                                        </div>
                                                        <div id="mensajemal" class="alert-warning">
                                                        </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6">

                        </div>
                        <div class="col-lg-3 col-md-6">

                        </div>
                        <div class="col-lg-3 col-md-6">

                        </div>
                        <div class="col-lg-3 col-md-6">

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
                        $sqlsumresDH = "SELECT sum( j.debe ) AS d, sum( j.haber ) AS h
FROM libro j
JOIN num_asientos n
WHERE j.asiento = n.t_ejercicio_idt_corrientes
AND n.idnum_asientos =" . $id_asientourl . "
AND j.t_bl_inicial_idt_bl_inicial = '" . $maxbalancedato . "'
AND j.year = '" . $year . "' ";
                        $resDH = mysqli_query($db, $sqlsumresDH);
                        while ($row1 = mysqli_fetch_array($resDH)) {
                            $ddetall = $row1['d'];  //echo "<script>alert(".$ddetall.")</script>";
                            $hdetall = $row1['h'];
                        }
                        //AND e.fecha = n.fecha
                        $sqlbuscagrupos = "SELECT n.`idnum_asientos` AS id, n.`t_ejercicio_idt_corrientes` ej, n.`concepto` c,
                                        concat( u.nombre,' ', u.apellido ) AS Empleado, s.tipo_user AS Cargo,n.fecha
FROM `num_asientos` n JOIN libro e JOIN logeo l JOIN usuario u JOIN user_tipo s
WHERE e.asiento = n.t_ejercicio_idt_corrientes 
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
                            ?>
                            <div class="col-lg-10">
                                <div class="panel panel-default">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="panel-heading">
                                            <input type="hidden" name="idnumass" id="idnumass" value="<?Php echo $idasiento; ?>" readonly="readonly" />
                                            <input type="hidden" name="idlogeo" id="idlogeo" value="<?Php echo $idlogeous; ?>" readonly="readonly" />
                                            <?Php
                                            echo '<br>';
                                            echo "Ingreso :"; echo $f;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="panel-heading">
                                            <label class="form">Fecha :</label>
                                            <input type="text" class="form-control datepicker" id="datetimepicker1" name="datetimepicker1" value=""/>
                                            <link rel="stylesheet" type="text/css" href="../../../../datepicker/jquery.datetimepicker.css"/>
                                            <script src="../../../../datepicker/jquery.js"></script>
                                            <script src="../../../../datepicker/jquery.datetimepicker.full.js"></script>
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
                                                });
                                            </script>
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
                                            <table class="table table-hover" id="tabedit">
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
                                                        echo '<th colspan="3" style="text-align: center;vertical-align: middle;"> Ref : ' . $codgrupo;
                                                        echo '<a href="impresiones/impasiento.php?id_asientourl=' . $idasiento . '&fechaurl=' . $f . '&idlogeo=' . $idlogeous . '">'
                                                        . '<img src="./images/print.png" alt="Imprimir" title="Imprimir" /> </a>';
                                                        echo '<th>';
                                                        ?>
                                                    </tr>
                                                    <?Php
                                                    echo '<input name="valor" type="hidden" id="valor" value="';
                                                    echo $codgrupo;
                                                    echo '"/>';

                                                    $n = 0;
                                                    $c = 1;
                                                    $sql_cuentasgrupos  = "SELECT idlibro as id,`asiento` as ejercicio , `asiento` as idt_corrientes, `fecha` , `ref` as cod_cuenta ,"
                                                            . " `cuenta` , debe, haber, `t_bl_inicial_idt_bl_inicial` as balance , "
                                                            . "grupo as tipo FROM `libro` "
                                            . "WHERE `t_bl_inicial_idt_bl_inicial` = '".$maxbalancedato."' AND `asiento` =".$codgrupo." AND year='".$year."' ORDER BY asiento";
                                                
                                                    $result2 = mysqli_query($db, $sql_cuentasgrupos) or trigger_error("Query Failed! SQL: $sql_cuentasgrupos - Error: " . mysqli_error($db), E_USER_ERROR);
                                                    while ($r2 = mysqli_fetch_array($result2)) {
                                                        ?>

                                                        <tr>
                                                            <td width="5%" style="display: none;"><?Php echo $r2['idt_corrientes']; ?>
                                                                <input type="text" class="form-control" name="idt_corrientes" id="idt_corrientes" value="<?Php echo $r2['id']; ?>"  />
                                                                <input type="text" class="form-control" name="campo1[]" id="idt_cont<?Php echo $c; ?>" value="<?Php echo $r2['id']; ?>"  />
                                                            <td width="35%">
                                                                <?Php // echo $r2['cod_cuenta']; ?>
                                                                </div>
                                                                <div class="input-group">
                                                                    <input type="text" list="cuent" name="campo2[]" id="cuentfas<?Php echo $c; ?>_1" class="form-control" value="<?Php echo $r2['cod_cuenta'] ?>" placeholder="Ingrese Cod Cuenta...">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn btn-default" onclick="ver(<?Php echo $c; ?>), cont(<?Php echo $c; ?>)" type="button" id="btnver">Ver!</button>
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <?Php
                                                                    $B_BUSCAR = "SELECT g.cod_grupo as grupo, g.nombre_grupo as nom FROM `t_plan_de_cuentas` p JOIN t_grupo g WHERE p.`t_grupo_cod_grupo` = g.cod_grupo AND `cod_cuenta` = '" . $r2['tipo'] . "'";
                                                                    $rnom = mysqli_query($db, $B_BUSCAR);
                                                                    $f = mysqli_fetch_array($rnom);
                                                                    if ($f == 0) {//        echo 'Error de codigo';
                                                                        ?>                           
                                                                        <input type="hidden" class="form-control" name="campo3[]" id="grupofas<?Php echo $c; ?>" readonly="readonly" value="Error de codigo"/> 
                                                                        <?Php echo "Error de codigo"; ?> 
                                                                        <?Php
                                                                    } else {
                                                                        $dato = $f['grupo'];
                                                                        $dato1 = $f['nom'];
                                                                        $codcuenta = $dato;
                                                                        $nomcuenta = $dato1;
                                                                        ?>                           
                                                                        <input type="hidden" class="form-control" name="campo3[]" id="grupofas<?Php echo $c; ?>" readonly="readonly" value="<?Php echo $nomcuenta; ?>"/> 
                                                                        <?Php // echo $nomcuenta; ?>
                                                                        <?Php
                                                                    }
                                                                    ?>
                                                                    <?Php // echo $r2['tipo']; ?>
                                                                    <input type="hidden" class="form-control" name="campo4[]" readonly="readonly" id="codgrupofas<?Php echo $c; ?>" value="<?Php echo $r2['tipo']; ?>"  >

                                                                    </td>
                                                                    <td width="25%">
                                                                        <input type="text" class="form-control" name="campo5[]" id="cuentafas<?Php echo $c; ?>" value="<?Php echo $r2['cuenta']; ?>"  >
                                                                        <?Php // echo $r2['cuenta']; ?></td>
                                                                    <td width="10%"> 
                                                                        <input type="text" class="form-control" name="campo6[]" id="debe<?Php echo $c; ?>_2" value="<?Php echo $r2['debe']; ?>" onkeyup="validarupd(this.id);"  >
                                                                        <?Php // echo $r2['debe']; ?> </td>
                                                                    <td width="10%"> 
                                                                        <input type="text" class="form-control" name="campo7[]" id="haber<?Php echo $c; ?>_3" value="<?Php echo $r2['haber']; ?>" onkeyup="validaruph(this.id);"  >
                                                                        <input type="hidden" class="form-control" name="campo8[]" id="campo" value="<?Php echo $c;?>" />
                                                                        <?Php // echo $r2['debe']; ?> </td>
                                                                <?Php // echo $r2['haber']; ?> </td>
                                                            <td> 
                                                                <!---->


                                                            </td>
                                                            <td>
                                                                <button type="button"  onclick="upmod(this.id)" value="" name="up-<?Php echo $c; ?>" id="up-<?Php echo $c; ?>" >
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
                                                            $c++;
                                                        }
                                                        $n++;
                                                    }
                                                    ?>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td> <strong>TOTAL : </strong> </td>
                                                    <td><?Php // echo $ddetall;   ?>
                                                        <input type="text"  readonly="readonly" class="form-control" name="camposumadebe" id="camposumadebe" value="<?Php echo $ddetall; ?>"/>
                                                    </td>
                                                    <td><?Php // echo $hdetall;   ?>
                                                        <input type="text"  readonly="readonly" class="form-control" name="camposumahaber" id="camposumahaber" value="<?Php echo $hdetall; ?>"/>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                            <textarea class="form-control" id="textarea_as" name="textarea_as" rows="1" cols="30"><?Php echo utf8_decode($nombre_grupo) ?></textarea>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                            
                    </div>
                    <!-- /.row -->
                    <?Php
//                    asdas
                    echo '</table>';
//                    echo '<a target="_blank" href="./impresiones/balanceimp.php?idlogeo=' . $idlogeous . ''
//                    . '&id_asientourl=' . $id_asientourl . '&fech_url=' . $fechaurl . ' " class="btn btn-success">ACTUALIZAR</a>';
//                    echo '</center>';
                    ?>
                    <!--<a target="_blank" onclick="verif()"class="btn btn-success">ACTUALIZAR</a>-->
                    <input type="submit" name="update" id="update" class="btn btn-success" onclick="verifasslib()" value="ACTUALIZAR"/>
                    </form>
                </div>
                <!-- /#page-wrapper -->
            </div>
            <!-- /#wrapper -->
            <!-- jQuery -->
            <script src="./../../../../js/jquery-1.11.0.js"></script>
            <!-- Bootstrap Core JavaScript -->
            <script src="./../../../../js/bootstrap.min.js"></script>
            <!-- Metis Menu Plugin JavaScript -->
            <script src="./../../../../js/plugins/metisMenu/metisMenu.min.js"></script>
            <script src="./../../../../js/plugins/dataTables/jquery.dataTables.js"></script>
            <script src="./../../../../js/plugins/dataTables/dataTables.bootstrap.js"></script>
            <!-- Morris Charts JavaScript -->
            <script src="./../../../../js/plugins/morris/raphael.min.js"></script>
            <script src="./../../../../js/plugins/morris/morris.min.js"></script>
            <script src="./../../../../js/plugins/morris/morris-data.js"></script>
            <!-- Custom Theme JavaScript -->
            <script src="./../../../../js/sb-admin-2.js"></script>
            <script src="./../../../../js/js.js"></script>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">ACTUALIZAR DATOS</h4>
                        </div>
                        <div class="modal-body" id="caja">

                        </div>
                    </div>
                </div>
            </div>
        <?Php } ?>
    </body>
</html>
