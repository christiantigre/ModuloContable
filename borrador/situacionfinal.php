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
$year = date("Y");
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../login.php"
</script>';
}
$id_usuario = $_SESSION['username'];
$user = strtoupper( $id_usuario );
$idlogeobl = $_SESSION['id_user'];

$accion = " / SITUACION FINAL / Ingreso a Situacion final";
generaLogs($user, $accion);
mysqli_close($c);
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
            var pagina = "situacionfinal.php";
            function redireccionar()
            {
                location.href = pagina;
            }
            $(document).ready(function () {
                $('#horizontalTab').easyResponsiveTabs({
                    type: 'default', //Types: default, vertical, accordion           
                    width: 'auto', //auto or any width like 600px
                    fit: true   // 100% fit in a container
                });
            });


        </script>

        <title>Situaci&oacute;n Final</title>
    </head>
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
                                <!--<li><a href="">Usuarios</a></li>-->
                                <li class="current"><a href="documentos/documentos.php">Documentos</a></li>								
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
                                            <td colspan="2"><div align="right">Usuario: <span class="Estilo6">
                                                        <strong><?php echo $user; ?> </strong>
                                                    </span>
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
                                <li><a href="index_modulo_contable.php">B Inicial</a></li>
                                <li><a href="Bl_inicial.php">Asientos</a></li>
                                <li><a href="automayorizacion.php">Mayorizacion</a></li>
                                <li><a href="index_modulo_contable.php">Diario</a></li>
                                <li><a href="balancederesultados.php">B. Resultados</a></li>								
                                <li  class="current"><a href="#">Situaci&oacute;n Final</a></li>								
                                <div class="clearfix"></div>
                            </ul>
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
                        <form name="BalancedeComprobacion" id="BalancedeComprobacion" action="situacionfinal.php" method="post">

                            <script>
                                function cierredeperiodo()
                                {
                                    var answer = confirm("Desea realizar el cierre del periodo y generar el nuevo periodo");
                                    if (answer) {
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
                                                creartabla();
                                            });
                                        }
                                    } else {
                                        alert("El cierre del periodo se ha cancelado...");
                                    }

                                }

                                function creartabla()
                                {
                                    var paginanuevobalance = "nuevobalance.php";
                                    location.href = paginanuevobalance;

                                }
                            </script>    
                            <center>
                                <h1>Situaci&oacute;n Final</h1>
                                <?php
                                $c = $dbi->conexion();
                                $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
                                $result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($c), E_USER_ERROR);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $maxbalancedato = $row['id'];
                                    }
                                }
                                $c->close();
                                ?>
                                <input type="hidden" value="<?php echo $maxbalancedato; ?>" id="texto"/>
                                <a href="impresiones/imphojadetrabajo.php?prmlg=<?php echo $idlogeobl; ?>">
                                    <img src="./images/print.png" alt="Ver" title="Detalles" /> 
                                </a>
                                <?php
                                $c = $dbi->conexion();
                                $muestraboton = "SELECT `estado` FROM `t_bl_inicial` WHERE year='" . $year . "' and idt_bl_inicial='" . $maxbalancedato . "'";
                                $res = mysqli_query($c, $muestraboton);
                                //$data=  mysqli_fetch_assoc($res);
                                while ($data = mysqli_fetch_array($res)) {
                                    $estado = $data['estado'];
                                    if ($data['estado'] == "1") {
                                        ?>
                                        <input type="button" name="cierrecontabilidad" onclick="cierredeperiodo();" id="cierrecontabilidad" class="btn" value="Cierre de Periodo"/>
                                        <?php
                                    } else {
                                        echo "<input type='button' name='cierrecontabilidad' id='cierrecontabilidad' class='btn' disabled='true' value='Cierre de Periodo'/>";
                                    }
                                }
                                $c->close();
                                ?>    
                                <div class="mensaje"></div>
                                <input type="hidden" value="<?php echo $estado; ?>"/>
                                <?Php
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
                                $selecclases = "SELECT nombre_clase as clase,cod_clase FROM `t_clase`";
                                $resulclases = mysqli_query($c, $selecclases) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                while ($rwclases = mysqli_fetch_assoc($resulclases)) {
                                    $nom_clase = $rwclases['clase'];
                                    $cod_clasesq = $rwclases['cod_clase'];
                                    echo '<table width="150%" class="bl">';
                                    echo '<tr>';
                                    echo '<th colspan="3"></th>';
                                    echo '<th colspan="2" class="thsaldos"><center>Sumas</center></th>';
                                    echo '<th colspan="2" class="thsaldosa"><center>Saldos</center></th>';
                                    echo '<th colspan="2" class="thsaldos"><center>Sumas Ajustes</center></th>';
                                    echo '<th colspan="2" class="thsaldosa"><center>Saldos Ajustes</center></th>';
                                    echo '<th colspan="2" class="thsaldosb"><center>Resultados</center></th>';
                                    echo '</tr>';
                                    echo '<tr><th class="l1" colspan="14"><center>' . $nom_clase . '</center></th></tr>';
                                    echo '<td style="display:none"><input name="valor" type="hidden" id="valor" value="';
                                    echo $cod_clasesq;
                                    echo '"/></td>';
                                    $sql_cargagrupos = "SELECT g.nombre_grupo AS grupo, g.cod_grupo AS cod
                                        FROM `hoja_de_trabajo` v JOIN t_grupo g JOIN t_clase c
                                        WHERE g.cod_grupo = v.`tipo` AND c.cod_clase = g.t_clase_cod_clase
                                        AND v.`t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "'
                                        AND v.year = '" . $year . "' AND c.cod_clase = '" . $cod_clasesq . "' GROUP BY cod_grupo";
                                    $resulgrupos = mysqli_query($c, $sql_cargagrupos)or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                    while ($row2 = mysqli_fetch_array($resulgrupos)) {
                                        echo '<tr><th colspan="14">' . $row2['grupo'] . '</th></tr>';
                                        echo '<td style="display:none"><input name="valorg" type="hidden" id="valorg" value="';
                                        echo $row2['cod'];
                                        echo '"/></td>';
                                        echo '<tr>
                                        <th style="display:none">id</th>
                                        <th>Fecha</th>
                                        <th>Ref.</th>
                                        <th>Cuenta</th>
                                        <th>Debe</th>
                                        <th>Haber</th>
                                        <th>Sld. Deudor</th>
                                        <th>Sld. Acreedor</th>
                                        <th>Ajuste. Deudor</th>
                                        <th>Ajuste. Acreedor</th>
                                        <th>Sld. Deudor</th>
                                        <th>Sld. Acreedor</th>
                                        <th>Activos</th>
                                        <th>Pasivos</th>
                                    </tr>';
                                        $sql_cargacuentas = "SELECT v.fecha AS f, v.cod_cuenta AS codcuenta, v.cuenta AS cuen, v.debe, v.haber,"
                                                . " v.`t_bl_inicial_idt_bl_inicial` AS balance, v.tipo AS grupo,v.sld_deudor AS slddeudor,"
                                                . " v.sld_acreedor AS sldacreedor, v.debe_aj, v.haber_aj, v.slddeudor_aj, v.sldacreedor_aj,"
                                                . " v.sum_deudor, v.sum_acreedor,"
                                                . " v.year, v.mes,g.nombre_grupo AS nomgrupo, g.cod_grupo AS codgrupo, g.`t_clase_cod_clase` AS codrelacionclase "
                                                . "FROM hoja_de_trabajo v JOIN t_grupo g "
                                                . "WHERE v.`tipo` = g.cod_grupo and year='" . $year . "' and t_bl_inicial_idt_bl_inicial='" . $parametro_contador . "'"
                                                . " and v.tipo='" . $row2['cod'] . "' and t_clase_cod_clase = '" . $cod_clasesq . "' order by tipo";
                                        $resultcargacuentas = mysqli_query($c, $sql_cargacuentas) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                        while ($rwcuentas = mysqli_fetch_assoc($resultcargacuentas)) {
                                            echo '<tr>';
                                            echo '<td >' . $rwcuentas['f'] . '</td>';
                                            echo '<td>' . $rwcuentas['codcuenta'] . '</td>';
                                            echo '<td>' . $rwcuentas['cuen'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['debe'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['haber'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['slddeudor'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['sldacreedor'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['debe_aj'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['haber_aj'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['slddeudor_aj'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['sldacreedor_aj'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['sum_deudor'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['sum_acreedor'] . '</td>';
                                            echo '</tr>';
                                        }



                                        $sql_sumastot = " SELECT sum( `debe` ) AS sumdebe, sum( `haber` ) AS sumhaber, sum( `sld_deudor` ) AS sumslddeudo,
    sum( `sld_acreedor` ) AS sumsldacreedor, sum( `debe_aj` ) AS sumajdebe,sum(`haber_aj` )  AS sumajhaber,
 sum(  `slddeudor_aj` )  AS sumajslddeudor, sum( `sldacreedor_aj`) AS sumajsldacreedor, 
 sum( `sum_deudor` ) AS resdebe, sum( `sum_acreedor` ) AS reshaber
FROM `hoja_de_trabajo`
WHERE `t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "'
AND year = '" . $year . "'
AND `tipo` = '" . $row2['cod'] . "'  ";
                                        $resultsumaajustes = mysqli_query($c, $sql_sumastot);
                                        while ($row = mysqli_fetch_array($resultsumaajustes)) {
                                            echo '<tr>';
                                            echo '<th colspan="3" style="background-color: #E0ECFF;">SUMAS DE ' . $row2['grupo'] . "-" . $row2['cod'] . '</th>';
                                            echo '<td style="background-color: #FFFFFF;>1</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row['sumdebe'] . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>3</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row['sumhaber'] . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>5</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row['sumslddeudo'] . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>7</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row['sumsldacreedor'] . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>8</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row['sumajdebe'] . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>10</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row['sumajhaber'] . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>12</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row['sumajslddeudor'] . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>14</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row['sumajsldacreedor'] . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>16</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row['resdebe'] . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>18</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row['reshaber'] . '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                    echo '</table>';
                                }
                                ?>

                                <table>
                                    <tr>
                                        <?Php
                                        $sql_sumastotfin = "  SELECT sum( `debe` ) AS sumdebe, sum( `haber` ) AS sumhaber, sum( `sld_deudor` ) AS sumslddeudor, sum( `sld_acreedor` ) AS sumsldacreedor, sum( `debe_aj` ) AS sumajdebe, sum( `haber_aj` ) AS sumajhaber, sum( `slddeudor_aj` ) AS sumajslddeudor, sum( `sldacreedor_aj` ) AS sumajsldacreedor, sum( `sum_deudor` ) AS resdebe, sum( `sum_acreedor` ) AS reshaber
FROM `hoja_de_trabajo`
WHERE `t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "'
AND year = '" . $year . "'  ";
                                        $resultsumaajustesfin = mysqli_query($c, $sql_sumastotfin);
                                        while ($rowf = mysqli_fetch_array($resultsumaajustesfin)) {
                                            $sumdebe = $rowf['sumdebe'];
                                            $sumhaber = $rowf['sumhaber'];
                                            $sumslddeudor = $rowf['sumslddeudor'];
                                            $sumsldacreedor = $rowf['sumsldacreedor'];
                                            $sumajdebe = $rowf['sumajdebe'];
                                            $sumajhaber = $rowf['sumajhaber'];
                                            $sumajslddeudor = $rowf['sumajslddeudor'];
                                            $sumajsldacreedor = $rowf['sumajsldacreedor'];
                                            $resdebe = $rowf['resdebe'];
                                            $reshaber = $rowf['reshaber'];
                                        }
                                        ?>
                                        <th colspan="6">Total </th>
                                        <td></td>
                                        <td></td>
                                        <td>Debe <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="tdebe" id="tdebe" value="<?php echo $sumdebe ?>" placeholder="0.00" /></td>
                                        <td>Haber <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="thaber" id="thaber" value="<?php echo $sumhaber ?>" placeholder="0.00" /></td>
                                        <td>Deudor <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="tdeudor" id="tdeudor" value="<?php echo $sumslddeudor ?>" placeholder="0.00" /></td>
                                        <td>Acreedor <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="tacreedor" id="tacreedor" value="<?php echo $sumsldacreedor ?>" placeholder="0.00" />

                                        <td>Aj.Debe <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="tdebe" id="tdebe" value="<?php echo $sumajdebe ?>" placeholder="0.00" /></td>
                                        <td>Aj.Haber <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="thaber" id="thaber" value="<?php echo $sumajhaber ?>" placeholder="0.00" /></td>
                                        <td>Aj.Deudor <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="tdeudor" id="tdeudor" value="<?php echo $sumajslddeudor ?>" placeholder="0.00" /></td>
                                        <td>Aj.Acreedor <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="tacreedor" id="tacreedor" value="<?php echo $sumajsldacreedor ?>" placeholder="0.00" />

                                        <td>Tot.  <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="resdebe" id="resdebe" value="<?php echo $resdebe ?>" placeholder="0.00" />
                                        <td>Tot. <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="resdebe" id="resdebe" value="<?php echo $reshaber ?>" placeholder="0.00" />

                                            <?Php $c->close(); ?>

                                    </tr>
                                </table>
                            </center>

                        </form>
                    </center>
                </div>
            </div>
        </div>

    </div>
</body>
</html>



