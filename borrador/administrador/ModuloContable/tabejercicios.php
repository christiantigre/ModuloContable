<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="es"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="es"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="es"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="es"> <!--<![endif]-->
    <?php
    $date = date("Y-m-j");
    $mes = date('F');
    $year = date("Y");
    $servername = "localhost";
    $usernamedb = "root";
    $password = "alberto2791";
    $dbname = "condata";
    $conn = new mysqli($servername, $usernamedb, $password, $dbname);
    $sql = "SELECT count(*) as cont FROM `t_bl_inicial`";
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
    $sql_versuma = " SELECT SUM( valor ) AS Totd, SUM( valorp ) AS Toth FROM `t_ejercicio`
WHERE t_bl_inicial_idt_bl_inicial = '" . $con . "' and mes='".$mes."' and year='".$year."' ";
    $resultsm = $conn->query($sql_versuma);
    if ($resultsm->num_rows > 0) {
        while ($clasesm = $resultsm->fetch_assoc()) {
            $totd = $clasesm['Totd'];
            $toth = $clasesm['Toth'];
        }
    } else {
        echo "<script>alert('No se puede ver los valores, consulte con su desarrollador')</script>";
    }
    //echo "<script>alert($con)</script>";    echo "<script>alert($concuad)</script>";    echo "<script>alert($consig)</script>";
    $conn->close();
    if (isset($_POST["submit"])) {
        $btntu = $_POST["submit"];
        if ($btntu == "Guardar Balance") {
            $conn = new mysqli($servername, $usernamedb, $password, $dbname);
            $sql_versumaseg = " SELECT SUM( valor ) AS Totd, SUM( valorp ) AS Toth FROM `t_ejercicio`
WHERE t_bl_inicial_idt_bl_inicial = '" . $con . "' and mes='".$mes."' and year='".$year."' ";
            $resultsmseg = $conn->query($sql_versumaseg);
            if ($resultsmseg->num_rows > 0) {
                while ($clasesms = $resultsmseg->fetch_assoc()) {
                    $totd = $clasesms['Totd'];
                    $toth = $clasesms['Toth'];
                }
            }
            $totd = $_POST['totd'];
            $toth = $_POST['toth'];
            if ($totd != $toth) {
                echo "<script>alert('Error... datos no cuadran')</script>";
            } elseif ($totd == $toth) {
                //echo "<script>alert('Datos Cuadrados')</script>";
                require('../../../Clases/cliente.class.php');
                $bal = htmlspecialchars(trim($_POST['bal']));
                //echo "<script>alert($con)</script>";
                $objGrupo = new Clase;
                if ($objGrupo->insertarresultadobalance(array($totd, $toth, $bal)) == true) {
                    echo '<script language = javascript>alert("Guardado con exito...")
self.location = "index_modulo_contable.php"</script>';
                } else {
                    echo '<script language = javascript>alert("Ocurrio un error, no se puede registrar el asiento...")</script>';
                }
            }
        }
        if ($btntu == "=") {
            $servername = "localhost";
            $usernamedb = "root";
            $password = "alberto2791";
            $dbname = "condata";
            $conn = new mysqli($servername, $usernamedb, $password, $dbname);
            $sql_versumaAc = " SELECT SUM( valor ) AS Totd, SUM( valorp ) AS Toth FROM `t_ejercicio`
WHERE t_bl_inicial_idt_bl_inicial = '" . $con . "' ";
            $resultsmAc = $conn->query($sql_versumaAc);
            if ($resultsmAc->num_rows > 0) {
                while ($clasesmAc = $resultsmAc->fetch_assoc()) {
                    $totd = $clasesmAc['Totd'];
                    $toth = $clasesmAc['Toth'];
                }
            } else {
                echo "<script>alert('No se puede ver los valores, consulte con su desarrollador')</script>";
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
            .borrar{background:url(../../../../images/cancell.png) 0 0 no-repeat}

            .mensaje{display:block;text-align:center;margin:0 0 20px 0}
            .ok{display:block;padding:10px;text-align:center;background:green;color:#fff}
            .ko{display:block;padding:10px;text-align:center;background:red;color:#fff}
        </style>
    </head>
    <body>
        <form id="fom_cuadrar_balance" action="tabejercicios.php" method="POST" >
            <div class="contenedor">
                <!--form a-->                
                <input type="hidden" id="bal" name="bal" value="<?php echo $con; ?>"/>
                <label>balance :<?php echo $con ?></label>
                <input type="hidden" id="balancefech" value="<?php echo $date; ?>"/>
                <label>Fecha :<?php echo $date; ?></label>
                <input type="hidden" id="concuadre" value="<?php echo $consig; ?>"/>

                <!--tabla de ejercicios de Balance Inicial-->

                <h1>Ejercicios Realizados</h1>
                <div class="mensaje"></div>
                <table class="editinplaceA">
                    <tr>
                        <th style="display:none">Cod.</th>
                        <th>Ejercicio</th>
                        <th>Fecha</th>
                        <th>Ref</th>
                        <th>Cuenta</th>
                        <th>Debe</th>
                        <th>Haber</th>
                    </tr>
                </table>   

                <table>
                    <tr>
                        <td><label>Total debe</label></td>
                        <td><input readonly="readonly" type="text" id="totd" name="totd" placeholder="Tot. debe" value="<?php echo $totd; ?>" required="required"></td>
                        <td><label>Total haber</label></td>
                        <td><input readonly="readonly" type="text" id="toth" name="toth" placeholder="Tot. haber" value="<?php echo $toth; ?>" required="required"></td>
                        <td><input type="submit" name="submit" id="submit" value="="/> </td>
                        <td><input type="submit" name="submit" id="submit" value="Guardar Balance"/> </td>
                    </tr>
                    <tr><td><a href="detalledebalance.php" ><img src="../../../../images/details.png" title="Detalle de Balance" alt="Detalle de Balance"/></a></td></tr>
                </table>

                <div id="a">

                </div>
                <!--form b-->
                <div id="b">


                </div>
            </div>

            <script type="text/javascript" src="jquery-1.10.2.min.js"></script>
            <script>
                $(document).ready(function ()
                {
                    /* OBTENEMOS TABLA */
                    $.ajax({
                        type: "GET",
                        url: "editinplacebini.php?tabla=1"
                    })
                            .done(function (json) {
                                json = $.parseJSON(json)
                                for (var i = 0; i < json.length; i++)
                                {
                                    $('.editinplaceA').append(
                                            "<tr><td class='id' style='display:none'>" + json[i].ids +
                                            "</span></td><td ><span>" + json[i].ejercicio +
                                            "</span></td><td ><span>" + json[i].fecha +
                                            "</span></td><td ><span>" + json[i].cod_cuenta +
                                            "</span></td><td class='noeditable'><span>" + json[i].cuenta +
                                            "</span></td><td class='noeditable' data-campo='valor'><span>" + json[i].valor +
                                            "</span></td><td class='noeditable' data-campo='valorp'><span>" + json[i].valorp +
                                            "</span></td><td class='borrar' style='display:none' ><span>" + ' ' +
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

                    $(document).on("click", ".borrar", function (e)
                    {
                        var answer = confirm("Deseas eliminar este registro?...La eliminacion de este registro podria alterar la contabilidad actual, es responsabilidad...")
                        if (answer) {
                            $(".mensaje").html("<img src='../../../../images/loading.gif'>");
                            id = $(this).closest("tr").find(".id").text();
                            //alert(id);
                            $.ajax({
                                type: "POST",
                                url: "eliminar.php",
                                data: {id: id}
                            })
                                    .done(function (msg) {
                                        $(".mensaje").html(msg);
                                        td.html("<span>" + id + "</span>");
                                        $("td:not(.id)").addClass("borrar");
                                        setTimeout(function () {
                                            $('.ok,.ko').fadeOut('fast');
                                        }, 3000);
                                    });

                        } else
                        {

                        }

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
                                url: "editinplacebini.php",
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
        <form action="star_balance.php">
            <input type="submit" name="regresar" value="Volver"/>
        </form>



    </body>
</html>