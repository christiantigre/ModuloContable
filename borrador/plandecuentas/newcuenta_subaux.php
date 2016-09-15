<!DOCTYPE html>
<!--Christian Tigre-->
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
require('../../../templates/Clases/Conectar.php');
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
$user = strtoupper($id_usuario);
$user = $id_usuario;
$consulgrupo = "SELECT * FROM `t_auxiliar`";
$queryclases = mysqli_query($c, $consulgrupo);

mysqli_close($c);


if (isset($_POST["submit"])) {
    $btntu = $_POST["submit"];
    if ($btntu == "Enviar") {
        require('../../Clases/cliente.class.php');
        $nombre_cuenta = htmlspecialchars(trim($_POST['nombre_cuenta']));
        $cod_subauxiliar = htmlspecialchars(trim($_POST['newcod_grupo']));
        $cod_auxiliar = htmlspecialchars(trim($_POST['cod_auxtxt']));
        $descrip_cuenta = htmlspecialchars(trim($_POST['descrip_cuenta']));
        $cod_subcuentatxt = htmlspecialchars(trim($_POST['cod_subcuentatxt']));
        $cod_cuentatxt = htmlspecialchars(trim($_POST['cod_cuentatxt']));
        $cod_grupptxt = htmlspecialchars(trim($_POST['cod_grupptxt']));
        $cod_classtxt = htmlspecialchars(trim($_POST['cod_classtxt']));
        $objGrupo = new Clase;
        if ($objGrupo->insertarcuentasubauxiliar(
                        array($nombre_cuenta, $cod_subauxiliar, $cod_auxiliar, $descrip_cuenta, $cod_subcuentatxt, $cod_cuentatxt, $cod_grupptxt, $cod_classtxt)) == true) {
            if ($objGrupo->insertarcuenta_plansubaux(
                            array($nombre_cuenta, $cod_subauxiliar, $cod_auxiliar, $descrip_cuenta, $cod_subcuentatxt, $cod_cuentatxt, $cod_grupptxt, $cod_classtxt)) == true) {
                echo '<script language = javascript>
alert("Guardado, exitosamente en Sub-Cuentas y Plan de Cuentas")
self.location = "plansubauxcuenta.php"
</script>';
            } else {
                echo '<script language = javascript>
alert("Ocurrio un error, no se guardo en el Plan de Cuentas...")
self.location = "newcuenta_subaux.php"
</script>';
            }
        } else {
            echo '<script language = javascript>
alert("Ocurrio un error, verifique los campos...")
self.location = "newcuenta_subaux.php"
</script>';
        }
    } else if ($btntu == "Codigo") {
        $c = $dbi->conexion();
        $cod_clase = $_POST['t_clase_cod_clase'];
        $cod_clase = $cod_clase;
        echo '<script>alert($cod_clase);</script>';
        $stu = "SELECT t_auxiliar_cod_cauxiliar AS codigo FROM `t_subauxiliar` WHERE `t_auxiliar_cod_cauxiliar` = '" . $cod_clase . "'"; //obtengo el cod de cuenta auxiliar
        $stuaux = "SELECT t_subcuenta_cod_subcuenta as sbcuenta,t_cuenta_cod_cuenta as codcuenta,t_grupo_cod_grupo as codcuentagrupo,t_clase_cod_clase as codcuentaclase FROM `t_auxiliar` WHERE `cod_cauxiliar` = '" . $cod_clase . "'";
        $stu1 = "select * from t_auxiliar";
        $query = mysqli_query($c, $stu);
        $queryclases = mysqli_query($c, $stu1);
        $querycods = mysqli_query($c, $stuaux);
        $row = mysqli_fetch_array($query);
        $idcod = $row['codigo'];
        $rowcuentas = mysqli_fetch_array($querycods);
        $idcodsubcuenta = $rowcuentas['sbcuenta'];
        $idcodcuenta = $rowcuentas['codcuenta'];
        $idcodgrupo = $rowcuentas['codcuentagrupo'];
        $idcodclase = $rowcuentas['codcuentaclase'];
        echo "<script>alert($cod_clase)</script>";
        if ($idcod == "") {
            $c = $dbi->conexion();
            $cod_clase = $_POST['t_clase_cod_clase'];
            $cod_clase = $cod_clase;
            $stu = "SELECT count( * )+1 AS codigo FROM `t_subauxiliar` WHERE `t_auxiliar_cod_cauxiliar` ='" . $cod_clase . "'  ";
            $query = mysqli_query($c, $stu);
            $row = mysqli_fetch_array($query);
            $idcod = $row['codigo'];
            $codigo_generado = $cod_clase . $idcod;
            $idcod = $codigo_generado . '.';
            $cod_clasetxt = $cod_clase;
            mysqli_close($c);
        } else {
            $c = $dbi->conexion();
            $cod_clasesubaux = $_POST['t_clase_cod_clase'];
            $cod_clasesubaux = $cod_clasesubaux;
            $stusb = "SELECT count( * ) +1 AS Siguiente, concat( (t_auxiliar_cod_cauxiliar), (count( * ) +1 )) AS Codigo FROM `t_subauxiliar` WHERE `t_auxiliar_cod_cauxiliar` = '" . $cod_clasesubaux . "'  ";
            $querysb = mysqli_query($c, $stusb);
            $rowsb = mysqli_fetch_array($querysb);
            $idsig = $rowsb['Siguiente'];
            $idcodesb = $rowsb['Codigo'];
            $idcod = $idcodesb . '.';
            $cod_clasetxt = $cod_clase;
            mysqli_close($c);
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
        <title>Admin de Cuentas de Detalle</title>
        <link href="../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <script src="../../../js/jquery.min.js"></script>
        <link href="../../../css/stylerespaldo.css" rel='stylesheet' type='text/css' />
        <link href="../../css/csstabladatos.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <script src="../../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../../js/jquery.functions.js" type="text/javascript"></script>
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
                        <a href="#">
                            <?Php
                            require('../../../templates/Clases/empresa.php');
                            $objClase = new Empresa;
                            $objClase->view_logadminsub();
                            ?>
                        </a>
                        <!--<a href="../../../index.php"><img src="../../../images/logo.png" width="650" height="100" alt=""></a>-->
                    </div>
                    <div class="menu">
                        <a class="toggleMenu" href="#"><img src="../../../images/nav_icon.png" alt="" /> </a>
                        <ul class="nav" id="nav">
                            <li><a href="../../../templates/PanelAdminLimitado/index_admin.php">Panel</a></li>
                            <li class="current"><a href="catalogodecuentas.php">Plan de Ctas</a></li>
                            <!--<li><a href="">Usuarios</a></li>-->
                            <li><a href="">Documentos</a></li>								
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
                                    <td colspan="2"><div align="right">Usuario: <span class="Estilo6">
                                                <strong><?php echo $username; ?> </strong></span></div></td>            
                                    <!--<td colspan="2"><div align="right">Acceso de: <span class="Estilo6"><strong><?php echo $type_user; ?> </strong></span></div></td>-->
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
                        <a href="../../../templates/PanelAdminLimitado/index_admin.php">  <img src="../../../images/Home.png" alt="" /> </a><strong> / 
                        </strong><a href="plansubcuentaadmin.php">Administraci&oacute;n de Ctas de Deatalle</a>
                        <br>
                        <br>                    
                        <div class="menuadministracion">
                            <a class="toggleMenu" href="#"><img src="../../../images/nav_icon.png" alt="" /> </a>
                            <ul class="nav" id="nav">
                                <li><a href="planclasesadmin.php"><img src="../../../images/user.png" title="Clases" alt="Clases" />Cl&aacute;ses</a></li>
                                <li><a href="plangruposadmin.php"><img src="../../../images/users.png" title="Grupos" alt="Grupos" />Gr&uacute;pos</a></li>							
                                <li><a href="plancuentaadmin.php"><img src="../../../images/ctas.png" title="Cuentas" alt="Cuentas" />Cuentas</a></li>							
                                <li><a href="plansubcuentaadmin.php"><img src="../../../images/subcuenta.png" title="Subcuentas" alt="Subcuentas" />Sub-Cuentas</a></li>							
                                <li><a href="planauxcuenta.php"><img src="../../../images/auxiliar.png" title="Cuenta Auxiliar" alt="Cuenta Auxiliar" />Cuenta Auxiliar</a></li>							

                                <li class="current"><a href="plansubauxcuenta.php"><img src="../../../images/subauxiliar.png" title="Cuenta Auxiliar" alt="Cuenta Auxiliar" />Sub Cuenta Auxiliar</a></li>							
                                <div class="clearfix"></div>
                            </ul>
                            <script type="text/javascript" src="../../../js/responsive-nav.js"></script>
                        </div>
                    </div>

                    <div id="contenedor">
                        <div id="formulario" style="display:none;">
                        </div>
                        <script>

            function cargacodgruponom()
            {
                var miVariable = $("#codgrupo").val();
                $.post("archivoobtenaux.php", {"texto": miVariable},
                function (respuest) {
                    document.getElementById('nombredelgrupo').value = respuest;
                });
            }
                        </script>
                        <div id="tabla">
                            <span id="new"><a href="planauxcuenta.php"><img src="../../../images/home_back.png" alt="Agregar dato" /></a></span>
                            <form id="frmClienteNuevo" name="frmClaseNuevo" method="post" action="newcuenta_subaux.php">        
                                <center>  <strong>Ingreso de Nueva Cta de Detalle</strong> </center>
                                <p><label>Seleccione a que clase pertenecer&aacute;    : <br/> 
                                        <input type="hidden" id="codgrupo" name="codgrupo" value="<?Php echo $cod_clasetxt ?>"/>
                                        <select class="text" name="t_clase_cod_clase" id="t_clase_cod_clase" 
                                                size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo();"><!--generar_codigo_grupo()-->
                                                    <?php
                                                    while ($arreglorepalmtu = mysqli_fetch_array($queryclases)) {
                                                        if ($_POST['t_clase_cod_clase'] == $arreglorepalmtu['cod_cauxiliar']) {
                                                            echo "<option value='" . $arreglorepalmtu['cod_cauxiliar'] . "' selected>&nbsp;&nbsp;" . $arreglorepalmtu['nombre_cauxiliar'] . "</option>";
                                                        } else {
                                                            ?>
                                                    <option class="text" value="<?php echo $arreglorepalmtu['cod_cauxiliar'] ?>"><?php echo $arreglorepalmtu['nombre_cauxiliar'] ?></option>     
                                                    <?php
                                                }
                                            }
                                            mysqli_close($c);
                                            ?>
                                        </select>
                                </p>
                                <center> <h6>Genere su c&oacute;digo.</h6></center> 
                                <p>
                                    <input type="submit" class="btn" name="submit" id="buttoncodificar" value="Codigo" />
                                </p>
                                <p>
                                    <label>C&oacute;digo<br />
                                        <input class="text" type="text" name="newcod_grupo" id="newcod_grupo" value="<?php echo $idcod; ?>" readonly="readonly"/>
                                </p>
                                <p>
                                </p>
                                <p><label>Nombre<br />   
                                        <input class="text" type="text" onclick="cargacodgruponom();" name="nombre_cuenta" id="nombre_cuenta" />
                                        <input class="text" type="hidden" name="cod_clasetxt" id="cod_subcuentatxt" value="<?php echo $idcodsubcuenta; ?>" />

                                        <input class="text" type="hidden" name="cod_auxtxt" id="cod_auxtxt" value="<?php echo $cod_clasetxt; ?>" />
                                        <input class="text" type="hidden" name="cod_subcuentaxt" id="cod_subcuentatxt" value="<?php echo $idcodsubcuenta; ?>" />
                                        <input class="text" type="hidden" name="cod_cuentatxt" id="cod_cuentatxt" value="<?php echo $idcodcuenta; ?>" />
                                        <input class="text" type="hidden" name="cod_grupptxt" id="cod_grupptxt" value="<?php echo $idcodgrupo; ?>" />
                                        <input class="text" type="hidden" name="cod_classtxt" id="cod_classtxt" value="<?php echo $idcodclase; ?>" />
                                    </label>
                                </p> 
                                <p>
                                    <label>Grupo</label><br/>
                                    <input class="text" type="text" readonly="readonly" id="nombredelgrupo" name="nombredelgrupo"/>
                                </p>
                                <p>
                                    <label>Descripcion<br />
                                        <input class="text" type="text" name="descrip_cuenta" id="descrip_cuenta" />
                                    </label>
                                </p>
                                <p>
                                    <input type="submit" class="btn" name="submit" id="buttonenviar" value="Enviar" />
                                    <!--<input type="reset" class="cancelar" name="cancelar" id="cancelar" value="Reset" onsubmit="<?php limpiarForm(); ?>"/>-->
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
