<!DOCTYPE html>
<!--Christian Tigre-->
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
require('../../../templates/Clases/empresa.php');
require('../../../templates/Clases/Conectar.php');
$dbi = new Conectar();
$c = $dbi->conexion();
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../login.php"
</script>';
}
$id_usuario = $_SESSION['username'];
mysqli_close($c);
?>
<html>
    <head>
        <title>Panel de Administracion de contabilidad</title>
        <link href="../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <script src="../../../js/jquery.min.js"></script>
        <link href="../../../css/style.css" rel='stylesheet' type='text/css' />
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
                            $objClase->view_logroot();
                            ?>
                        </a>
                        <!--<a href="../../../index.php"><img src="../../../images/logo.png" width="650" height="100" alt=""></a>-->
                    </div>
                    <div class="menu">
                        <a class="toggleMenu" href="#"><img src="../../../images/nav_icon.png" alt="" /> </a>
                        <ul class="nav" id="nav">
                            <li><a href="../../../index.php">Panel</a></li>
                            <li class="current"><a href="../../../templates/PaneldeAdministrador/configuracion/indexconfig.php">Configuraci&oacute;n</a></li>
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
                    <div class='col-md-4 banner_left'>
                        <a href="../../../index.php"><img src="../../../images/Home.png" alt="" /></a><strong> / </strong><a href="../../../index.php">Panel de Administraci&oacute;n</a>
                        <br>
                        <br>                    
                        <div class="menuadministracion">
                            <a class="toggleMenu" href="#"><img src="images/nav_icon.png" alt="" /> </a>
                            <ul class="nav" id="nav">
                                <li class="current"><a href=""> <img src="../../../images/information.png" title="" alt="" />Empresa</a></li>
                                <div class="clearfix"></div>
                            </ul>
                            <script type="text/javascript" src="js/responsive-nav.js"></script>
                        </div>
                        <span></span>
                    </div>
                    <div class='col-md-6 banner_right'>
                        <form id="empresa" method="post" enctype="multipart/form-data">
                            <?Php
//                            require('../../Clases/empresa.php');
                            $objClase = new Empresa;
                            if (isset($_POST['btnedit'])) {
                                $objClase->edit_empress();
                            } elseif (isset($_POST['btnsave'])) {
                                $id = $_POST['idemp'];
                                $objClase->save_emp(array($_POST['nomemp'], utf8_encode($_POST['diremp']), $_POST['rucemp'], $_POST['mailemp'], $_POST['telemp'], $_POST['faxemp'], $_POST['propemp'], $_POST['funemp']), $id);
//                                $objClase->update_img($id);
                                $objClase->upload_img($id);
                                $objClase->ver_empress();
                            } else {
                                $objClase->ver_empress();
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container footer">
                <div class="footer_bottom">
                    <div class="copy">
                        <p>&copy;2015 Mod Contabilidad<a href="" target="_blank"> Desarrollo</a></p>
                    </div>
                    <ul class="social">
                    </ul>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>	
    </body>
</html>	