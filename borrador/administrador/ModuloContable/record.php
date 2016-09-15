<!DOCTYPE html>
<!--Christian Tigre-->
<?php
require '../../../../templates/Clases/Conectar.php';
require '../../../PaneldeAdministrador/admin_users/functions.php';
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
$dbi = new Conectar();
$c = $dbi->conexion();
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "login.php"
</script>';
}
$year = date("Y");
$date = date("j-m-Y");
$id_usuario = $_SESSION['username'];
$consulta = "SELECT l.username, u.tipo_user, l.idlogeo
FROM logeo l
JOIN user_tipo u
WHERE l.user_tipo_iduser_tipo = u.iduser_tipo
AND l.username = '" . $id_usuario . "'";
$resultado = mysqli_query($c, $consulta) or die(mysqli_error($c));
$fila = mysqli_fetch_array($resultado);
$user = $fila['username'];
$type_user = $fila['tipo_user'];
$idlogeo = $fila['idlogeo'];

include '../../Clases/guardahistorial.php';
$accion = "Ingreso a historial";
generaLogs($user, $accion);

mysqli_close($c);
?>
<html>
    <head>
        <title>Registro de Historial</title>
        <link href="../../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <link href="../../../../css/style.csss" rel='stylesheet' type='text/css' />
        <script src="../../../../js/jquery.min.js"></script>
        <link href="../../../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <script src="../../../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../../../js/jquery.functions.js" type="text/javascript"></script>
    </head>
    <style>
        .contenedores{margin:60px auto;width:960px;font-family:sans-serif;font-size:15px}
        table {width:72%;box-shadow:0 0 10px #ddd;text-align:left}
        th {padding:5px;background:#555;color:#fff}
        td {padding:5px;border:solid #ddd;border-width:0 0 1px;}
        .editable span{display:block;}
        .editable span:hover {background:url(images/edit.png) 90% 50% no-repeat;cursor:pointer}
        .tablib{margin-right:187px;}
        td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
        a.enlace{display:inline-block;width:24px;height:24px;margin:0 0 0 5px;overflow:hidden;text-indent:-999em;vertical-align:middle}
        .guardar{background:url(images/save.png) 0 0 no-repeat}
        .cancelar{background:url(images/cancell.png) 0 0 no-repeat}
        .compa3{width: auto;}
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
                                <li><a href="../catalogodecuentas.php">Plan de Ctas</a></li>
                                <!--<li><a href="">Usuarios</a></li>-->
                                <li><a href="documentos/documentos.php">Documentos</a></li>								
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
                                    <td colspan="2">
                                        <div align="right">Usuario: 
                                            <span class="Estilo6">
                                                <strong>
                                                    <?php echo $user; ?> 
                                                </strong>
                                            </span>
                                            <input type="hidden" id="idlogeotxt" name="idlogeotxt" value="<?Php echo $idlogeo; ?>"
                                        </div>
                                    </td>            
                                    <!--<td colspan="2"><div align="right">Acceso de: <span class="Estilo6"><strong>
                                    <?php
                                    //echo $type_user; 
                                    ?> 
                                    </strong></span></div></td>-->
                                    <td>&nbsp;</td>
                                    <td colspan="2"><div align="left"><a href="../../../../templates/logeo/desconectar_usuario.php"><img src="../../../../images/logout.png" title="Salir" alt="Salir" /></a> </div></td>
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
                                <li><a href="star_balance.php">B Inicial</a></li>
                                <li><a href="Bl_inicial.php">Asientos</a></li>
                                <li><a href="automayorizacion.php">Mayorizacion</a></li>
                                <li><a href="balancederesultados.php">B. Comprobaci&oacute;n</a></li>								
                                <li><a href="estadoresultados.php">E. Resultados</a></li>								
                                <li><a href="situacionfinal.php">S. Final</a></li>								
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                    </div>
                </div>
            </center>
            <div id="cuerpo">
                <div id="banner_left"></div>
                <div id="formulario_bl">
                    <center>
                        <form name="record" id="record" action="record.php" method="post">
                            <h3>Historial</h3>
                            <label>Fecha : <a onclick="show_calendar()" style="cursor: pointer;">
                                            <!--<small>(calendario)</small>-->
                                    <img src="../../../../images/calendar.png" alt="Calendario" title="Calendario"/>
                                </a>
                                <input class="alert" type="text" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo date("j-m-Y"); ?>" />
                                <input type="submit" name="submit" id="record" class="btn btn-success" value="Ver"/>
                                <div id="calendario" style="display:none;"><?php echo calendar_html(); ?></div>    
                            </label>
                            <?Php
                            echo '</br>';
                            if (isset($_POST["submit"])) {
                                $btntu = $_POST["submit"];
                                if ($btntu == "Ver") {
                                    $fecha_record = htmlspecialchars(trim($_POST['fecha_nacimiento']));
                                    $fecha2=date("j-m-Y",strtotime($fecha_record));

                                    $nom_arc = $fecha2;
                                    $nombre_archivo = "../../../../hss/$nom_arc";
                                    if (file_exists($nombre_archivo)) {
//                                        echo nl2br(file_get_contents($nombre_archivo));
                                        $rows = file($nombre_archivo);
                                    array_shift($rows);
                                        echo "<html><body><table border=1>";
                                        echo "<tr><th>Fecha-Accion</th></tr>";
                                        foreach ($rows as $row) {
                                            $fields = explode("|", $row);
                                            echo "<tr>"
                                            . "<td>" . $fields[0] . "</td>";
                                        }
                                        echo "</table></body></html>";
                                    } else {
                                        $mensaje = "El archivo no existe";
                                    }


//                                    $fecha_record = htmlspecialchars(trim($_POST['fecha_nacimiento']));
//                                    $fecha2=date("j-m-Y",strtotime($fecha_record));
//                                    $path = "../ModuloContable/$fecha2";
////                                    C:\AppServ\www\ModuloContable\
//                                    if (!file_exists($path))
//                                        exit("File not found");
//                                    $rows = file($path);
//                                    array_shift($rows);
//                                    echo "<html><body><table border=1>";
//                                    echo "<tr><th>Fecha-Accion</th></tr>";
//                                    foreach ($rows as $row) {
//                                        $fields = explode("|", $row);
//                                        echo "<tr>"
//                                        . "<td>" . $fields[0] . "</td>";
//                                    }
//                                    echo "</table></body></html>";
                                }
                            }
                            ?>
                        </form>                    
                    </center>
                </div>
            </div>
        </div>
    </div>        
</body>
</html>	
