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
$consulclases = "select * from t_clase";
$queryclases = mysqli_query($c, $consulclases);
//$consulta = "SELECT l.username, u.tipo_user,l.idlogeo
//FROM logeo l
//JOIN user_tipo u
//WHERE l.user_tipo_iduser_tipo = u.iduser_tipo and l.username = '" . $id_usuario . "'";
//$resultado = mysqli_query($c, $consulta) or die(mysqli_errno($c));
//$fila = mysqli_fetch_array($resultado);
//$user = $fila['username'];
//$type_user = $fila['tipo_user'];
mysqli_close($c);


$seleccionado = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seleccionado = $_POST['t_clase_cod_clase'];
}


if (isset($_REQUEST["submit"])) {
    $btntu = $_REQUEST["submit"];
    if ($btntu == "Enviar") {
        // echo "<script>alert('boton enviar');</script>";
        require('../../Clases/cliente.class.php');
        $nombre_grupo = htmlspecialchars(trim($_REQUEST['nombre_grupo']));
        $cod_grupo = htmlspecialchars(trim($_REQUEST['newcod_grupo']));
        $descrip_grupo = htmlspecialchars(trim($_REQUEST['descrip_grupo']));
        $t_clase_cod_clase = htmlspecialchars(trim($_REQUEST['cod_clasetxt']));
        $objGrupo = new Clase;
        if ($nombre_grupo == "" or $cod_grupo == "") {
            echo "<script> alert('Complete los campos');</script>";
        } else {
            if ($objGrupo->insertargrupo(array($nombre_grupo, $cod_grupo, $descrip_grupo, $t_clase_cod_clase)) == true) {
                if ($objGrupo->insertargrupo_plan(array($nombre_grupo, $cod_grupo, $descrip_grupo, $t_clase_cod_clase)) == true) {
                    // echo "<script> alert('Guardado; '".$nombre_grupo + $cod_grupo + $descrip_grupo =$cod_claseaux."');</script>";
                } else {
                    echo "<script> alert('Error, no se guardo el registro en el Plan de Cuentas');</script>";
                }
                echo '<script language = javascript>
alert("Guardado, exitosamente en Grupos y Plan de Cuentas")
self.location = "plangruposadmin.php"
</script>';
            } else {
                echo "<script> alert('Error, no se guardo el registro');</script>";
            }
        }
    } else if ($btntu == "Codigo") {
        $cod_clase = $_REQUEST['t_clase_cod_clase'];
        $c = $dbi->conexion();
        $stu = " SELECT cod_grupo as codigo FROM `t_grupo` WHERE `t_clase_cod_clase` ='" . $cod_clase . "'  ";
        $stu1 = "select * from t_clase";
        $query = mysqli_query($c, $stu);
        $queryclases = mysqli_query($c, $stu1);
        $row = mysqli_fetch_array($query);
        $idcod = $row['codigo'];
        if ($idcod == "") {
            $c = $dbi->conexion();
            $cod_clase = $_REQUEST['t_clase_cod_clase'];
            $stu = "SELECT count( * ) +1 AS codigo
FROM `t_cuenta`
WHERE `t_grupo_cod_grupo` = '" . $cod_clase . "'  ";
            $query = mysqli_query($c, $stu);
            $row = mysqli_fetch_array($query);
            $idcod = $row['codigo'];
            $codigo_generado = $cod_clase . $idcod . '.';
            $idcod = $codigo_generado;
            $cod_clasetxt = $cod_clase;
            mysqli_close($c);
        } else {
            $c = $dbi->conexion();
            $cod_clase = $_REQUEST['t_clase_cod_clase'];
            $stu = " SELECT count( * ) +1 AS Siguiente, concat( (t_clase_cod_clase), (count( * ) +1 ))"
                    . " AS Codigo FROM `t_grupo` WHERE `t_clase_cod_clase` =" . $cod_clase . "  ";
            $query = mysqli_query($c, $stu);
            $row = mysqli_fetch_array($query);
            $idsig = $row['Siguiente'];
            $idcod = $row['Codigo'];
            $cod_clasetxt = $cod_clase;
            $codigo_generado = $idcod . '.';
            $idcod = $codigo_generado;
            mysqli_close($c);
        }
    }

    $contenido = $_REQUEST;

    function limpiarForm() {
        unset($contenido);
    }

}
?>
<html>
    <head>
        <title>Admin de Gr&uacute;pos</title>
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
                        <!--<a href="../index_admin.php"><img src="../../../images/logo.png" width="650" height="100" alt=""></a>-->
                    </div>
                    <div class="menu">
                        <a class="toggleMenu" href="#"><img src="../../../images/nav_icon.png" alt="" /> </a>
                        <ul class="nav" id="nav">
                            <li><a href="../index_admin.php">Panel</a></li>
                            <li class="current"><a href="catalogodecuentas.php">Plan de Ctas</a></li>
                            <!--<li><a href="services.html">Usuarios</a></li>-->
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
                        <a href="../../../index.php">  <img src="../../../images/Home.png" alt="" /> </a><strong> / </strong><a href="plangrupos.php">Administraci&oacute;n de Grupos</a>
                        <br>
                        <br>                    
                        <div class="menuadministracion">
                            <a class="toggleMenu" href="#"><img src="../../../images/nav_icon.png" alt="" /> </a>
                            <ul class="nav" id="nav">
                                <li><a href="../templateslimit/planclasesadmin.php"><img src="../../../images/user.png" title="Plan de Cuentas" alt="Plan de Cuentas" />Cl&aacute;ses</a></li>
                                <li class="current"><a href="../templateslimit/plangruposadmin.php"><img src="../../../images/users.png" title="Control de Usuarios" alt="Control de Usuarios" />Gr&uacute;pos</a></li>							
                                <li><a href="plancuentaadmin.php"><img src="../../../images/ctas.png" title="Control de Usuarios" alt="Control de Usuarios" />Cuentas</a></li>							
                                <li><a href="plansubcuentaadmin.php"><img src="../../../images/subcuenta.png" title="Subcuentas" alt="Subcuentas" />Sub-Cuentas</a></li>							
                                <li><a href="planauxcuenta.php"><img src="../../../images/auxiliar.png" title="Cuenta Auxiliar" alt="Cuenta Auxiliar" />Cuenta Auxiliar</a></li>							
                                <li><a href="plansubauxcuenta.php"><img src="../../../images/subauxiliar.png" title="Cuenta Auxiliar" alt="Cuenta Auxiliar" />Sub Cuenta Auxiliar</a></li>							
                                <div class="clearfix"></div>
                            </ul>
                            <script type="text/javascript" src="../../../js/responsive-nav.js"></script>
                        </div>
                    </div>
                    <div id="contenedor">
                        <div id="formulario" style="display:none;">
                        </div>
                        <div id="tabla">
                            <span id="new"><a href="plangruposadmin.php"><img src="../../../images/home_back.png" alt="Agregar dato" /></a></span>
                            <form id="frmClienteNuevo" name="frmClaseNuevo" method="post" action="newgrupo.php">        
                                <center>  <strong>Ingreso de Nuevo Grupo</strong> </center>

                                <p><label>Selecciones a que clase pertenecer&aacute;    : <br/> 
                                        <select class="text" name="t_clase_cod_clase" id="t_clase_cod_clase" size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo();"><!--generar_codigo_grupo()-->
                                            <?php
                                            while ($arreglorepalmtu = mysqli_fetch_array($queryclases)) {
                                                if ($_POST['t_clase_cod_clase'] == $arreglorepalmtu['cod_clase']) {
                                                    echo "<option value='" . $arreglorepalmtu['cod_clase'] . "' selected>&nbsp;&nbsp;" . $arreglorepalmtu['nombre_clase'] . "</option>";
                                                } else {
                                                    ?>
                                                    <option class="text" value="<?php echo $arreglorepalmtu['cod_clase'] ?>">
                                                        <?php echo $arreglorepalmtu['nombre_clase'] ?></option>     
                                                    <?php
                                                }}
                                            mysqli_close($c);
                                            ?>
                                        </select>
                                </p>
                                <p>
                                <center> <h6>Genere su c&oacute;digo.</h6></center> <p>
                                    <input type="submit" name="submit" class="btn" id="buttoncodificar" value="Codigo" /></p>
                                </p>
                                <p><label>Nombre<br />
                                        <input class="text" type="text" name="nombre_grupo" id="nombre_grupo" />
                                        <input class="text" type="hidden" name="cod_clasetxt" id="cod_clasetxt" value="<?php echo $cod_clasetxt; ?>" />
                                    </label>
                                </p>
                                <p>
                                    <label>C&oacute;digo<br />
                                        <input class="text" type="text" name="newcod_grupo" id="newcod_grupo" value="<?php echo $idcod; ?>" readonly="readonly"/>
                                       </p>
                                <p>
                                    <label>Descripcion<br />
                                        <input class="text" type="text" name="descrip_grupo" id="descrip_grupo" />
                                    </label>
                                </p>
                                <p>
                                    <input type="submit" class="btn" name="submit" id="buttonenviar" value="Enviar" />
                                    <!--<input type="reset"  name="cancelar" id="cancelar" value="Reset" onsubmit="<?php limpiarForm(); ?>"/>-->
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
