<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?Php
//require('../../../Clases/cliente.class.php');
require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$conex = $dbi->conexion();
$conn = $dbi->conexion();
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
$date = date("Y-m-j");
$year = date("Y");
$mes = date('F');
//Validar si se est� ingresando con sesi�n correctamente
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../../login.php"
</script>';
}
$id_usuari = $_SESSION['username'];
$idlogeobl = $_SESSION['id_user'];
$id_usuari = strtoupper ( $id_usuari );
mysqli_close($conex);
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
            });
        </script>	

        <title>Balance de Comprobaci&oacute;n</title>
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
                                                        <strong><?php echo $id_usuari; ?> </strong>
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
                                <li class="current"><a href="#">B. Resultados</a></li>								
                                <li><a href="situacionfinal.php">Situaci&oacute;n Final</a></li>								
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
                <!--para banner-->
            </div>    
            <!--formulario 2-->
            <div id="form2"> 
                <div id="formulario_bl">
                    <center>
                        <form name="BalancedeComprobacion" id="BalancedeComprobacion" action="balancederesultados.php" method="post">
                            <center>
                                <h1>Balance de Comprobaci&oacute;n</h1>
                                <h3>Hasta la fecha <?php echo $date ?> del <?php echo $year ?></h3>
                                <div style="float: left;" class="menu"> 
                                    <ul class="nav" id="nav">
                                        <li><a href="ajustesasientos.php">Ajuste</a></li>
                                        <li><a href="impresiones/impbalanceresultados.php?prmlg=<?php echo $idlogeobl; ?>">
                                                <img src="./images/print.png" alt="Ver" title="Detalles" /> 
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="mensaje"></div>
                                <!--carga de el balance de resultados por grupos-->
                                <?php
                                $sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
                                $resul_param = $conn->query($sqlparametro);
                                if ($resul_param->num_rows > 0) {
                                    while ($clase_param = $resul_param->fetch_assoc()) {
                                        $parametro_contador = $clase_param['cont'];
                                    }
                                } else {
                                    echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
                                }
                                $sql_cargaclases = "SELECT nombre_clase as clase,cod_clase FROM `t_clase`";
                                $resulclases = mysqli_query($conn, $sql_cargaclases) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                while ($rwclases = mysqli_fetch_assoc($resulclases)) {
                                    $nom_clase = $rwclases['clase'];
                                    $cod_clasesq = $rwclases['cod_clase'];
                                    echo '<table width="100%" class="bl">';
                                    echo '<tr>';
                                    echo '<th colspan="3"></th>';
                                    echo '<td style="display:none"></td>';
                                    echo '<td style="display:none"></td>';
                                    echo '<th colspan="2" class="thsaldos"><center>Sumas</center></th>';
                                    echo '<th colspan="2" class="thsaldosa"><center>Saldos</center></th>';
                                    echo '<th colspan="2" class="thsaldos"><center>Sumas Ajustes</center></th>';
                                    echo '<th colspan="2" class="thsaldosa"><center>Saldos Ajustes</center></th>';
                                    echo '</tr>';
                                    echo '<tr><th class="l1" colspan="14"><center>' . $nom_clase . '</center></th></tr>';
                                    echo '<td style="display:none"><input name="valor" type="hidden" id="valor" value="';
                                    echo $cod_clasesq;
                                    echo '"/></td>';
                                    $sql_cargagrupos = "SELECT g.nombre_grupo AS grupo, g.cod_grupo AS cod FROM `vistaautomayorizacion` v JOIN t_grupo g JOIN t_clase c WHERE g.cod_grupo = v.`tipo` 
                                        AND c.cod_clase=g.t_clase_cod_clase AND `t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "' AND year = '" . $year . "' "
                                            . "AND c.cod_clase = '" . $cod_clasesq . "' GROUP BY cod_grupo";
                                    $resulgrupos = mysqli_query($conn, $sql_cargagrupos)or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
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
                                    </tr>';

                                        $sql_cargacuentas = "SELECT v.fecha AS f, v.cod_cuenta AS codcuenta, v.cuenta AS cuen, v.debe, v.haber,"
                                                . " v.`t_bl_inicial_idt_bl_inicial` AS balance, v.tipo AS grupo,v.sld_deudor AS slddeudor, v.sld_acreedor AS sldacreedor,"
                                                . " v.year, v.mes,g.nombre_grupo AS nomgrupo, g.cod_grupo AS codgrupo, g.`t_clase_cod_clase` AS codrelacionclase "
                                                . "FROM vistaautomayorizacion v JOIN t_grupo g "
                                                . "WHERE v.`tipo` = g.cod_grupo and year='" . $year . "' and t_bl_inicial_idt_bl_inicial='" . $parametro_contador . "'"
                                                . " and v.tipo='" . $row2['cod'] . "' and t_clase_cod_clase = '" . $cod_clasesq . "' order by tipo";

                                        $resultcargacuentas = mysqli_query($conn, $sql_cargacuentas) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                        while ($rwcuentas = mysqli_fetch_assoc($resultcargacuentas)) {
                                            echo '<tr>';
                                            echo '<td >' . $rwcuentas['f'] . '</td>';
                                            echo '<td>' . $rwcuentas['codcuenta'] . '</td>';
                                            echo '<td>' . $rwcuentas['cuen'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['debe'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['haber'] . '</td>';
                                            //echo '<td>' . $rwcuentas['balance'] . '</td>';
                                            //echo '<td>' . $rwcuentas['grupo'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['slddeudor'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $rwcuentas['sldacreedor'] . '</td>';
//                                            echo '<td>' . $rwcuentas['year'] . '</td>';
//                                            echo '<td>' . $rwcuentas['mes'] . '</td>';
//                                            echo '<td>' . $rwcuentas['nomgrupo'] . '</td>';
                                            // echo '<td>' . $rwcuentas['codgrupo'] . '</td>';
//                                            echo '<td>' . $rwcuentas['codrelacionclase'] . '</td>'; 
                                            $sql_cargaajustes = "SELECT v.fecha AS f, v.cod_cuenta AS codcuenta, v.cuenta AS cuen, v.debe, v.haber,
                                                v.`balance` AS balance, v.grupo AS grupo,v.sld_deudor AS sld_deudor, v.sld_acreedor AS sld_acreedor,v.year,
                                                v.mes,g.nombre_grupo AS nomgrupo,g.cod_grupo AS codgrupo,g.`t_clase_cod_clase` AS codrelacionclase FROM vautomayorizacionajustes v JOIN t_grupo g 
                                                WHERE v.`grupo` = g.cod_grupo and year='" . $year . "' and balance='" . $parametro_contador . "' "
                                                    . "and v.grupo='" . $row2['cod'] . "' and t_clase_cod_clase = '" . $cod_clasesq . "' and v.cod_cuenta='" . $rwcuentas['codcuenta'] . "'  order by grupo";
                                            $resultajustes = mysqli_query($conn, $sql_cargaajustes) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                            $row1 = mysqli_fetch_assoc($resultajustes);
//while ($row1 = mysqli_fetch_assoc($resultajustes)) {
                                            echo '<td style="background-color: window;color:black;">' . $row1['debe'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $row1['haber'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $row1['sld_deudor'] . '</td>';
                                            echo '<td style="background-color: window;color:black;">' . $row1['sld_acreedor'] . '</td>';
                                            //             }
                                            echo '</tr>';
                                        }


                                        $sql_sumasdegrupos = "SELECT sum( v.debe ) AS sumdebe, sum( v.haber ) AS sumhaber,
sum( v.sld_deudor ) AS sumslddeudor, sum( v.sld_acreedor ) AS sumsldacreedor
FROM vistaautomayorizacion v JOIN t_grupo g WHERE v.`tipo` = g.cod_grupo AND year = '" . $year . "' AND t_bl_inicial_idt_bl_inicial = '" . $parametro_contador . "'
AND t_clase_cod_clase = '" . $cod_clasesq . "' AND `tipo` = '" . $row2['cod'] . "'";


//                                        sumas de ajustes
                                        $sql_sumasajustes = " SELECT sum( v.debe ) AS sumdebe, sum( v.haber ) AS sumhaber,
sum( v.sld_deudor ) AS sumslddeudor, sum( v.sld_acreedor ) AS sumsldacreedor
FROM vautomayorizacionajustes v
JOIN t_grupo g
WHERE v.`grupo` = g.cod_grupo
AND v.year = '" . $year . "'
AND v.balance = '" . $parametro_contador . "'
AND g.t_clase_cod_clase = '" . $cod_clasesq . "'
AND v.`grupo` = '" . $row2['cod'] . "' ";
                                        $resultsumaajustes = mysqli_query($conn, $sql_sumasajustes);

                                        $resultsumasst = mysqli_query($conn, $sql_sumasdegrupos) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                        while ($resultsumas = mysqli_fetch_assoc($resultsumasst)) {
                                            $row3 = mysqli_fetch_assoc($resultsumaajustes);
                                            $sumdebe = $resultsumas['sumdebe'];
                                            $sumhaber = $resultsumas['sumhaber'];
                                            $sumdeudorsld = $resultsumas['sumslddeudor'];
                                            $sumhabersld = $resultsumas['sumsldacreedor'];
                                            echo '<tr>';
                                            echo '<th colspan="3" style="background-color: #E0ECFF;">SUMAS DE ' . $row2['grupo'] . "-" . $row2['cod'] . '</th>';
                                            echo '<td style="background-color: #FFFFFF;>1</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $sumdebe . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>3</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $sumhaber . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>5</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $sumdeudorsld . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>7</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $sumhabersld . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>8</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row3['sumdebe'] . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>10</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row3['sumhaber'] . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>12</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row3['sumslddeudor'] . '</td>';
                                            echo '<td style="background-color: #FFFFFF;>14</td>';
                                            echo '<td style="background-color: #FFFFFF;>' . $row3['sumsldacreedor'] . '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                    echo '</table>';
                                    //$n++;
                                }
                                ?>
                                <!--fin carga de el balance de resultados por grupos-->


                                <!--Inicia tabla de resultados en campos-->
                                <table>
                                    <!--Inicia funcion de botones-->
                                    <?Php
                                    
                                    ?>
                                    <!--termina funcion de botones-->
                                    <table>
                                        <tr>
                                            <?php
                                            $c = $dbi->conexion();
                                            $sqlsumastotal = "SELECT
sum( `debe_aj` ) AS s_deb_aj, sum( `haber_aj` ) AS sum_hab_aj, sum( `slddeudor_aj` ) AS sum_slddeu_aj, sum( `sldacreedor_aj` ) AS sum_slsacreed_aj,
sum( `debe` ) AS sumdebe, sum( `haber` ) AS sumhaber, sum( `sld_deudor` ) AS sumslddeud, sum( `sld_acreedor` ) AS sumsldacreed, 
sum( sum_deudor ) AS sumatotdeb, sum( sum_acreedor ) AS sumatothab
FROM `hoja_de_trabajo`
WHERE year = '" . $year . "'and t_bl_inicial_idt_bl_inicial = '" . $parametro_contador . "'
GROUP BY `t_bl_inicial_idt_bl_inicial` ";
                                            $resums = mysqli_query($c, $sqlsumastotal);
                                            while ($row = mysqli_fetch_assoc($resums)) {
                                                $Tdebe = $row['sumdebe'];
                                                $Thaber = $row['sumhaber'];
                                                $Sdeudor = $row['sumslddeud'];
                                                $Sacreedor = $row['sumsldacreed'];
                                                $Tdebeaj = $row['s_deb_aj'];
                                                $Thaberaj = $row['sum_hab_aj'];
                                                $Sslddeudoraj = $row['sum_slddeu_aj'];
                                                $Ssldacreedoraj = $row['sum_slsacreed_aj'];
                                            }
                                            mysqli_close($c);
                                            ?>

                                            <th colspan="6">Total :</th>
                                            <td></td>
                                            <td></td>
                                            <td>Debe <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="tdebe" id="tdebe" value="<?php echo $Tdebe ?>" placeholder="0.00" /></td>
                                            <td>Haber <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="thaber" id="thaber" value="<?php echo $Thaber ?>" placeholder="0.00" /></td>
                                            <td>Deudor <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="tdeudor" id="tdeudor" value="<?php echo $Sdeudor ?>" placeholder="0.00" /></td>
                                            <td>Acreedor <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="tacreedor" id="tacreedor" value="<?php echo $Sacreedor ?>" placeholder="0.00" />

                                            <td>Aj.Debe <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="tdebe" id="tdebe" value="<?php echo $Tdebeaj ?>" placeholder="0.00" /></td>
                                            <td>Aj.Haber <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="thaber" id="thaber" value="<?php echo $Thaberaj ?>" placeholder="0.00" /></td>
                                            <td>Aj.Deudor <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="tdeudor" id="tdeudor" value="<?php echo $Sslddeudoraj ?>" placeholder="0.00" /></td>
                                            <td>Aj.Acreedor <input type="text" style="width: 70px;" class="compa2" readonly="readonly" required="required" name="tacreedor" id="tacreedor" value="<?php echo $Ssldacreedoraj ?>" placeholder="0.00" />

                                                <input type="hidden" value="<?php echo $resultdato ?>" name="bl" id="bl"/>
                                            </td>
                                        </tr>
                                    </table>


                                    <!--Termina tabla de resultados en campos-->

                            </center>

                        </form>
                    </center>
                </div>
            </div>
        </div>

    </div>
    <?Php
    mysqli_close($conex);
    mysqli_close($conn);
    mysqli_close($c);
    ?>
</body>
</html>

