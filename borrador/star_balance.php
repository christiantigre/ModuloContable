<!DOCTYPE html>
<!--Christian Tigre-->
<?php
require('../../../Clases/cliente.class.php');
require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
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
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../login.php"
</script>';
}
$date = date("Y-m-d");
$mes = date('F');
$year = date("Y");
// ejecuta un contador de balances
$consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
$query_bl = mysqli_query($c, $consul_bal_inicial);
$row = mysqli_fetch_array($query_bl);
$idcod = $row['contador'];
$idcod_sig = $row['Siguiente'];
// ejecuta contador de balances
$contador_de_asientosSQL = "select count(year)+1 as CON from num_asientos"
        . " where `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "'";
$query_contador = mysqli_query($c, $contador_de_asientosSQL);
$row_cont = mysqli_fetch_array($query_contador);
$contador_ass = $row_cont['CON'];
$_SESSION['username'] = $_SESSION['loginu'];
$id_usuario = $_SESSION['username'];
$user = strtoupper($id_usuario);
$idlogeobl = $_SESSION['id_user'];

include '../../Clases/guardahistorial.php';
$accion = "/ Balance Inicial / Ingreso en balance inicial";
generaLogs($user, $accion);

mysqli_close($c);
if (isset($_POST["submit"])) {
    $btntu = $_POST["submit"];
    $contenido = $_POST;
    if ($btntu == "Inicio de Contabilidad") {
        $objGrupo = new Clase;
        $idlogeobl = $_SESSION['id_user'];
        $balances_realizados = htmlspecialchars(trim($_POST['balances_realizados']));
        $contador_balances = $idcod_sig;
        $fecha_nacimiento = htmlspecialchars($_POST['fecha_corte']);

        if ($objGrupo->insertarbalance_ini(array($contador_balances, $fecha_nacimiento, $idlogeobl)) == true) {
            echo '<script language = javascript>alert("Nueva Orden Guardada")
            self.location = "star_balance.php"</script>';
            $accion = "/ INICIO DE CONTABILIDAD / Creo un nuevo periodo contable";
            generaLogs($user, $accion);
        } else {
            echo '<script language = javascript>alert("Ocurrio un error, verifique los campos...")</script>';
            $accion = "/ INICIO DE CONTABILIDAD / ERROR AL CREAR PERIODO CONTABLE";
            generaLogs($user, $accion);
        }
    }

    function limpiarForm() {
        unset($contenido);
    }

}
?>
<html>
    <head>
        <title>Balance Inicial</title>
        <link href="../../../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <script src="../../../../js/jquery.min.js"></script>
        <script src="../../../../js/jquery-1.11.0.js"></script>
        <link href="../../../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <!--<script src="../../../../js/easyResponsiveTabs.js" type="text/javascript"></script>-->
        <script src="../../../../js/jquery.functions.js" type="text/javascript"></script>
        <script src="../../../../js/script.js" type="text/javascript"></script>

        <style>
            .contenedores{margin:60px auto;width:960px;font-family:sans-serif;font-size:15px}
            table {width:100%;box-shadow:0 0 10px #ddd;text-align:left}
            th {padding:5px;background:#555;color:#fff}
            td {padding:5px;border:solid #ddd;border-width:0 0 1px;}
            .editable span{display:block;}
            .editable span:hover {background:url(images/edit.png) 90% 50% no-repeat;cursor:pointer}

            td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
            .compa2{width: 98px}
            .compa3{width: auto;}
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
                                                    <strong><?php echo $user; ?> </strong>
                                                </span>
                                                <input name="idlog" id="idlog" type="hidden" value="<?php echo $idlogeobl; ?>"
                                            </div></td>            
                                        <td></td>
                                        <td colspan="2"><div align="right">
                                                <a href="../../../../templates/logeo/desconectar_usuario.php">
                                                    <img src="../../../../images/logout.png" title="Salir" alt="Salir" />
                                                </a> </div></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                </table>
                            </center>
                        </div>
                        <div class="menu">
                            <ul class="nav" id="nav">
                                <li class="current"><a href="star_balance.php">B Inicial</a></li>
                                <li><a href="Bl_inicial.php">Asientos</a></li>
                                <li><a href="automayorizacion.php">Mayorizacion</a></li>
                                <li><a href="index_modulo_contable.php">Diario</a></li>
                                <li><a href="balancederesultados.php">B. Comprobaci&oacute;n</a></li>								
                                <li><a href="estadoresultados.php">E. Resultados</a></li>								
                                <li><a href="situacionfinal.php">S. Final</a></li>								
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
                    <form id="frm_bl" name="frm_bl" method="post" action="star_balance.php" enctype="multipart/form-data"> 
                        <fieldset>
                            <legend>Balance</legend>
                            <p>
                                <?Php
                                $c = $dbi->conexion();
//                                ver si hay datos
                                $sqlverdatos = "SELECT * FROM `t_bl_inicial`";
                                $resexist = mysqli_query($c, $sqlverdatos);
                                $dataexist = mysqli_num_rows($resexist);
                                if ($dataexist == '0') {
                                    echo '<input type="submit" name="submit" class="btn" onclick="return confirmar();" id="submit" value="Inicio de Contabilidad" />';
                                } else {
                                    $SQL_vercontt = "SELECT * FROM `t_bl_inicial` WHERE `idt_bl_inicial`='" . $idcod . "'";
                                    $res_data = mysqli_query($c, $SQL_vercontt);
                                    $rw = mysqli_fetch_array($res_data);
                                    $dtinicial = $rw['idt_bl_inicial'];
                                    $fbl = $rw['fecha_balance'];
                                    $std = $rw['estado'];
                                    $yearbl = $rw['year'];
                                    echo '<lablel>Periodo : ' . $yearbl . ' </lablel></br>';
                                    echo '<lablel>Estado : </lablel>';
                                    if ($std == '0') {
                                        echo '<input type = "checkbox" id = "0" name = "0" value = "0" disabled=""/></br>';
                                        echo '<input type="submit" name="submit" class="btn" onclick="return confirmar();" id="submit" value="Inicio de Contabilidad"/>';
                                    } else {
                                        echo '<input type = "checkbox" id = "1" name = "1" value = "1" checked="checked" disabled=""/></br>';
                                        echo '<input type="submit" name="submit" class="btn" onclick="return confirmar();" id="submit" value="Inicio de Contabilidad" disabled=""/>';
                                    }
                                }
                                ?>                        
                                <input type="hidden" class="texto" name="balances_realizados" id="balances_realizados" value="<?Php echo $idcod; ?>"></br>                            
                                <input class="hidden" name="contador_balances" id="contador_balances" value="<?php echo $idcod_sig; ?>">
                            </p> 
                            <p>
                                <input type="hidden" class="texto" name="balances_realizados" id="balances_realizados" value="<?Php echo $idcod; ?>"></br>
                            </p><p>
                                <input type="hidden" class="text" name="contador_balances" id="contador_balances" value="<?php echo $idcod_sig; ?>" disabled="">
                            </p>                             
                            <p>
                                <input class="hidden" type="hidden" name="fecha_corte" id="fecha_corte" value="<?php echo $date ?>" disabled=""/>
                            </p>
                        </fieldset>  
                        </br></br>
                    </form>
                    <!--Menu -->
                </div>    
                <!--formulario 2    javascript: fn_agregar();-->
                <div id="form2"> 
                    <div id="new_ejercicio">
                        <form name="form_ejercicio" id="form_ejercicio" method="post" action="star_balance.php">
                            <input name="username" id="username" type="hidden" value="<?php echo $_SESSION['username']; ?>"/>
                            <input type="hidden" class="texto" name="balances_realizados" id="balances_realizados" value="<?Php echo $idcod; ?>"/>
                            <input type="hidden" name="id_asientourl" name="id_asientourl" value=""/>
                            <input name="idlogeobl" id="idlogeobl" type="hidden" value="<?php echo $idlogeobl; ?>"
                                   <fieldset>
                                <legend>
                                    <center>  <strong>  Estado Inicial de la Empresa  </strong> </center>
                                </legend>
                                <datalist id="cuenta">
                                    <?php
                                    $c = $dbi->conexion();
//                                    $query = "select * from t_plan_de_cuentas order by cod_cuenta";
                                    $query = "SELECT * FROM `t_plan_de_cuentas` ";
                                    $resul1 = mysqli_query($c, $query);
                                    while ($dato1 = mysqli_fetch_array($resul1)) {
                                        $cod1 = $dato1['cod_cuenta'];
                                        echo "<option value='" . $dato1['cod_cuenta'] . "' >";
                                        echo $dato1['cod_cuenta'] . '      ' . utf8_decode($dato1['nombre_cuenta_plan']);
                                        echo '</option>';
                                    }mysqli_close($c);
                                    ?>
                                </datalist>
                                <datalist id="cuenta_nom" >
                                    <?php
                                    $c = $dbi->conexion();
                                    $query = "select * from t_plan_de_cuentas";
                                    $resul1 = mysqli_query($c, $query);
                                    while ($dato1 = mysqli_fetch_array($resul1)) {
                                        $cod1 = $dato1['cod_cuenta'];
                                        echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >";
                                        echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                        echo '</option>';
                                    }mysqli_close($c);
                                    ?>
                                </datalist>

                                <script language="javascript">
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
                                        $('#Add').attr("disabled", false);
                                    }
                                    function actualiza() {
                                        $("#contb").load("./cargatablabinicial.php");
                                    }
                                    setInterval("actualiza()", 1000);
                                    function carga_idasiento() {
                                        var numasiento = $("#asiento_numaux").val();
                                        $.post("archivocargaidasiento.php", {"texto": numasiento},
                                        function (respuestan) {
                                            document.getElementById('idas').value = respuestan;
                                        });
                                    }
                                    window.onload = function () {
                                        setCursor(document.getElementById('textarea_as'), 0, 0)
                                    }

                                    function setCursor(el, st, end) {
                                        if (el.setSelectionRange) {
                                            el.focus();
                                            el.setSelectionRange(st, end);
                                        } else {
                                            if (el.createTextRange) {
                                                range = el.createTextRange();
                                                range.collapse(true);
                                                range.moveEnd('character', end);
                                                range.moveStart('character', st);
                                                range.select();
                                            }
                                        }
                                    }

                                    function desactivabtn() {
                                        $('#guardaras').attr("disabled", true);
                                    }

                                    function activarbtn() {
                                        $('#guardaras').attr("disabled", false);
                                    }
                                    function desactivarbtnAdd() {
                                        $('#Add').attr("disabled", true);
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
                                        //alert(camposumadebe+' '+camposumahaber);//vericifado si toma asta aqui los decimales.
                                        if (camposumadebe != camposumahaber)
                                        {
                                            alert("Error!!!...El balance no esta cuadrado correctamente, No se puede guardar!!!");
                                        } else
                                        {
                                            aux_save();
                                        }

                                    }

                                    function aux_save()
                                    {
                                        $('#form_ejercicio').submit(function (msg) {
//                    var nColumnas = $("#tblDatos tr:last td").length;
                                            $.post("guardaasientos.php", $(this).serialize(), function (data) {
                                                alert(data); //carga_idasiento();//imprimir_balance();
                                                //vaciar_tab();
                                                $("#textarea_as").attr("value", "");
                                                $("#camposumadebe").attr("value", "");
                                                $("#camposumahaber").attr("value", "");
                                            });
                                            return false;
                                        });
                                    }

                                    var bPreguntar = true;
                                    function confirmar() {
                                        var formulario = document.getElementById("frm_bl");
                                        var dato = formulario[0];
                                        respuesta = confirm('¿Desea crear el nuevo periodo contable ?');
                                        if (respuesta) {
                                            formulario.submit();
                                            return true;
                                        } else {
                                            alert("No se aplicaran los cambios...!!!");
                                            return false;
                                        }
                                    }

                                    function keyup() {
//                                        alert("dato");
                                        fAgrega();
                                        fcarga();
                                        fcarg_grupo();
                                        fcarg_gruponombre();
                                    }
                                    document.getElementById('cod_cuenta').addEventListener('input', function () {
                                        console.log('changed');
                                    });
                                    function compr_evento() {
                                        var Cadena = $('#cod_cuenta').val();
                                        var Search = ".";
                                        var i = 0;
                                        var counter = 0;
                                        while (i != -1)
                                        {
                                            var i = Cadena.indexOf(Search, i);
                                            if (i != -1)
                                            {
                                                i++;
                                                counter++;
                                            }
                                        }
                                        if(counter == "1"){  var dato = "t_clase_cod_clase"; }
                                        if(counter == "2"){  var dato = "t_grupo_cod_grupo"; }
                                        if(counter == "3"){  var dato = "t_cuenta_cod_cuenta"; }
                                        if(counter == "4"){  var dato = "t_subcuenta_cod_subcuenta"; }
                                        if(counter == "5"){  var dato = "t_auxiliar_cod_cauxiliar"; }
                                        if(counter == "6"){  var dato = "t_subauxiliar_cod_subauxiliar"; }
                                        if(!isNaN(Cadena)){
                                            dato = "cadena";
                                        }
                                        alert(dato);



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
                                            <!--  onblur="compr_evento();"                                           -->
                                            <input list="cuenta" onselect="fAgrega();
                                                                                                fcarga();
                                                                                                fcarg_grupo();
                                                                                                fcarg_gruponombre();" class="text" name="cod_cuenta" id="cod_cuenta"/>
                                            <input type="hidden" id="texto"/>
                                        </td>
                                        <td align="center"><label class="form">Nombre Cuenta :</label>
                                            <input class="texto" readonly="readonly" onchange="fcarga()" name="nom_cuenta" id="nom_cuenta" />
                                        </td>
                                        </p>         
                                        </tr>
                                        <tr>    
                                        <p>
                                        <td align="center">
                                            <label class="form">Valor :</label>
                                            <input type="text" id="valor" name="valor" onkeypress="Calcular()" onkeyup="validar(this.id);
                                                    Calcular();" style="text-align: right" value="0.00" placeholder="Format 0.00"/></td>
                                        <td align="center">
                                            <label class="form">Asiento Num :</label>
                                            <input type="text" id="asiento_num" readonly="readonly" name="asiento_num" style="text-align: center" 
                                                   value="<?php echo $contador_ass ?>"/>
                                            <input type="hidden" id="asiento_numaux" readonly="readonly" name="asiento_numaux" style="text-align: center"  value="<?php echo $contador_ass ?>"/>
                                            <input type="hidden" id="idas" readonly="readonly" name="idas" value="" />
                                        </td>
                                        </p>
                                        </tr>
                                        <tr>
                                        <p>
                                        <td align="center">
                                            <label class="form">De la fecha :</label>
                                            <!--fecha fija <input type="text" id="fech" readonly="readonly" name="fech" style="text-align: center" value="<?php echo $date ?>"/>-->
                                            <input type="text" id="datetimepicker1" name="datetimepicker1" value=""/>
                                            <link rel="stylesheet" type="text/css" href="../../../../datepicker/jquery.datetimepicker.css"/>
                                            <script src="../../../../datepicker/jquery.js"></script>
                                            <script src="../../../../datepicker/jquery.datetimepicker.full.js"></script>
                                            <script>
                                                jQuery.datetimepicker.setLocale('es');
                                                jQuery('#datetimepicker1').datetimepicker({
                                                    i18n: {
                                                        de: {
                                                            months: [
                                                                'Enero', 'Febrero', 'Marzo', 'Abril',
                                                                'Mayo', 'Junio', 'Julio', 'Agosto',
                                                                'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',
                                                            ],
                                                            dayOfWeek: [
                                                                "So.", "Mo", "Di", "Mi",
                                                                "Do", "Fr", "Sa.",
                                                            ]
                                                        }
                                                    },
                                                    timepicker: false,
                                                    format: 'Y-m-d'
                                                });</script>
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
                                            $db = $dbi->conexion();
                                            $SQLtipobaldh = "SELECT * FROM tip_cuenta";
                                            $query_tipo_bldh = mysqli_query($db, $SQLtipobaldh);
                                            ?>
                                            <select name="tip_cuentadh" id="tip_cuentadh" size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo();"><!--generar_codigo_grupo()-->
                                                <?php while ($arreglot_cuendh = mysqli_fetch_array($query_tipo_bldh)) { ?>
                                                    <option class="text" value="<?php echo $arreglot_cuendh['idtip_cuenta']; ?>">
                                                        <?php echo $arreglot_cuendh['tipo']; ?></option>     
                                                    <?php
                                                }
                                                mysqli_close($db);
                                                ?>
                                            </select>
                                        </td>
                                        <td align="center">
                                            <label class="form">Concepto del Asiento Generado:</label>
                                            <textarea class="form-control" placeholder="Concepto del Asiento..." maxlength="250" onkeyup="this.value = this.value.slice(0, 250)" id="textarea_as" name="textarea_as" rows="1" cols="30"></textarea>
                                        </td>
                                        </p>
                                        </tr>
                                        <p>
                                            </br>
                                            </br>
                                            <input name="Add" id="Add" class="btn" type="button" value="Insertar" onclick="addasiento();
                                                    activarbtn();
                                                    desactivarbtnAdd()" disabled/>
                                            <input type="button" id="cancelarasiento" name="cancelarasiento" class="btn" value="Cancelar" onclick="reset_tab()"/>
                                            <input type="submit" class="btn" name="guardaras" id="guardaras" onclick="guardaas();
                                                    desactivabtn();
                                                    actualiza()" value="Guardar" disabled/> 
                                        </p>                               
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
                                </fieldset>
                            </fieldset>
                        </form>
                        <form name="cuadrar_balance" action="star_balance.php" method="POST">
                        </form>
                    </div>
                </div>
            </div>

            <div id="conta">
            </div>   

            <div id="contb">
                <?php
                include './cargatablabinicial.php';
                ?>
            </div>
        </div>







    </body>
</html>	
