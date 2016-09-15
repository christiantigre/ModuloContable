<!DOCTYPE html>
<!--Christian Tigre-->
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>alert("Usuario no autenticado")
            self.location = "../../login.php"</script>';
}
$user = $_SESSION['loginu'];
$idlogeous = $_SESSION['id_user'];
$user = $_SESSION['loginu'];
require('./../Clases/Conectar.php');
$dbi = new Conectar();
$c = $dbi->conexion();
    include './Clases/guardahistorialpanel.php';
    $accion="/ PANEL CONTABLE / Acceso a panel contable";
    generaLogs($user, $accion);
?>
<html>
    <head>
        <title>Panel de Administrador</title>
        <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <script src="../../js/jquery.min.js"></script>
        <link href="../../css/style.css" rel='stylesheet' type='text/css' />
        <link href="../../css/menuadministracion.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <!----- start-header---->
        <div class="wrapper">
            <!----start-header---->
            <div class="header">
                <div class="container header_top">
                    <div class="logo">
                        <a href="#">
                            <?Php
                            require('../../templates/Clases/empresa.php');
                            $objClase = new Empresa;
                            $objClase->view_logadmin();
                            ?>
                        </a>
                        <!--<a href="#"><img src="../../images/logo.png" width="650" height="100" alt=""></a>-->
                    </div>
                    <div class="menu">
                        <a class="toggleMenu" href="#"><img src="../../images/nav_icon.png" alt="" /> </a>
                        <ul class="nav" id="nav">
                            <li class="current"><a href="#">Panel</a></li>
                            <li><a href="templateslimit/catalogodecuentas.php">Plan de Ctas</a></li>
                            <!--<li><a href="templates/PaneldeAdministrador/admin_users/panel_logeos.php">Usuarios</a></li>-->
                            <li><a href="templateslimit/ModuloContable/documentos/documentos.php">Documentos</a></li>								
                            <div class="clearfix"></div>
                        </ul>
                    </div>	
                    <div class="clearfix">
                        <!-- Caja de Usuario  -->
                        <div class="cajauser">
                            <table width="718"  align="center"  >
                                <tr>&nbsp;</tr>
                                <tr>
                                    <td colspan="2"><div align="right">Usuario: <span class="Estilo6"><strong><?php echo $user; ?> 
                                                </strong></span></div></td>            
                                    <td></td>
                                    <td colspan="2">
                                        <div align="right">
                                            <a href="../../templates/logeo/desconectar_usuario.php">
                                                <img src="../../images/logout.png" title="Salir" alt="Salir" />
                                            </a> 
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!----/End-top-nav---->
                </div>
            </div>
            <!----- //End-header---->
            <div class="container banner">
                <div class="row">
                    <div class='col-md-4 banner_left'>
                        <a href="#"><img src="../../images/Home.png" alt="" /></a><strong> / </strong><a href="#">Panel de Administraci&oacute;n</a>
                        <br>
                        <br>                    
                        <div class="menuadministracion">
                            <a class="toggleMenu" href="#"><img src="../../images/nav_icon.png" alt="" /> </a>
                            <ul class="nav" id="nav">
                                <li class="current"><a href="templateslimit/plangruposadmin.php">
                                        <img src="../../images/Catalog.png" title="Plan de Cuentas" alt="Plan de Cuentas" /> Catalogo Ctas</a></li>
<!--                                <li><a href="templateslimit/admin_users/panel_users.php">
                                        <img src="../../images/users.png" title="Control de Usuarios" alt="Control de Usuarios" /> Control Usuarios</a></li>							-->
                                <li><a href="templateslimit/ModuloContable/index_modulo_contable.php">
                                        <img src="../../images/contabilidad.png" title="Contabilidad" alt="Contabilidad" /> Contabilidad</a>
                                </li>							
                                <li><a href="templateslimit/ModuloContable/record.php">
                                        <img src="../../images/record.png" title="Actividad Realizada en el Sistema" alt="Actividad Realizada en el Sistema" /> Actividad</a>
                                </li>							
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                        <span></span>
                    </div>
                    <div class='col-md-6 banner_right'>
                        <h1>BIENVENIDO</h1>
                        <h2>Administrador Contable</h2>
                        <p>Gesti&oacute;n de clases, grupos y cuentas de detalle.</p>
                        <!--<a class="banner_btn" href="">More Info</a>-->
                    </div>
                </div>
            </div>
            <div class="container footer">
                <div class="footer_bottom">
                    <div class="copy">
                        <!--<p>&copy;2015 Mod Contabilidad<a href="" target="_blank"> Desarrollo</a></p>-->
                    </div>
                    <ul class="social">
                        <!--<li><a href=""> <i class="fb"> </i> </a></li>
                        <li><a href=""><i class="tw"> </i> </a></li>-->



                    </ul>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>	
    </body>
</html>		