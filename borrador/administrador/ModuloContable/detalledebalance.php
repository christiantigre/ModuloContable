<!DOCTYPE html>
<!--Christian Tigre-->
<?php
require('../../../Clases/cliente.class.php');
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
$tot_act_corr = 0;
$tot_actno_corr = 0;
$tot_pasivos = 0;
$totalpasivos = 0;
$tot_pasivosno_corr = 0;
$tot_patrimonio = 0;
$tot_activos = 0;
$tot_pasivomaspatrimonio = 0;
//Proceso de conexi�n con la base de datos
$conex = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
mysql_select_db("condata", $conex) or die("ERROR con la base de datos");
//Iniciar Sesi�n
session_start();

//Validar si se est� ingresando con sesi�n correctamente
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../login.php"
</script>';
}
$date = date("Y-m-j");

$id_usuario = $_SESSION['username'];
$consulta = "SELECT l.username, u.tipo_user, l.idlogeo
FROM logeo l
JOIN user_tipo u
WHERE l.user_tipo_iduser_tipo = u.iduser_tipo
AND l.username = '" . $id_usuario . "'";
//$id_usuario . "'";
$resultado = mysql_query($consulta, $conex) or die(mysql_error());
$fila = mysql_fetch_array($resultado);
$user = $fila['username'];
$type_user = $fila['tipo_user'];
$idlogeobl = $fila['idlogeo'];

$servername = "localhost";
$usernamedb = "root";
$password = "alberto2791";
$dbname = "condata";
$conn = new mysqli($servername, $usernamedb, $password, $dbname);
$sql = "SELECT count(*) as cont FROM `t_bl_inicial` WHERE fecha_balance='" . $date . "'";
$result = $conn->query($sql);
$resultcuad = $conn->query($sqlcua);
if ($result->num_rows > 0) {
    while ($clase = $result->fetch_assoc()) {
        $con = $clase['cont'];
    }
} else {
    echo "<script>alert('No se selecciono el balance')</script>";
}


if (isset($_POST["submit"])) {
    $btntu = $_POST["submit"];
    // echo "<script>alert('boton enviar');</script>";
    if ($btntu == "Agregar") {
        
    }
    if ($btntu == "Ordenar Corte de Balance") {
        
    }
    if ($btntu == "Cuadrar") {
        
    }
    if ($btntu == "Actualizar") {
        
    }
    if ($btntu == "Calculo Activos") {
        
    }
}
?>
<html>
    <head>
        <title>Detalle Balance Inicial</title>
        <link href="../../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <script src="../../../../js/jquery.min.js"></script>
        <script src="../../../../js/jquery-1.3.1.min.js"></script>
        <link href="../../../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <link href="css/datepicker.css" rel='stylesheet' type='text/css' />
        <link href="css/layout.css" rel='stylesheet' type='text/css' />
        <script src="../../../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../../../js/jquery.functions.js" type="text/javascript"></script>
        <script src="../../../../js/script.js" type="text/javascript"></script>
        <script src="js/jquery.js" type="text/javascript"></script>
        <script src="js/datepicker.js" type="text/javascript"></script>
        <script src="js/eye.js" type="text/javascript"></script>
        <script src="js/utils.js" type="text/javascript"></script>
        <script src="js/layout.js?ver=1.0.2" type="text/javascript"></script>

        <style>
            .contenedores{margin:60px auto;width:960px;font-family:sans-serif;font-size:15px}
            table {width:100%;box-shadow:0 0 10px #ddd;text-align:left}
            th {padding:5px;background:#555;color:#fff}
            td {padding:5px;border:solid #ddd;border-width:0 0 1px;}
            .editable span{display:block;}
            .editable span:hover {background:url(images/edit.png) 90% 50% no-repeat;cursor:pointer}

            td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
            a.enlace{display:inline-block;width:24px;height:24px;margin:0 0 0 5px;overflow:hidden;text-indent:-999em;vertical-align:middle}
            .guardar{background:url(images/save.png) 0 0 no-repeat}
            .cancelar{background:url(images/cancell.png) 0 0 no-repeat}

            .mensaje{display:block;text-align:center;margin:0 0 20px 0}
            .ok{display:block;padding:10px;text-align:center;background:green;color:#fff}
            .ko{display:block;padding:10px;text-align:center;background:red;color:#fff}

            select {
                background : transparent;
                border : none;
                font-size : 14px;
                height : 30px;
                padding : 5px;
                width : 250px;
            }
            select:focus {
                outline : none;
            } 
            
            //css calendario//
            input.inputDate {
	border: 1px solid #999;
	padding: 4px;
	border-bottom-color: #ddd;
	border-right-color: #ddd;
	width: 65px;
}
        </style>
    </head>
    <body>
        <div id="contenedor_bl">
            <div id="menu_contable">
                <div class="menu">
                    <ul class="nav" id="nav">
                        <li><a href="../../index_admin.php">Panel</a></li>
                        <li><a href="../PaneldeAdministrador/funcionesdeadministrador/catalogodecuentas.php">Plan de Ctas</a></li>
                        <li><a href="">Usuarios</a></li>
                        <li><a href="">Documentos</a></li>								
                        <div class="clearfix"></div>
                    </ul>
                </div>
                <div>
                    <center><h1>Modulo de Contabilidad</h1></center>
                </div>
            </div>
            <div id="menu_general">
                <div id="caja_us">
                    <center>
                        <table width="718" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>&nbsp;</tr>
                            <tr>
                                <td colspan="2">
                                    <div align="right">
                                        <label>  Usuario: </label> <span class="Estilo6"> <strong><?php echo $_SESSION['username']; ?> </strong> </span>
                                        <label>  Priv. : </label> <span class="Estilo6"> <strong><?php echo $type_user; ?> </strong> </span>
                                        
                                        <input name="idlog" id="idlog" type="hidden" value="<?php echo $idlogeobl ?>"
                                    </div></td>            
                                <td></td>
                                <td colspan="2"><div align="right">
                                        <a href="../../../../templates/logeo/desconectar_usuario.php">
                                            <img src="../../../../images/logout.png" title="Salir" alt="Salir" /></a> </div></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </center>
                </div>
                <div class="menu">
                    <ul class="nav" id="nav">
                        <li><a href="../../templateslimit/ModuloContable/star_balance.php">B Inicial</a></li>
                        <li><a href="Bl_inicial.php">Asientos</a></li>
                        <li><a href="index_modulo_contable.php">Diario</a></li>
                        <li><a href="">B. Resultados</a></li>								
                        <li><a href="">Perdidas y Ganancias</a></li>								
                        <div class="clearfix"></div>
                    </ul>
                </div>
            </div>
            <div id="cuerpo">
                <div id="banner_left"></div>
                <!--formulario 1-->
                <div id="form1">
                    <form id="frm_detbl" name="frm_detbl" method="post" action="" enctype="multipart/form-data"> 
                        <input type="hidden" id="bal" name="bal" value="<?php echo $con; ?>"/>
                        <input type="hidden" id="balancefech" value="<?php echo $date; ?>"/>
                        <label>Fecha :<?php echo $date; ?></label>
                        <br/>
                        <br/>
                        <strong>Detalle de Balance Inicial</strong>
                        <br>
                        <table>
                            <tr>
                                <td>
                                    <label>Ver por grupos:</label>
                                    <?php
//carga los tipo de cuentas para el balance
                                    $cone_tpdh = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
                                    mysql_select_db("condata", $cone_tpdh) or die("ERROR con la base de datos");
                                    $SQLtipobaldh = "SELECT DISTINCT e.tipo AS tp, g.nombre_grupo as ng
FROM t_ejercicio e
JOIN t_grupo g
WHERE g.cod_grupo = e.tipo";
                                    $query_tipo_bldh = mysql_query($SQLtipobaldh);
                                    ?>
                                    <select name="tip_cuentadh" id="tip_cuentadh" size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo()
                                                    ;"><!--generar_codigo_grupo()-->
                                                <?php while ($arreglot_cuendh = mysql_fetch_array($query_tipo_bldh)) { ?>
                                            <option class="text" value="<?php echo $arreglot_cuendh['tp'] ?>">
                                                <?php echo $arreglot_cuendh['ng'] ?></option>     
                                        <?php }mysql_close($cone_tpdh); ?>
                                    </select>
                                    <input type="submit" name="submit" id="submit" value="Ver Por Grupo"/>
                                </td>
                            <tr>
                                <td>
                                    <label>Ver por Periodos :</label></br>
                                    <label>Desde :</label>
                                    <input class="inputDate" name="inputDate" id="inputDate" value="<?php echo $date?>" /></br>
                                    <label>Hasta :</label>
                                    <input class="inputDate1" name="inputDate1" id="inputDate1" value="<?php echo $date?>" /></br>
                                    <input type="submit" name="submit" id="submit" value="Ver Por Periodo"/>
                                </td>
                            </tr>
                            </tr>
                        </table>
                    </form>
                    <!--Menu -->
                </div>    
                <!--formulario 2    javascript: fn_agregar();-->
                <div id="form2"> 
                    <?php
                    
                    if (isset($_POST["submit"])) {
    $btntu = $_POST["submit"];
    // echo "<script>alert('boton enviar');</script>";
    if ($btntu == "Ver Por Grupo") {
                    $cone_tpdh = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
                    mysql_select_db("condata", $cone_tpdh) or die("ERROR con la base de datos");
                    $tp = htmlspecialchars(trim($_POST['tip_cuentadh']));
                    $contador = htmlspecialchars(trim($_POST['bal']));
                    //echo "<script>alert('$tp')</script>";
                    $result = mysql_query("SELECT * FROM t_ejercicio WHERE tipo = '".$tp."' ", $cone_tpdh);
                    //$resultvalores = mysql_query(" SELECT SUM( valor ) AS vd, SUM( valorp ) AS vh FROM `t_ejercicio` WHERE tipo = '".$tp."' AND `t_bl_inicial_idt_bl_inicial` ='".$contador."' ", $cone_tpdh);
                    //se despliega el resultado  
                    echo "<table class='editinplaceA'>";
                    echo "<tr>";
                    echo "<th style='display:none'>Cod</td>";
                    echo "<th>Ejercicio</td>";
                    echo "<th>Fecha</td>";
                    echo "<th>Ref</td>";
                    echo "<th>Cuenta</td>";
                    echo "<th>Debe</td>";
                    echo "<th>Haber</td>";
                    echo "</tr>";
                    while ($row = mysql_fetch_row($result)) {
                        echo "<tr>";
                        echo "<td style='display:none'>$row[0]</td>";
                        echo "<td>$row[1]</td>";
                        echo "<td>$row[4]</td>";
                        echo "<td>$row[2]</td>";
                        echo "<td>$row[3]</td>";
                        echo "<td>$row[5]</td>";
                        echo "<td>$row[6]</td>";
                        echo "</tr>";
                    }                  
                    }
    if ($btntu == "Ver Por Periodo") {
                    $cone_tpdh = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
                    mysql_select_db("condata", $cone_tpdh) or die("ERROR con la base de datos");
                    $tp = htmlspecialchars(trim($_POST['tip_cuentadh']));
                    $desde = htmlspecialchars(trim($_POST['inputDate']));
                    $hasta = htmlspecialchars(trim($_POST['inputDate1']));
                    //echo "<script>alert('$tp')</script>";
                    $result = mysql_query("SELECT * FROM `t_ejercicio` WHERE `fecha` BETWEEN '".$desde."'  AND '".$hasta."';", $cone_tpdh);
                    //$resultvalores = mysql_query(" SELECT SUM( valor ) AS vd, SUM( valorp ) AS vh FROM `t_ejercicio` WHERE tipo = '".$tp."' AND `t_bl_inicial_idt_bl_inicial` ='".$contador."' ", $cone_tpdh);
                    //se despliega el resultado  
                    echo "<table class='editinplaceA'>";
                    echo "<tr>";
                    echo "<th style='display:none'>Cod</td>";
                    echo "<th>Ejercicio</td>";
                    echo "<th>Fecha</td>";
                    echo "<th>Ref</td>";
                    echo "<th>Cuenta</td>";
                    echo "<th>Debe</td>";
                    echo "<th>Haber</td>";
                    echo "</tr>";
                    while ($row = mysql_fetch_row($result)) {
                        echo "<tr>";
                        echo "<td style='display:none'>$row[0]</td>";
                        echo "<td>$row[1]</td>";
                        echo "<td>$row[4]</td>";
                        echo "<td>$row[2]</td>";
                        echo "<td>$row[3]</td>";
                        echo "<td>$row[5]</td>";
                        echo "<td>$row[6]</td>";
                        echo "</tr>";
                    } 
                        
                    }
}
                    ?>  
                    
                </div>
            </div>
        </div>
    </body>
</html>	
