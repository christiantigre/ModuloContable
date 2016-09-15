<!DOCTYPE html>
<!--Christian Tigre-->
<?php
require '../../templateslimit/admin_users/functions.php';
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
require '../../Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "login.php"
</script>';
}

$id_usuario = $_SESSION['username'];
$consul_usuarios = " SELECT count( * ) +1 AS Codigo FROM `usuario` ";
$query_usuarios = mysqli_query($c,$consul_usuarios);
$row = mysqli_fetch_array($query_usuarios);
$idcod = $row['Codigo'];
$consul_log = " SELECT count( * ) +1 AS Codigo FROM `logeo` ";
$query_usuarioslog = mysqli_query($c,$consul_log);
$rowl = mysqli_fetch_array($query_usuarioslog);
$idcodl = $rowl['Codigo'];
$queryclases = mysqli_query($c,$consulgrupo);
$consul_cargos = " SELECT * FROM `user_tipo` WHERE tipo_user != 'Sup'";
$query_cargos = mysqli_query($c,$consul_cargos);
$rowcrg = mysqli_fetch_array($query_cargos);
$consulta = "SELECT l.username, u.tipo_user, l.idlogeo
FROM logeo l
JOIN user_tipo u
WHERE l.user_tipo_iduser_tipo = u.iduser_tipo
AND l.username = '" . $id_usuario . "'";
$resultado = mysqli_query($c,$consulta) or die(mysqli_errno($c));
$fila = mysqli_fetch_array($resultado);
$user = $fila['username'];
$type_user = $fila['tipo_user'];
mysqli_close($c);

if (isset($_POST["submit"])) {
    $btntu = $_POST["submit"];
    if ($btntu == "Enviar") {
        $c = $dbi->conexion();
//        echo '<script language = javascript>alert("sms..")</script>';
        $newcod_us = htmlspecialchars(trim($_POST['newcod_us']));
        $nombre_us = htmlspecialchars(trim($_POST['nombre_us']));
        $ap_us = htmlspecialchars(trim($_POST['ap_us']));
        $correo_us = htmlspecialchars(trim($_POST['correo_us']));
        $crg_us = htmlspecialchars(trim($_POST['crg_us']));
        $cc_us = htmlspecialchars(trim($_POST['cc_us']));
        $descrip_us = htmlspecialchars(trim($_POST['descrip_us']));
        $user = htmlspecialchars(trim($_POST['user']));
        $pass = htmlspecialchars(trim($_POST['pass']));
        
        $insertauser = "INSERT INTO `condata`.`usuario` (`idusuario`, `nombre`, `apellido`, `email`, `nacionalidad`, `cargo`, `foto`, `fecha_nacimiento`, `cedula`, `telefono`, `celular`, `Descrip_user`) "
                . "VALUES ('" . $newcod_us . "', '" . $nombre_us . "', '" . $ap_us . "', '" . $correo_us . "', NULL, NULL, NULL, NULL, '" . $cc_us . "', NULL, null, '" . $descrip_us . "');";
        $insertlogeo = "INSERT INTO `condata`.`logeo` (`idlogeo` ,`password` ,`username` ,`user_tipo_iduser_tipo` ,`usuario_idusuario`)VALUES (
'" . $newcod_us . "', '" . $pass . "', '" . $user . "', '" . $crg_us . "', '" . $newcod_us . "');";
        
        if (($c->query($insertauser)===TRUE)&&($c->query($insertlogeo)===TRUE) ) {
            echo '<script language = javascript>
alert("Guardado exitosamente...")
self.location = "panel_reg_user.php"
</script>';
        }  else {
            echo '<script language = javascript>
alert("Error... No se pudo guardar los datos")
self.location = "new_user.php"
</script>';
        }
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
        <link href="../../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../../../../js/jquery.min.js"></script>
        <!-- Custom Theme files -->
        <!--<link href="../../css/style.css" rel='stylesheet' type='text/css' />-->
        <link href="../../../../css/stylerespaldo.css" rel='stylesheet' type='text/css' />
        <link href="../../../css/csstabladatos.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <script src="../../../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../../../js/jquery.functions.js" type="text/javascript"></script>
        <script src="../../../../js/jquery-1.3.1.min.js" type="text/javascript"></script>
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
                        <a href="../../index_admin.php"><img src="../../../../images/logo.png" width="650" height="100" alt=""></a>
                    </div>
                    <div class="menu">
                        <a class="toggleMenu" href="#"><img src="../../../images/nav_icon.png" alt="" /> </a>
                        <ul class="nav" id="nav">
                            <li><a href="../../../PanelAdminLimitado/index_admin.php">Panel</a></li>
                            <li><a href="../catalogodecuentas.php">Plan de Ctas</a></li>
                            <li class="current"><a href="panel_users.php">Usuarios</a></li>
                            <li><a href="../ModuloContable/documentos/documentos.php">Documentos</a></li>								
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
                                    <!--<td colspan="2"><div align="right">Acceso de: <span class="Estilo6"><strong><?php echo $type_user; ?> </strong></span></div></td>-->
                                    <td></td>
                                    <td colspan="2"><div align="right"><a href="../../../../templates/logeo/desconectar_usuario.php"><img src="../../../../images/logout.png" title="Salir" alt="Salir" /></a> </div></td>
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
                        <a href="../../index_admin.php">  <img src="../../../../images/Home.png" alt="" /> </a><strong> / 
                        </strong><a href="panel_users.php">Administraci&oacute;n de Usuarios</a>
                        <br>
                        <br>                    
                        <div class="menuadministracion">
                            <a class="toggleMenu" href="#"><img src="../../../../images/nav_icon.png" alt="" /> </a>
                            <ul class="nav" id="nav">
                                <li><a href="../admin_users/panel_users.php">
                                        <img src="../../../../images/user.png" title="Plan de Cuentas" alt="Plan de Cuentas" />Categor&iacute;as</a></li>
                                <li class="current"><a href="panel_users.php"><img src="../../../../images/users.png" title="Control de Usuarios" alt="Control de Usuarios" />Control de Usuarios</a></li>							
                                <div class="clearfix"></div>
                            </ul>
                            <script type="text/javascript" src="../../../js/responsive-nav.js"></script>
                        </div>
                    </div>

                    <div id="contenedor">
                        <div id="formulario" style="display:none;">
                        </div>
                        <div id="tabla">
                            <span id="new"><a href="panel_users.php"><img src="../../../../images/home_back.png" alt="Agregar dato" /></a></span>

                            <form id="frmClaseNuevo" name="frmClaseNuevo" method="post" action="new_user.php" >        


                                <script>
            function cancelar() {
//                                            alert('sms');
                var answer = confirm("Cancelado con exito...?");
                if (answer) {
                    var pag = "panel_reg_user.php";
                    location.href = pag;
                } else {
                }
            }


            function reset_campos() {
                $("#nombre_us").attr("value", "");
                $("#ap_us").attr("value", "");
                $("#cc_us").attr("value", "");
                $("#correo_us").attr("value", "");
                $("#cc_us").attr("value", "");
                $("#user").attr("value", "");
                $("#pass").attr("value", "");
                $("#descrip_us").attr("value", "");
            }


            function veruser()
            {
                var miVariableJS = $("#user").val();
                $.post("consultauser.php", {"texto": miVariableJS},
                function (respuestag) {
                    document.getElementById('user').value = respuestag;
                });
            }
            function verpass()
            {
                var miVariableJS = $("#pass").val();
                $.post("consultapass.php", {"texto": miVariableJS},
                function (respuestag) {
                    document.getElementById('pass').value = respuestag;
                });
            }
                                </script>

                                <center>  <strong>Ingreso de Nuevo Usuario</strong> </center>
                                <p>
                                    <input type="hidden" name="newcod_us" id="newcod_us" value="<?php echo $idcod; ?>" readonly="readonly"/>
                                </p>
                                <p><label>Nombre<br />
                                        <input class="text" type="text" name="nombre_us" id="nombre_us" required="required"/>
                                    </label>
                                </p>
                                <p><label>Apellido<br />
                                        <input class="text" type="text" name="ap_us" id="ap_us" required="required"/>
                                    </label>
                                </p>
                                <p><label>Cedula<br />
                                        <input class="text" type="text" name="cc_us" id="cc_us" required="required"/>
                                    </label>
                                </p>
                                <p><label>Correo<br />
                                        <input class="text" type="email" name="correo_us" id="correo_us" />
                                    </label>
                                </p>
                                <p><label>Usuario<br />
                                        <input class="text" type="text" onchange="veruser()" name="user" id="user" required="required"/>
                                    </label>
                                </p>
                                <p><label>Clave<br />
                                        <input class="text" type="text" onchange="verpass()" name="pass" id="pass" required="required"/>
                                    </label>
                                </p>
                                <p><label>Cargo<br />
                                        <select class="text" name="crg_us" id="crg_us" size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo();"><!--generar_codigo_grupo()-->
                                            <?php while ($arreglotipo = mysqli_fetch_array($query_cargos)) { ?>
                                                <option class="text" value="<?php echo $arreglotipo['cod_user'] ?>"><?php echo $arreglotipo['tipo_user'] ?></option>     
                                                <?php
                                            }
                                            mysqli_close($c);
                                            ?>
                                        </select>
                                    </label>
                                </p>
                                <p>
                                    <label>Descripci&oacute;n<br />
                                        <input class="text" type="text" name="descrip_us" id="descrip_us" />
                                    </label>
                                </p>
                                <p>
                                    <input type="submit" name="submit" class="btn" id="buttonenviar" value="Enviar" />
                                    <input type="submit" name="submit" class="btn" onclick="cancelar()" id="buttoncancel" value="Cancelar" />

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
