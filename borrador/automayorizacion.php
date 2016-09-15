<!DOCTYPE html>
<!--Christian Tigre-->
<?php
//require('../../../Clases/cliente.class.php');
require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
$totdebe = 0.00;
$tothaber = 0.00;
$year = date("Y");
$mes = date('F');
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../login.php"
</script>';
}
$date = date("Y-m-j");
$consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
$query_bl = mysqli_query($c, $consul_bal_inicial);
$row = mysqli_fetch_array($query_bl);
$idcod = $row['contador'];
$idcod_sig = $row['Siguiente'];

$incr = "select count(*)+1 as inc from libro";
$query_inc = mysqli_query($c, $incr);
$r_inc = mysqli_fetch_array($query_inc);
$idinc = $r_inc['inc'];

$contador_de_asientosSQL = "SELECT COUNT( * ) +1 AS CON
FROM libro b
WHERE b.fecha = '" . $date . "'";
$query_contador = mysqli_query($c, $contador_de_asientosSQL);
$row_cont = mysqli_fetch_array($query_contador);
$contador_ass = $row_cont['CON'];

$id_usuario = $_SESSION['username'];
$user = $_SESSION['username'];
$idlogeobl = $_SESSION['id_user'];

include '../../Clases/guardahistorial.php';
$accion = "Ingreso a mayorizacion";
generaLogs($user, $accion);

$sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
$resul_param = mysqli_query($c, $sqlparametro);
$dataparametro = mysqli_fetch_array($resul_param);
$parametro_contador = $dataparametro['cont'];
if ($parametro_contador == "") {
    echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
}

$sql_bactual_libro = "SELECT MIN(fecha) as Min_p, MAX(fecha) as Max_p FROM `v_mayorizacionaux` where t_bl_inicial_idt_bl_inicial = '" . $parametro_contador . "' ";
$result_bl_lib = mysqli_query($c, $sql_bactual_libro);
$clase_bl_lib = mysqli_fetch_array($result_bl_lib);
$Min_p = $clase_bl_lib['Min_p'];
$Max_p = $clase_bl_lib['Max_p'];


$valores = "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, "
        . "sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,"
        . "sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sld_deudor,"
        . "sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as sld_acreedor FROM vistabalanceresultadosajustados WHERE "
        . "`t_bl_inicial_idt_bl_inicial`='" . $parametro_contador . "' and year='" . $year . "'";
$res_valores = mysqli_query($c, $valores);
while ($resultb = mysqli_fetch_assoc($res_valores)) {
    $Tdebe = $resultb['debe'];
    $Thaber = $resultb['haber'];
    $Sdeudor = $resultb['sld_deudor'];
    $Sacreedor = $resultb['sld_acreedor'];
}
//mysqli_close($c);
?>
<html>
    <head>
        <title>Mayorizacion</title>
        <link href="../../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <script src="../../../../js/jquery.min.js"></script>
        <script src="../../../../js/jquery-1.3.1.min.js"></script>
        <link href="../../../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <script src="../../../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../../../js/jquery.functions.js" type="text/javascript"></script>
        <script src="../../../../js/script.js" type="text/javascript"></script>
        <script>
            function validar(campo) {
                var elcampo = document.getElementById(campo);
                if ((!validarNumero(elcampo.value)) || (elcampo.value == "")) {
                    elcampo.value = "";
                    elcampo.focus();
                    document.getElementById('mensaje').innerHTML = 'Debe ingresar un número';
                } else {
                    document.getElementById('mensaje').innerHTML = '';
                }
            }
            function validarNumero(input) {
                return (!isNaN(input) && parseInt(input) == input) || (!isNaN(input) && parseFloat(input) == input);
            }

            $('.clsGuardar22').live('click', function () {
                var inputs = $('#form_ejercicio').serialize();
                //alert(inputs.trim());
                $.ajax({
                    url: 'almacenartablamayorizada.php',
                    type: "POST",
                    data: inputs,
                    success: function (inputs) {
                        alert(inputs)
                    }
                });
                return false;
            });

            $('.clsGuardar2').live('click', function () {
                $('#form_ejercicio').submit(function (msg) {
                    //alert($(this).serialize()); // check to show that all form data is being submitted
                    //$.post("ggrillamayor.php", $(this).serialize(), function (data) {
                    $.post("almacenartablamayorizada.php", $(this).serialize(), function (data) {
                        alert(data);
                    });
                    return false;
                });
                $('#submitsave').css('display', 'none');
            });
        </script>
        <style>
            .contenedoresm{margin:60px auto;width:960px;font-family:sans-serif;font-size:15px}
            table {width:100%;box-shadow:0 0 10px #ddd;text-align:left}
            th {padding:5px;background:#555;color:#fff}
            td {padding:5px;border:solid #ddd;border-width:0 0 1px;}
            .editable span{display:block;}
            .editable span:hover {background:url(images/edit.png) 90% 50% no-repeat;cursor:pointer}

            td input {height:24px;width:155px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
            .compa2{width: 85px}
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
                width : 150px;
            }
            select:focus {
                outline : none;
            } 

            #table1
            {
                width:700px; height:auto;
            }
            .table1
            {
                width:700px; height:auto;
            }
        </style>
    </head>
    <body onBeforeUnload="return antesdecerrar()">
        <div id="contenedor_bl">
            <center>
                <div id="menus">
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
                    <div id="menu_general">
                        <div id="caja_us">
                            <center>
                                <div>
                                    <table width="718" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>&nbsp;</tr>
                                        <tr>
                                            <td colspan="2"><div align="right">Usuario: <span class="Estilo6">
                                                        <strong><?php echo $_SESSION['username']; ?> </strong>
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
                                <li  class="current"><a href="automayorizacion.php">Mayorizacion</a></li>
                                <li><a href="index_modulo_contable.php">Diario</a></li>
                                <li><a href="balancederesultados.php">B. Resultados</a></li>								
                                <li><a href="situacionfinal.php">Perdidas y Ganancias</a></li>								
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                    </div>
                </div>
            </center>
            <div id="cuerpo">
                <div id="banner_left"></div>
                <!--formulario 1-->
                <div id="form1">
                    <form id="frm_bl" name="frm_bl" method="post" action="Bl_inicial.php" > 
                        <fieldset>
                            <legend>Balance</legend>
                            <p>
                                <?Php
                                $SQL_vercontt = "SELECT * FROM `t_bl_inicial` WHERE `idt_bl_inicial`='" . $idcod . "'";
                                $res_data = mysqli_query($c, $SQL_vercontt);
                                $rw = mysqli_fetch_array($res_data);
                                $dtinicial = $rw['idt_bl_inicial'];
                                $fbl = $rw['fecha_balance'];
                                $std = $rw['estado'];
                                $yearbl = $rw['year'];
                                echo '<lablel>Periodo : ' . $yearbl . ' </lablel></br>';
                                echo '<lablel>Estado : </lablel>';
                                if ($std == '') {
                                    echo '<input type = "checkbox" id = "0" name = "0" value = "0" />';
                                } else {
                                    echo '<input type = "checkbox" id = "1" name = "1" value = "1" checked/>';
                                }
                                ?>                        
                                <input type="hidden" class="texto" name="balances_realizados" id="balances_realizados" value="<?Php echo $idcod; ?>">
                                </br>                            
                                <input class="hidden" name="contador_balances" id="contador_balances" value="<?php echo $idcod_sig; ?>">
                            </p> 
                        </fieldset>                                                                    
                        </br>                        </br>
                    </form>
                </div>    
                <!--formulario 2  -->
                <div id="form2"> 
                    <div id="new_ejercicio">
                        <form id="formulariodetalles" name="formulariodetalles" method="post" action="automayorizacion.php">
                            <table>
                                <tr>                  
                                    <td>
                                        <label>Cuentas Utilizadas</label>
                                    </td>
                                    <td>
                                        <?php
                                        $SQLtipobaldh = "SELECT DISTINCT (cuenta) AS dif_cuentas, cod_cuenta as cod FROM vistabalanceresultadosajustados WHERE `t_bl_inicial_idt_bl_inicial` ='" . $parametro_contador . "'";
                                        $query_tipo_bldh = mysqli_query($c, $SQLtipobaldh);
                                        ?>
                                        <select name="tip_cuentadh" id="tip_cuentadh" size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo()
                                                        ;"><!--generar_codigo_grupo()-->
                                                    <?php
                                                    while ($arreglot_cuendh = mysqli_fetch_array($query_tipo_bldh)) {
                                                        if ($_POST['tip_cuentadh'] == $arreglot_cuendh['cod']) {
                                                            echo "<option value='" . $arreglot_cuendh['cod'] . "' selected>&nbsp;&nbsp;" . $arreglot_cuendh['dif_cuentas'] . "</option>";
                                                        } else {
                                                            ?>
                                                    <option class="text" value="<?php echo $arreglot_cuendh['cod'] ?>">
                                                        <?php echo $arreglot_cuendh['dif_cuentas'] ?></option>     
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td> <input id="submit" name="submit" type="submit" value="Detalle por cuenta"/><input id="submit" name="submit" type="submit" value="-"/> </td>
                                    <?php
                                    if (isset($_POST["submit"])) {
                                        $btntu = $_POST["submit"];
                                        if ($btntu == "Detalle por cuenta") {
                                            $tip_cuentadh = htmlspecialchars(trim($_POST['tip_cuentadh']));
                                            $result = mysqli_query($c, "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`valor` , v.`valorp` , v.`t_bl_inicial_idt_bl_inicial` , v.ejercicio AS j, n.concepto FROM `v_mayorizacionaux` v JOIN num_asientos n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`t_bl_inicial_idt_bl_inicial` = n.t_bl_inicial_idt_bl_inicial and v.t_bl_inicial_idt_bl_inicial='" . $parametro_contador . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "'");
                                            $sqlaj = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`debe` , v.`haber` , v.`balance` , v.ejercicio AS j, n.concepto FROM `vmayorizacionajustes` v JOIN num_asientos_ajustes n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`balance` = n.t_bl_inicial_idt_bl_inicial and v.balance='" . $parametro_contador . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "'";
                                            $resulaj = mysqli_query($c, $sqlaj);
                                            $result_d_m_mayor = mysqli_query($c, "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, 
        sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,
        sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sldeu,
        sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as slacr FROM vistabalanceresultadosajustados WHERE 
        `t_bl_inicial_idt_bl_inicial`='" . $parametro_contador . "' and year='" . $year . "' and cod_cuenta='" . $tip_cuentadh . "'");
                                            $dato_fila = mysqli_fetch_array($result_d_m_mayor);
                                            $mayor_debe = $dato_fila['debe'];
                                            $mayor_haber = $dato_fila['haber'];
                                            $mayor_sldue = $dato_fila['sldeu'];
                                            $mayor_sldacr = $dato_fila['slacr'];
                                            echo "<table>";
                                            echo '<center><h5>T</h5></center>';
                                            echo "<tr>";
                                            echo "<td style='display:none'>Ejercicio</td>";
                                            echo "<td style='display:none'>balance</td>";
                                            echo "<td>Fecha</td>";
                                            echo "<td>Cod.</td>";
                                            echo "<td>Cuenta</td>";
                                            echo "<td>Debe</td>";
                                            echo "<td>Haber</td>";
                                            echo "<td>Concepto</td>";
                                            echo "</tr>";
                                            while ($row = mysqli_fetch_row($result)) {
                                                echo "<tr>";
                                                echo "<td style='display:none'>$row[6]</td>";
                                                echo "<td style='display:none'>$row[5]</td>";
                                                echo "<td>$row[0]</td>";
                                                echo "<td>$row[1]</td>";
                                                echo "<td>$row[2]</td>";
                                                echo "<td>$row[3]</td>";
                                                echo "<td>$row[4]</td>";
                                                echo "<td>$row[7]</td>";
                                                echo "</tr>";
                                            }
                                            echo "</table>";
                                            echo '<center><h5>AJUSTES</h5></center>';
                                            echo "<table>";
                                            echo "<tr>";
                                            echo "<td style='display:none'>Ejercicio</td>";
                                            echo "<td style='display:none'>balance</td>";
                                            echo "<td>Fecha</td>";
                                            echo "<td>Cod.</td>";
                                            echo "<td>Cuenta</td>";
                                            echo "<td>Debe</td>";
                                            echo "<td>Haber</td>";
                                            echo "<td>Concepto</td>";
                                            echo "</tr>";
                                            while ($rowaj = mysqli_fetch_row($resulaj)) {
                                                echo "<tr>";
                                                echo "<td style='display:none'>$rowaj[6]</td>";
                                                echo "<td style='display:none'>$rowaj[5]</td>";
                                                echo "<td>$rowaj[0]</td>";
                                                echo "<td>$rowaj[1]</td>";
                                                echo "<td>$rowaj[2]</td>";
                                                echo "<td>$rowaj[3]</td>";
                                                echo "<td>$rowaj[4]</td>";
                                                echo "<td>$rowaj[7]</td>";
                                                echo "</tr>";
                                            }
                                            echo "</table>";
                                            ?>
                                        <table>
                                            <tr>
                                                <td>
                                                    <label>Total debe :</label>
                                                    <input type="text" readonly="readonly" id="campomayor_debe" name="campomayor_debe" class="compa2" value="<?php echo $mayor_debe ?>"/>
                                                    <label>Total haber :</label>
                                                    <input type="text" readonly=readonly id="campomayor_haber" name="campomayor_haber" class=compa2 value="<?php echo $mayor_haber ?>"/>
                                                </td>
                                            </tr>
                                        </table>
                                        <?php
                                        $accion = " / MAYORIZACION / Dtll. mayorizacion cta:" . $tip_cuentadh;
                                        generaLogs($user, $accion);
                                    }  else {
                                        
                                    }
                                }
                                ?>

                                </tr>
                            </table>
                        </form>


                        <form name="form_ejercicio" id="form_ejercicio" method="post" action="ggrillamayor.php">
                            <fieldset>
                                <br/>
                                <strong><label>Contbl :</label><?php echo $parametro_contador; ?> 
                                    <label> Desde :</label><?php echo $Min_p; ?> 
                                    <label>  - Hasta :</label><?php echo $Max_p; ?></strong>
                                <br/>
                                <div class="contenedoresm">

                                    <center>
                                        <table id="table1" name="table1" > 

                                            <thead>
                                                <tr>
                                                    <td style='display:none'>balance</td>
                                                    <td style='display:none'>Fecha</td>
                                                    <td>Cod.</td>
                                                    <td>Cuenta</td>
                                                    <td>Debe</td>
                                                    <td>Haber</td>
                                                    <td>Deudor</td>
                                                    <td>Acreedor</td>
                                                </tr>
                                            </thead>
                                            <!--Zona Upload de cuentas para mayor-->
                                            <?Php
                                            $cargamayor = "SELECT `t_bl_inicial_idt_bl_inicial`,`tipo`,`cod_cuenta`, `cuenta`, 
    sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0)) as sdeb, 
    sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0)) as shab, 
    sum(COALESCE(debe_aj, 0)+COALESCE(debe,0)) - sum(COALESCE(haber_aj, 0) + COALESCE(haber, 0)) as sldeu, 
    CONCAT('0.00') as slacr FROM vistabalanceresultadosajustados WHERE `t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "' and year='" . $year . "'
    group BY cod_cuenta, cod_cuenta_aj HAVING sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0))>sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0))
UNION
SELECT `t_bl_inicial_idt_bl_inicial`,`tipo`,`cod_cuenta`, `cuenta`, sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0)) as sdeb, sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0)) as shab,
CONCAT('0.00') as slacr, sum(COALESCE(haber_aj, 0) + COALESCE(haber, 0))-sum(COALESCE(debe_aj, 0)+COALESCE(debe,0)) as sldeu  FROM vistabalanceresultadosajustados WHERE 
`t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "' and year='" . $year . "' group BY cod_cuenta, cod_cuenta_aj HAVING sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0))<sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0))
order by cod_cuenta";
                                            $result = mysqli_query($c, $cargamayor);
                                            while ($row = mysqli_fetch_row($result)) {
                                                echo "<tbody>";
                                                echo "<tr>";
                                                //echo "<td style='display:none'>$row[5]</td>";
                                                echo "<td style='display:none;'><input type='text' readonly='readonly' id='tipo' name='campo9[]' class='compa2' value='$row[1]'/></td>";
                                                echo "<td style='display:none'><input type='text' readonly='readonly' id='t_bl_inicial_idt_bl_inicial' name='campo1[]' class='compa2' value='$row[0]'/></td>";
                                                echo "<td style='display:none'><input type='text' readonly='readonly' id='fecha' name='campo2[]' class='compa2' value='$row[0]'/></td>";
                                                echo "<td style='width:5px;'><input type='text' readonly='readonly' id='cod_cuenta' name='campo3[]' class='compa2' value='$row[2]'/></td>";
                                                echo "<td style='width:150px;'><input type='text' readonly='readonly' id='cuenta' name='campo4[]' class='compa' value='$row[3]'/></td>";
                                                echo "<td style='width:20px;'><input type='text' readonly='readonly' id='deb' name='campo5[]' class='compa2' value='$row[4]'/></td>";
                                                echo "<td style='width:20px;'><input type='text' readonly='readonly' id='hab' name='campo6[]' class='compa2' value='$row[5]'/></td>";

                                                echo "<td style='width:20px;'><input type='text' readonly='readonly' id='saldodeudor' name='campo7[]' onkeyup='validar(this.id);' class='compa2' value='";
                                                echo $row[6];
                                                echo "'/></td>";
                                                echo "<td><input type='text' readonly='readonly' id='saldoacreedor' name='campo8[]' onkeyup='validar(this.id);' class='compa2' value='";
                                                echo $row[7];
                                                echo"'/></td>";
                                                echo "</tr>";
                                                echo "</tbody>";
                                            }
                                            ?>

                                        </table>  
                                    </center>

                                    <table class="table1">
                                        <tr>
                                            <td style='width:15px;'>Sumas :</td>
                                            <td style='width:0px;'></td>
                                            <td style='width:0px;'></td>
                                            <td style='width:0px;'></td>
                                            <td style='width:10px;'>Debe <input type="text" class="compa2" readonly="readonly" required="required" name="tdebe" id="tdebe" value="<?php echo $Tdebe ?>" placeholder="0.00" /></td>
                                            <td style='width:10px;'>Haber <input type="text" class="compa2" readonly="readonly" required="required" name="thaber" id="thaber" value="<?php echo $Thaber ?>" placeholder="0.00" /></td>
                                            <td style='width:10px;'>Deudor <input type="text" class="compa2" readonly="readonly" required="required" name="tdeudor" id="tdeudor" value="<?php echo $Sdeudor ?>" placeholder="0.00" /></td>
                                            <td style='width:10px;'>Acreedor <input type="text" class="compa2" readonly="readonly" required="required" name="tacreedor" id="tacreedor" value="<?php echo $Sacreedor ?>" placeholder="0.00" />
                                                <input type="hidden" value="<?php echo $resultdato ?>" name="bl" id="bl"/>
                                            </td>
                                        </tr>
                                    </table>


                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            mysqli_close($c);
            ?>
        </div>
    </body>
</html>	

