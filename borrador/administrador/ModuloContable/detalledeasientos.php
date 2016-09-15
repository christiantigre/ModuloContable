<!DOCTYPE html>
<!--Christian Tigre-->
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
//Proceso de conexi�n con la base de datos
$conex = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
mysql_select_db("condata", $conex) or die("ERROR con la base de datos");
//Iniciar Sesi�n
session_start();
$date = date("Y-m-j");
$mes = date('F');
$year = date("Y");
//Validar si se est� ingresando con sesi�n correctamente
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "login.php"
</script>';
}

$id_usuario = $_SESSION['username'];
$consulgrupo = "SELECT * FROM `t_grupo`";
$queryclases = mysql_query($consulgrupo, $conex);
$consulta = "SELECT l.username, u.tipo_user,l.idlogeo
FROM logeo l
JOIN user_tipo u
WHERE l.username = '" . $id_usuario . "'";
$resultado = mysql_query($consulta, $conex) or die(mysql_error());
$fila = mysql_fetch_array($resultado);
$user = $fila['username'];
$type_user = $fila['tipo_user'];
$idlogeous = $fila['idlogeo'];

mysql_close($conex);


//$id_asientourl = $_GET['id_asientourl'];
$fechaurl = $_GET['fechaurl'];
if (isset($_GET['id_asientourl'])) {
    require('../../../Clases/cliente.class.php');
    $objCuenta = new Clase;
    $id_asientourl = $_GET['id_asientourl'];
    $fechaurl = $_GET['fechaurl'];
    ?>
    <html>
        <head>
            <title>Detalle de Asiento</title>
            <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
            <link href="../../css/mod_contable.css" rel='stylesheet' type='text/css' />

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
                    <?php
                        include './component/headercont.php';
                    ?>
                </center>
                <div id="cuerpo">
                    <div id="banner_left"></div>
                    <div id="formulario_bl">
                        <center>                        
                            <form id="form_ejercicio" >
                                <center><strong>Detalle de Asiento</strong></center> 
                                <?Php
                                $db = new mysqli("localhost", "root", "alberto2791", "condata");
                                $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";


                                $result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
                                    }
                                }


                                $sqlsumresDH = " SELECT sum( j.debe ) AS d, sum( j.haber) AS h FROM libro j join num_asientos n
WHERE j.asiento=n.t_ejercicio_idt_corrientes AND n.idnum_asientos=" . $id_asientourl . "
AND j.mes = '" . $mes . "' AND j.t_bl_inicial_idt_bl_inicial='" . $maxbalancedato . "'
AND j.year = '" . $year . "' ";

                                $resDH = mysqli_query($db, $sqlsumresDH);
                                while ($row1 = mysqli_fetch_array($resDH)) {
                                    $ddetall = $row1['d'];  //echo "<script>alert(".$ddetall.")</script>";
                                    $hdetall = $row1['h'];
                                }


                                $sqlbuscagrupos = "SELECT n.`idnum_asientos` AS id, n.`t_ejercicio_idt_corrientes` ej, n.`concepto` c,
                                        concat( u.nombre,' ', u.apellido ) AS Empleado, s.tipo_user AS Cargo
FROM `num_asientos` n JOIN libro e JOIN logeo l JOIN usuario u JOIN user_tipo s
WHERE e.asiento = n.t_ejercicio_idt_corrientes AND e.fecha = n.fecha
AND e.logeo_idlogeo = l.user_tipo_iduser_tipo AND l.usuario_idusuario = u.idusuario
AND s.iduser_tipo = l.user_tipo_iduser_tipo
AND n.fecha = '" . $fechaurl . "'
AND n.idnum_asientos = '" . $id_asientourl . "' AND e.year='" . $year . "'
GROUP BY `t_ejercicio_idt_corrientes`";
                                $result_grupo = mysqli_query($db, $sqlbuscagrupos) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                echo '<center>';
                                echo '<table style="padding:5px;background:#555;color:#fff;width: 960px;">';
                                echo '<tr>';
                                echo '<td style="display:none">id</td>';
                                echo '<td>Fecha</td>';
                                echo '<td>Codigo</td>';
                                echo '<td>Cuenta</td>';
                                echo '<td>Debe</td>';
                                echo '<td>Haber</td>';
                                echo '</tr>';

                                while ($rw = mysqli_fetch_assoc($result_grupo)) {
                                    $idasiento = $rw['id'];
                                    $nombre_grupo = $rw['c'];
                                    $codgrupo = $rw['ej'];
                                    $emp = $rw['Empleado'];
                                    $crg = $rw['Cargo'];
                                    $d = $rw['d'];
                                    $h = $rw['h'];
                                    echo '<table id="tblDatos"  width="85%" class="table" style="padding:5px;width: 960px;">';
                                    echo '<tr><th colspan="5" > Registrado por : ' . $crg . ' - ' . $emp . '</th>  </tr>';
                                    echo '<tr><th colspan="5" style="text-align: center;vertical-align: middle;"> Ref : ' . $codgrupo . '</tr>';
                                    echo '<input name="valor" type="hidden" id="valor" value="';
                                    echo $codgrupo;
                                    echo '"/>';

                                    $n = 0;
                                    $sql_cuentasgrupos = "SELECT `idlibro` , `asiento` , `fecha` , `ref` , `cuenta` ,
                                        debe, haber, `t_bl_inicial_idt_bl_inicial` , grupo
FROM `libro` WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "' AND `asiento` =" . $codgrupo . " AND year='" . $year . "' ORDER BY asiento";
                                    $result2 = mysqli_query($db, $sql_cuentasgrupos);
                                    //echo "<script>alert(".$id_asientourl.")</script>";       


                                    while ($r2 = mysqli_fetch_array($result2)) {
                                        echo '<tr>';
                                        echo '<td width="5%" style="display:none">  ' . $r2['idlibro'] . '   </td>';
                                        echo '<td width="15%">  ' . $r2['fecha'] . '   </td>';
                                        echo '<td width="15%">  ' . $r2['ref'] . '   </td>';
                                        echo '<td width="35%">  ' . $r2['cuenta'] . '   </td>';
                                        echo '<td width="10%">  ' . $r2['debe'] . '   </td>';
                                        echo '<td width="10%">  ' . $r2['haber'] . '   </td>';
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
                                echo '<a target="_blank" href="./impresiones/impasientos.php?idlogeo=' . $idlogeous . ''
                                . '&id_asientourl=' . $id_asientourl . '&fech_url=' . $fechaurl . ' " class="btn btn-danger">Exportar a PDF</a>';
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
    </body>
</html>	
