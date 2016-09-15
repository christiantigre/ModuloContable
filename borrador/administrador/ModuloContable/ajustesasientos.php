<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require('../../../Clases/cliente.class.php');
include '../../Clases/guardahistorial.php';
require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$conex = $dbi->conexion();
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
//$conex = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
//mysql_select_db("condata", $conex) or die("ERROR con la base de datos");
session_start();

//Validar si se est� ingresando con sesi�n correctamente
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../login.php"
</script>';
}
$date = date("Y-m-j");
$mes = date('F');
$year = date("Y");
//$id_asientourl = $_GET['id_asientourl'];
//echo "<script>alert('.$year.')</script>";
// ejecuta un contador de balances
$sqlcontasiaj = "SELECT count(`t_ejercicio_idt_corrientes`)+1 as cont FROM `num_asientos_ajustes`";
$queryajustecont = mysqli_query($conex, $sqlcontasiaj);
$rcontajustes = mysqli_fetch_array($queryajustecont);
$conajustes = $rcontajustes['cont'];


$consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
$query_bl = mysqli_query($conex, $consul_bal_inicial);
$row = mysqli_fetch_array($query_bl);
$idcod = $row['contador'];
$idcod_sig = $row['Siguiente'];
// ejecuta contador de balances
$contador_de_asientosSQL = "select count(year)+1 as CON from num_asientos"
        . " where `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "'";
$query_contador = mysqli_query($conex, $contador_de_asientosSQL);
$row_cont = mysqli_fetch_array($query_contador);
$contador_ass = $row_cont['CON'];

$id_usuario = $_SESSION['username'];
$consulta = "SELECT l.username, u.tipo_user, l.idlogeo
FROM logeo l
JOIN user_tipo u
WHERE l.user_tipo_iduser_tipo = u.iduser_tipo
AND l.username = '" . $id_usuario . "'";
//$id_usuario . "'";
$resultado = mysqli_query($conex,$consulta) or die(mysqli_errno($conex));
$fila = mysqli_fetch_array($resultado);
$user = $fila['username'];
$type_user = $fila['tipo_user'];
$idlogeobl = $fila['idlogeo'];


$accion = "Ingreso a asientos de ajustes";
generaLogs($user, $accion);


//mysqli_close($conex);

//$idlogeobl = $_GET['idlogeo'];
//$fech_url = $_GET['fech_url'];
?>
<html>
    <head>
        <title>Ajustes de Asientos</title>
        <link href="../../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <script src="../../../../js/jquery.min.js"></script>
        <script src="../../../../js/jquery-1.3.1.min.js"></script>
        <link href="../../../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <script src="../../../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../../../js/jquery.functions.js" type="text/javascript"></script>
        <script src="../../../../js/script.js" type="text/javascript"></script>
        <script>
            //Christian



            function desactivabtn() {
                $('#guardaras').attr("disabled", true);
            }
            function activarbtn() {
                $('#guardaras').attr("disabled", false);
            }
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

            function guardaas()
            {
                var camposumadebe = $("#camposumadebe").val();
                var camposumahaber = $("#camposumahaber").val();
                if (camposumadebe != camposumahaber)
                {
                    var answer = confirm("Error!!!...El Ajuste no esta cuadrado correctamente desea guardarlo!!!")
                    if (answer)
                    {
                        aux_save();//carga_idasiento();
                    } else {

                    }
                } else
                {
                    aux_save();
                }

            }

            function aux_save()
            {
                $('#form_ejercicio').submit(function (msg) {
                    $.post("guardaajustesasientos.php", $(this).serialize(), function (data) {
                        alert(data);//carga_idasiento();//imprimir_balance();
                        //vaciar_tab();
                        $("#textarea_asaj").attr("value", "");
                        $("#camposumadebe").attr("value", "");
                        $("#camposumahaber").attr("value", "");
                        redireccionar();
                    });
                    return false;
                });
            }

            var pagina = "ajustesasientos.php";
            function redireccionar()
            {
                location.href = pagina;
            }


        </script>
        <style>
            #contbajustes{width: 800px;}
            //#cuerpo            {font-family: verdana; font: bold 90% monospace;            }
            #new_ejercicio{width: 50%;}
            .contenedores{margin:60px auto;width:960px;font-family:sans-serif;font-size:15px}
            table {width:100%;box-shadow:0 0 10px #ddd;text-align:left}
            th {padding:5px;background:#555;color:#fff}
            td {padding:5px;border:solid #ddd;border-width:0 0 1px;}
            .editable span{display:block;}
            .editable span:hover {background:url(images/edit.png) 90% 50% no-repeat;cursor:pointer}

            td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
            .compa2{width: 98px}
            .compa3{width: 85px}
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
        </style>
    </head>
    <body>
        <div id="contenedor_bl">
            <center>
                <div id="menus">
                    <div id="menu_contable">
                        <div class="menu">
                            <ul class="nav" id="nav">
                                <li><a href="../../index_admin.php">Panel</a></li>
                                <li><a href="../catalogodecuentas.php">Plan de Ctas</a></li>
                                <!--<li><a href="">Usuarios</a></li>-->
                                <li  class="current"><a href="documentos/documentos.php">Documentos</a></li>								
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
                                        <td colspan="2"><div align="right">Usuario: <span class="Estilo6">
                                                    <strong><?php echo $_SESSION['username']; ?> </strong>
                                                </span>
                                                <input name="idlog" id="idlog" type="hidden" value="<?php echo $idlogeobl; ?>"/>
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
                                <li><a href="star_balance.php">B Inicial</a></li>
                                <li><a href="Bl_inicial.php">Asientos</a></li>
                                <li><a href="automayorizacion.php">Mayorizacion</a></li>
<!--                                <li><a href="index_modulo_contable.php">Diario</a></li>
                                <li><a href="tabmayor/t_mayor.php">B. Resultados</a></li>								
                                <li><a href="">Perdidas y Ganancias</a></li>								-->
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
                    <form id="frm_bl" name="frm_bl" method="post" action="ajustesasientos.php.php" enctype="multipart/form-data"> 
                        <fieldset>
                            <table>
                                <tr>
                                    <td>
                                        <label>Estado de Contabilidad Anual</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Contabilidad del A&ncaron;o :<?php echo $year ?></label>
                                    </td>
                                </tr> 
                            </table>
                        </fieldset>

                        </br>                        </br>
                    </form>
                    <!--Menu -->
                </div>    
                <!--formulario 2    javascript: fn_agregar();-->
                <div id="form2"> 
                    <div id="new_ejercicio">
                        <form name="form_ejercicio" id="form_ejercicio" method="post" action="ajustesasientos.php" style="width: 70%">
                            <input name="idlogaj" id="idlogaj" type="hidden" value="<?php echo $idlogeobl; ?>"/>
                            <input type="hidden" name="id_asientourl" name="id_asientourl" value=""/>
                            <fieldset>
                                <legend>
                                    <center>  <strong>  Ajustes de Asientos  </strong> </center>
                                </legend>
                                <datalist id="cuenta">
                                    <?php
//                                    $dbi = new Conectar();
//                                    $conex = $dbi->conexion();
//                                    $con1 = mysql_connect("localhost", "root", "alberto2791");
//                                    mysql_select_db("condata", $con1);
                                    $query = "select * from t_plan_de_cuentas order by cod_cuenta";
                                    $resul1 = mysqli_query($conex,$query);
                                    while ($dato1 = mysqli_fetch_array($resul1)) {
                                        $cod1 = $dato1['cod_cuenta'];
                                        echo "<option value='" . $dato1['cod_cuenta'] . "' >";
                                        echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                        echo '</option>';
                                    }
                                    ?>
                                </datalist>
                                <datalist id="cuenta_nom" >
                                    <?php
//                                    $con1 = mysql_connect("localhost", "root", "alberto2791");
//                                    mysql_select_db("condata", $con1);
                                    $query = "select * from t_plan_de_cuentas order by cod_cuenta";
                                    $resul1 = mysqli_query($conex,$query);
                                    while ($dato1 = mysqli_fetch_array($resul1)) {
                                        $cod1 = $dato1['cod_cuenta'];
                                        echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >";
                                        echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                        echo '</option>';
                                    }
                                    ?>
                                </datalist>
                                <script language="javascript">


                                    function actualiza() {
                                        $("#contbajustes").load("ajustesasientos.php");
                                    }
                                    setInterval("actualiza()", 1000);
                                    function cargando()
                                    {
                                        $('#cargando').html('<div><img src="images/ajax-loader.gif"/></div>');
                                        setTimeout(function () {
                                            $("#cargando").fadeOut(1500);
                                        }, 4500);
                                    }
                                    function fAgrega()
                                    {
                                        document.getElementById("texto").value = document.getElementById("cod_cuenta").value;
                                    }
                                    function fcarga()
                                    {
                                        var miVariableJS = $("#texto").val();
                                        $.post("archivo.php", {"texto": miVariableJS},
                                        function (respuesta) {
                                            //alert(respuesta);
                                            document.getElementById('nom_cuenta').value = respuesta;
                                            //document.getElementById('select').value = respuesta;
                                        });
                                        fcarg_grupo();
                                        //var dato = $("#cod_cuenta").val(); $.post("archivoposicion.php", {"texto": dato},
                                        //function (respuesta) { document.getElementById('select').value = respuesta; });
                                    }
                                    function fconsul()
                                    {
                                        var miVariableJS = $("#texto").val();
                                        $.post("archivo.php", {"texto": miVariableJS},
                                        function (respuesta) {
                                            document.getElementById('nom_cuenta').value = respuesta;
                                        });
                                    }
                                    function fcarg_grupo()
                                    {
                                        var miVariableJS = $("#texto").val();
                                        $.post("archivogrupo.php", {"texto": miVariableJS},
                                        function (respuestag) {
                                            document.getElementById('nom_grupo').value = respuestag;
                                            $('#tip_cuenta option[value="' + respuestag + '"]').attr({selected: "selected"});
                                        });
                                    }
                                    function fcarg_gruponombre()
                                    {
                                        var miVariableJS = $("#texto").val();
                                        $.post("archivogruponombre.php", {"texto": miVariableJS},
                                        function (respuestan) {
                                            document.getElementById('cod_grupo').value = respuestan;
                                        });
                                    }
                                    function actualiza() {
                                        $("#contb").load("cargatablabinicial.php");
                                    }
                                    setInterval("actualiza()", 1000);
                                    function carga_idasiento() {
                                        var numasiento = $("#asiento_numaux").val();
                                        //alert(numasiento)
                                        $.post("archivocargaidasiento.php", {"texto": numasiento},
                                        function (respuestan) {
                                            document.getElementById('idas').value = respuestan;
                                        });
                                    }

                                </script>
                                <fieldset>
                                    <legend>Ingrese los datos</legend>
                                    <center><div id="cargando"></div></center>                             
                                    <input type="hidden" name="mes" id="mes" readonly="readonly" value="<?php echo $mes ?>"/>
                                    <table border="0" cellpadding="0" cellspacing="0" >
                                        <tr>
                                        <p>
                                        <td align="center">
                                            <label class="form">Cod Cuenta :   </label>
                                            <input list="cuenta" onselect="fAgrega();
                                                    fcarga();
                                                    fcarg_grupo();
                                                    fcarg_gruponombre();" onkeyup="" 
                                                   onchange="cargando();" class="text" name="cod_cuenta" id="cod_cuenta"/>
                                            <input type="hidden" id="texto"/>
                                        </td>
                                        <td align="center"><label class="form">Nombre Cuenta :</label>
                                            <!--list="cuenta_nom-->
                                            <input class="texto" readonly="readonly" onchange="fcarga()" name="nom_cuenta" id="nom_cuenta" />
                                        </td>
                                        </p>         
                                        </tr>
                                        <tr>
                                        <p>
                                        <td align="center"><label class="form">Valor :</label>
                                            <input type="text" id="valor" name="valor" onkeypress="Calcular()" onkeyup="validar(this.id);
                                                    Calcular();" style="text-align: right" value="0.00" placeholder="Format 0.00"/></td>
                                        <td align="center"><label class="form">Ajuste :</label>
                                            <input type="text" id="asiento_num" readonly="readonly" name="asiento_num" style="text-align: center" 
                                                   value="<?php echo $conajustes ?>"/>
                                            <input type="hidden" id="asiento_numaux" readonly="readonly" name="asiento_numaux" style="text-align: center" 
                                                   value="<?php echo $contador_ass ?>"/>
                                            <input type="hidden" id="asiento_url" readonly="readonly" name="asiento_url" style="text-align: center" 
                                                   value="<?php echo $id_asientourl ?>"/>
                                            <input type="hidden" id="idas" readonly="readonly" name="idas" value="" />
                                        </td>
                                        </p>
                                        </tr>
                                        <tr>
                                        <p>
                                        <td align="center">
                                            <label class="form">De la fecha :</label>
                                            <input type="text" id="fech" readonly="readonly" name="fech" style="text-align: center" value="<?php echo $date ?>"/>
                                            <input type="hidden" id="fechurl" readonly="readonly" name="fechurl" style="text-align: center" value="<?php echo $fech_url ?>"/>
                                        </td>
                                        <td align="center"> <label class="form">Grupo    : </label> 
                                            <input type="text" name="cod_grupo" id="cod_grupo" readonly="readonly">                                    
                                            <input type="text" name="nom_grupo" id="nom_grupo" style="width: 40px;" readonly="readonly"/>
                                        </td>
                                        </p>
                                        </tr>
                                        <tr>
                                        <p>
                                        <td align="center">
                                            <label class="form">Cuenta de   : </label> 
                                            <?php
//carga los tipo de cuentas para el balance
//                                            $cone_tpdh = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
//                                            mysql_select_db("condata", $cone_tpdh) or die("ERROR con la base de datos");
                                            $SQLtipobaldh = "SELECT * FROM `tip_cuenta";
                                            $query_tipo_bldh = mysqli_query($conex,$SQLtipobaldh);
                                            ?>
                                            <select name="tip_cuentadh" id="tip_cuentadh" size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo()
                                                            ;"><!--generar_codigo_grupo()-->
                                                        <?php while ($arreglot_cuendh = mysqli_fetch_array($query_tipo_bldh)) { ?>
                                                    <option class="text" value="<?php echo $arreglot_cuendh['idtip_cuenta'] ?>">
                                                        <?php echo $arreglot_cuendh['tipo'] ?></option>     
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td align="center">
                                            <label class="form">Concepto del Asiento Generado:</label>
                                            <textarea class="form-control" maxlength="250" onkeyup="this.value = this.value.slice(0, 250)" id="textarea_asaj" name="textarea_asaj" rows="1" cols="30">                                        
                                            </textarea>
                                        </td>
                                        </p>
                                        </tr>
                                        <p>
                                            </br>
                                            </br>
                                            <!--<input name="submit" type="submit" class="btn" value="Calcular" onclick="fn_agregar()"/>-->
                                            <!--<input name="submit" id="submit" type="submit" class="btn" value="Agregar"/>-->
                                            <input name="Add" id="Add" class="btn" type="button" value="Insertar" onclick="addasiento();
                                                    activarbtn();" />
                                            <input type="button" id="cancelarasiento" name="cancelarasiento" class="btn" value="Cancelar" onclick="reset_tab()"/>
                                            <input type="submit" class="btn" name="guardaras" id="guardaras" onclick="guardaas();
                                                    desactivabtn();
                                                    actualiza()" value="Ajustar" disabled/> 
                                                <!--<input type="button" value="vaciar" class="btn" onclick="vaciar_tab()"/>-->

                                        </p>
                                        <!--Tabla de asientos-->                                
                                        <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" class="tablaDatos" id="tblDatos">
                                            <tbody>   
                                                <tr>
                                            <thead>
                                            <td style="display:none">Asiento</td>
                                            <td>Cod_Cuenta</td>
                                            <td>Cuenta</td>
                                            <td>Fecha</td>
                                            <td>Debe</td>
                                            <td>Haber</td>
                                            <td style="display:none">bl</td>
                                            <td style="display:none">Grupo</td>
                                            <td style="display:none">log</td> 
                                            <td>    </td> 
                                            </thead>
                                            </tr>
                                            <tr id="datos">

                                            </tr> 

                                            <tr>
                                            <tfoot>
                                            <td></td>
                                            <td></td>
                                            <td> <strong>Total :</strong> </td>
                                            <td>
                                                <input type="text"  readonly="readonly" class="compa3" name="camposumadebe" id="camposumadebe" value=""/> 
                                            </td>
                                            <td>
                                                <input type="text"  readonly="readonly" class="compa3" name="camposumahaber" id="camposumahaber" value=""/>
                                            </td>
                                            </tfoot>            
                                            </tr>
                                            </tbody>
                                        </table>
                                        <!--final tabla asientos-->
                                    </table>

                                    <!--Inicio Tabla de asiento por ajustar-->
                                    <div id="contbajustes">
                                        <?Php
//echo "<script>alert('".$idlogeobl.$id_asientourl.$fech_url."')</script>";
                                        $year = date("Y");
                                        //$db = new mysqli("localhost", "root", "alberto2791", "condata");
                                        $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
                                        $result = mysqli_query($conex, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
                                            }
                                        }
                                        $sqlbuscagrupos = "SELECT `idnum_asientos_ajustes` AS id, `t_ejercicio_idt_corrientes` ej, `concepto` c, fecha AS f, saldodebe AS sald, saldohaber AS salh
FROM `num_asientos_ajustes`
WHERE t_bl_inicial_idt_bl_inicial = '" . $maxbalancedato . "'
AND year = '" . $year . "'
ORDER BY `t_ejercicio_idt_corrientes`";
                                        $result_grupo = mysqli_query($conex, $sqlbuscagrupos) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
                                        echo '<center>';
                                        echo '<table style="padding:5px;background:#555;color:#fff;width: 800px;font: bold 90% monospace;">';
                                        echo '<tr>';
                                        echo '<td style="display:none">id</td>';
                                        echo '<td width="10%">Fecha</td>';
                                        echo '<td width="5%">Codigo</td>';
                                        echo '<td width="25%">Cuenta</td>';
                                        echo '<td width="5%">Debe</td>';
                                        echo '<td width="5%">Haber</td>';
                                        echo '</tr>'; //eje
                                        while ($rw = mysqli_fetch_assoc($result_grupo)) {
                                            $idasiento = $rw['id']; //echo "<script>alert('".$nombre_grupo."')</script>";
                                            $nombre_grupo = $rw['c']; //echo "<script>alert('".$nombre_grupo."')</script>";
                                            $codgrupo = $rw['ej']; //echo "<script>alert('".$nombre_grupo."')</script>";
                                            $fecha = $rw['f'];
                                            $saldodb = $rw['sald'];
                                            $saldohb = $rw['salh'];
                                            echo '<table width="55%" class="table" style="padding:5px;width: 800px;font: bold 90% monospace;">';
                                            echo '<tr><th colspan="5" style="text-align: center;vertical-align: middle;"> Ref : ' . $codgrupo;
                                            echo '<a href="impresiones/impajustedetall.php?id_asientourl=' . $idasiento . '&fechaurl=' . $fecha . '&idlogeo=' . $idlogeobl . '">'
                                            . '<img src="./images/print.png" alt="Imprimir Detalle" title="Imprimir Detalle" /> </a>';
                                            echo '</th>'
                                            . '</tr>';
                                            echo '<input name="valor" type="hidden" id="valor" value="';
                                            echo $codgrupo;
                                            echo '"/>';

                                            $n = 0;
                                            $sql_cuentasgrupos = "SELECT `ejercicio` , `idajustesejercicio` , `fecha` , `cod_cuenta` , `cuenta` ,
                                                `valor` AS debe, `valorp` AS haber, `t_bl_inicial_idt_bl_inicial` , tipo,`logeo_idlogeo`,`year`
                                                    FROM `ajustesejercicio` WHERE  `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "' AND `ejercicio` =" . $codgrupo . " and year='" . $year . "'
                                                ORDER BY ejercicio";

                                            $sql_sumasdeajusteasiento = "SELECT sum(`valor`) AS debe, sum(`valorp`) AS haber
                                            FROM `ajustesejercicio` WHERE  `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'"
                                                    . " AND `ejercicio` =" . $codgrupo . " and year='" . $year . "' ";
                                            $resulsumasdeasientoajuste = mysqli_query($conex, $sql_sumasdeajusteasiento);
                                            while ($row1 = mysqli_fetch_assoc($resulsumasdeasientoajuste)) {
                                                $debeaj = $row1['debe'];
                                                $haberaj = $row1['haber'];
                                            }


                                            $result2 = mysqli_query($conex, $sql_cuentasgrupos);
                                            while ($r2 = mysqli_fetch_array($result2)) {
                                                echo '<tr>';
                                                echo '<td width="5%" style="display:none">  ' . $r2['dajustesejercicio'] . '   </td>';
                                                echo '<td width="10%">  ' . $r2['fecha'] . '   </td>';
                                                echo '<td width="5%">  ' . $r2['cod_cuenta'] . '   </td>';
                                                echo '<td width="25%">  ' . $r2['cuenta'] . '   </td>';
                                                echo '<td width="5%">  ' . $r2['debe'] . '   </td>';
                                                echo '<td width="5%">  ' . $r2['haber'] . '   </td>';
                                                echo '</tr>';
                                            }
                                            echo '<tr>';
                                            echo '<th colspan="6" style="background-color: #ddd;font: bold 90% monospace;"> Concepto :'
                                            . '<textarea class="form-control" id="textarea_as" name="textarea_as" rows="1" cols="30">' . $nombre_grupo . '</textarea></th>';
                                            //echo '' . $nombre_grupo . '';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<th>';
                                            echo '<td></td>';
                                            echo '<td><label>Saldo Debe: <input name="saldo" type="text" id="saldo" style="color:#FF0000;" value="' . $debeaj . '"/></label></td>';
                                            echo '<td><label>Saldo Haber: <input name="saldo" readonly="readonly" type="text" id="saldo" style="color:#FF0000;" value="' . $haberaj . '"/></label></td>';
                                            echo '</th>';
                                            echo '</tr>';
                                            echo '</table>';
                                            $n++;
                                        }

                                        echo '</table>';
                                        echo '</center>';
                                        ?>

                                        <!--Final Tabla de asiento por ajustar-->


                                    </div>
                                </fieldset>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>

        </div>
<?phpmysqli_close($conex);?>
    </body>
</html>	
