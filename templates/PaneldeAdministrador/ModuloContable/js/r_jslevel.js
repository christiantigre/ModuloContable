/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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
$(document).ready(function () {
    document.oncontextmenu = function () {
        return false;
    }
});

function validar(campo) {
    var elcampo = document.getElementById(campo);
    if ((!validarNumero(elcampo.value)) || (elcampo.value == "")) {
        elcampo.value = "";
        elcampo.focus();
        newAlert("success", "        No es un valor numerico!!!");
//        document.getElementById('mensaje').innerHTML = 'Debe ingresar un número';
//        $('#mensaje').hide();

    } else {
        document.getElementById('mensaje').innerHTML = '';
    }
}


function newAlert(type, message) {
    $("#alert-area").append($("<div class='alert-message " + type + " fade in' data-alert><p> " + message + " </p></div>"));
    $(".alert-message").delay(3000).fadeOut("slow", function () {
        $(this).remove();
    });
}


function rr_compr_evento_level() {
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

    if (counter > 1) {
        var miVariableJS = $("#cod_cuenta").val();
        $.post("./r_scriptsPHP/archivo.php", {"texto": miVariableJS, "campo": "cod_cuenta"},
        function (respuesta) {
            var elem = respuesta.split('_');
            var1 = elem[0];
            var2 = elem[1];
            var3 = elem[2];
            document.getElementById('nom_cuenta').value = var1;
            document.getElementById('cod_cuenta').value = var2;
            document.getElementById('cod_grupo').value = var3;
            r_fcarg_grupo_level(var3);
        });
    } else {
        var miVariableJS = $("#cod_cuenta").val();
        $.post("./r_scriptsPHP/archivo.php", {"texto": miVariableJS, "campo": "nombre_cuenta_plan"},
        function (respuesta) {
            var elem = respuesta.split('_');
            var1 = elem[0];
            var2 = elem[1];
            var3 = elem[2];
            document.getElementById('nom_cuenta').value = var1;
            document.getElementById('cod_cuenta').value = var2;
            document.getElementById('cod_grupo').value = var3;
            r_fcarg_grupo_level(var3);
        });
    }

    function r_fcarg_grupo_level(var3)
    {
        $.post("./r_scriptsPHP/archivogruponom.php", {"texto": var3},
        function (respuestag) {
            document.getElementById('nom_grupo').value = respuestag;
        });
    }


}

function addasiento_level() {
    var datocodigo = document.getElementById("nom_grupo").value;
    var datetimepicker1 = document.getElementById("datetimepicker1").value;
    var valor_val = $("#valor").val();
    if (valor_val == "0.00") {
        alert("Ingrese un monto valido :" + valor_val);
        newAlert("danger", "        El monto que ingreso debe ser mayor a 0.00 $ !!!");
    } else {
        if (datetimepicker1 == "") {

        } else {
            if (datocodigo == "")
            {
                alert("Falta un dato muy importante");
            } else {
                var seleccion = document.getElementById("tip_cuentadh").value;
                //alert(num.value);
                if (seleccion == 1) {
                    var mes = $("#mes").val();
                    var cod_cuenta = $("#cod_cuenta").val();
                    var nom_cuenta = $("#nom_cuenta").val();
                    var valor = $("#valor").val();
                    var asiento_num = $("#asiento_num").val();
//                    var fech = $("#datetimepicker1").val();
                    var fech = $("#fecha_hidden").val();
                    var cod_grupo = $("#cod_grupo").val();
                    var idlog = $("#idlog").val();
                    var balances_realizados = $("#balances_realizados").val();
                    var tablaDatos = $("#tblDatos");
                    var gene_dh = "0.00";
                    //alert("1");
                    //v¿bootstrap <button class='btn btn-danger btn-sm' onclick='deleteRow(this)'><i class='glyphicon glyphicon-minus' ></i></button>
//               original <input type='button' value='x' class='btn btn-danger btn-sm' onclick='deleteRow(this)'></input>
                    if (cod_cuenta != "" || nom_cuenta != "" || valor != "" || fech != "" || cod_grupo != "") {
                        tablaDatos.append("<tr id='datos'>\n\
<td style='display:none'>><input type='text' readonly='readonly' name='campo1[]' class='compa2' value=' " + asiento_num + "'/></td>\n\
<td>" + cod_cuenta + "<input type='hidden' readonly='readonly' name='campo2[]' class='compa3' value='" + cod_cuenta + "'/></td>\n\
<td>" + nom_cuenta + "<input type='hidden' readonly='readonly' name='campo3[]' value='" + nom_cuenta + "'/></td>\n\
<td>" + fech + "<input type='hidden' readonly='readonly' name='campo4[]' class='compa2' value='" + fech + "'/></td>\n\
<td>" + valor + "<input type='hidden' readonly='readonly' name='campo5[]' class='compa2' value='" + valor + "'/></td>\n\
<td>" + gene_dh + " <input type='hidden' readonly='readonly' name='campo6[]' class='compa2' value='" + gene_dh + "'/></td>\n\
<td style='display:none'>><input type='text'  readonly='readonly' class='compa3' name='campo7[]' value='" + balances_realizados + "'/></td>\n\
<td style='display:none'>><input type='text'  readonly='readonly' class='compa3' name='campo8[]' value='" + cod_grupo + "'/></td>\n\
<td style='display:none'>><input type='text'  readonly='readonly' class='compa3' name='campo9[]' value='" + idlog + "'/></td><td>\n\
<button class='btn btn-danger btn-sm' onclick='deleteRow(this)'><i class='glyphicon glyphicon-minus' ></i></button></td>\n\\n\
<td style='display:none'>" + mes + "<input type='hidden' readonly='readonly' name='campo10[]' class='compa3' value='" + mes + "'/></td>\n\
</tr>");
                        reset_campos();
                        SumarColumnaAsientos('tblDatos', 4);
                        SumarColumnaAsientosh('tblDatos', 5);
                        newAlert("success", "        Agrego / " + nom_cuenta + " / con valor debe " + valor);
                        $('#datetimepicker1').attr("readonly", true);
                    }
                }
                else {
                    var mes = $("#mes").val();
                    var cod_cuenta = $("#cod_cuenta").val();
                    var nom_cuenta = $("#nom_cuenta").val();
                    var valor = $("#valor").val();
                    var asiento_num = $("#asiento_num").val();
//                    var fech = $("#datetimepicker1").val();
                    var fech = $("#fecha_hidden").val();
                    var cod_grupo = $("#cod_grupo").val();
                    var idlog = $("#idlog").val();
                    var balances_realizados = $("#balances_realizados").val();
                    var tablaDatos = $("#tblDatos");
                    var gene_dh = "0.00";
                    //alert("2");
                    if (cod_cuenta != "" || nom_cuenta != "" || valor != "" || fech != "" || cod_grupo != "") {
                        tablaDatos.append("<tr id='datos'>\n\
<td style='display:none'>><input type='text' readonly='readonly' name='campo1[]' class='compa2' value=' " + asiento_num + "'/></td>\n\
<td>" + cod_cuenta + "<input type='hidden' readonly='readonly' name='campo2[]' class='compa3' value='" + cod_cuenta + "'/></td>\n\
<td>" + nom_cuenta + "<input type='hidden' readonly='readonly' name='campo3[]' value='" + nom_cuenta + "'/></td>\n\
<td>" + fech + "<input type='hidden' readonly='readonly' name='campo4[]' class='compa2' value='" + fech + "'/></td>\n\
<td>" + gene_dh + "<input type='hidden' readonly='readonly' name='campo5[]' class='compa2' value='" + gene_dh + "'/></td>\n\
<td>" + valor + " <input type='hidden' readonly='readonly' name='campo6[]' class='compa2' value='" + valor + "'/></td>\n\
<td style='display:none'>><input type='text'  readonly='readonly' class='compa3' name='campo7[]' value='" + balances_realizados + "'/></td>\n\
<td style='display:none'>><input type='text'  readonly='readonly' class='compa3' name='campo8[]' value='" + cod_grupo + "'/></td>\n\
<td style='display:none'>><input type='text'  readonly='readonly' class='compa3' name='campo9[]' value='" + idlog + "'/></td><td>\n\
<button class='btn btn-danger btn-sm' onclick='deleteRow(this)'><i class='glyphicon glyphicon-minus' ></i></button></td>\n\
<td style='display:none'>" + mes + "<input type='hidden' readonly='readonly' name='campo10[]' class='compa3' value='" + mes + "'/></td>\n\
</tr>");
                        reset_campos();
                        SumarColumnaAsientos('tblDatos', 4);
                        SumarColumnaAsientosh('tblDatos', 5);
                        newAlert("success", "        Agrego / " + nom_cuenta + " / con valor haber " + valor);
                        $('#datetimepicker1').attr("readonly", true);
                    }
                }
            }
        }
    }
}

function rr_reset_form()
{
    var answer = confirm("Deseas cancelar la edición?");
    if (answer) {
        window.location = '../indexadmin.php';
        newAlert("success", "        Transacción cancelada !!!");
    } else {
        newAlert("success", "        Puede continuar con la transacción");
    }
}
function reset_buscar()
{
    var answer = confirm("Deseas cancelar la busqueda?");
    if (answer) {
        window.location = '../ModuloContable/cont_op.php';
        newAlert("success", "        Operación cancelada !!!");
    } else {
        newAlert("success", "        Puede continuar con la busqueda");
    }
}

function guardaas_level()
{
    var camposumadebe = $("#camposumadebe").val();
    var camposumahaber = $("#camposumahaber").val();
    var asiento = $("#asiento_num").val();
    if (camposumadebe != camposumahaber)
    {
        alert("Error!!!...El balance no esta cuadrado correctamente, No se puede guardar!!!");
        newAlert("success", "Los valores DEBE /" + camposumadebe + "/ y HABER /" + camposumahaber + "/ deben ser igualados");
        $('#form_ejercicio').submit(function (msg) {
            return false;
        });
    } else
    {
        aux_save_level();
    }
}

function aux_save_level()
{
    $('#form_ejercicio').submit(function (msg) {
        $.post("./scriptsPHP/guardaasientoslevel.php", $(this).serialize(), function (data) {
            alert(data);
            newAlert("success", " " + data);
            $("#textarea_as").attr("value", "");
            $("#camposumadebe").attr("value", "");
            $("#camposumahaber").attr("value", "");
            window.location = '../../indexadmin.php';
        });
        return false;
    });
}


function rr_guardaas_level_as()
{
    var camposumadebe = $("#camposumadebe").val();
    if (camposumadebe == "") {
        $('#form_ejercicio').submit(function (msg) {
            return false;
        });
    } else {

        var camposumadebe = $("#camposumadebe").val();
        var camposumahaber = $("#camposumahaber").val();
        var asiento = $("#asiento_num").val();
        if (camposumadebe != camposumahaber)
        {
            alert("Error!!!...La transaccion debe ser cuadrada, No se puede guardar!!!");
            newAlert("success", "Los valores DEBE /" + camposumadebe + "/ y HABER /" + camposumahaber + "/ deben ser igualados");
            $('#form_ejercicio').submit(function (msg) {
                return false;
            });
        } else
        {
            rr_aux_save_level_as();
        }
    }
}
function rr_guardaas_level_asini()
{
    var datetimepicker1 = $("#datetimepicker1").val();
    if (datetimepicker1 == "") {
        alert("[Error]... Ingrese la fecha");
        newAlert("success", "Debe ingresar la fecha, campo obligatório");
    } else {
        var answer = confirm("Esta seguro que desea editar el asiento contable?");
        if (answer) {
            var camposumadebe = $("#camposumadebet").val();
            var camposumahaber = $("#camposumahabert").val();
            var asiento = $("#asiento_numt").val();
            if (camposumadebe != camposumahaber)
            {
                alert("Error!!!...La transaccion debe ser cuadrada, No se puede guardar!!!");
                newAlert("success", "Los valores DEBE /" + camposumadebe + "/ y HABER /" + camposumahaber + "/ deben ser igualados");
                $('#form').submit(function (msg) {
                    return false;
                });
//        }
            } else
            {
                rr_aux_save_level_asini();
            }
        } else {
            $('#form').submit(function (msg) {
                return false;
            });
        }
    }
}
function rr_aux_save_level_asini()
{
    $('#form').submit(function (msg) {
        $.post("./r_scriptsPHP/scriptupdata_ej.php", $(this).serialize(), function (data) {
            alert(data);
            newAlert("success", " " + data);
            $("#textarea_as").attr("value", "");
            $("#camposumadebet").attr("value", "");
            $("#camposumahabert").attr("value", "");
            var answer = confirm("Desea imprimir el asiento realizado?");
            if (answer) {
                var idlogeo = $("#idlog").val();
                var fech_url = $("#datetimepicker1").val();
                var id_asientourl = $("#idnumass").val();
                window.open('impresiones/impasiento.php?idlogeo=' + idlogeo +
                        '&fechaurl=' + fech_url + '&id_asientourl=' + id_asientourl);
                window.location = '../indexadmin.php';
            } else
            {
                window.location = '../indexadmin.php';
            }
        });
        return false;
    });
}


function rr_guardaas_level_asup()
{
    var datetimepicker1 = $("#datetimepicker1").val();
    if (datetimepicker1 == "") {
        alert("[Error]... Ingrese la fecha");
        newAlert("success", "Debe ingresar la fecha, campo obligatório");
    } else {
        var answer = confirm("Esta seguro que desea editar el asiento contable?");
        if (answer) {
            var camposumadebe = $("#camposumadebet").val();
            var camposumahaber = $("#camposumahabert").val();
            var asiento = $("#asiento_numt").val();
            if (camposumadebe != camposumahaber)
            {
                alert("Error!!!...La transaccion debe ser cuadrada, No se puede guardar!!!");
                newAlert("success", "Los valores DEBE /" + camposumadebe + "/ y HABER /" + camposumahaber + "/ deben ser igualados");
                $('#form').submit(function (msg) {
                    return false;
                });
            } else
            {
                rr_aux_save_level_asup();
            }
        } else {
            $('#form').submit(function (msg) {
                return false;
            });
        }
    }
}

function rr_aux_save_level_asup()
{
    $('#form').submit(function (msg) {
        $.post("./r_scriptsPHP/scriptupdata_lib.php", $(this).serialize(), function (data) {
            alert(data);
            newAlert("success", " " + data);
            $("#textarea_as").attr("value", "");
            $("#camposumadebet").attr("value", "");
            $("#camposumahabert").attr("value", "");
            var answer = confirm("Desea imprimir el asiento realizado?");
            if (answer) {
                var idlogeo = $("#idlog").val();
                var fech_url = $("#datetimepicker1").val();
                var id_asientourl = $("#idnumass").val();
                window.open('impresiones/impasiento.php?idlogeo=' + idlogeo +
                        '&fechaurl=' + fech_url + '&id_asientourl=' + id_asientourl);
                window.location = '../indexadmin.php';
            } else
            {
                window.location = '../indexadmin.php';
            }
        });
        return false;
    });
}

function rr_aux_save_level_as()
{
    $('#form_ejercicio').submit(function (msg) {
        $.post("./r_scriptsPHP/guardaasientoslibro.php", $(this).serialize(), function (data) {
            alert(data);
            newAlert("success", " " + data);
            $("#textarea_as").attr("value", "");
            $("#camposumadebe").attr("value", "");
            $("#camposumahaber").attr("value", "");
            var answer = confirm("Desea imprimir el asiento realizado?");
            if (answer) {
                var idlogeo = $("#idlog").val();
                var fech_url = $("#datetimepicker1").val();
                var id_asientourl = $("#asiento_num").val();
                window.open('impresiones/impasiento.php?idlogeo=' + idlogeo +
                        '&fechaurl=' + fech_url + '&id_asientourl=' + id_asientourl);
                window.location = '../indexadmin.php';
            } else
            {
                window.location = '../../indexadmin.php';
            }
        });
        return false;
    });
}

function add_trs(ass, y, m, d, bl) {
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', '../paginascont/new_trs.php?y=' + y + "&m=" + m + "&d=" + d + "&ass=" + ass + "&bl=" + bl, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}

function add_trs_ass(ass, y, m, d, bl) {
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', '../paginascont/new_trs_ass.php?y=' + y + "&m=" + m + "&d=" + d + "&ass=" + ass + "&bl=" + bl, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}


function agregar_trs() {
    var datocodigo = document.getElementById("nom_grupot").value;
    var datetimepicker1 = document.getElementById("datetimepicker1t").value;
    var valor_val = $("#valort").val();
    if (valor_val == "0.00") {
        alert("Ingrese un monto valido :" + valor_val);
        newAlert("danger", "        El monto que ingreso debe ser mayor a 0.00 $ !!!");
    } else {
        if (datocodigo == "")
        {
            alert("Falta un dato muy importante");
        } else {
            var seleccion = document.getElementById("tip_cuentadht").value;
            //alert(num.value);
            if (seleccion == 1) {
                var mes = $("#mest").val();
                var cod_cuenta = $("#cod_cuentat").val();
                var nom_cuenta = $("#nom_cuentat").val();
                var valor = $("#valort").val();
                var asiento_num = $("#asiento_numt").val();
                var fech = $("#datetimepicker1t").val();
                var cod_grupo = $("#cod_grupot").val();
                var idlog = $("#idlogt").val();
                var balances_realizados = $("#balances_realizadost").val();
                var tablaDatos = $("#tabedit");
                var gene_dh = "0.00";
                //alert("1");
                //v¿bootstrap <button class='btn btn-danger btn-sm' onclick='deleteRow(this)'><i class='glyphicon glyphicon-minus' ></i></button>
//               original <input type='button' value='x' class='btn btn-danger btn-sm' onclick='deleteRow(this)'></input>
                if (cod_cuenta != "" || nom_cuenta != "" || valor != "" || fech != "" || cod_grupo != "") {
                    tablaDatos.append("<tr id='datos'>\n\
<td style='display:none'><input type='text' readonly='readonly' name='campo1[]' class='form-control' value=' " + asiento_num + "'/></td>\n\
<td><div class='input-group'><input type='text' list='cuent' name='campo2[]' id='cuentfas_1' class='form-control' value='" + cod_cuenta + "' placeholder='Ingrese Cod Cuenta...'><span class='input-group-btn'><button class='btn btn-default' onclick='ver(<?Php echo $c; ?>), cont(<?Php echo $c; ?>)' type='button' id='btnver'>Ver!</button> </span></div></td>\n\
<td><input type='text' name='campo3[]' class='form-control' value='" + nom_cuenta + "'/></td>\n\
<td style='display:none'><input type='text' readonly='readonly' name='campo4[]' class='form-control' value='" + fech + "'/></td>\n\
<td><input type='text' name='campo5[]' class='form-control' value='" + valor + "'/></td>\n\
<td><input type='text' name='campo6[]' class='form-control' value='" + gene_dh + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='form-control' name='campo7[]' value='" + balances_realizados + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='form-control' name='campo8[]' value='" + cod_grupo + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='form-control' name='campo9[]' value='" + idlog + "'/></td><td>\n\
<button class='btn btn-danger btn-sm' onclick='deleteRow(this)'><i class='glyphicon glyphicon-minus' ></i></button></td>\n\\n\
<td style='display:none'>" + mes + "<input type='hidden' readonly='readonly' name='campo10[]' class='compa3' value='" + mes + "'/></td>\n\
</tr>");
                    reset_campos();
                    SumarColumnaAsientos('tabedit', 4);
                    SumarColumnaAsientosh('tabedit', 5);
                    newAlert("success", "        Agrego / " + nom_cuenta + " / con valor debe " + valor);
//                        $('#datetimepicker1').attr("readonly", true);
                }
            }
            else {
                var mes = $("#mest").val();
                var cod_cuenta = $("#cod_cuentat").val();
                var nom_cuenta = $("#nom_cuentat").val();
                var valor = $("#valort").val();
                var asiento_num = $("#asiento_numt").val();
                var fech = $("#datetimepicker1").val();
                var cod_grupo = $("#cod_grupot").val();
                var idlog = $("#idlogt").val();
                var balances_realizados = $("#balances_realizadost").val();
                var tablaDatos = $("#tabedit");
                var gene_dh = "0.00";
                //alert("2");
                if (cod_cuenta != "" || nom_cuenta != "" || valor != "" || fech != "" || cod_grupo != "") {
                    tablaDatos.append("<tr id='datos'>\n\
<td style='display:none'><input readonly='readonly' type='text' name='campo1[]' class='form-control' value=' " + asiento_num + "'/></td>\n\
<td><div class='input-group'><input type='text' list='cuent' name='campo2[]' id='cuentfas_1' class='form-control' value='" + cod_cuenta + "' placeholder='Ingrese Cod Cuenta...'><span class='input-group-btn'><button class='btn btn-default' onclick='ver(<?Php echo $c; ?>), cont(<?Php echo $c; ?>)' type='button' id='btnver'>Ver!</button> </span></div></td>\n\
<td><input type='text' name='campo3[]' class='form-control' value='" + nom_cuenta + "'/></td>\n\
<td style='display:none'><input type='text' readonly='readonly' name='campo4[]' class='form-control' value='" + fech + "'/></td>\n\
<td><input type='text' name='campo5[]' class='form-control' value='" + gene_dh + "'/></td>\n\
<td><input type='text' name='campo6[]' class='form-control' value='" + valor + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='form-control' name='campo7[]' value='" + balances_realizados + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='form-control' name='campo8[]' value='" + cod_grupo + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='form-control' name='campo9[]' value='" + idlog + "'/></td><td>\n\
<button class='btn btn-danger btn-sm' onclick='deleteRow(this)'><i class='glyphicon glyphicon-minus' ></i></button></td>\n\
<td style='display:none'>" + mes + "<input type='hidden' readonly='readonly' name='campo10[]' class='compa3' value='" + mes + "'/></td>\n\
</tr>");
                    reset_campos();
                    SumarColumnaAsientos('tabedit', 4);
                    SumarColumnaAsientosh('tabedit', 5);
                    newAlert("success", "        Agrego / " + nom_cuenta + " / con valor haber " + valor);
//                        $('#datetimepicker1').attr("readonly", true);
                }
            }
        }
    }
}

function rr_compr_t() {
    var Cadena = $('#cod_cuentat').val();
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

    if (counter > 1) {
        var miVariableJS = $("#cod_cuentat").val();
        $.post("./r_scriptsPHP/archivo.php", {"texto": miVariableJS, "campo": "cod_cuenta"},
        function (respuesta) {
            var elem = respuesta.split('_');
            var1 = elem[0];
            var2 = elem[1];
            var3 = elem[2];
            document.getElementById('nom_cuentat').value = var1;
            document.getElementById('cod_cuentat').value = var2;
            document.getElementById('cod_grupot').value = var3;
            fcarg_grupo_t(var3);
        });
    } else {
        var miVariableJS = $("#cod_cuentat").val();
        $.post("./r_scriptsPHP/archivo.php", {"texto": miVariableJS, "campo": "nombre_cuenta_plan"},
        function (respuesta) {
            var elem = respuesta.split('_');
            var1 = elem[0];
            var2 = elem[1];
            var3 = elem[2];
            document.getElementById('nom_cuentat').value = var1;
            document.getElementById('cod_cuentat').value = var2;
            document.getElementById('cod_grupot').value = var3;
            fcarg_grupo_t(var3);
        });
    }

    function fcarg_grupo_t(var3){
        $.post("./r_scriptsPHP/archivogruponom.php", {"texto": var3},
        function (respuestag) {
            document.getElementById('nom_grupot').value = respuestag;
        });
    }
}

//ajustes de asientos


function guardaas_aj()
{
    var camposumadebe = $("#camposumadebe").val();
    var camposumahaber = $("#camposumahaber").val();
    if (camposumadebe != camposumahaber)
    {
        alert("Error!!!...La transaccion debe ser cuadrada, No se puede guardar!!!");
        newAlert("success", "Los valores DEBE /" + camposumadebe + "/ y HABER /" + camposumahaber + "/ deben ser igualados");
        $('#form_ejercicio').submit(function (msg) {
            return false;
        });
    } else
    {
        ans = confirm("Desea ingresar el nuevo asiento de ajuste?\n...")
        if (ans)
        {
            aux_save_aj();
        } else {
            $('#form_ejercicio').submit(function (msg) {
                return false;
            });
        }
    }

}

function aux_save_aj()
{
    $('#form_ejercicio').submit(function (msg) {
        $.post("guardaajustesasientos.php", $(this).serialize(), function (data) {
            alert(data);
            $("#textarea_asaj").attr("value", "");
            $("#camposumadebe").attr("value", "");
            $("#camposumahaber").attr("value", "");
            redireccionar_aj();
        });
        return false;
    });
}

var p_aj = "cont_aj_lib.php";
function redireccionar_aj()
{
    location.href = p_aj;
}
var p_aj_as = "./cont_aj_ass.php";
function new_as_aj() {
    window.location.href = p_aj_as;
//    load('./');
}

function buscar_ass() {
    var formulario = document.getElementById("form_ejercicio");
    var num_ass = document.getElementById("num_ass");
    if (num_ass.value == "") {
        num_ass.focus();
        alert("Complete los campos");
        return false;
    } else {
        formulario.submit();
        return true;
    }
}

function buscar_fech() {
    var formulario = document.getElementById("form_ejercicio");
    var datetimepicker1 = document.getElementById("datetimepicker1");
    if (datetimepicker1.value == "") {
        datetimepicker1.focus();
        alert("Ingrese la fecha");
        return false;
    } else {
        formulario.submit();
        return true;
    }
}

function buscar_prd() {
    var formulario = document.getElementById("form_ejercicio");
    var datetimepicker1min = document.getElementById("datetimepicker1min");
    var datetimepicker1max = document.getElementById("datetimepicker1max");

    if (datetimepicker1min.value == "") {
        datetimepicker1min.focus();
        alert("Ingrese la fecha mín");
        return false;
    }
    if (datetimepicker1max.value == "") {
        datetimepicker1max.focus();
        alert("Ingrese la fecha máx");
        return false;
    } else {
        formulario.submit();
        return true;
    }
}

function buscar_ms() {
    var formulario = document.getElementById("form_ejercicio");
    var indice = document.getElementById("opciones").selectedIndex;
    if (indice == null || indice == 0) {
        alert("Seleccióne el mes");
        return false;
    } else {
        formulario.submit();
        return true;
    }
}


