<!DOCTYPE html>
<!--Christian Tigre-->
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();

if (!$_SESSION) {
    echo '<script language = javascript>alert("Usuario no autenticado")
            self.location = "../../../login.php"</script>';
}
$id_usuario = $_SESSION['username'];

require('../../Clases/Conectar.php');
$dbi = new Conectar();
$c = $dbi->conexion();
$consulta = "SELECT l.username, u.tipo_user, l.idlogeo
FROM logeo l
JOIN user_tipo u
WHERE l.user_tipo_iduser_tipo = u.iduser_tipo
AND l.username = '" . $id_usuario . "'";
$res = mysqli_query($c, $consulta);

while ($fila = mysqli_fetch_assoc($res)) {
    $user = $fila['username'];
    $type_user = $fila['tipo_user'];
    $idlogeous = $fila['idlogeo'];
}
//include '../../../../Clases/guardahistorialdoc.php';
//$accion = "Ingreso a Documentos";
//generaLogs($user, $accion);
?>
<html>
    <head>
        <title>Documentos</title>
        <link href="../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <script src="../../../js/jquery.min.js"></script>
        <link href="../../../css/style.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    <style type="text/css">

        h1{
            font-size:20px;
        }
        .modalmask {
            position: fixed;
            font-family: Arial, sans-serif;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: rgba(0,0,0,0.8);
            z-index: 99999;
            opacity:0;
            -webkit-transition: opacity 400ms ease-in;
            -moz-transition: opacity 400ms ease-in;
            transition: opacity 400ms ease-in;
            pointer-events: none;
        }
        .modalmask:target {
            opacity:1;
            pointer-events: auto;
        }
        .modalbox{
            width: 400px;
            position: relative;
            padding: 5px 20px 13px 20px;
            background: #fff;
            border-radius:3px;
            -webkit-transition: all 500ms ease-in;
            -moz-transition: all 500ms ease-in;
            transition: all 500ms ease-in;

        }

        /*        .movedown {
                    margin: 0 auto;
                }
                .rotate {
                    margin: 10% auto;
                    -webkit-transform: scale(-5,-5); 
                    transform: scale(-5,-5);
                }*/
        .resize {
            margin: 10% auto;
            width:0;
            height:0;

        }
        .modalmask:target .rotate{		
            transform: rotate(360deg) scale(1,1);
            -webkit-transform: rotate(360deg) scale(1,1);
        }

        .modalmask:target .resize{
            width:400px;
            height:200px;
        }
        .close {
            background: #606061;
            color: #FFFFFF;
            line-height: 25px;
            position: absolute;
            right: 1px;
            text-align: center;
            top: 1px;
            width: 24px;
            text-decoration: none;
            font-weight: bold;
            border-radius:3px;
            font-size:16px;
        }

        .close:hover { 
            background: #FAAC58; 
            color:#222;
        }

        /*        a{
                    text-decoration:none;
                    font-size:25px;
                    color:#222;
        
                }
                a:hover{
        
                    color:#DF7401;
        
                }*/
    </style>
    <script>
        function imprimirlibro()
        {
            var idlogeo = $("#idlog").val();
            var year = $("#fechabi").val();
            var id_asientourl = $("#asiento_num").val();
            window.location = 'impresiones/balanceimp.php?idlogeo=' + idlogeo +
                    '&fechaurl=' + year + '&id_asientourl=' + id_asientourl;

        }
        function imprimirasiento()
        {
            var idlogeo = $("#idlog").val();
            var fech_url = $("#fechabi").val();
            var id_asientourl = $("#asiento_num").val();
//            window.open("impresiones/impasiento.php?idlogeo=" + idlogeo +
//                    "&fechaurl=" + fech_url + "&id_asientourl=" + id_asientourl","_blank","toolbar=yes, location=no, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=800, height=600");
            window.location = 'impresiones/impasiento.php?idlogeo=' + idlogeo +
                    '&fechaurl=' + fech_url + '&id_asientourl=' + id_asientourl;

        }
        function imprimirmayor()
        {
            var idlogeo = $("#idlog").val();
            var fech_url = $("#fecham").val();
            window.location = 'impresiones/impmayor.php?idlogeo=' + idlogeo +
                    '&fechaurl=' + fech_url;

        }
        
        
        function imprimirbalancecomp()
        {
            var idlogeo = $("#idlog").val();
            var fech_url = $("#fecham").val();
            window.location = 'impresiones/impbalanceresultados.php?prmlg=' + idlogeo +
                    '&fechaurl=' + fech_url;

        }

    </script>
    <body>

        <!----- start-header---->
        <div class="wrapper">
            <!----start-header---->
            <div class="header">
                <div class="container header_top">
                    <div class="logo">
                        <a href="#"><img src="../../../images/logo.png" width="650" height="100" alt=""></a>
                    </div>
                    <div class="menu">
                        <a class="toggleMenu" href="#"><img src="../../../../../images/nav_icon.png" alt="" /> </a>
                        <ul class="nav" id="nav">
                            <li><a href="../../../index.php">Panel</a></li>
                            <li><a href="../../PaneldeAdministrador/admincatalogodecuentas.php">Plan de Ctas</a></li>
                            <!--<li><a href="templates/PaneldeAdministrador/admin_users/panel_logeos.php">Usuarios</a></li>-->
                            <li  class="current"><a href="#">Documentos</a></li>								
                            <div class="clearfix"></div>
                        </ul>
                    </div>	
                    <div class="clearfix">
                        <!-- Caja de Usuario  -->
                        <div class="cajauser">

                            <table width="718" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>&nbsp;</tr>
                                <tr>
                                    <td colspan="2"><div align="right">Usuario: <span class="Estilo6"><strong><?php echo $user; ?> </strong></span></div></td>            
                                    <td><input name="idlog" id="idlog" type="hidden" value="<?php echo $idlogeous; ?>" /></td>
                                    <td colspan="2"><div align="right"><a href="../../../templates/logeo/desconectar_usuario.php">
                                                <img src="../../../images/logout.png" title="Salir" alt="Salir" /></a> </div></td>

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
                <form name="formdocumentos" id="formdocumentos" action="documentos.php" method="post">
                    <div class="center">


                        <ul class="nav">
                            <li class="mdlli"><a href="#modal3">Balance Inicial</a></li>
                            <li class="mdlli"><a href="#modal2">Libro Diario</a></li>
                            <li class="mdlli"><a href="#modal4">Mayorizaci&oacute;n</a></li>
                            <li class="mdlli"><a href="#modal5">Balance de Comprobaci&oacute;n</a></li>
                            <li class="mdlli"><a href="#modal5">Situac&oacute;n Final</a></li>
                            <li class="mdlli"><a href="impresiones/impplan.php?idlogeo=<?php echo $idlogeous ?>">Plan de Cuentas</a></li>
                        </ul>

                        <div id="modal3" class="modalmask">
                            <div class="modalbox resize">
                                <a href="#close" title="Close" class="close">X</a>
                                <h2>Fecha</h2>
                                <p>
                                    <label> Periodo :</label>

                                    <input type="text" name="fechabi" id="fechabi" size="12" value="<?php echo date('Y'); ?>"/>
                                    <input type="hidden" name="asiento_num" id="asiento_num" size="12" value="1"/>

                                    <!--<input type="submit" name="submit" id="btnbi" onclick="imprimirbalance();" value="Imprimir Balance"/>--> 
                                    <a href="#" onclick="imprimirasiento();" class="submit">Imprimir Balance</a>
                                </p>
                            </div>
                        </div>


                        <div id="modal2" class="modalmask">
                            <div class="modalbox resize">
                                <a href="#close" title="Close" class="close">X</a>
                                <h2>Fecha</h2>
                                <p>Seleccione la fecha a consultar.</p>
                                <p>
                                    <input type="date" name="fechadoc" id="fechadoc" value="<?php echo date('Y'); ?>"/>
                                    <a href="#" onclick="imprimirlibro()" class="submit">Imprimir Libro</a> 
                                </p>
                            </div>
                        </div>


                        <div id="modal4" class="modalmask">
                            <div class="modalbox resize">
                                <a href="#close" title="Close" class="close">X</a>
                                <h2>Fecha</h2>
                                <p>Seleccione la fecha a consultar.</p>
                                <p>
                                    <input type="date" name="fecham" id="fecham" value="<?php echo date('Y'); ?>"/>
                                    <a href="#" onclick="imprimirmayor()" class="submit">Imprimir Mayor</a> 
                                </p>
                            </div>
                        </div>


                        <div id="modal5" class="modalmask">
                            <div class="modalbox resize">
                                <a href="#close" title="Close" class="close">X</a>
                                <h2>Fecha</h2>
                                <p>Seleccione la fecha a consultar.</p>
                                <p>
                                    <input type="date" name="fechacom" id="fechacom" value="<?php echo date('Y'); ?>"/>
                                    <a href="#" onclick="imprimirbalancecomp()" class="submit">Imprimir Balance</a> 
                                </p>
                            </div>
                        </div>




                    </div>
                </form>
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