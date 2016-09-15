<!DOCTYPE html>
<!--Christian Tigre-->
<?php
require '../../PaneldeAdministrador/admin_users/functions.php';
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
//Proceso de conexi�n con la base de datos
$conex = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
mysql_select_db("condata", $conex) or die("ERROR con la base de datos");
//Iniciar Sesi�n
session_start();
//Validar si se est� ingresando con sesi�n correctamente
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "login.php"
</script>';
}

$id_usuario = $_SESSION['username'];
$consul_log = " SELECT count( * ) +1 AS Codigo FROM `logeo` ";
$query_usuarios = mysql_query($consul_log);
$row = mysql_fetch_array($query_usuarios);
$idcod = $row['Codigo'];
$queryclases = mysql_query($consulgrupo, $conex);
$consul_cargos = " SELECT * FROM `user_tipo` WHERE tipo_user != 'Sup'";
$query_cargos = mysql_query($consul_cargos);
$rowcrg = mysql_fetch_array($query_cargos);
$consulta = "SELECT l.username, u.tipo_user
FROM logeo l
JOIN user_tipo u
WHERE l.username = '" . $id_usuario . "'";
$resultado = mysql_query($consulta, $conex) or die(mysql_error());
$fila = mysql_fetch_array($resultado);
$user = $fila['username'];
$type_user = $fila['tipo_user'];
mysql_close($conex);

if (isset($_POST["submit"])) {
    $btntu = $_POST["submit"];
    if ($btntu == "Enviar") {
// echo "<script>alert('boton enviar');</script>";
        require('../../Clases/cliente.class.php');
        $newcod_us = htmlspecialchars(trim($_POST['newcod_us']));
        $pass = htmlspecialchars(trim($_POST['pass']));
        $usuario = htmlspecialchars(trim($_POST['usuario']));
        $crg_us = htmlspecialchars(trim($_POST['crg_us']));
        $idusuario = htmlspecialchars(trim($_POST['idusuario']));
        $objGrupo = new Clase;
        if ($objGrupo->insertar_new_login(array($newcod_us, $pass, $usuario, $crg_us, $idusuario)) == true) {
            echo '<script language = javascript>
alert("Guardado exitosamente...")
self.location = "panel_logeos.php"
</script>';
        } else {
            echo '<script language = javascript>
alert("Ocurrio un error...")
self.location = "new_logeo.php"
</script>';
        }
    }
    if ($btntu == "Buscar") {
        //echo "<script>alert('Buscar')</script>";
        $cc = htmlspecialchars(trim($_POST['cc']));
        $conex = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
        mysql_select_db("condata", $conex) or die("ERROR con la base de datos");
        $consultau = "SELECT * FROM `usuario` WHERE `cedula`='" . $cc . "'";
        $resultadou = mysql_query($consultau, $conex) or die(mysql_error());
        $rw = mysql_fetch_array($resultadou);
        $rowu = $rw['idusuario'];
        $rowd = $rw['nombre'];
        $rowt = $rw['apellido'];
        $rowc = $rw['email'];
        $rowci = $rw['nacionalidad'];
        $rowse = $rw['cedula'];
        $rowsi = $rw['telefono'];
        $campoinfo_us = $rowd . " " . $rowt;
    }
    $contenido = $_POST;

    function limpiarForm() {
        unset($contenido);
    }

}
?>
<html>
    <head>
        <title>Admin de Usuarios</title>
        <link href="../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../../../js/jquery.min.js"></script>
        <!-- Custom Theme files -->
        <!--<link href="../../css/style.css" rel='stylesheet' type='text/css' />-->
        <link href="../../../css/stylerespaldo.css" rel='stylesheet' type='text/css' />
        <link href="../../css/csstabladatos.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <script src="../../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../../js/jquery.functions.js" type="text/javascript"></script>
        <script src="../../../js/jquery-1.3.1.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#horizontalTab').easyResponsiveTabs({
                    type: 'default', //Types: default, vertical, accordion           
                    width: 'auto', //auto or any width like 600px
                    fit: true   // 100% fit in a container
                });
            });


        </script>	

    </head>

    <body>
        <!----- start-header---->
        <div class="wrapper">
            <!----start-header---->
            <div class="header">
                <div class="container header_top">
                    <div class="logo">
                        <a href="../../../index.php"><img src="../../../images/logo.png" width="650" height="100" alt=""></a>
                    </div>
                    <div class="menu">
                        <a class="toggleMenu" href="#"><img src="../../../images/nav_icon.png" alt="" /> </a>
                        <ul class="nav" id="nav">
                            <li><a href="../../../index.php">Panel</a></li>
                            <li><a href="../funcionesdeadministrador/plancuentas.php">Plan de Ctas</a></li>
                            <li class="current"><a href="panel_users.php">Usuarios</a></li>
                            <li><a href="contact.html">Documentos</a></li>								
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
            <div class="container banner">
                <div class="row">
                    <div class='col-md-4'>
                        <a href="../../../index.php">  <img src="../../../images/Home.png" alt="" /> </a><strong> / 
                        </strong><a href="panel_logeos.php">Administraci&oacute;n de Logeos</a>
                        <br>
                        <br>                    
                        <div class="menuadministracion">
                            <a class="toggleMenu" href="#"><img src="../../../images/nav_icon.png" alt="" /> </a>
                            <ul class="nav" id="nav">
                                <li><a href="../admin_users/panel_users.php">
                                        <img src="../../../images/user.png" title="Plan de Cuentas" alt="Plan de Cuentas" />Categor&iacute;as</a></li>
                                <li><a href="panel_users.php"><img src="../../../images/users.png" title="Control de Usuarios" alt="Control de Usuarios" />Usuarios</a></li>							
                                <li class="current"><a href="panel_logeos.php">
                                        <img src="../../../images/ctas.png" title="Control de Usuarios" alt="Control de Usuarios" />Logeos</a></li>							
                                <div class="clearfix"></div>
                            </ul>
                            <script type="text/javascript" src="../../../js/responsive-nav.js"></script>
                        </div>
                    </div>

                    <div id="contenedor">
                        <div id="formulario" style="display:none;">
                        </div>
                        <div id="tabla">
                            <span id="new"><a href="panel_users.php"><img src="../../../images/home_back.png" alt="Agregar dato" /></a></span>
                            <span id="new"><a href="new_user.php"><img src="../../../images/add_us.png" alt="Agregar Usuario" /></a></span>
                            <center>  <strong>Ingreso de Nueva Cuenta de Logeo</strong> </center>
                            <form id="frmClienteNuevo" name="frmClaseNuevo" method="post" action="new_logeo.php" enctype="multipart/form-data" >        
                                <p>
                                    <!--<label>C&oacute;digo<br />-->
                                    <input class="text" type="hidden" name="newcod_us" id="newcod_us" value="<?php echo $idcod; ?>" readonly="readonly"/>
                                </p>
                                <p>
                                    <label>C.I del Usuario.<br />
                                        <input class="text" type="text" name="cc" id="cc" />
                                        <p>
                                            <input type="submit" name="submit" id="buttonbuscar" value="Buscar" /> 
                                        </p>
                                        <input class="text" type="hidden" name="idusuario" id="idusuario" value="<?php echo $rowu ?>"/>
                                        <input class="text" type="hidden" name="idus" id="idus" value="<?php echo $rowd ?>"/>
                                        <input class="text" type="hidden" name="idus" id="idus" value="<?php echo $rowt ?>"/>
                                        <input class="text" type="hidden" name="idus" id="idus" value="<?php echo $rowc ?>"/>
                                        <input class="text" type="hidden" name="idus" id="idus" value="<?php echo $rowci ?>"/>
                                        <input class="text" type="hidden" name="idus" id="idus" value="<?php echo $rowse ?>"/>
                                        <input class="text" type="hidden" name="idus" id="idus" value="<?php echo $rowsi ?>"/>
                                        <center>  <strong>Datos del usuario</strong> </center>
                                        <p>                                            
                                            <label>Usuario</label>
                                            <input class="text" readonly="readonly" type="text" name="infoname" id="infoname" value="<?php echo $campoinfo_us ?>"/>   
                                        </p> 
                                        <p>                                            
                                            <label>Cedula id.</label>
                                            <input class="text" readonly="readonly" type="text" name="cedula" id="cedula" value="<?php echo $rowse ?>"/>   
                                        </p> 
                                    </label>  
                                <p>
                                <center>  <strong>Registrar Cuenta de logeo</strong> </center>
                                </p>
                                <p><label>Cargo<br />
                                        <select class="text" name="crg_us" id="crg_us" size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo();"><!--generar_codigo_grupo()-->
                                            <?php while ($arreglotipo = mysql_fetch_array($query_cargos)) { ?>
                                                <option class="text" value="<?php echo $arreglotipo['cod_user'] ?>"><?php echo $arreglotipo['tipo_user'] ?></option>     
                                                <?php
                                            }
                                            mysql_close($conex);
                                            ?>
                                        </select>
                                    </label>
                                </p>
                                <p><label>Usuario<br />
                                        <input class="text" type="text" name="usuario" id="usuario" />
                                    </label>
                                </p>
                                <p><label>Contrase&ncaron;a<br />
                                        <input class="text" type="text" name="pass" id="pass" />
                                    </label>
                                </p>  
                                <p>
                                    <!--<input type="button" name="buttongen" id="button" value="Gen" onclick="cargarfuncion();"/>-->
                                    <input type="submit" name="submit" id="buttonenviar" value="Enviar" />
                                    <input type="reset" class="cancelar" name="cancelar" id="cancelar" value="Reset" onsubmit="<?php limpiarForm(); ?>"/>
                                    <label></label>
                                </p>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>	

    </body>
</html>	
