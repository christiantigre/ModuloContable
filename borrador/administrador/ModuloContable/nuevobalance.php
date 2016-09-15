<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?Php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
require '../../../../templates/Clases/Conectar.php';
include '../../Clases/guardahistorial.php';
$dbi = new Conectar();
$c = $dbi->conexion();
session_start();
$date = date("Y-m-j");
$year = date("Y");
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../login.php"
</script>';
}
$id_usuario = $_SESSION['username'];
$consulta = "SELECT l.username, u.tipo_user,l.idlogeo
FROM logeo l
JOIN user_tipo u
WHERE l.username = '" . $id_usuario . "'";
//$resultado = mysql_query($consulta, $conex) or die(mysql_error());
$resultado = mysqli_query($c, $consulta);
$fila = mysqli_fetch_array($resultado);
$user = $fila['username'];
$type_user = $fila['tipo_user'];
$idlogeobl = $fila['idlogeo'];
$accion = "Generando nuevo balance";
generaLogs($user, $accion);
//mysqli_close($c);
//$db->close();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <link href="../../../../css/style.csss" rel='stylesheet' type='text/css' />
        <link href="../../templateslimit/ModuloContable/css/estyle_tablas_modcontable.css" rel='stylesheet' type='text/css' />
        <script src="../../../../js/jquery.min.js"></script>
        <link href="../../../../css/mod_contable.css" rel='stylesheet' type='text/css' />
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
            });</script>

        <title>Balance a la fecha</title>
    </head>
    <script>

        function guardanewBalance()
        {
            var answer = confirm("Al aceptar se guardara automaticamente el balance actual generado...");
            if (answer) {
                $('#formulario').submit(function (msg) {
                    $.post("guardanewbalance.php", $(this).serialize(), function (data) {
                        alert(data);
                        var paginanuevobalance = "index_modulo_contable.php";
                        location.href = paginanuevobalance;
                    });
                    return false;
                });
            } else {
                alert("Se cancelo el registro del balance actual generado...");
            }
        }

        function cierredeperiodo() {
            var miVariableJS = $("#texto").val();
            if (miVariableJS == 0)
            {
                alert("El periodo ya esta cerrado");
            }
            else {
                $.post("cierraperiodo.php", {"texto": miVariableJS},
                function (respuesta) {
                    document.getElementById('texto').value = respuesta;
                    alert(respuesta);
                    //redireccionar();
                    creartabla();
                });
            }
        }

        function creartabla() {
            var paginanuevobalance = "nuevobalance.php";
            location.href = paginanuevobalance;
        }
    </script> 
    <body>
        <div id="contenedor">
            <center>
                <div id="menus">
                    <!--Menu contable-->
                    <div id="menu_contable">
                        <div class="menu">
                            <ul class="nav" id="nav">
                                <li><a href="../../index_admin.php">Panel</a></li>
                                <li><a href="../catalogodecuentas.php">Plan de Ctas</a></li>
                                <li><a href="">Usuarios</a></li>
                                <li class="current"><a href="">Documentos</a></li>								
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                        <div>
                            <center><h1>Modulo de Contabilidad</h1></center>
                        </div>
                    </div>
                    <!--Menu general-->
                    <div id="menu_general">
                        <div id="caja_us">
                            <center>
                                <div>
                                    <table width="718" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>&nbsp;</tr>
                                        <tr>
                                            <td colspan="2">
                                                <div align="right">Usuario: 
                                                    <span class="Estilo6">
                                                        <strong><?php echo $_SESSION['username']; ?> </strong>
                                                    </span>
                                                    <input name="idlog" id="idlog" type="hidden" value="<?php echo $idlogeobl ?>"/>
                                                </div>
                                            </td>            
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
                                <li><a href="index_modulo_contable.php">B Inicial</a></li>
                                <li><a href="Bl_inicial.php">Asientos</a></li>
                                <li><a href="automayorizacion.php">Mayorizacion</a></li>
                                <li><a href="index_modulo_contable.php">Diario</a></li>
                                <li><a href="balancederesultados.php">B. Resultados</a></li>								
                                <li  class="current"><a href="#">Balance Generado</a></li>								
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                    </div>
                </div>        
            </center>
        </div>
        <div id="cuerpo">
            <div id="banner_left"></div>
            <!--formulario 1-->
            <div id="form1">

            </div>    
            <!--formulario 2-->
            <div id="form2"> 
                <div id="formulario_bl">
                    <center>
                        <form name="formulario" id="formulario" action="nuevobalance.php" method="POST">
                            <center>
                                <h1>Balance Generado</h1>
                                <?php
                                $c = $dbi->conexion();
                                $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
                                $result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($c), E_USER_ERROR);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $maxbalancedato = $row['id'];
                                    }
                                }
                                //$c->close();
                                ?>
                                <!--<input type="hidden" value="<?php echo $maxbalancedato; ?>" id="texto"/>-->
<!--                                <a href="impresiones/imphojadetrabajo.php?prmlg=<?php echo $idlogeobl; ?>">
                                    <img src="./images/print.png" alt="Ver" title="Detalles" /> 
                                </a>-->
                                <input type="submit" name="savenewblini" onclick="guardanewBalance()" 
                                       id="savenewblini" class="btn" value="Guardar Nuevo Balance"/>
<!--                                <input type="button" name="balanceactual" id="balanceactual" class="btn" value="Balance General Actual"/>-->
                                <div class="mensaje"></div>
                                <input type="hidden" value="<?php echo $estado; ?>"/>
                                <input type="hidden" name="respuesta" id="respuesta" value=""/>
                                <input type="hidden" name="idlogeobl" id="idlogeobl" value="<?php echo $idlogeobl; ?>"/>
                                <?php
                                $c = $dbi->conexion();
                                $sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
                                $resul_param = $c->query($sqlparametro);
                                if ($resul_param->num_rows > 0) {
                                    while ($clase_param = $resul_param->fetch_assoc()) {
                                        $parametro_contador = $clase_param['cont'];
                                    }
                                } else {
                                    echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
                                }
                                $sql_sumyear = "SELECT year FROM `t_bl_inicial` where idt_bl_inicial='" . $maxbalancedato . "'";
                                $data = mysqli_query($c, $sql_sumyear);
                                $resdata = mysqli_fetch_assoc($data);
                                $yearactual = $resdata['year'] + 1;
                                ?>
                                <input type="text"  readonly="readonly" class="form-control" name="yearsiguiente" id="yearsiguiente" value="El periodo a crear es :<?php echo $yearactual; ?>"/>
                                <?Php
                                $sql_carganuevobalance = "
SELECT v.fecha AS f, v.cod_cuenta AS codcuenta, p.nombre_cuenta_plan AS cuenta, v.tipo AS grupo, v.sum_deudor, v.sum_acreedor
FROM hoja_de_trabajo v
JOIN t_grupo g
JOIN t_plan_de_cuentas p
WHERE v.`tipo` = g.cod_grupo
AND p.cod_cuenta = v.cod_cuenta
AND v.year = '".$year."'
AND v.t_bl_inicial_idt_bl_inicial = '".$maxbalancedato."'
ORDER BY tipo";
                                ?>

                                <center>
                                    <table>
                                        <tr>
                                            <td>Fecha</td>
                                            <td>Codigo</td>
                                            <td>Cuenta</td>
                                            <td>Debe</td>
                                            <td>Haber</td>
                                        </tr>
                                        <?Php
                                        $resul1 = mysqli_query($c, $sql_carganuevobalance);
                                        while ($r2 = mysqli_fetch_array($resul1)) {
                                            echo '<tr>';
                                            echo '<td width="15%"><input readonly="readonly" type="text" name="campo1[]" id="fecha" value=' . $date . '></td>';
                                            echo '<td width="15%"><input readonly="readonly" type="text" name="campo2[]" id="cod" value=' . $r2['codcuenta'] . '></td>';
                                            echo '<td width="45%">';
                                            echo '<input type="text" readonly="readonly" name="campo3[]" id="cuenta" style="width: 220px;" value="' . $r2['cuenta'] . '">';
                                            echo '</td>';
                                            echo '<td width="10%"><input readonly="readonly" type="text" name="campo4[]" id="deb" value=' . $r2['sum_deudor'] . '></td>';
                                            echo '<td width="10%"><input readonly="readonly" type="text" name="campo5[]" id="hab" value=' . $r2['sum_acreedor'] . '></td>';
                       echo '<td width="15%" style="display:none"><input readonly="readonly" type="text" name="campo6[]" id="tipo" value=' . $r2['grupo'] . '></td>';
                                            echo '</tr>';
                                        }
                                        //$c->close();
                                        ?>

                                        <tr>
                                            <th colspan="6"> Concepto :
                                                <textarea class="form-control" id="textarea_asnew" name="textarea_asnew" rows="1" cols="30">
                                Balance actual a la fecha <?php echo $date; ?> por cierre de periodo <?php echo $year; ?>...
                                                </textarea>
                                            </th>
                                        </tr>
                                    </table>
                                </center>


                            </center>
                        </form>
                    </center>
                </div>
            </div>
        </div>

    </div>
</body>
</html>



