<!DOCTYPE html>
<!--Christian Tigre-->
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
require('./templates/Clases/empresa.php');
require('./templates/Clases/Conectar.php');
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
$type_user = $_SESSION['tipo_user']
?>
<html>
    <head>
        <title>Panel de Administracion de contabilidad</title>
        <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
        <script src="js/jquery.min.js"></script>
        <link href="css/style.css" rel='stylesheet' type='text/css' />
        <link href="css/menuadministracion.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <script src="js/easyResponsiveTabs.js" type="text/javascript"></script>
        <!--<script src="js/cerrarsession.js" type="text/javascript"></script>-->
        <script type="text/javascript">
            $(document).ready(function () {
                $('#horizontalTab').easyResponsiveTabs({
                    type: 'default',
                    width: 'auto',
                    fit: true
                });
            });
        </script>
    </script>	
</head>
<body>
    <!----- start-header---->
    <div class="wrapper">
        <!----start-header---->
        <div class="header">
            <div class="container header_top">
                <div class="logo">
                    <a href="index.php">
                        <?Php                        
                            $objClase = new Empresa;
                            $objClase->view_log();
                        ?>
                        <!--<img src="images/logo.png" width="650" height="100" alt="">-->
                    </a>
                </div>
                <div class="menu">
                    <a class="toggleMenu" href="#"><img src="images/nav_icon.png" alt="" /> </a>
                    <ul class="nav" id="nav">
                        <li class="current"><a href="index.php">Panel</a></li>
                        <li><a href="templates/PaneldeAdministrador/funcionesdeadministrador/catalogodecuentas.php">Plan de Ctas</a></li>
                        <li><a href="templates/PaneldeAdministrador/admin_users/panel_logeos.php">Usuarios</a></li>
                        <li><a href="templates/PaneldeAdministrador/documentos/documentos.php">Documentos</a></li>								
                        <div class="clearfix"></div>
                    </ul>
                    <script type="text/javascript" src="js/responsive-nav.js"></script>
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
                                <td colspan="2"><div align="right"><a href="templates/logeo/desconectar_usuario.php"><img src="images/logout.png" title="Salir" alt="Salir" /></a> </div></td>

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
                <div class='col-md-4 banner_left'>
                    <a href="index.php"><img src="images/Home.png" alt="" /></a><strong> / </strong><a href="index.php">Panel de Administraci&oacute;n</a>
                    <br>
                    <br>                    
                    <div class="menuadministracion">
                        <a class="toggleMenu" href="#"><img src="images/nav_icon.png" alt="" /> </a>
                        <ul class="nav" id="nav">
                            <li class="current"><a href="templates/PaneldeAdministrador/funcionesdeadministrador/plangrupos.php"> <img src="images/Catalog.png" title="Plan de Cuentas" alt="Plan de Cuentas" />Catalogo Ctas</a></li>
                            <li><a href="templates/PaneldeAdministrador/users/admin_us.php"> <img src="images/" title="Control de Usuarios" alt="Control de Usuarios" />Control Usuarios</a></li>							
                            <li><a href="templates/PaneldeAdministrador/indexadmin.php">  <img src="images/contabilidad.png" title="Contabilidad" alt="Contabilidad" />Contabilidad</a></li>							
                            <li><a href="templates/PaneldeAdministrador/documentos/documentos.php">  <img src="images/print.png" title="Documentos" alt="Documentos" />Documentos</a></li>							
                            <li><a href="templates/PaneldeAdministrador/record/record.php">  <img src="images/record.png" title="Actividad" alt="Actividad" />Actividad</a></li>							
                            <li><a href="templates/PaneldeAdministrador/configuracion/indexconfig.php">  <img src="images/configuration.png" title="Config" alt="Config" />Configuraci&oacute;n</a></li>							
                            <div class="clearfix"></div>
                        </ul>
                        <script type="text/javascript" src="js/responsive-nav.js"></script>
                    </div>
                    <span></span>
                </div>
                <div class='col-md-6 banner_right'>
                    <h1>BIENVENIDO</h1>
                    <h2>Administrador del sistema</h2>
                    <p>Gesti&oacute;n en general.</p>
                    <!--                        <a class="banner_btn" href="">More Info</a>-->
                </div>
            </div>
        </div>
        <div class="container footer">
            <div class="footer_bottom">
                <div class="copy">
                    <p>&copy;2015 Mod Contabilidad<a href="" target="_blank"> Desarrollo</a></p>
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