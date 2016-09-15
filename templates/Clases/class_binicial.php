<?php
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");

/**
 * Description of class_binicial
 *
 * @author CHRISTIAN
 */
class class_binicial {

    function conec_base() {
        $this->objconec = mysqli_connect('localhost', $_SESSION['loginu'], $_SESSION['clave'], 'condata');
        return $this->objconec;
    }

    function info_balance() {
        $conn = $this->conec_base();
        echo '<div id="form1">';
        echo '<form id="frm_bl" name="frm_bl" method="post" action="Bl_inicial.php" >';
        echo '<fieldset><legend>Balance</legend><p>';
        $consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
        $query_bl = mysqli_query($conn, $consul_bal_inicial);
        $row = mysqli_fetch_array($query_bl);
        $idcod = $row['contador'];
        $idcod_sig = $row['Siguiente'];
        $SQL_vercontt = "SELECT * FROM `t_bl_inicial` WHERE `idt_bl_inicial`='" . $idcod . "'";
        $res_data = mysqli_query($conn, $SQL_vercontt);
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
        </br></br>
        </form>
        </div> <?php
        mysqli_close($conn);
    }

    function form_blinicial() {
        session_start();
        $date = date("Y-m-j");
        $year = date("Y");
        $c = $this->conec_base();
        $id_usuario = $_SESSION['username'];
        $consulta = "SELECT l.username, u.tipo_user, l.idlogeo FROM logeo l JOIN user_tipo u WHERE "
                . "l.user_tipo_iduser_tipo = u.iduser_tipo AND l.username = '" . $id_usuario . "'";
        $resultado = mysqli_query($c, $consulta) or die(mysqli_errno($c));
        $fila = mysqli_fetch_array($resultado);
        $user = $fila['username'];
        $type_user = $fila['tipo_user'];
        $idlogeobl = $fila['idlogeo'];
        $consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
        $query_bl = mysqli_query($c, $consul_bal_inicial);
        $row = mysqli_fetch_array($query_bl);
        $idcod = $row['contador'];
        $idcod_sig = $row['Siguiente'];
        $contador_de_asientosSQL = "select count(year)+1 as CON from num_asientos where `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' "
                . "and year='" . $year . "' ";
        $query_contador = mysqli_query($c, $contador_de_asientosSQL);
        $row_cont = mysqli_fetch_array($query_contador);
        $contador_ass = $row_cont['CON'];
        ?>
        <div id = "form2">
            <div id = "new_ejercicio">
                <form name = "form_ejercicio" id = "form_ejercicio" method = "post" action = "Bl_inicial.php">
                    <input name = "username" id = "username" type = "hidden" value = "<?php echo $_SESSION['username']; ?>"/>
                    <input type = "hidden" class = "texto" name = "balances_realizados" id = "balances_realizados" value = "<?Php echo $idcod; ?>"/>
                    <input type = "hidden" id = "username" name = "username" value = "<?php echo $_SESSION['username']; ?>"/>
                    <fieldset>
                        <legend>Asientos Contables</legend>
                        <datalist id = "cuenta">
                            <?php
                            $query = "select * from t_plan_de_cuentas order by cod_cuenta";
                            $resul1 = mysqli_query($c, $query);
                            while ($dato1 = mysqli_fetch_array($resul1)) {
                                $cod1 = $dato1['cod_cuenta'];
                                echo "<option value='" . $dato1['cod_cuenta'] . "' >";
                                echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                echo '</option>';
                            }
                            ?>
                        </datalist>
                        <datalist id="cuenta_nom">
                            <?php
                            $query = "select * from t_plan_de_cuentas";
                            $resul1 = mysqli_query($c, $query);
                            while ($dato1 = mysqli_fetch_array($resul1)) {
                                $cod1 = $dato1['cod_cuenta'];
                                echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >";
                                echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                                echo '</option>';
                            }
                            ?>
                        </datalist>
                        <script language="javascript">
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
                                var fech_url = $("#fech").val();
                                var id_asientourl = $("#asiento_num").val();
                                window.open('impresiones/impasiento.php?idlogeo=' + idlogeo + '&fechaurl=' + fech_url + '&id_asientourl=' + id_asientourl);

                            }

                            var pagina = "Bl_inicial.php";
                            function redireccionar()
                            {
                                location.href = pagina;
                            }

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
                                    document.getElementById('nom_cuenta').value = respuesta;
                                });
                                fcarg_grupo();
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

                            function actualizatabas() {
                                $("#cargatablaasientos").load("cargatabladeasientos.php");
                            }

                        </script>
                        <fieldset>
                            <legend>Registro de asientos contables</legend>
                            <div class="mensajeform"></div>
                            <table border="0" cellpadding="0" cellspacing="0" >
                                <input type="hidden" name="idcod" id="idcod" value="<?php echo $idcod ?>"/>
                                <input type="hidden" name="inc" id="inc" value="<?php echo $idinc ?>"/>
                                <input type = "hidden" id = "idlog" name = "idlog" value = "<?php echo $idlogeobl ?>"/>
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
                                    <input type="text" id="fech" readonly="readonly" name="fech" style="text-align: center" value="<?php echo $date ?>"/>
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
                                    $SQLtipobaldh = "SELECT * FROM tip_cuenta";
                                    $query_tipo_bldh = mysqli_query($c, $SQLtipobaldh);
                                    ?>
                                    <select name="tip_cuentadh" id="tip_cuentadh" size="0" style="alignment-adjust: central"><!--generar_codigo_grupo()-->
                                        <?php while ($arreglot_cuendh = mysqli_fetch_array($query_tipo_bldh)) { ?>
                                            <option class="text" value="<?php echo $arreglot_cuendh['idtip_cuenta'] ?>">
                                                <?php echo $arreglot_cuendh['tipo'] ?></option>     
                                            <?php
                                        }
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
        <?php
        mysqli_close($c);
    }

    function tab_asientos() {
        $c = $this->conec_base();
        $mes = date('F');
        $year = date("Y");
        $id_usuario = $_SESSION['username'];
        $consulta = "SELECT l.username, u.tipo_user, l.idlogeo FROM logeo l JOIN user_tipo u WHERE l.user_tipo_iduser_tipo = u.iduser_tipo AND l.username = '" . $id_usuario . "'";
        $resultado = mysqli_query($c, $consulta) or die(mysqli_errno($c));
        $fila = mysqli_fetch_array($resultado);
        $user = $fila['username'];
        $type_user = $fila['tipo_user'];
        $idlogeobl = $fila['idlogeo'];

        $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
        $result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($c), E_USER_ERROR);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $maxbalancedato = $row['id'];
            }
        }
        $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` ej,`concepto` c,fecha as f,saldodebe as sald,saldohaber as salh FROM `num_asientos` "
                . "WHERE `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' and year ='" . $year . "'"
                . " and `t_ejercicio_idt_corrientes` >1  order by ej desc";
        $result_grupo = mysqli_query($c, $sqlbuscagrupos) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($c), E_USER_ERROR);
        echo '<center>';
        echo '<table style="padding:5px;background:#555;color:#fff;width: 960px;">';
        echo '<tr>';
        echo '<td style="display:none">id</td>';
        echo '<td>Fecha</td>';
        echo '<td>Codigo</td>';
        echo '<td>Cuenta</td>';
        echo '<td>Debe</td>';
        echo '<td>Haber</td>';
        echo '</tr>';
//eje
        while ($rw = mysqli_fetch_assoc($result_grupo)) {
            $idasiento = $rw['id']; //echo "<script>alert('".$nombre_grupo."')</script>";
            $nombre_grupo = $rw['c']; //echo "<script>alert('".$nombre_grupo."')</script>";
            $codgrupo = $rw['ej']; //echo "<script>alert('".$nombre_grupo."')</script>";
            $fecha = $rw['f'];
            $saldodb = $rw['sald'];
            $saldohb = $rw['salh'];
            echo '<table width="85%" class="table" style="padding:5px;width: 960px;">';
            echo '<tr><th colspan="5" style="text-align: center;vertical-align: middle;"> Ref : ' . $codgrupo . ''
            . '<a href="detallecuentaasientos.php?id_asientourl=' . $idasiento . '&fechaurl=' . $fecha . '">'
            . '<img src="./images/detail.png" alt="Ver" title="Detalles" /> </a>';

            if ($saldodb != 0.00) {
                echo '<a target="_blank" href="ajustesasientos.php?idlogeo=';
                echo $idlogeobl;
                echo '&id_asientourl=';
                echo $idasiento;
                echo '&fech_url=';
                echo $fecha . ' " class="btn btn-danger">Realizar Ajuste</a>';
            } elseif ($saldohb != 0.00) {
                echo '<a target="_blank" href="ajustesasientos.php?idlogeo=';
                echo $idlogeobl;
                echo '&id_asientourl=';
                echo $idasiento;
                echo '&fech_url=';
                echo $fecha . ' " class="btn btn-danger">Realizar Ajuste</a>';
            }
            echo '</th>'
            . '</tr>';
            echo '<input name="valor" type="hidden" id="valor" value="';
            echo $codgrupo;
            echo '"/>';

            $n = 0;
            $sql_cuentasgrupos = "SELECT idlibro,`asiento` , `fecha` , `ref` , `cuenta` ,  debe,  haber, `t_bl_inicial_idt_bl_inicial` , grupo
FROM `libro`
WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'
AND `asiento` =" . $codgrupo . " and year='" . $year . "'
 ORDER BY asiento";
            $result2 = mysqli_query($c, $sql_cuentasgrupos);
            while ($r2 = mysqli_fetch_array($result2)) {
                echo '<tr>';
                echo '<td width="5%" style="display:none">  ' . $r2['idlibro'] . '   </td>';
                echo '<td width="15%">  ' . $r2['fecha'] . '   </td>';
                echo '<td width="15%">  ' . $r2['ref'] . '   </td>';
                echo '<td width="35%">  ' . $r2['cuenta'] . '   </td>';
                echo '<td width="10%">  ' . $r2['debe'] . '   </td>';
                echo '<td width="10%">  ' . $r2['haber'] . '   </td>';
                echo '</tr>';
            }
            echo '<tr>';
            echo '<th colspan="6" style="background-color: #ddd;"> Concepto :'
            . '<textarea class="form-control" id="textarea_as" name="textarea_as" rows="1" cols="30" disabled="disabled">' . $nombre_grupo . '</textarea></th>';
//echo '' . $nombre_grupo . '';
            echo '</tr>';
            echo '</table>';
            $n++;
        }

        echo '</table>';
        echo '</center>';
        mysqli_close($c);
    }

    function tab_binicial() {
        $db = $this->conec_base();
        $year = date("Y");
        $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
        $result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $maxbalancedato = $row['id'];
            }
        }
        $sqlbuscagrupos = "SELECT `idnum_asientos` as id,`t_ejercicio_idt_corrientes` ej,`concepto` c,fecha as f FROM `num_asientos` "
                . "WHERE `t_bl_inicial_idt_bl_inicial`='" . $maxbalancedato . "' and year ='" . $year . "' and `t_ejercicio_idt_corrientes`=1  order by ej";
        $result_grupo = mysqli_query($db, $sqlbuscagrupos) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
        echo '<center>';

        echo '<table style="padding:5px;background:#555;color:#fff;width: 960px;">';
//eje

        while ($rw = mysqli_fetch_assoc($result_grupo)) {
            $idasiento = $rw['id']; //echo "<script>alert('".$nombre_grupo."')</script>";
            $nombre_grupo = $rw['c']; //echo "<script>alert('".$nombre_grupo."')</script>";
            $codgrupo = $rw['ej']; //echo "<script>alert('".$nombre_grupo."')</script>";
            $fecha = $rw['f'];
            echo '<table width="85%" class="table" style="padding:5px;width: 960px;">';
            echo '<tr><th colspan="5" style="text-align: center;vertical-align: middle;"> Ref : ' . $codgrupo . ''
            . '<a href="detallecuenta.php?id_asientourl=' . $idasiento . '&fechaurl=' . $fecha . '"><img src="./images/detail.png" alt="Ver" title="Detalles" /> </a></th>'
            . '</tr>';
            echo '<input name="valor" type="hidden" id="valor" value="';
            echo $codgrupo;
            echo '"/>';

            $n = 0;
            $sql_cuentasgrupos = "SELECT `ejercicio` , `idt_corrientes` , `fecha` , `cod_cuenta` , `cuenta` , `valor` AS debe, `valorp` AS haber, `t_bl_inicial_idt_bl_inicial` , tipo
FROM `t_ejercicio`
WHERE `t_bl_inicial_idt_bl_inicial` = '" . $maxbalancedato . "'
AND `ejercicio` =" . $codgrupo . " and year='" . $year . "'
ORDER BY ejercicio";
            $result2 = mysqli_query($db, $sql_cuentasgrupos);
            while ($r2 = mysqli_fetch_array($result2)) {
                echo '<tr>';
                echo '<td width="5%" style="display:none">  ' . $r2['idt_corrientes'] . '   </td>';
                echo '<td width="15%">  ' . $r2['fecha'] . '   </td>';
                echo '<td width="15%">  ' . $r2['cod_cuenta'] . '   </td>';
                echo '<td width="35%">  ' . $r2['cuenta'] . '   </td>';
                echo '<td width="10%">  ' . $r2['debe'] . '   </td>';
                echo '<td width="10%">  ' . $r2['haber'] . '   </td>';
                echo '</tr>';
            }
            echo '<tr>';
            echo '<th colspan="6" style="background-color: #ddd;"> Concepto :'
            . '<textarea class="form-control" id="textarea_as" name="textarea_as" rows="1" cols="30" disabled="disabled">' . $nombre_grupo . '</textarea></th>';
            echo '</tr>';
            echo '</table>';
            $n++;
        }

        echo '</table>';
        echo '</center>';
        mysqli_close($db);
    }

    function tot_val() {
        $conn = $this->conec_base();
        $year = date("Y");
        $rs = mysqli_query($conn, "SELECT MAX(idt_bl_inicial) AS id FROM t_bl_inicial");
        if ($row = mysqli_fetch_row($rs)) {
            $maxbalance = trim($row[0]);
        }

        $sql_totales = "SELECT e.year, e.`t_bl_inicial_idt_bl_inicial` AS balance, sum( e.`debe` ) AS d, sum( e.`haber` ) AS h FROM `libro` e WHERE e.`t_bl_inicial_idt_bl_inicial` = '" . $maxbalance . "' AND e.year = '" . $year . "' GROUP BY e.`t_bl_inicial_idt_bl_inicial` ";
        $sql_totalesbalance = "SELECT e.year,e.`t_bl_inicial_idt_bl_inicial` as balance, sum( e.`valor` ) as debe_b, sum( e.`valorp` ) as haber_b
        FROM `t_ejercicio` e where e.year='" . $year . "' and e.t_bl_inicial_idt_bl_inicial='" . $maxbalance . "' group by e.`t_bl_inicial_idt_bl_inicial`";
        $res_tot = mysqli_query($conn, $sql_totales) or die(mysqli_errno($conn));
        $res_totb = mysqli_query($conn, $sql_totalesbalance) or die(mysqli_errno($conn));
        $f_tot = mysqli_fetch_array($res_tot);
        $f_totb = mysqli_fetch_array($res_totb);

        $d = $f_tot['d'];
        $h = $f_tot['h'];

        $ta = $f_totb['debe_b'];
        $pp = $f_totb['haber_b'];

        $td = $d + $ta;
        $th = $h + $pp;
        ?>
        <table>
            <tr>
                <td><label>Total debe</label></td>
                <td><input readonly="readonly" style="text-align: right" type="text" id="totd" name="totd" placeholder="Tot. debe" value="<?php echo $td; ?>" required></td>
                <td><label>Total haber</label></td>
                <td><input readonly="readonly" style="text-align: right" type="text" id="toth" name="toth" placeholder="Tot. haber" value="<?php echo $th; ?>" required></td>
            </tr>
        </table>

        <a target="_blank" href="./impresiones/balanceimp.php?idlogeo=<?Php echo $idlogeo; ?>&ddetall=<?php echo $td ?>&hdetall=<?php echo $th ?> " class="btn btn-danger">Exportar a PDF</a>
        <?Php
        mysqli_close($conn);
    }

    function for_asientoini() {
        session_start();
        $c = $this->conec_base();
        $date = date("Y-m-j");
        $mes = date('F');
        $year = date("Y");
        $consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
        $query_bl = mysqli_query($c, $consul_bal_inicial);
        $row = mysqli_fetch_array($query_bl);
        $idcod = $row['contador'];
        $idcod_sig = $row['Siguiente'];
        $contador_de_asientosSQL = "select count(year)+1 as CON from num_asientos where `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "'";
        $query_contador = mysqli_query($c, $contador_de_asientosSQL);
        $row_cont = mysqli_fetch_array($query_contador);
        $contador_ass = $row_cont['CON'];

        $id_usuario = $_SESSION['username'];
        $consulta = "SELECT l.username, u.tipo_user, l.idlogeo FROM logeo l JOIN user_tipo u WHERE l.user_tipo_iduser_tipo = u.iduser_tipo AND l.username = '" . $id_usuario . "'";

        $resultado = mysqli_query($c, $consulta) or die(mysqli_errno($c));
        $fila = mysqli_fetch_array($resultado);
        $user = $fila['username'];
        $type_user = $fila['tipo_user'];
        $idlogeobl = $fila['idlogeo'];
        ?>
        <div id = "new_ejercicio">
            <form name = "form_ejercicio" id = "form_ejercicio" method = "post" action = "star_balance.php">
                <input name = "username" id = "username" type = "hidden" value = "<?php echo $_SESSION['username']; ?>"/>
                <input type = "hidden" class = "texto" name = "balances_realizados" id = "balances_realizados" value = "<?Php echo $idcod; ?>"/>
                <input type = "hidden" name = "id_asientourl" name = "id_asientourl" value = ""/>
                <input name = "idlogeobl" id = "idlogeobl" type = "hidden" value = "<?php echo $idlogeobl; ?>"
                       <fieldset>
                    <legend>
                        <center> <strong> Estado Inicial de la Empresa </strong> </center>
                    </legend>
                    <datalist id = "cuenta">
                        <?php
                        $query = "select * from t_plan_de_cuentas order by cod_cuenta";
                        $resul1 = mysqli_query($c, $query);
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
                        $query = "select * from t_plan_de_cuentas";
                        $resul1 = mysqli_query($c, $query);
                        while ($dato1 = mysqli_fetch_array($resul1)) {
                            $cod1 = $dato1['cod_cuenta'];
                            echo "<option value='" . $dato1['nombre_cuenta_plan'] . "' >";
                            echo $dato1['cod_cuenta'] . '      ' . $dato1['nombre_cuenta_plan'];
                            echo '</option>';
                        }
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
                                    alert(data);//carga_idasiento();//imprimir_balance();
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
                                                fcarg_gruponombre();" 
                                       onchange="cargando();" class="text" name="cod_cuenta" id="cod_cuenta"/>
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
                            <td align="center"><label class="form">De la fecha :</label>
                                <input type="text" id="fech" readonly="readonly" name="fech" style="text-align: center" value="<?php echo $date ?>"/></td>
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
                                $SQLtipobaldh = "SELECT * FROM tip_cuenta";
                                $query_tipo_bldh = mysqli_query($c, $SQLtipobaldh);
                                ?>
                                <select name="tip_cuentadh" id="tip_cuentadh" size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo();"><!--generar_codigo_grupo()-->
                                    <?php while ($arreglot_cuendh = mysqli_fetch_array($query_tipo_bldh)) { ?>
                                        <option class="text" value="<?php echo $arreglot_cuendh['idtip_cuenta']; ?>">
                                            <?php echo $arreglot_cuendh['tipo']; ?></option>     
                                        <?php
                                    }
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
        <?php
        mysqli_close($c);
    }

    function det_porcuenta() {
        session_start();
        $c = $this->conec_base();
        $year = date("Y");
        $consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
        $query_bl = mysqli_query($c, $consul_bal_inicial);
        $row = mysqli_fetch_array($query_bl);
        $idcod = $row['contador'];
        $idcod_sig = $row['Siguiente'];
        $sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
        $resul_param = mysqli_query($c, $sqlparametro);
        $dataparametro = mysqli_fetch_array($resul_param);
        $parametro_contador = $dataparametro['cont'];
        if ($parametro_contador == "") {
            echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
        }
        ?>
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
                    } else {
                        
                    }
                }
                ?>

                </tr>
            </table>
        </form>
        <?php
    }

    function mayorizacion() {
        session_start();
        $c = $this->conec_base();
        $year = date("Y");
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
        ?>
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
        <?php
    }

    function balance_res() {
        $date = date("Y-m-j");
        $year = date("Y");
        session_start();
        $conn = $this->conec_base();
        $sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
        $resul_param = $conn->query($sqlparametro);
        if ($resul_param->num_rows > 0) {
            while ($clase_param = $resul_param->fetch_assoc()) {
                $parametro_contador = $clase_param['cont'];
            }
        } else {
            echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
        }
        ?>
        <h1>Balance de Comprobaci&oacute;n</h1>
        <h3>Hasta la fecha <?php echo $date ?> del <?php echo $year ?></h3>
        <div style="float: left;" class="menu"> 
            <ul class="nav" id="nav">
                <li><a href="../templates/ModuloContable/ajustesasientos.php">Ajuste</a></li>
            </ul>
        </div>
        <?php
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
        mysqli_close($conn);
    }

    function totval_blres() {

        $year = date("Y");
        session_start();
        $c = $this->conec_base();
        $sqlparametro = " SELECT max( `idt_bl_inicial` ) AS cont FROM `t_bl_inicial`";
        $resul_param = $c->query($sqlparametro);
        if ($resul_param->num_rows > 0) {
            while ($clase_param = $resul_param->fetch_assoc()) {
                $parametro_contador = $clase_param['cont'];
            }
        } else {
            echo "<script>alert('Ocurrio un error al cargar un parametro...')</script>";
        }
        ?>
        <table>
            <tr>
                <?php
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
        <?php
    }

    function situacionfinal() {
        $date = date("Y-m-j");
        $year = date("Y");
        session_start();
        $c = $this->conec_base();
        ?>    
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
                                //redireccionar();
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
                $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
                $result = mysqli_query($c, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($c), E_USER_ERROR);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $maxbalancedato = $row['id'];
                    }
                }
                ?>
                <input type="hidden" value="<?php echo $maxbalancedato; ?>" id="texto"/>
                <?php
                $muestraboton = "SELECT `estado` FROM `t_bl_inicial` WHERE year='" . $year . "' and idt_bl_inicial='" . $maxbalancedato . "'";
                $res = mysqli_query($c, $muestraboton);
                while ($data = mysqli_fetch_array($res)) {
                    $estado = $data['estado'];
                    if ($data['estado'] == "1") {
                        ?>
                <label class="label-warning">El periodo debe cerrarlo el contador</label>
                        <!--<input type="button" name="cierrecontabilidad" onclick="cierredeperiodo();" id="cierrecontabilidad" class="btn" value="Cierre de Periodo"/>-->
                        <?php
                    } else {
                    echo    '<label class="label-warning">El periodo debe cerrarlo el contador</label>';
//                        echo "<input type='button' name='cierrecontabilidad' id='cierrecontabilidad' class='btn' disabled='true' value='Cierre de Periodo'/>";
                    }
                }
                ?>    
        <!--                                <input type="button" name="balanceactual" id="balanceactual" onclick="creartabla()" class="btn" value="Balance General Actual"/>-->
                <div class="mensaje"></div>
                <input type="hidden" value="<?php echo $estado; ?>"/>
                <?Php
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
        <?php
    }

    function detalleasiento($id_asientourl, $fechaurl) {
        $mes = date('F');
        $date = date("Y-m-j");
        $year = date("Y");
        session_start();
        $db = $this->conec_base();
        ?>
        <form id="form_ejercicio" >
            <center><strong>Detalle de Asiento</strong></center> 
            <?Php
            $consulta = "SELECT max( idt_bl_inicial ) as id FROM `t_bl_inicial`";
            $result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $maxbalancedato = $row['id'];     //echo "<script>alert('".$maxbalancedato."')</script>";
                }
            }
            $sqlsumresDH = " SELECT sum( j.debe ) AS d, sum( j.haber ) AS h
FROM libro j
JOIN num_asientos n
WHERE j.asiento = n.t_ejercicio_idt_corrientes
AND n.idnum_asientos =" . $id_asientourl . "
AND j.mes = '" . $mes . "'
AND j.t_bl_inicial_idt_bl_inicial = ' $maxbalancedato ' AND j.year = '" . $year . "' ";

            $resDH = mysqli_query($db, $sqlsumresDH);
            while ($row1 = mysqli_fetch_array($resDH)) {
                $ddetall = $row1['d'];  //echo "<script>alert(".$ddetall.")</script>";
                $hdetall = $row1['h'];
            }
            $sqlbuscagrupos = "SELECT n.`idnum_asientos` AS id, n.`t_ejercicio_idt_corrientes` as ej, n.`concepto` as c,
                                        concat( u.nombre,' ', u.apellido ) AS Empleado, s.tipo_user AS Cargo
FROM `num_asientos` n JOIN libro e JOIN logeo l JOIN usuario u JOIN user_tipo s
WHERE e.asiento = n.t_ejercicio_idt_corrientes AND e.fecha = n.fecha
AND e.logeo_idlogeo = l.user_tipo_iduser_tipo AND l.usuario_idusuario = u.idusuario
AND s.iduser_tipo = l.user_tipo_iduser_tipo
AND n.fecha = '" . $fechaurl . "'
AND n.idnum_asientos = '" . $id_asientourl . "' AND e.year='" . $year . "'
GROUP BY `t_ejercicio_idt_corrientes`";
            $result_grupo = mysqli_query($db, $sqlbuscagrupos) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($mysqli), E_USER_ERROR);
            echo '<center>';
            echo '<table style="padding:5px;background:#555;color:#fff;width: 960px;">';
            echo '<tr>';
            echo '<td style="display:none">id</td>';
            echo '<td>Fecha</td>';
            echo '<td>Codigo</td>';
            echo '<td>Cuenta</td>';
            echo '<td>Debe</td>';
            echo '<td>Haber</td>';
            echo '</tr>';

            while ($rw = mysqli_fetch_assoc($result_grupo)) {
                $idasiento = $rw['id'];
                $nombre_grupo = $rw['c'];
                $codgrupo = $rw['ej'];
                $emp = $rw['Empleado'];
                $crg = $rw['Cargo'];
                echo '<table id="tblDatos"  width="85%" class="table" style="padding:5px;width: 960px;">';
                echo '<tr><th colspan="5" > Registrado por : ' . $crg . ' - ' . $emp . '</th>  </tr>';
                echo '<tr><th colspan="5" style="text-align: center;vertical-align: middle;"> Ref : ' . $codgrupo;
//                echo '<a href="impresiones/impasiento.php?id_asientourl=' . $idasiento . '&fechaurl=' . $fechaurl . '&idlogeo=' . $idlogeous . '">'
//                . '<img src="./images/print.png" alt="Imprimir" title="Imprimir" /> </a>';
                echo '<th>';
                echo '</tr>';
                echo '<input name="valor" type="hidden" id="valor" value="';
                echo $codgrupo;
                echo '"/>';

                $n = 0;
                $sql_cuentasgrupos = "SELECT * FROM `libro` "
                        . "WHERE `t_bl_inicial_idt_bl_inicial` = ' $maxbalancedato ' AND `asiento` =" . $codgrupo . " AND year='" . $year . "' ORDER BY asiento";
                $result2 = mysqli_query($db, $sql_cuentasgrupos);      
                while ($r2 = mysqli_fetch_array($result2)) {
                    echo '<tr>';
                    echo '<td width="5%" style="display:none">  ' . $r2['idt_corrientes'] . '   </td>';
                    echo '<td width="15%">  ' . $r2['fecha'] . '   </td>';
                    echo '<td width="15%">  ' . $r2['cod_cuenta'] . '   </td>';
                    echo '<td width="35%">  ' . $r2['cuenta'] . '   </td>';
                    echo '<td width="10%">  ' . $r2['debe'] . '   </td>';
                    echo '<td width="10%">  ' . $r2['haber'] . '   </td>';
                    echo '</tr>';
                }
                echo '<tfoot>';
                echo '
                                    <td></td>
                                    <td></td>
                                    <td> <strong>Total :</strong> </td>
                                    <td>
                                        <input type="text"  readonly="readonly" class="compa3"
                                        name="camposumadebe" id="camposumadebe" value="' . $ddetall . '"/> 
                                    </td>
                                    <td>
                                        <input type="text"  readonly="readonly" class="compa3"
                                        name="camposumahaber" id="camposumahaber" value="' . $hdetall . '"/>
                                    </td>';
                echo '</tfoot>';
                echo '<tr>';
                echo '<th colspan="6" style="background-color: #ddd;"> Concepto :'
                . '<textarea class="form-control" id="textarea_as" name="textarea_as" rows="1" cols="30">' . $nombre_grupo . '</textarea></th>';
                //echo '' . $nombre_grupo . '';
                echo '</tr>';
                echo '</table>';
                $n++;
            }
            echo '</table>';
//            echo '<a target="_blank" href="./impresiones/balanceimp.php?idlogeo=' . $idlogeous . ''
//            . '&id_asientourl=' . $id_asientourl . '&fech_url=' . $fechaurl . ' " class="btn btn-danger">Exportar a PDF</a>';
            echo '</center>';
            ?>

        </form>
        <?Php
        mysqli_close($db);
    }

}
