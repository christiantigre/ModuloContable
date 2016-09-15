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
//Validar si se est� ingresando con sesi�n correctamente
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "login.php"
</script>';
}

$id_usuario = $_SESSION['username'];
$consulcat = "SELECT count( * )+1 AS Contador from user_tipo";
$query_cat = mysql_query($consulcat);
$row = mysql_fetch_array($query_cat);
$idcod = $row['Contador'];
$queryclases = mysql_query($consulgrupo, $conex);
$consulta = "SELECT l.username, u.tipo_user, l.idlogeo
FROM logeo l
JOIN user_tipo u
WHERE l.user_tipo_iduser_tipo = u.iduser_tipo
AND l.username = '".$id_usuario."'";
$resultado = mysql_query($consulta, $conex) or die(mysql_error());
$fila = mysql_fetch_array($resultado);
$user = $fila['username'];
$type_user = $fila['tipo_user'];
mysql_close($conex);
if (isset($_POST["submit"])) {
    $btntu = $_POST["submit"];
    if ($btntu == "Enviar") {
        // echo "<script>alert('boton enviar');</script>";
        require('../../../Clases/cliente.class.php');
        $tipo_user= htmlspecialchars(trim($_POST['tipo_user']));
        $decrip_user= htmlspecialchars(trim($_POST['decrip_user']));
        $cod_user= htmlspecialchars(trim($_POST['cod_user']));
        $objGrupo = new Clase;
        if ($objGrupo->insertar_cat_user(array($tipo_user, $descrip_user, $cod_user)) == true) {
            // echo "<script> alert('Guardado; '".$nombre_grupo + $cod_grupo + $descrip_grupo =$cod_claseaux."');</script>";
            echo '<script language = javascript>
alert("Guardado, exitosamente")
self.location = "panel_users.php"
</script>';
            //echo 'Datos guardados';
        } else {
            echo '<script language = javascript>
alert("Ocurrio un error, verifique los campos...")
self.location = "panel_users.php"
</script>';
//    echo 'Se produjo un error. Intente nuevamente';
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
                        <a href="../../../../templates/PanelAdminLimitado/index_admin.php"><img src="../../../../images/logo.png" width="650" height="100" alt=""></a>
                    </div>
                    <div class="menu">
                        <a class="toggleMenu" href="#"><img src="../../../../images/nav_icon.png" alt="" /> </a>
                        <ul class="nav" id="nav">
                            <li><a href="../../index_admin.php">Panel</a></li>
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
                        <a href="../../../../templates/PanelAdminLimitado/index_admin.php">  <img src="../../../../images/Home.png" alt="" /> </a><strong> / 
                        </strong><a href="new_category.php">Administraci&oacute;n de Categor&iacute;as</a>
                        <br>
                        <br>                    
                        <div class="menuadministracion">
                            <a class="toggleMenu" href="#"><img src="../../../images/nav_icon.png" alt="" /> </a>
                            <ul class="nav" id="nav">
                                <li class="current"><a href="../admin_users/panel_users.php">
                <img src="../../../../images/user.png" title="Plan de Cuentas" alt="Plan de Cuentas" />Categor&iacute;as</a></li>
                <li><a href="panel_reg_user.php"><img src="../../../../images/users.png" title="Control de Usuarios" alt="Control de Usuarios" />Usuarios</a></li>							
                                							
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
                            <form id="frmClienteNuevo" name="frmClaseNuevo" method="post" action="new_category.php">        
                                <center>  <strong>Ingreso de Nueva Categor&iacute;a</strong> </center>                                
                                </p>
                                <p><label>Nombre<br />
                                        <input class="text" type="text" name="tipo_user" id="tipo_user" />
                                    </label>
                                </p>
                                <p>
                                    <label>C&oacute;digo<br />
                                        <input class="text" type="text" name="cod_user" id="cod_user" value="<?php echo $idcod; ?>" readonly="readonly"/>
                                </p>
                                <p>
                                    <label>Descripcion<br />
                                        <input class="text" type="text" name="descrip_user" id="descrip_user" />
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
