<!DOCTYPE html>
<!--Christian Tigre-->
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
require('../../../Clases/cliente.class.php');
require '../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
$totdebe = 0.00;
$tothaber = 0.00;
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../login.php"
</script>';
}
$date = date("Y-m-j");
$mes = date('F');
$year = date("Y");
$consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
$query_bl = mysqli_query($c, $consul_bal_inicial);
$row = mysqli_fetch_array($query_bl);
$idcod = $row['contador'];
$idcod_sig = $row['Siguiente'];

$incr = "select count(*)+1 as inc from libro";
$query_inc = mysqli_query($c, $incr);
$r_inc = mysqli_fetch_array($query_inc);
$idinc = $r_inc['inc'];

$contador_de_asientosSQL = "select count(year)+1 as CON from num_asientos"
        . " where `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "' ";
$query_contador = mysqli_query($c, $contador_de_asientosSQL);
$row_cont = mysqli_fetch_array($query_contador);
$contador_ass = $row_cont['CON'];

$id_usuario = $_SESSION['username'];
$user = $id_usuario;
$idlogeobl = $_SESSION['id_user'];
include '../../Clases/guardahistorial.php';
$accion = "Ingreso en registro de asientos";
generaLogs($user, $accion);


mysqli_close($c);
if (isset($_POST["submit"])) {
    $btntu = $_POST["submit"];
    $contenido = $_POST;

    function limpiarForm() {
        unset($contenido);
    }

}
?>
<html>
    <head>
        <title>Asientos contables</title>
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

            function guardaaslibro()
            {
                var camposumadebe = $("#camposumadebe").val();
                var camposumahaber = $("#camposumahaber").val();
                if (camposumadebe != camposumahaber)
                {
                    alert("Error!!!...El asiento no esta cuadrado correctamente, no se puede guardar!!!");
                } else
                {
                    aux_save();
                }

            }


            function aux_save()
            {
                $('#form_ejercicio').submit(function (msg) {
                    $.post("guardaasientoslibro.php", $(this).serialize(), function (data) {
                        alert(data);
                        var answer = confirm("Desea imprimir el asiento realizado?")
                        if (answer) {
                            imprimirasiento();
                            //redireccionar();
                        } else
                        {
                            redireccionar();
                        }
                    });
                    return false;
                });
            }

            function imprimirasiento()
            { 
                var idlogeo = $("#idlog").val();
                var fech_url = $("#datetimepicker1").val();
                var id_asientourl = $("#asiento_num").val();
                window.open('impresiones/impasiento.php?idlogeo=' + idlogeo +
                        '&fechaurl=' + fech_url + '&id_asientourl=' + id_asientourl);
                redireccionar();

            }

            var pagina = "Bl_inicial.php";
            function redireccionar()
            {
                location.href = pagina;
            }
            //setTimeout("redireccionar()", 20000);


        </script>
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
                                <table width="718" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>&nbsp;</tr>
                                    <tr>
                                        <td colspan="2"><div align="right">Usuario: <span class="Estilo6">
                                                    <strong><?php echo $_SESSION['username']; ?> </strong>
                                                </span>
                                                <input name="idlog" id="idlog" type="hidden" value="<?php echo $idlogeobl ?>" /></div></td>            
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
                                <li class="current"><a href="Bl_inicial.php">Asientos</a></li>
                                <li><a href="automayorizacion.php">Mayorizacion</a></li>
                                <li><a href="index_modulo_contable.php">Diario</a></li>
                                <li><a href="balancederesultados.php">B. Resultados</a></li>								
                                <li><a href="situacionfinal.php">Perdidas y Ganancias</a></li>								
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
                <form id="frm_bl" name="frm_bl" method="post" action="Bl_inicial.php" > 
                    <fieldset>
                        <legend>Balance</legend>
                        <p>
                            <?Php
                            $c = $dbi->conexion();
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
                            mysqli_close($c);
                            ?>                        
                            <input type="hidden" class="texto" name="balances_realizados" id="balances_realizados" value="<?Php echo $idcod; ?>">
                            </br>                            
                            <input class="hidden" name="contador_balances" id="contador_balances" value="<?php echo $idcod_sig; ?>">
                        </p>     
                    </fieldset>                                                                    
                    </br></br>
                </form>
            </div>    
            <!--formulario 2    javascript: fn_agregar();-->
            <div id="form2"> 
                <div id="new_ejercicio">
                    <form name="form_ejercicio" id="form_ejercicio" method="post" action="Bl_inicial.php">
                        <input name="username" id="username" type="hidden" value="<?php echo $_SESSION['username']; ?>"/>
                        <input type="hidden" class="texto" name="balances_realizados" id="balances_realizados" value="<?Php echo $idcod; ?>"/>
                        <input type="hidden" id="username" name="username" value="<?php echo $user; ?>"
                               <fieldset>
                            <legend>Asientos Contables</legend>
                            <datalist id="cuenta">
                                <?php
                                $c = $dbi->conexion();
                                $query = "select * from t_plan_de_cuentas order by cod_cuenta";
                                $resul1 = mysqli_query($c, $query);
                                while ($dato1 = mysqli_fetch_array($resul1)) {
                                    $cod1 = $dato1['cod_cuenta'];
                                    echo "<option value='" . $dato1['cod_cuenta'] . "' >";
                                    echo $dato1['cod_cuenta'] . '      ' . utf8_decode($dato1['nombre_cuenta_plan']);
                                    echo '</option>';
                                }
                                mysqli_close($c);
                                ?>
                            </datalist>
                            <datalist id="cuenta_nom">
                                <?php
                                $c = $dbi->conexion();
                                $query = "select * from t_plan_de_cuentas";
                                $resul1 = mysqli_query($c, $query);
                                while ($dato1 = mysqli_fetch_array($resul1)) {
                                    $cod1 = $dato1['cod_cuenta'];
                                    echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >";
                                    echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                    echo '</option>';
                                }
                                mysqli_close($c);
                                ?>
                            </datalist>
                            <script language="javascript">
                                function desactivabtnas() {
                                    $('#guardaras').attr("disabled", true);
                                }
                                function activarbtnas() {
                                    $('#guardaras').attr("disabled", false);
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

                                //                        function actualizaas() {
                                //                            $("#tabasientos").load("tabasientos.php");
                                //                            actualizatabas();
                                //                        }
                                function actualizatabas() {
                                    $("#cargatablaasientos").load("cargatabladeasientos.php");
                                }

                            </script>
                            <fieldset>
                                <legend>Registro de asientos contables</legend>
                                <div class="mensajeform"></div>
                                <table border="0" cellpadding="0" cellspacing="0" >
                                    <!--Incremento de contador de registros libro-->
                                    <input type="hidden" name="idcod" id="idcod" value="<?php echo $idcod ?>"/>
                                    <input type="hidden" name="inc" id="inc" value="<?php echo $idinc ?>"/>
                                    <tr>
                                    <p>
                                    <td align="center">
                                        <label class="form">Cod Cuenta :   </label>
                                        <input list="cuenta" onselect="fAgrega();
                                                fcarga();
                                                fcarg_grupo();
                                                fcarg_gruponombre();" 
                                               onchange="cargando();
                                                       fAgrega();
                                                       fcarga();
                                                       fcarg_grupo();
                                                       fcarg_gruponombre();" onkeyup="fAgrega();
                                                               fcarga();
                                                               fcarg_grupo();
                                                               fcarg_gruponombre();" class="texto" name="cod_cuenta" id="cod_cuenta"/>
                                        <input type="hidden" id="texto"/>
                                    </td>

                                    <td align="center"><label class="form">Nombre Cuenta :</label>
                                        <!--list="cuenta_nom-->
                                        <input class="texto" readonly="readonly" name="nom_cuenta" id="nom_cuenta" />
                                    </td></p>         
                                    </tr>
                                    <tr>
                                    <p>
                                    <td align="center">
                                        <label class="form">Valor :</label>
                                        <input type="text" id="valor" name="valor" onkeypress="Calcular()" onkeyup="validar(this.id);
                                                Calcular();" style="text-align: right" value="0.00" placeholder="Format 0.00"/>
                                    </td>
                                    <td align="center"><label class="form">Asiento Num :</label>
                                        <input type="text" id="asiento_num" readonly="readonly" name="asiento_num" style="text-align: center"  value="<?php echo $contador_ass ?>"/>
                                    </td>
                                    </p>
                                    </tr>
                                    <tr>
                                    <p>
                                    <td align="center">
                                        <label class="form">De la fecha :</label>
                                        <!--<input type="text" id="fech" readonly="readonly" name="fech" style="text-align: center" value="<?php echo $date ?>"/>-->
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
                                                });
                                            </script>
                                    </td>
                                    <td align="center"> <label class="form">Grupo    : </label>
                                        <input type="text" name="cod_grupo" id="cod_grupo" required="required" readonly="readonly"> 
                                        <input type="text" name="nom_grupo" id="nom_grupo" style="width: 40px;"/>
                                    </td>
                                    </tr>
                                    <tr>
                                    <p>
                                    <td align="center">
                                        <label class="form">Cuenta de   : </label> 
                                        <?php
                                        $c = $dbi->conexion();
                                        $SQLtipobaldh = "SELECT * FROM tip_cuenta";
                                        $query_tipo_bldh = mysqli_query($c, $SQLtipobaldh);
                                        ?>
                                        <select name="tip_cuentadh" id="tip_cuentadh" size="0" style="alignment-adjust: central"><!--generar_codigo_grupo()-->
                                            <?php while ($arreglot_cuendh = mysqli_fetch_array($query_tipo_bldh)) { ?>
                                                <option class="text" value="<?php echo $arreglot_cuendh['idtip_cuenta'] ?>">
                                                    <?php echo $arreglot_cuendh['tipo'] ?></option>     
                                                <?php
                                            }
                                            mysqli_close($c);
                                            ?>
                                        </select>
                                    </td>
                                    <td align="center">
                                        <label class="form">Concepto del Asiento Generado:</label>
                                        <textarea class="form-control" maxlength="250" onkeyup="this.value = this.value.slice(0, 250)" id="textarea_as" name="textarea_as" rows="1" cols="30">                                        
                                        </textarea>
                                    </td>
                                    </p>
                                    </tr>
                                    <p>
                                        </br>
                                        </br>
                                        <input name="Add" id="Add" class="btn" type="button" value="Insertar" onclick="addasientoAs();
                                                activarbtnas();" />
                                        <input type="button" id="cancelarasiento" name="cancelarasiento" class="btn" value="Cancelar" onclick="reset_tab()"/>
                                        <input type="submit" class="btn" name="guardaras" id="guardaras" onclick="guardaaslibro();
                                                desactivabtnas();
                                                actualizatabas()" value="Guardar" disabled/> 
                                    </p>


                                    <!--Tabla de asientos-->                                
                                    <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" class="tablaDatosAs" id="tblDatosAs">

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
                    <form name="cuadrar_balance" action="Bl_inicial.php" method="POST">
                    </form>
                </div>
            </div>
        </div>
        <div id="tabasientos">
        </div>
        <div id="cargatablaasientos">
            <?Php
            include_once './cargatabladeasientos.php';
            ?>
        </div>
    </div>
</body>
</html>	
