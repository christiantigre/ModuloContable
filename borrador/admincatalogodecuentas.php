<!DOCTYPE html>
<!--Christian Tigre-->
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
//Proceso de conexi�n con la base de datos
$conex = mysql_connect("localhost", "root", "alberto2791")
        or die("No se pudo realizar la conexion");
mysql_select_db("condata", $conex)
        or die("ERROR con la base de datos");
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
$consulta = "SELECT l.username, u.tipo_user
FROM logeo l
JOIN user_tipo u
WHERE l.username = '" . $id_usuario . "'";
$resultado = mysql_query($consulta, $conex) or die(mysql_error());
$fila = mysql_fetch_array($resultado);
$user = $fila['username'];
$type_user = $fila['tipo_user'];
mysql_close($conex);
?>
<html>
    <head>
        <title>Admin de Cuentas</title>
        <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../../js/jquery.min.js"></script>
        <!-- Custom Theme files -->
        <link href="../../css/style.css" rel='stylesheet' type='text/css' />
        <link href="../../css/menuadministracion.css" rel='stylesheet' type='text/css' />
        <link href="../../css/csstabladatos.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <script src="../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../js/jquery.functions.js" type="text/javascript"></script>
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
                        <a href="../../index.php"><img src="../../images/logo.png" width="650" height="100" alt=""></a>
                    </div>
                    <div class="menu">
                        <a class="toggleMenu" href="#"><img src="images/nav_icon.png" alt="" /> </a>
                        <ul class="nav" id="nav">
                            <li><a href="../../index.php">Panel</a></li>
                            <li class="current"><a href="">Plan de Ctas</a></li>
                            <li><a href="admin_users/panel_reg_user.php">Usuarios</a></li>
                            <li><a href="../ModuloContable/documentos/documentos.php">Documentos</a></li>								
                            <div class="clearfix"></div>
                        </ul>
                        <script type="text/javascript" src="../../js/responsive-nav.js"></script>
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
                                    <td colspan="2"><div align="right"><a href="templates/logeo/desconectar_usuario.php"><img src="../../images/logout.png" title="Salir" alt="Salir" /></a> </div></td>

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
                        <a href="../../index.php">  <img src="../../images/Home.png" alt="" /> </a><strong> / </strong><a href="admincatalogodecuentas.php">Administraci&oacute;n de Cuentas</a>
                        <br>
                        <br>                    
                        <div class="menuadministracion">
                            <a class="toggleMenu" href="#"><img src="images/nav_icon.png" alt="" /> </a>
                            <ul class="nav" id="nav">
                                <li class="current"><a href="admincatalogodecuentas.php"><img src="../../images/user.png" title="Plan de Cuentas" alt="Plan de Cuentas" />Cl&aacute;ses</a></li>
                                <li><a href="about.html"><img src="../../images/users.png" title="Control de Usuarios" alt="Control de Usuarios" />Gr&uacute;pos</a></li>							
                                <li><a href="about.html"><img src="../../images/ctas.png" title="Control de Usuarios" alt="Control de Usuarios" />Cuentas</a></li>							
                                <div class="clearfix"></div>
                            </ul>
                            <script type="text/javascript" src="js/responsive-nav.js"></script>
                        </div>
                    </div>
                    <div id="contenido">
                        <div id="contenedor">
                            <div id="formulario" style="display:none;">
                            </div>
                            <div id="tabla">

                            </div>
                        </div>

                        <div id="cargatabla">
                            <script type="text/javascript">
           $(document).ready(function () {
               // mostrar formulario de actualizar datos
               $("table tr .modi a").click(function () {
                   $('#tabla').hide();
                   $("#formulario").show();
                   $.ajax({
                       url: this.href,
                       type: "GET",
                       success: function (datos) {
                           $("#formulario").html(datos);
                       }
                   });
                   return false;
               });

               // llamar a formulario nuevo
               $("#nuevo a").click(function () {
                   $("#formulario").show();
                   $("#tabla").hide();
                   $.ajax({
                       type: "GET",
                       url: 'nuevocuenta.php',
                       success: function (datos) {
                           $("#formulario").html(datos);
                       }
                   });
                   return false;
               });
           });

                            </script>
                            <fieldset>
                                <legend>Catalogo de Clases</legend>
                                <span id="nuevo"><a href="#cargaformulario" onclick="#contenido"><img src="../../images/add.png" alt="Agregar dato" title="Agregar Nueva Clase"/></a></span>
                                <span id="refrescar"><a href="admincatalogodecuentas.php"><img src="../../images/update.png" alt="Actualizar" title="Actualizar"/></a></span>
                                <center>
                                    <table>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Codigo</th>
                                            <th>Descripcion</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <?php
                                        require('../Clases/cliente.class.php');
                                        $objCuenta = new Clase;
                                        $consulta = $objCuenta->mostrar_clases();
                                        if ($consulta) {
                                            while ($clase = mysql_fetch_array($consulta)) {
                                                ?>
                                                <tr id="fila-<?php echo $clase['cod_clase'] ?>">
                                                    <td><?php echo $clase['nombre_clase'] ?></td>
                                                    <td><?php echo $clase['cod_clase'] ?></td>
                                                    <td><?php echo $clase['descrip_class'] ?></td>
                                                    <td><span class="modi"><a href="funcionesdeadministrador/actualizar.php?cod_clase=<?php echo $clase['cod_clase'] ?>">
                                                                <img src="../../images/database_edit.png" title="Editar" alt="Editar" /></a></span></td>
                                                    <td><span class="dele"><a onClick="EliminarDatoCuenta(<?php echo $clase['idt_cuenta'] ?>);
                                                                    return false" href="funcionesdeadministrador/eliminarcuenta.php?cod_clase=<?php echo $clase['cod_clase'] ?>">
                                                                <img src="../../images/delete.png" title="Eliminar" alt="Eliminar" /></a></span></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </table>
                                    <BR>
                                </center>
                            </fieldset>
                        </div>
                        <div id="cargaformulario">
                            <form id="frmClienteNuevo" name="frmClaseNuevo" method="post" action="admincatalogodecuentas.php">
                                <?php
                                $ctu = mysql_connect("localhost", "root", "alberto2791") or die("Error en la conexion");
                                $Btu = mysql_select_db("condata", $ctu) or die("Problema al seleccionar la base de datos");
                                $stu = " SELECT MAX( `cod_clase` ) +1 AS id FROM t_clase ";
                                $query = mysql_query($stu);
                                if ($row = mysql_fetch_row($query)) {
                                    $id = trim($row[0]);
                                    //echo "<script>alert($id);</script>";
                                }
                                ?>
                                <p><label>Nombre<br />
                                        <input class="text" type="text" name="nombre_clase" id="nombre_clase" />
                                    </label>
                                </p>
                                <p>
                                    <!-- <label>Codigo<br />-->
                                    <input  readonly="readonly" class="text" type="hidden" name="cod_clase" id="cod_clase" style="text-align:center" value="<?Php
                                    echo $id;
                                    mysql_close($ctu);
                                    ?>"/>
                                    <!-- </label>-->
                                </p>
                                <p>
                                    <label>Descripcion<br />
                                        <input class="text" type="text" name="descrip_class" id="descrip_class" />
                                    </label>
                                </p>
                                <p>

                                <p>
                                    <input type="submit" name="submit" id="submit" value="Enviar" />
                                    <label></label>
                                <form method="" action="#cargatabla" onabort="#contenido" name="regresar">
                                    <input type="submit" class="cancelar" name="cancelar" id="cancelar" value="Cancelar" />
                                </form>
                                </p>


                                <?php
                                if (isset($_POST["submit"])) {
                                    $btntu = $_POST["submit"];
                                    if ($btntu == "Enviar") {
                                        $nombre_clase = htmlspecialchars(trim($_POST['nombre_clase']));
                                        $cod_clase = htmlspecialchars(trim($_POST['cod_clase']));
                                        $descrip_class = htmlspecialchars(trim($_POST['descrip_class']));
                                        $objClase = new Clase;
                                        if ($objClase->insertar(array($nombre_clase, $cod_clase, $descrip_class)) == true) {
                                            echo 'Datos Guardados';
                                        } else {
                                            echo 'Ocurrio un error';
                                            echo '<script language = javascript> alert("Ocurrio un error.")self.location = "admincatalogodecuentas.php"</script>';
                                        }
                                    }
                                }
                                ?>




                            </form>
                            <BR>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="container footer">
                <div class="footer_bottom">
                    <div class="copy">
                        <p>&copy;2015 Mod Contabilidad<a href="" target="_blank"> Desarrollo</a></p>
                    </div>
                    <ul class="social">
                        <li><a href=""> <i class="fb"> </i> </a></li>
                        <li><a href=""><i class="tw"> </i> </a></li>
                    </ul>
                </div>
            </div>-->
        </div>	
    </body>
</html>		