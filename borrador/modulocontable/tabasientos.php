<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="es"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="es"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="es"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="es"> <!--<![endif]-->
    <?php
    if (isset($_POST["submit"])) {
        $btntu = $_POST["submit"];
        // echo "<script>alert('boton enviar');</script>";
        if ($btntu == "Guardar Asientos") {
            $conex = mysql_connect("localhost", "root", "alberto2791") or die("No se pudo realizar la conexion");
            mysql_select_db("condata", $conex) or die("ERROR con la base de datos");
            $sql_maxbalance = "SELECT MAX(t_bl_inicial_idt_bl_inicial) AS id FROM libro";
            $res_max = mysql_query($sql_maxbalance, $conex) or die(mysql_error());
            $f_max = mysql_fetch_array($res_max);
            $ex_balan = $f_max['id'];

            $sql_inclibro = "SELECT COUNT(*)+1 AS cont FROM res_librodiario";
            $res_inc = mysql_query($sql_inclibro, $conex) or die(mysql_error());
            $f_inc = mysql_fetch_array($res_inc);
            $ex_inc = $f_inc['cont'];

            $sql_conculod = "SELECT SUM(debe) as Totd FROM `libro` WHERE t_bl_inicial_idt_bl_inicial = '" . $ex_balan . "' ";
            $sql_conculoh = "SELECT SUM(haber) as Toth FROM `libro` WHERE t_bl_inicial_idt_bl_inicial = '" . $ex_balan . "' ";
            $res_cld = mysql_query($sql_conculod, $conex) or die(mysql_error());
            $res_clh = mysql_query($sql_conculoh, $conex) or die(mysql_error());
            $f_colde = mysql_fetch_array($res_cld);
            $f_colha = mysql_fetch_array($res_clh);
            $totdebe = $f_colde['Totd'];
            $tothaber = $f_colha['Toth'];
            mysql_close($conex);
            if ($totdebe != $tothaber) {
                echo "<script>alert('Error... datos no cuadran')</script>";
            } elseif ($totdebe == $tothaber) {
                require('../../../Clases/cliente.class.php');
                $tot_debe = htmlspecialchars(trim($_POST['totd']));
                $tot_haber = htmlspecialchars(trim($_POST['toth']));
                $objGrupo = new Clase;
                if ($objGrupo->insertarreslibro(array($ex_inc, $tot_debe, $tot_haber, $ex_balan)) == true) {
                    echo '<script language = javascript>alert("Guardado con exito...")
self.location = "index_modulo_contable.php"</script>';
                } else {
                    //echo '<script language = javascript>alert("Ocurrio un error, no se puede registrar el asiento...")</script>';
                    if ($objGrupo->Updatoreslibro(array($ex_inc,$tot_debe,$tot_haber),$ex_balan) == true) {
                        echo '<script language = javascript>alert("Ya existia un ingreso de este libro, se procedio a atualizar datos...")
self.location = "index_modulo_contable.php"</script>';
                    }
                }
            }
        }
    }
    ?>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios de Balance</title>
        <style>
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
        <form id="fom_cuadrar_balance" action="tabasientos.php" method="POST">
            <div class="contenedor">
                <center>
                    <span id="refrescar"><a href="tabasientos.php"><img src="../../../../images/update.png" alt="Actualizar" title="Actualizar"/></a></span>
                    <h1>Registro de asientos</h1>
                    <div class="mensaje"></div>
                    <table class="editinplace">
                        <tr>
                            <th style="display:none">Cod.</th>
                            <th>Fecha</th>
                            <th>Asiento</th>
                            <th>Codigo</th>
                            <th>Cuenta</th>
                            <th>Debe</th>
                            <th>Haber</th>
                        </tr>
                    </table>               

                    <table>
                        <tr>
                            <td><label>Total debe</label></td>
                            <td><input readonly="readonly" type="text" id="totd" name="totd" placeholder="Tot. debe" value="<?php echo $totdebe; ?>" required></td>
                            <td><label>Total haber</label></td>
                            <td><input readonly="readonly" type="text" id="toth" name="toth" placeholder="Tot. haber" value="<?php echo $tothaber; ?>" required></td>
                        </tr>
                    </table>

                </center>
                <center>
                    <table>
                        <tr>
                            <td>
                                <input name="submit" id="submit" type="submit" value="Guardar Asientos"/>
                            </td>
                        </tr>
                    </table>
                </center>
            </div>

            <script type="text/javascript" src="jquery-1.10.2.min.js"></script>
            <script>
                $(document).ready(function ()
                {
                    /* OBTENEMOS TABLA */
                    $.ajax({
                        type: "GET",
                        url: "editinplacelibro.php?tabla=1"
                    })
                            .done(function (json) {
                                json = $.parseJSON(json)
                                for (var i = 0; i < json.length; i++)
                                {
                                    $('.editinplace').append(
                                            "<tr><td class='id' style='display:none'>" + json[i].ids +
                                            "</span></td><td ><span>" + json[i].fecha +
                                            "</span></td><td ><span>" + json[i].asiento +
                                            "</span></td><td ><span>" + json[i].ref +
                                            "</span></td><td ><span>" + json[i].cuenta +
                                            "</span></td><td class='editable' data-campo='debe'><span>" + json[i].debe +
                                            "</span></td><td class='editable' data-campo='haber'><span>" + json[i].haber +
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
                                url: "editinplacelibro.php",
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
        </form>
        <form action="Bl_inicial.php">
            <input type="submit" name="regresar" value="Volver"/>
        </form>




    </body>
</html>