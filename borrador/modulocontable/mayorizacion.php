<!DOCTYPE html>
<!--Christian Tigre-->
<?php
require('../../../Clases/cliente.class.php');
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
$totdebe = 0.00;
$tothaber = 0.00;
$year = date("Y");
$mes = date('F');
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
$consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
$query_bl = mysql_query($consul_bal_inicial);
$row = mysql_fetch_array($query_bl);
$idcod = $row['contador'];
$idcod_sig = $row['Siguiente'];

$incr = "select count(*)+1 as inc from libro";
$query_inc = mysql_query($incr);
$r_inc = mysql_fetch_array($query_inc);
$idinc = $r_inc['inc'];

$contador_de_asientosSQL = "SELECT COUNT( * ) +1 AS CON
FROM libro b
WHERE b.fecha = '" . $date . "'";
$query_contador = mysql_query($contador_de_asientosSQL);
$row_cont = mysql_fetch_array($query_contador);
$contador_ass = $row_cont['CON'];
//include '../../../../templates/PanelAdminLimitado/Clases/conexion_mysqli.php';
$que_t_cuent_diario = "Select * from t_cuentadediario";
//$r_cuendiario = $conexion->query($que_t_cuent_diario);
$r_cuendiario = mysql_query($que_t_cuent_diario);

$id_usuario = $_SESSION['username'];
$consulta = "SELECT l.username, u.tipo_user,l.idlogeo
FROM logeo l
JOIN user_tipo u
WHERE l.username = '" . $id_usuario . "'";
$resultado = mysql_query($consulta, $conex) or die(mysql_error());
$fila = mysql_fetch_array($resultado);
$user = $fila['username'];
$type_user = $fila['tipo_user'];
$idlogeobl = $fila['idlogeo'];
mysql_close($conex);

$conn = new mysqli("localhost", "root", "alberto2791", "condata");

$sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
$resul_param = $conn->query($sqlparametro);
if ($resul_param->num_rows > 0) {
    while ($clase_param = $resul_param->fetch_assoc()) {
        $parametro_contador = $clase_param['cont'];
    }
} else {
    echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
}


$sql_bactual_libro = "SELECT MIN(fecha) as Min_p, MAX(fecha) as Max_p
FROM `v_mayorizacionaux` where t_bl_inicial_idt_bl_inicial = '" . $parametro_contador . "' ";
$result_bl_lib = $conn->query($sql_bactual_libro);
if ($result_bl_lib->num_rows > 0) {
    while ($clase_bl_lib = $result_bl_lib->fetch_assoc()) {
        $Min_p = $clase_bl_lib['Min_p'];
        $Max_p = $clase_bl_lib['Max_p'];
    }
} else {
    echo "<script>alert('No se puede cargar los parametros')</script>";
}

$valores = "SELECT sum(deb) as Tdebe, sum(hab) as Thaber, sum(saldodeudor) as Sdeudor,sum(saldoacreedor)"
        . "as Sacreedor FROM `t_mayor` WHERE `t_bl_inicial_idt_bl_inicial`='" . $parametro_contador . "' and year='" . $year . "' and mes='" . $mes . "' ";
$res_valores = mysqli_query($conn, $valores);
while ($resultb = mysqli_fetch_assoc($res_valores)) {
    $Tdebe = $resultb['Tdebe'];
    $Thaber = $resultb['Thaber'];
    $Sdeudor = $resultb['Sdeudor'];
    $Sacreedor = $resultb['Sacreedor'];
}
mysqli_close($conn);
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
                        alert(data); //post check to show that the mysql string is the same as submit                        
                    });
                    return false; // return false to stop the page submitting. You could have the form action set to the same PHP page so if people dont have JS on they can still use the form
                });
                $('#submitsave').css('display', 'none');
            });

            var salir = true;
            function cambiarvalor()
            {
                salir = false;
            }
            function antesdecerrar()
            {
                if (salir == true)
                {
                    return 'Esta accion perdera los cambios hechos a la pagina si no guardas!!!!!';
                }
            }

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
                                <li><a href="">Usuarios</a></li>
                                <li class="current"><a href="">Documentos</a></li>								
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
                                <li  class="current"><a href="mayorizacion.php">Mayorizacion</a></li>
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
                            <lablel>Balance Numero 
                                <input type="hidden" class="texto" name="balances_realizados" id="balances_realizados" value="<?Php echo $idcod; ?>">
                                <label><?php echo $idcod; ?></label>
                            </lablel></br>
                        </p>                                <p>
                        <!--<lablel>Balance Actual</lablel></br>-->
                        <input class="hidden" name="contador_balances" id="contador_balances" value="<?php echo $idcod_sig; ?>">
                    </p>                              <p>
                        <label>Balance cortado a: <?php echo $date; ?>
                            <input class="text" type="hidden" readonly="readonly" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo date("Y-m-j"); ?>" />
                        </label>
                    </p>
                </fieldset>                                                                    
                </br>                        </br>
            </form>
        </div>    
        <!--formulario 2    javascript: fn_agregar();-->
        <div id="form2"> 
            <div id="new_ejercicio">



                <form id="formulariodetalles" name="formulariodetalles" method="post" action="mayorizacion.php">
                    <table>
                        <tr>                  
                            <td>
                                <label>Cuentas Utilizadas</label>
                            </td>
                            <td>
                                <?php
                                //carga las diferentes de cuentas del balance actual
                                $cone_tpdh = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
                                mysql_select_db("condata", $cone_tpdh) or die("ERROR con la base de datos");
                                $SQLtipobaldh = "SELECT DISTINCT (cuenta) AS dif_cuentas, cod_cuenta as cod FROM `v_mayorizacionaux` WHERE `t_bl_inicial_idt_bl_inicial` ='" . $parametro_contador . "'";
                                $query_tipo_bldh = mysql_query($SQLtipobaldh);
                                ?>
                                <select name="tip_cuentadh" id="tip_cuentadh" size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo()
                                                ;"><!--generar_codigo_grupo()-->
                                            <?php while ($arreglot_cuendh = mysql_fetch_array($query_tipo_bldh)) { ?>
                                        <option class="text" value="<?php echo $arreglot_cuendh['cod'] ?>">
                                            <?php echo $arreglot_cuendh['dif_cuentas'] ?></option>     
                                    <?php }mysql_close($cone_tpdh); ?>
                                </select>
                            </td>
                            <td> <input id="submit" name="submit" type="submit" value="Detalle por cuenta" </td>
                            <?php
                            if (isset($_POST["submit"])) {
                                $btntu = $_POST["submit"];
                                if ($btntu == "Detalle por cuenta") {
                                    $tip_cuentadh = htmlspecialchars(trim($_POST['tip_cuentadh']));
                                    $cone_tpdh = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
                                    mysql_select_db("condata", $cone_tpdh) or die("ERROR con la base de datos");
                                    $result = mysql_query("SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`valor` , v.`valorp` , v.`t_bl_inicial_idt_bl_inicial`,v.ejercicio as j,n.concepto
                   FROM `v_mayorizacionaux` v  JOIN num_asientos n WHERE
v.ejercicio=n.t_ejercicio_idt_corrientes and
 v.`t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "'
                                             AND v.cod_cuenta = '" . $tip_cuentadh . "' and v.year='" . $year . "'", $cone_tpdh);
                                    $result_d_m_mayor = mysql_query("SELECT sum(`valor`) as debe , sum(`valorp`) as haber FROM `v_mayorizacionaux` "
                                            . "WHERE `t_bl_inicial_idt_bl_inicial` = '" . $parametro_contador . "'and year='" . $year . "' AND cod_cuenta = '" . $tip_cuentadh . "'", $cone_tpdh);
                                    $dato_fila = mysql_fetch_array($result_d_m_mayor);
                                    $mayor_debe = $dato_fila['debe'];
                                    $mayor_haber = $dato_fila['haber'];
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
                                    while ($row = mysql_fetch_row($result)) {
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
                                    echo "<label>Total debe :</label>";
                                    echo "<input type='text' readonly='readonly' id='campomayor_debe' name='campomayor_debe' class='compa2' value='$mayor_debe'/>";
                                    echo "<label>Total haber :</label>";
                                    echo "<input type='text' readonly='readonly' id='campomayor_haber' name='campomayor_haber' class='compa2' value='$mayor_haber'/>";
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
                            <label>Periodo desde :</label><?php echo $Min_p; ?> 
                            <label>Periodo hasta :</label><?php echo $Max_p; ?></strong>
                        <br/>
                        <div class="contenedoresm">
                            <table>
                                <tr>
                                    <td> <input id="submitsave" name="submit" type="submit" class="clsGuardar2" value="Guardar Mayorizacion" </td>
                                </tr>
                            </table>
                            <table id="table1" name="table1"> 

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
//"SELECT `fecha`,`cod_cuenta`, `cuenta`, `valor`, `valorp` FROM `v_mayorizacionaux` WHERE`t_bl_inicial_idt_bl_inicial` = 3 order by cuenta";
                                $cone_tpdh = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
                                mysql_select_db("condata", $cone_tpdh) or die("ERROR con la base de datos");
//$result = mysql_query("SELECT `fecha`,`cod_cuenta`, `cuenta`, `valor`, `valorp`,`t_bl_inicial_idt_bl_inicial` FROM `v_mayorizacionaux` WHERE `t_bl_inicial_idt_bl_inicial` = '".$parametro_contador."' order by cuenta", $cone_tpdh);
                                $result = mysql_query("SELECT `fecha` , `cod_cuenta` , `cuenta` ,sum( `valor`) as debe , sum(`valorp`) as haber ,"
                                        . " `t_bl_inicial_idt_bl_inicial`,tipo FROM `v_mayorizacionaux` WHERE `t_bl_inicial_idt_bl_inicial` = "
                                        . "'" . $parametro_contador . "' AND year = '" . $year . "' GROUP BY cuenta ORDER BY cuenta", $cone_tpdh);
                                while ($row = mysql_fetch_row($result)) {
                                    echo "<tbody>";
                                    echo "<tr>";
                                    //echo "<td style='display:none'>$row[5]</td>";
                                    echo "<td style='display:none'><input type='text' readonly='readonly' id='tipo' "
                                    . "name='campo9[]' class='compa2' value='$row[6]'/></td>";
                                    echo "<td style='display:none'><input type='text' readonly='readonly' id='t_bl_inicial_idt_bl_inicial' "
                                    . "name='campo1[]' class='compa2' value='$row[5]'/></td>";
                                    echo "<td style='display:none'><input type='text' readonly='readonly' id='fecha' name='campo2[]' class='compa2' value='$row[0]'/></td>";
                                    echo "<td><input type='text' readonly='readonly' id='cod_cuenta' name='campo3[]' class='compa2' value='$row[1]'/></td>";
                                    echo "<td><input type='text' readonly='readonly' id='cuenta' name='campo4[]' class='compa' value='$row[2]'/></td>";
                                    echo "<td><input type='text' readonly='readonly' id='deb' name='campo5[]' class='compa2' value='$row[3]'/></td>";
                                    echo "<td><input type='text' readonly='readonly' id='hab' name='campo6[]' class='compa2' value='$row[4]'/></td>";
                                    $debe = $row[3];
                                    $debe = str_replace(",", ".", $debe);
                                    $haber = $row[4];
                                    $haber = str_replace(",", ".", $haber);
                                    if ($debe > $haber) {
                                        $res_saldod = 0.00;
                                        $res_saldod = $debe - $haber;
                                        $res_saldod = str_replace(",", ".", $res_saldod);
                                        $res_saldoa = '0.00';
                                    } elseif ($haber > $debe) {
                                        $res_saldoa = 0.00;
                                        $res_saldoa = $haber - $debe;
                                        $res_saldoa = str_replace(",", ".", $res_saldoa);
                                        $res_saldod = '0.00';
                                    } elseif ($debe == $haber) {
                                        $res_saldoa = '0.00';
                                        $res_saldod = '0.00';
                                    }
                                    echo "<td><input type='text' readonly='readonly' id='saldodeudor' name='campo7[]'"
                                    . " onkeyup='validar(this.id);' class='compa2' value='";
                                    echo $res_saldod;
                                    echo "'/></td>";
                                    echo "<td><input type='text' readonly='readonly' id='saldoacreedor' name='campo8[]' onkeyup='validar(this.id);'"
                                    . " class='compa2' value='";
                                    echo $res_saldoa;
                                    echo"'/></td>";
                                    echo "</tr>";
                                    echo "</tbody>";
                                }
                                ?>

                            </table>  

                            <table>
                                <tr>
                                    <td>Total :</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Debe <input type="text" class="compa2" readonly="readonly" required="required" name="tdebe" id="tdebe" value="<?php echo $Tdebe ?>" placeholder="0.00" /></td>
                                    <td>Haber <input type="text" class="compa2" readonly="readonly" required="required" name="thaber" id="thaber" value="<?php echo $Thaber ?>" placeholder="0.00" /></td>
                                    <td>Deudor <input type="text" class="compa2" readonly="readonly" required="required" name="tdeudor" id="tdeudor" value="<?php echo $Sdeudor ?>" placeholder="0.00" /></td>
                                    <td>Acreedor <input type="text" class="compa2" readonly="readonly" required="required" name="tacreedor" id="tacreedor" value="<?php echo $Sacreedor ?>" placeholder="0.00" />
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

</div>
</body>
<!--
                  
                        $debe=$row[3];
                        $haber=$row[4];
                        if ($debe>$haber)
                            {   $res_saldo=0;
                                     if ($debe=='0.00')
                                        {
                                            $res_saldo=$res_saldo-$haber;
                                        }elseif ($haber=='0.00') {
                                            $res_saldo=$res_saldo+$debe;
                                        }
                            }else{
                                $res_saldo=0;
                                    if ($debe=='0.00')
                                        {
                                            $res_saldo=$res_saldo-$haber;
                                        }elseif ($haber=='0.00') {
                                            $res_saldo=$res_saldo+$debe;
                                        }
                            }
-->
</html>	

