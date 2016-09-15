<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="es"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="es"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="es"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="es"> <!--<![endif]-->
    <?php
    $date = date("Y-m-j");
    $servername = "localhost";
    $usernamedb = "root";
    $password = "alberto2791";
    $dbname = "condata";
    $conn = new mysqli($servername, $usernamedb, $password, $dbname);
    $sql = "SELECT count(*) as cont FROM `t_bl_inicial` WHERE fecha_balance='" . $date . "'";
    $sqlcua = "SELECT count(*) as contcuadre,count(*)+1 as sig FROM `cuad_balance`";
    $result = $conn->query($sql);
    $resultcuad = $conn->query($sqlcua);
    if ($result->num_rows > 0) {
        while ($clase = $result->fetch_assoc()) {
            $con = $clase['cont'];
        }
    } else {
        echo "<script>alert('No se selecciono el balance')</script>";
    }
    if ($resultcuad->num_rows > 0) {
        while ($clase = $resultcuad->fetch_assoc()) {
            $concuad = $clase['contcuadre'];
            $consig = $clase['sig'];
        }
    } else {
        echo "<script>alert('No se selecciono el balance')</script>";
    }
    //echo "<script>alert($con)</script>";    echo "<script>alert($concuad)</script>";    echo "<script>alert($consig)</script>";
    $conn->close();
    if (isset($_POST["submit"])) {
        $btntu = $_POST["submit"];
        if ($btntu == "Guardar Balance") {
            $date = date("Y-m-j");
            $conex = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
            mysql_select_db("condata", $conex) or die("ERROR con la base de datos");
            $sql_conculo = "SELECT SUM(valor) as TotalA FROM `t_ejercicio` WHERE fecha='" . $date . "' and tipo='1'";
            $sql_conculoAcno = "SELECT SUM(valor) as TotalAcno FROM `t_ejercicio` WHERE fecha='" . $date . "' and tipo='2'";
            $sql_conculoP = "SELECT SUM(valorp) as TotalP FROM `t_ejercicio` WHERE fecha='" . $date . "' and tipo='3'";
            $sql_conculoPno = "SELECT SUM(valorp) as TotalPno FROM `t_ejercicio` WHERE fecha='" . $date . "' and tipo='4'";
            $sql_conculoPat = "SELECT SUM(valorp) as TotalPat FROM `t_ejercicio` WHERE fecha='" . $date . "' and tipo='5'";
            $rescalculo = mysql_query($sql_conculo, $conex) or die(mysql_error());
            $rescalculoAcno = mysql_query($sql_conculoAcno, $conex) or die(mysql_error());
            $rescalculoP = mysql_query($sql_conculoP, $conex) or die(mysql_error());
            $rescalculoPno = mysql_query($sql_conculoPno, $conex) or die(mysql_error());
            $rescalculoPat = mysql_query($sql_conculoPat, $conex) or die(mysql_error());
            $fcl = mysql_fetch_array($rescalculo);
            $fclno = mysql_fetch_array($rescalculoAcno);
            $fclP = mysql_fetch_array($rescalculoP);
            $fclPno = mysql_fetch_array($rescalculoPno);
            $fclPat = mysql_fetch_array($rescalculoPat);
            $tot_act_corr = $fcl['TotalA'];
            $tot_actno_corr = $fclno['TotalAcno'];
            $tot_pasivos = $fclP['TotalP'];
            $tot_pasivosno_corr = $fclPno['TotalPno'];
            $tot_patrimonio = $fclPat['TotalPat'];
            $tot_activos = $tot_act_corr + $tot_actno_corr;
            $totalpasivos = $tot_pasivos + $tot_pasivosno_corr;
            $tot_pasivomaspatrimonio = $totalpasivos + $tot_patrimonio;
            mysql_close($conex);
            if ($tot_activos != $tot_pasivomaspatrimonio) {
                echo "<script>alert('Error... datos no cuadran')</script>";
            } elseif ($tot_activos == $tot_pasivomaspatrimonio) {
                //echo "<script>alert('Datos Cuadrados')</script>";
                require('../../../Clases/cliente.class.php');
                $concuadre = htmlspecialchars(trim($_POST['concuadre']));
                $balancefech = htmlspecialchars(trim($_POST['balancefech']));
                $tot_act_corr = htmlspecialchars(trim($_POST['tot_act_corr']));
                $tot_actno_corr = htmlspecialchars(trim($_POST['tot_actno_corr']));
                $tot_activos = htmlspecialchars(trim($_POST['tot_activos']));
                $tot_pasivos = htmlspecialchars(trim($_POST['tot_pasivos']));
                $tot_pasivosNo = htmlspecialchars(trim($_POST['tot_pasivosNo']));
                $totalpasivos = htmlspecialchars(trim($_POST['totalpasivos']));
                $tot_patNo = htmlspecialchars(trim($_POST['tot_patNo']));
                $tot_pp = htmlspecialchars(trim($_POST['tot_pp']));
                $bal = htmlspecialchars(trim($_POST['bal']));
                //echo "<script>alert($con)</script>";
                $objGrupo = new Clase;
                if ($objGrupo->insertarcuadredebalance(array(
                            $concuadre, $date, $tot_act_corr, $tot_actno_corr,
                            $tot_activos, $tot_pasivos, $tot_pasivosNo, $totalpasivos, $tot_patNo, $tot_pp, $con)) == true) {
                    echo '<script language = javascript>alert("Guardado con exito...")
self.location = "index_modulo_contable.php"</script>';
                } else {
                    echo '<script language = javascript>alert("Ocurrio un error, no se puede registrar el asiento...")</script>';
                }
            }
        }
    }
    ?>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios de Balance</title>
        <style>
            #a{float: left;}
            #b{float: left;} 
            .contenedor{margin:60px auto;width:960px;font-family:sans-serif;font-size:15px}
            table {width:100%;box-shadow:0 0 10px #ddd;text-align:left}
            table{overflow: auto;}
            th {padding:5px;background:#555;color:#fff}
            td {padding:5px;border:solid #ddd;border-width:0 0 1px;}
            .editable span{display:block;}
            .editable span:hover {background:url(../../../../images/edit.png) 90% 50% no-repeat;cursor:pointer}

            td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
            a.enlace{display:inline-block;width:24px;height:24px;margin:0 0 0 5px;overflow:hidden;text-indent:-999em;vertical-align:middle}
            .guardar{background:url(../../../../images/save.png) 0 0 no-repeat}
            .cancelar{background:url(../../../../images/cancell.png) 0 0 no-repeat}

            .mensaje{display:block;text-align:center;margin:0 0 20px 0}
            .ok{display:block;padding:10px;text-align:center;background:green;color:#fff}
            .ko{display:block;padding:10px;text-align:center;background:red;color:#fff}
        </style>
    </head>
    <body>
        <form id="fom_cuadrar_balance" action="tablasAcorrientes.php" method="POST" >
            <div class="contenedor">
                <!--form a-->                
                <input type="hidden" id="bal" name="bal" value="<?php echo $con; ?>"/>
                <label>balance :<?php echo $con ?></label>
                <input type="hidden" id="balancefech" value="<?php echo $date; ?>"/>
                <label>fecha :<?php echo $date; ?></label>
                <input type="hidden" id="concuadre" value="<?php echo $consig; ?>"/>
                <div id="a">
                    <h1>Activos Corrientes</h1>
                    <div class="mensaje"></div>
                    <table class="editinplaceA">
                        <tr>
                            <th style="display:none">Cod.</th>
                            <th>Ref</th>
                            <th>Cuenta</th>
                            <th>Valor</th>
                        </tr>
                    </table>   
                    <!--tot Activ Corr-->
                    <table>
                        <tr>
                            <td><label>Tot. de Activos Corrientes</label></td>
                            <td><input readonly="readonly" type="text" id="tot_act_corr" name="tot_act_corr" placeholder="Tot. Activos" value="<?php echo $tot_act_corr; ?>" required></td>
                        </tr>
                    </table>


                    <h1>Activos No Corrientes</h1>
                    <table class="editinplaceA2">
                        <tr>
                            <th style="display:none">Cod.</th>
                            <th>Ref</th>
                            <th>Cuenta</th>
                            <th>Valor</th>
                        </tr>
                    </table>   
                    <!--Tot Act No Corr-->
                    <table>
                        <tr>
                            <td><label>Tot. de Activos No Corrientes</label></td>
                            <td><input readonly="readonly" type="text" id="tot_actno_corr" name="tot_actno_corr" placeholder="Tot. Activos No Corr." value="<?php echo $tot_actno_corr; ?>" required></td>
                        </tr>
                    </table>
                    <!--Sum de Activos-->
                    <table>
                        <tr>
                            <td><label>TOTAL DE ACTIVOS</label></td>
                            <td><input readonly="readonly" type="text" id="tot_activos" name="tot_activos" placeholder="TOTAL DE ACTIVOS" value="<?php echo $tot_activos; ?>" required></td>
                        </tr>
                    </table>
                </div>
                <!--form b-->
                <div id="b">
                    <h1>Pasivos Corrientes</h1>
                    <center>
                        <div class="mensaje"></div>
                        <table class="editinplaceP">
                            <tr>
                                <th style="display:none">Cod.</th>
                                <th>Ref</th>
                                <th>Cuenta</th>
                                <th>Valor</th>
                            </tr>
                        </table> 
                        <!--Sum de Pasivos-->
                        <table>
                            <tr>
                                <td><label>Tot Pasivos Corrientes</label></td>
                                <td><input readonly="readonly" type="text" id="tot_pasivos" name="tot_pasivos" placeholder="Tot de Pasivos" value="<?php echo $tot_pasivos; ?>" required></td>
                            </tr>
                        </table>
                    </center>
                    <h1>Pasivos No Corrientes</h1>
                    <center>
                        <table class="editinplacePno">
                            <tr>
                                <th style="display:none">Cod.</th>
                                <th>Ref</th>
                                <th>Cuenta</th>
                                <th>Valor</th>
                            </tr>
                        </table>
                        <!--Sum de Pasivos no Corr-->
                        <table>
                            <tr>
                                <td><label>Tot Pasivos No Corrientes</label></td>
                                <td><input readonly="readonly" type="text" id="tot_pasivosNo" name="tot_pasivosNo" placeholder="Tot de Pasivos No Corrientes" value="<?php echo $tot_pasivosno_corr; ?>" required></td>
                            </tr>
                            <tr>
                                <td><label>TOTAL DE PASIVOS</label></td>
                                <td><input readonly="readonly" type="text" id="totalpasivos" name="totalpasivos" placeholder="Tot de pasivos" value="<?php echo $totalpasivos; ?>" required></td>
                            </tr>
                        </table>
                    </center>
                    <h1>Patrimonio</h1>
                    <center>
                        <table class="editinplacePa">
                            <tr>
                                <th style="display:none">Cod.</th>
                                <th>Ref</th>
                                <th>Cuenta</th>
                                <th>Valor</th>
                            </tr>
                        </table>
                        <!--Sum de Patrimonios-->
                        <table>
                            <tr>
                                <td><label>TOTAL DE PATRIMONIO</label></td>
                                <td><input readonly="readonly" type="text" id="tot_patNo" name="tot_patNo" placeholder="Tot de Patrimonio" value="<?php echo $tot_patrimonio; ?>" required="required"></td>
                            </tr>
                        </table>
                    </center>
                    <center>
                        <!--total de pasivos mas patrimonio-->
                        <table>
                            <tr>
                                <td><label>TOTAL PASIVOS + PATRIMONIO</label></td>
                                <td><input readonly="readonly" type="text" id="tot_pp" name="tot_pp" placeholder="Pasivo + Parimonio" value="<?php echo $tot_pasivomaspatrimonio; ?>" required="required"></td>
                            </tr>
                        </table>
                    </center>
                    <center>
                        <table>
                            <tr>
                                <td>
                                    <input name="submit" id="submit" type="submit" value="Guardar Balance"/>
                                </td>
                            </tr>
                        </table>
                    </center>
                </div>
            </div>

            <script type="text/javascript" src="jquery-1.10.2.min.js"></script>
            <script>
                $(document).ready(function ()
                {
                    /* OBTENEMOS TABLA */
                    $.ajax({
                        type: "GET",
                        url: "editinplaceActivos.php?tabla=1"
                    })
                            .done(function (json) {
                                json = $.parseJSON(json)
                                for (var i = 0; i < json.length; i++)
                                {
                                    $('.editinplaceA').append(
                                            "<tr><td class='id' style='display:none'>" + json[i].ids +
                                            "</span></td><td class='editable' data-campo='cod_cuenta'><span>" + json[i].cod_cuenta +
                                            "</span></td><td class='editable' data-campo='cuenta'><span>" + json[i].cuenta +
                                            "</span></td><td class='editable' data-campo='valor'><span>" + json[i].valor +
                                            "</span></td></tr>");
                                }
                            });

                    var td, campo, valor, id;
                    $(document).on("click", "td.editable span", function (e)
                    {
                        e.preventDefault();
                        $("td:not(.id)").removeClass("editable");
                        td = $(this).closest("td");
                        campo = $(this).closest("td").data("campo");
                        valor = $(this).text();
                        id = $(this).closest("tr").find(".id").text();
                        td.text("").html("<input type='text' name='" + campo + "' value='" + valor + "'><a class='enlace guardar' href='#'>Guardar</a><a class='enlace cancelar' href='#'>Cancelar</a>");
                    });

                    $(document).on("click", ".cancelar", function (e)
                    {
                        e.preventDefault();
                        td.html("<span>" + valor + "</span>");
                        $("td:not(.id)").addClass("editable");
                    });

                    $(document).on("click", ".guardar", function (e)
                    {
                        $(".mensaje").html("<img src='../../../../images/loading.gif'>");
                        e.preventDefault();
                        nuevovalor = $(this).closest("td").find("input").val();
                        if (nuevovalor.trim() != "")
                        {
                            $.ajax({
                                type: "POST",
                                url: "editinplaceActivos.php",
                                data: {campo: campo, valor: nuevovalor, id: id}
                            })
                                    .done(function (msg) {
                                        $(".mensaje").html(msg);
                                        td.html("<span>" + nuevovalor + "</span>");
                                        $("td:not(.id)").addClass("editable");
                                        setTimeout(function () {
                                            $('.ok,.ko').fadeOut('fast');
                                        }, 3000);
                                    });
                        }
                        else
                            $(".mensaje").html("<p class='ko'>Debes ingresar un valor</p>");
                    });
                });

            </script>	
            <!--actinos no corrientes-->
            <script>
                $(document).ready(function ()
                {
                    /* OBTENEMOS TABLA */
                    $.ajax({
                        type: "GET",
                        url: "editinplaceActivosNo.php?tabla=1"
                    })
                            .done(function (json) {
                                json = $.parseJSON(json)
                                for (var i = 0; i < json.length; i++)
                                {
                                    $('.editinplaceA2').append(
                                            "<tr><td class='id' style='display:none'>" + json[i].ids +
                                            "</span></td><td class='editable' data-campo='cod_cuenta'><span>" + json[i].cod_cuenta +
                                            "</span></td><td class='editable' data-campo='cuenta'><span>" + json[i].cuenta +
                                            "</span></td><td class='editable' data-campo='valor'><span>" + json[i].valor +
                                            "</span></td></tr>");
                                }
                            });


                });
                $(document).ready(function ()
                {
                    /* OBTENEMOS TABLA */
                    $.ajax({
                        type: "GET",
                        url: "editinplacePasivos.php?tabla=1"
                    })
                            .done(function (json) {
                                json = $.parseJSON(json)
                                for (var i = 0; i < json.length; i++)
                                {
                                    $('.editinplaceP').append(
                                            "<tr><td class='id' style='display:none'>" + json[i].ids +
                                            "</span></td><td class='editable' data-campo='cod_cuenta'><span>" + json[i].cod_cuenta +
                                            "</span></td><td class='editable' data-campo='cuenta'><span>" + json[i].cuenta +
                                            "</span></td><td class='editable' data-campo='valorp'><span>" + json[i].valorp +
                                            "</span></td></tr>");
                                }
                            });


                });
                $(document).ready(function ()
                {
                    /* OBTENEMOS TABLA */
                    $.ajax({
                        type: "GET",
                        url: "editinplacePasivosNo.php?tabla=1"
                    })
                            .done(function (json) {
                                json = $.parseJSON(json)
                                for (var i = 0; i < json.length; i++)
                                {
                                    $('.editinplacePno').append(
                                            "<tr><td class='id' style='display:none'>" + json[i].ids +
                                            "</span></td><td class='editable' data-campo='cod_cuenta'><span>" + json[i].cod_cuenta +
                                            "</span></td><td class='editable' data-campo='cuenta'><span>" + json[i].cuenta +
                                            "</span></td><td class='editable' data-campo='valorp'><span>" + json[i].valorp +
                                            "</span></td></tr>");
                                }
                            });


                });
                $(document).ready(function ()
                {
                    /* OBTENEMOS TABLA */
                    $.ajax({
                        type: "GET",
                        url: "editinplacePatrimonios.php?tabla=1"
                    })
                            .done(function (json) {
                                json = $.parseJSON(json)
                                for (var i = 0; i < json.length; i++)
                                {
                                    $('.editinplacePa').append(
                                            "<tr><td class='id' style='display:none'>" + json[i].ids +
                                            "</span></td><td class='editable' data-campo='cod_cuenta'><span>" + json[i].cod_cuenta +
                                            "</span></td><td class='editable' data-campo='cuenta'><span>" + json[i].cuenta +
                                            "</span></td><td class='editable' data-campo='valorp'><span>" + json[i].valorp +
                                            "</span></td></tr>");
                                }
                            });


                });

            </script>	

        </form>
        <form action="star_balance.php">
            <input type="submit" name="regresar" value="Volver"/>
        </form>



    </body>
</html>