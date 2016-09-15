<!DOCTYPE html>
<!--Christian Tigre-->
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

mysqli_close($conex);

$id_asientourl = $_GET['id_asientourl'];
$fechaurl = $_GET['fechaurl'];
if (isset($_GET['id_asientourl'])) {
    require('../../../Clases/cliente.class.php');
    $objCuenta = new Clase;
    $id_asientourl = $_GET['id_asientourl'];
    $fechaurl = $_GET['fechaurl'];
    ?>
    <html>
        <head>
            <title>Editar Asiento</title>
            <link href="../../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
            <script src="../../../../js/jquery.min.js"></script>
            <link href="../../../../css/mod_contable.css" rel='stylesheet' type='text/css' />
            <link href="../../../../css/sb-admin-2.css" rel='stylesheet' type='text/css' />
            <link href="../../../../less/sb-admin-2.css" rel='stylesheet' type='text/css' />
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
            <script src="../../../../js/easyResponsiveTabs.js" type="text/javascript"></script>
            <script src="../../../../js/jquery.functions.js" type="text/javascript"></script>
            <!--ini edit asiento-->
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#horizontalTab').easyResponsiveTabs({
                        type: 'default', //Types: default, vertical, accordion           
                        width: 'auto', //auto or any width like 600px
                        fit: true   // 100% fit in a container
                    });
                });

                function pago_alumno() {
                    var resultado = document.getElementById('page-wrapper');
                    //    resultado.innerHTML = '<br><br><br><center><img src="img/45.gif"></center>';
                    ajax = objetoAjax();
                    ajax.open("GET", "../editasiento/updata.php", true);
                    ajax.onreadystatechange = function () {
                        if (ajax.readyState == 4) {

                            resultado.innerHTML = ajax.responseText;
                            tables();
                        }
                    }
                    ajax.send(null);
                }
            </script>	

        </head>
        <style>
            .contenedores{margin:60px auto;width:960px;font-family:sans-serif;font-size:15px}
            table {width:100%;box-shadow:0 0 10px #ddd;text-align:left}
            th {padding:5px;background:#555;color:#fff}
            td {padding:5px;border:solid #ddd;border-width:0 0 1px;}
            .editable span{display:block;}
            .editable span:hover {background:url(images/edit.png) 90% 50% no-repeat;cursor:pointer}

            td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
            a.enlace{display:inline-block;width:24px;height:24px;margin:0 0 0 5px;overflow:hidden;text-indent:-999em;vertical-align:middle}
            .guardar{background:url(images/save.png) 0 0 no-repeat}
            .cancelar{background:url(images/cancell.png) 0 0 no-repeat}

            .mensaje{display:block;text-align:center;margin:0 0 20px 0}
            .ok{display:block;padding:10px;text-align:center;background:green;color:#fff}
            .ko{display:block;padding:10px;text-align:center;background:red;color:#fff}
        </style>
        <body>
            <div id="contenedor">
                <center>
                    <div id="menus">
                        <!--Menu contable-->
                        <div id="menu_contable">
                            <div class="menu">
                                <ul class="nav" id="nav">
                                    <li><a href="../../index_admin.php">Panel</a></li>
                                    <li><a href="../../catalogodecuentas.php">Plan de Ctas</a></li>
                                    <!--<li><a href="">Usuarios</a></li>-->
                                    <li><a href="../documentos/documentos.php">Documentos</a></li>								
                                    <div class="clearfix"></div>
                                </ul>
                            </div>
                            <div>
                                <center><h1>Modulo de Contabilidad</h1></center>
                            </div>
                        </div>
                        <!--Menu general-->
                        <div id="menu_general">                
                            <div id="caja_us">
                                <table width="718" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>&nbsp;</tr>
                                    <tr>
                                        <td colspan="2"><div align="right">Usuario: <span class="Estilo6"><strong><?php echo $_SESSION['username']; ?> </strong></span></div></td>            
                                        <!--<td colspan="2"><div align="right">Acceso de: <span class="Estilo6"><strong>
                                        <?php
                                        //echo $type_user; 
                                        ?> 
                                        </strong></span></div></td>-->
                                        <td>&nbsp;</td>
                                        <td colspan="2"><div align="left">
                                                <a href="../../../../templates/logeo/desconectar_usuario.php">
                                                    <img src="../../../../images/logout.png" title="Salir" alt="Salir" /></a> </div></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp; 
                                        </td>
                                    </tr>
                                </table>
                            </div>                
                            <div class="menu">
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
                        </div>
                    </div>
                </center>
                <div id="page-wrapper">
                <div id="cuerpo">
                    <div id="banner_left"></div>
                    <div id="formulario_bl">
                        <center>                               
                            <form id="form_ejercicio" >
                                <center><strong>EDITAR ASIENTO</strong></center> 

                                </br>
                                </br>
                                <?Php
                                //$dbi = new Conectar();
                                $db = $dbi->conexion();
                                $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
                                $result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($db), E_USER_ERROR);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
                                    }
                                }
                                $sqlsumresDH = " SELECT sum( j.valor ) AS d, sum( j.valorp ) AS h
FROM t_ejercicio j join num_asientos n
WHERE j.ejercicio=n.t_ejercicio_idt_corrientes
AND n.idnum_asientos=" . $id_asientourl . "
AND j.mes = '" . $mes . "' AND j.t_bl_inicial_idt_bl_inicial='" . $maxbalancedato . "'
AND j.year = '" . $year . "' ";
                                $resDH = mysqli_query($db, $sqlsumresDH);
                                while ($row1 = mysqli_fetch_array($resDH)) {
                                    $ddetall = $row1['d'];  //echo "<script>alert(".$ddetall.")</script>";
                                    $hdetall = $row1['h'];
                                }
                                $sqlbuscagrupos = "SELECT n.`idnum_asientos` AS id, n.`t_ejercicio_idt_corrientes` ej, n.`concepto` c,
                                        concat( u.nombre,' ', u.apellido ) AS Empleado, s.tipo_user AS Cargo,n.fecha
FROM `num_asientos` n JOIN t_ejercicio e JOIN logeo l JOIN usuario u JOIN user_tipo s
WHERE e.ejercicio = n.t_ejercicio_idt_corrientes AND e.fecha = n.fecha
AND e.logeo_idlogeo = l.user_tipo_iduser_tipo AND l.usuario_idusuario = u.idusuario
AND s.iduser_tipo = l.user_tipo_iduser_tipo
AND n.fecha = '" . $fechaurl . "'
AND n.idnum_asientos = '" . $id_asientourl . "' AND e.year='" . $year . "'
GROUP BY `t_ejercicio_idt_corrientes`";
                                $result_grupo = mysqli_query($db, $sqlbuscagrupos) or trigger_error("Query Failed! SQL: $sqlbuscagrupos - Error: " . mysqli_error($db), E_USER_ERROR);
                                echo '<center>';
                                echo '<table style="padding:5px;background:#555;color:#fff;width: 960px;">';
                                echo '<tr>';
                                echo '<td style="display:none">id</td>';
                                echo '<td>Fecha</td>';
                                echo '<td>Codigo</td>';
                                echo '<td>Cuenta</td>';
                                echo '<td>Debe</td>';
                                echo '<td>Haber</td>';
                                echo '<td>Acción</td>';
                                echo '</tr>';

                                while ($rw = mysqli_fetch_assoc($result_grupo)) {
                                    $idasiento = $rw['id'];
                                    $nombre_grupo = $rw['c'];
                                    $codgrupo = $rw['ej'];
                                    $emp = $rw['Empleado'];
                                    $crg = $rw['Cargo'];
                                    $f = $rw['fecha'];
                                    $d = $rw['d'];
                                    $h = $rw['h'];
                                    echo '<table id="tblDatos"  width="85%" class="table" style="padding:5px;width: 960px;">';
                                    echo '<tr><th colspan="7" > Registrado por : ' . $crg . ' - ' . $emp . '</th>  </tr>';
                                    echo '<tr><th colspan="6" style="text-align: center;vertical-align: middle;"> Ref : ' . $codgrupo;
                                    echo '<a href="impresiones/impasiento.php?id_asientourl=' . $idasiento . '&fechaurl=' . $f . '&idlogeo=' . $idlogeous . '">'
                                    . '<img src="./images/print.png" alt="Imprimir" title="Imprimir" /> </a>';
                                    echo '<th>';
                                    echo '</tr>';
                                    echo '<input name="valor" type="hidden" id="valor" value="';
                                    echo $codgrupo;
                                    echo '"/>';

                                    $n = 0;
                                    $sql_cuentasgrupos = "SELECT `ejercicio` , `idt_corrientes` ,ejercicio as ej, `fecha` , 
                                        `cod_cuenta` , `cuenta` , `valor` AS debe, `valorp` AS haber, `t_bl_inicial_idt_bl_inicial` as balance , tipo, 
                                        logeo_idlogeo as log, mes, year
                                        FROM `t_ejercicio` WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "' "
                                            . "AND `ejercicio` =" . $codgrupo . " AND year='" . $year . "' ORDER BY ejercicio";
                                    $result2 = mysqli_query($db, $sql_cuentasgrupos) or trigger_error("Query Failed! SQL: $sql_cuentasgrupos - Error: " . mysqli_error($db), E_USER_ERROR);
                                    //echo "<script>alert(".$id_asientourl.")</script>";       
                                    while ($r2 = mysqli_fetch_array($result2)) {
                                        echo '<tr>';
                                        echo '<td width="5%" style="display:none">  ' . $r2['idt_corrientes'] . '   </td>';
                                        echo '<td width="15%">  ';
                                        echo '<input type="text" class="compa3" name="datetimepicker1" id="datetimepicker1" value="' . $r2['fecha'] . '"/>';
                                        echo '</td>';
                                        echo '<td width="15%">  ';
                                        echo '<input type="text" class="compa3" name="cod_cuenta" id="cod_cuenta" value="' . $r2['cod_cuenta'] . '"/>';
                                        echo '</td>';
                                        echo '<td width="35%">  ';
                                        echo '<input type="text" class="compa3" name="cuenta" id="cuenta" value="' . $r2['cuenta'] . '"/>';
                                        echo '</td>';
                                        echo '<td width="10%">  ';
                                        echo '<input type="text" class="compa3" name="debe" id="debe" value="' . $r2['debe'] . '"/>';
                                        echo '</td>';
                                        echo '<td width="10%">  ';
                                        echo '<input type="text" class="compa3" name="haber" id="haber" value="' . $r2['haber'] . '"/>';
                                        echo '</td>';
                                        $r2['ej'];
                                        $r2['balance'];
                                        $r2['tipo'];
                                        $r2['log'];
                                        $r2['mes'];
                                        $r2['year'];
                                        echo '<td>';
//                                        echo '<a href="arch.php?formmod='.$r2['idt_corrientes'].'"  rel="moodalbox 1000 650" >'
//                                        . '<img src="../../../../images/database_edit.png" alt="EDITAR" title="EDITAR" /></a>';
                                        ?>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#myModal" onclick="pago_alumno();">
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </button>
                                        <?Php
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    echo '<tfoot>';
                                    echo '
                                    <td></td>
                                    <td></td>
                                    <td> <strong>Total :</strong> </td>
                                    <td>
                                        <input type="text"  readonly="readonly" class="compa3"
                                        name="camposumadebe" id="camposumadebe" value="' . $ddetall . '"/> 
                                    </td>
                                    <td>
                                        <input type="text"  readonly="readonly" class="compa3"
                                        name="camposumahaber" id="camposumahaber" value="' . $hdetall . '"/>
                                    </td>';
                                    echo '</tfoot>';
                                    echo '<tr>';
                                    echo '<th colspan="6" style="background-color: #ddd;"> Concepto :'
                                    . '<textarea class="form-control" id="textarea_as" name="textarea_as" rows="1" cols="30">' . $nombre_grupo . '</textarea></th>';
                                    //echo '' . $nombre_grupo . '';
                                    echo '</tr>';
                                    echo '</table>';
                                    $n++;
                                }

                                echo '</table>';
                                echo '<a target="_blank" href="./impresiones/balanceimp.php?idlogeo=' . $idlogeous . ''
                                . '&id_asientourl=' . $id_asientourl . '&fech_url=' . $fechaurl . ' " class="btn btn-success">ACTUALIZAR</a>';
                                echo '</center>';
                                ?>

                            </form>
                            <?php
                        }
                        ?>



                    </center>
                    </div>
                 </div>
                </div>        
        </div>        



        <!--ini edicion de asiento--> 


        <!-- jQuery -->
        <script src="../../../../../js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../../../../../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../../../../js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="../../../../../js/plugins/morris/raphael.min.js"></script>
        <script src="../../../../../js/plugins/morris/morris.min.js"></script>
        <script src="../../../../../js/plugins/morris/morris-data.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../../../../../js/sb-admin-2.js"></script>
        <script src="../../../../../js/js.js"></script>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


        <!--fin edicion de asiento-->            

    </body>
</html>	
