<!DOCTYPE html>
<!--Christian Tigre-->
<?php
require '../../../templates/Clases/Conectar.php';
require '../../../templates/PaneldeAdministrador/admin_users/functions.php';
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
$dbi = new Conectar();
$c = $dbi->conexion();
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../login.php"
</script>';
}
$year = date("Y");
$date = date("j-m-Y");
$id_usuario = $_SESSION['username'];
$user = $_SESSION['username'];
$idlogeo = $_SESSION['id_user'];

//include '../../Clases/guardahistorial.php';
//$accion = " / HISTORIAL / Ingreso a panel historial";
//generaLogs($_SESSION['username'], $accion);

mysqli_close($c);
?>
<html>
    <head>
        <title>Registro de Historial</title>
        <link href="../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <link href="../../../css/style.csss" rel='stylesheet' type='text/css' />
        <script src="../../../js/jquery.min.js"></script>
        <script src="../../../js/jquery-1.10.2.min.js"></script>
        <link href="../../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <script src="../../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../../js/jquery.functions.js" type="text/javascript"></script>
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
        <div class="wrapper">
            <!----start-header---->
            <div class="header">
                <div class="container header_top">
                    <!--                    <div class="logo">
                                            <a href="../../../index.php"><img src="../../../images/logo.png" width="650" height="100" alt=""></a>
                                        </div>-->
                    <div class="menu">
                        <a class="toggleMenu" href="#"><img src="../../../images/nav_icon.png" alt="" /> </a>
                        <ul class="nav" id="nav">
                            <li><a href="../../../index.php">Panel</a></li>
                            <li><a href="../funcionesdeadministrador/catalogodecuentas.php">Plan de Ctas</a></li>	
                            <li class="current"><a href="#">Documentos</a></li>	
                            <div class="clearfix"></div>
                        </ul>
                        <script type="text/javascript" src="../../../js/responsive-nav.js"></script>
                    </div>	
                    <div class="clearfix">
                        <!-- Caja de Usuario  -->
                        <div class="cajauser">
                            <table width="718" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>&nbsp;</tr>
                                <tr>
                                    <td colspan="2"><div align="right">Usuario: <span class="Estilo6"><strong><?php echo $_SESSION['username']; ?> </strong></span></div></td>            
                                    <td colspan="2"><div align="right">Acceso de: <span class="Estilo6"><strong><?php echo $type_user; ?> </strong></span></div></td>
                                    <td><input name="idlog" id="idlog" type="hidden" value="<?php echo $idlogeous; ?>" /></td>
                                    <td></td>
                                    <td colspan="2"><div align="right"><a href="../../../templates/logeo/desconectar_usuario.php"><img src="../../../images/logout.png" title="Salir" alt="Salir" /></a> </div></td>

                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>

                        </div>

                    </div>

                    <!----//End-top-nav---->
                </div>

            </div>
            <!----- //End-header---->
            <div id="contenedor">
                <div id="cuerpo">
                    <div id="banner_left"></div>
                    <div id="formulario_bl">
                        <center>
                            <form name="record" id="record" action="record.php" method="post">
                                <h3>Historial</h3>
                                <label>Fecha : <a onclick="show_calendar()" style="cursor: pointer;">
                                                <!--<small>(calendario)</small>-->
                                        <img src="../../../images/calendar.png" alt="Calendario" title="Calendario"/>
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
                                        $fecha2 = date("j-m-Y", strtotime($fecha_record));
                                        $nom_arc = $fecha2;
                                        $nombre_archivo = "../../../hss/$nom_arc";
                                        if (file_exists($nombre_archivo)) {
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
                                            $accion = " / HISTORIAL / Visualizo Historial de fecha " . $fecha2;
                                            generaLogs($_SESSION['username'], $accion);
                                        } else {
                                            $mensaje = "El archivo no existe";
                                        }
                                    }
                                }
                                ?>
                            </form>                    
                        </center>
                    </div>
                </div>
            </div>
        </div> 
        <!--otro formulario-->

    </body>
</html>	
