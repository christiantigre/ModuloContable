/* global caldaValor, relustVal */

// JavaScript Document

$(document).ready(function () {
    fn_dar_eliminar();
    fn_cantidad();
    $("#formulario_bl").validate();
});

function fn_cantidad() {
    cantidad = $("#grilla tbody").find("tr").length;
    $("#span_cantidad").html(cantidad);
}
;


function fn_agregar() {

    cantidad = $("#grilla tbody").find("tr").length;
    $("#span_cantidad").html(cantidad);

    var $num = document.getElementById('grilla').getElementsByTagName('tr').length - 1;
    $num + 1;
    a = parseFloat(document.getElementById('debe').value);
    b = parseFloat(document.getElementById('haber').value);
    if (a > b)
    {
        document.getElementById('acreedor').value = a - b + (0.00);
        document.getElementById('deudor').value = ('0.00');
    } else {
        document.getElementById('deudor').value = b - a;
        document.getElementById('acreedor').value = ('0.00');
    }
    if (a == b)
    {
        document.getElementById('deudor').value = b - a;
        document.getElementById('acreedor').value = a - b;
    }
    //var $acreedor=document.getElementById('acreedor').value;
    //var $deudor=document.getElementById('deudor').value;
    document.getElementById('asiento_num').value = $num;
    cadena = "<tr>";
    cadena = cadena + "<td>" + $num + "</td>";
    cadena = cadena + "<td>" + $("#cod_cuenta").val() + "</td>";
    cadena = cadena + "<td>" + $("#nom_cuenta").val() + "</td>";
    cadena = cadena + "<td>" + a + "</td>";
    cadena = cadena + "<td>" + b + "</td>";
    cadena = cadena + "<td>" + $("#acreedor").val() + "</td>";
    cadena = cadena + "<td>" + $("#deudor").val() + "</td>";
    cadena = cadena + "<td><a class='elimina'><img src='../../../../images/delete.png' /></a></td>";



    $("#grilla tbody").append(cadena);

    fn_dar_eliminar();
    fn_cantidad();
    //   alert("Datos cargados");
}

function agregarfila() {
    var $num = document.getElementById('grilla').getElementsByTagName('tr').length - 1;
    $num--;
    cadena = "<tr>";
    cadena = cadena + "<td>" + $num + "</td>";
    cadena = cadena + "<td>" + $("").val() + "</td>";
    cadena = cadena + "<td>" + $("Total de Activos").val() + "</td>";
    cadena = cadena + "<td>" + $("0,00").val() + "</td>";
    cadena = cadena + "<td>" + $("0,00").val() + "</td>";
    cadena = cadena + "<td><a class='elimina'><img src='../../images/delete.png' /></a></td>";
    $("#grilla tbody").append(cadena);
    /*
     aqui puedes enviar un conunto de tados ajax para agregar al usuairo
     $.post("agregar.php", {ide_usu: $("#valor_ide").val(), nom_usu: $("#valor_uno").val()});
     */
    fn_dar_eliminar();
    fn_cantidad();
    //   alert("Datos cargados");
}
;
function fn_dar_eliminar() {
    $("a.elimina").click(function () {
        id = $(this).parents("tr").find("td").eq(0).html();
        respuesta = confirm("Desea eliminar el asiento numero: " + id);
        if (respuesta) {
            $(this).parents("tr").fadeOut("normal", function () {
                $(this).remove();
                alert("Datos" + id + " eliminados")
                /*
                 aqui puedes enviar un conjunto de datos por ajax
                 $.post("eliminar.php", {ide_usu: id})
                 */
            })
        }
    });
}
;
function SumarColumna(grilla, columna1, columna2) {
    var resultVal1 = 0.0;
    var resultVal2 = 0.0;
    $("#" + grilla + " tbody tr").not(':first').not(':last').each(
            function () {
                var celdaValor1 = $(this).find('td:eq(' + columna1 + ')');
                var celdaValor2 = $(this).find('td:eq(' + columna2 + ')');

                if (celdaValor1.val() != null)
                    resultVal1 += parseFloat(celdaValor1.html().replace(',', '.'));
                if (celdaValor2.val() != null)
                    resultVal2 += parseFloat(celdaValor2.html().replace(',', '.'));
            } //function
    ) //each
    alert(resultVal1);
    alert(resultVal2);
    // $("#" + grilla + " tbody tr:last td:eq(" + columna + ")").html(resultVal.toFixed(2).toString().replace('.',','));   
    //$("#" + grilla + " tfoot td:eq(" + columna + ")").html(resultVal.toFixed(2).toString().replace('.',','));   
}

function GrabarDatos_bl_Ini() {
    var balances_realizados = $('#balances_realizados').attr('value');
    var asiento_num = $('#asiento_num').attr('value');
    var cod_cuenta = $('#cod_cuenta').attr('value');
    var nom_cuenta = $('#nom_cuenta').attr('value');
    var debe = $("#debe").attr("value");
    var haber = $("#haber").attr("value");
    var acreedor = $("#acreedor").attr("value");
    var deudor = $("#deudor").attr("value");

    $.ajax({
        url: 'grabar_bl_ini.php',
        type: "POST",
        data: "submit=&asiento_num=" + asiento_num +
                "&cod_cuenta=" + cod_cuenta +
                "&nom_cuenta=" + nom_cuenta +
                "&debe=" + debe +
                "&haber=" + haber +
                "&acreedor=" + acreedor +
                "&deudor=" + deudor +
                "&balances_realizados=" + balances_realizados,
        //success: function (datos) {ConsultaDatosCuentaAux();alert(datos);$("#formulario").hide();$("#tabla").show(); 
        //    } 
    });
    return false;
}

function Calcular(){
    a = parseFloat(document.getElementById('debe').value);
    b = parseFloat(document.getElementById('haber').value);
    if (a > b)
    {
        document.getElementById('acreedor').value = a - b + (0.00);
        document.getElementById('deudor').value = ('0.00');
    } else {
        document.getElementById('deudor').value = b - a;
        document.getElementById('acreedor').value = ('0.00');
    }
    if (a == b)
    {
        document.getElementById('deudor').value = b - a;
        document.getElementById('acreedor').value = a - b;
    }
}


//<script type="text/javascript" charset="utf-8">

function addasiento() {
    var datocodigo = document.getElementById("nom_grupo").value;
    var datetimepicker1 = document.getElementById("datetimepicker1").value;
    if (datetimepicker1 == "") {
        alert("Ingrese la fecha");
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
                var fech = $("#datetimepicker1").val();
                var cod_grupo = $("#nom_grupo").val();
                var idlog = $("#idlog").val();
                var balances_realizados = $("#balances_realizados").val();
                var tablaDatos = $("#tblDatos");
                var gene_dh = "0.00";
                //alert("1");
                if (cod_cuenta != "" || nom_cuenta != "" || valor != "" || fech != "" || cod_grupo != "") {
                    tablaDatos.append("<tr id='datos'>\n\
<td style='display:none'><input type='text' readonly='readonly' name='campo1[]' class='compa2' value=' " + asiento_num + "'/></td>\n\
<td>" + cod_cuenta + "<input type='hidden' readonly='readonly' name='campo2[]' class='compa3' value='" + cod_cuenta + "'/></td>\n\
<td>" + nom_cuenta + "<input type='hidden' readonly='readonly' name='campo3[]' value='" + nom_cuenta + "'/></td>\n\
<td>" + fech + "<input type='hidden' readonly='readonly' name='campo4[]' class='compa2' value='" + fech + "'/></td>\n\
<td>" + valor + "<input type='hidden' readonly='readonly' name='campo5[]' class='compa2' value='" + valor + "'/></td>\n\
<td>" + gene_dh + " <input type='hidden' readonly='readonly' name='campo6[]' class='compa2' value='" + gene_dh + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='compa3' name='campo7[]' value='" + balances_realizados + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='compa3' name='campo8[]' value='" + cod_grupo + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='compa3' name='campo9[]' value='" + idlog + "'/></td><td><input type='button' value='Delete' onclick='deleteRow(this)'/></td>\n\\n\
<td style='display:none'>" + mes + "<input type='hidden' readonly='readonly' name='campo10[]' class='compa3' value='" + mes + "'/></td>\n\
</tr>");
                    reset_campos();
                    SumarColumnaAsientos('tblDatos', 4);
                    SumarColumnaAsientosh('tblDatos', 5);
                }
            }
            else {
                var mes = $("#mes").val();
                var cod_cuenta = $("#cod_cuenta").val();
                var nom_cuenta = $("#nom_cuenta").val();
                var valor = $("#valor").val();
                var asiento_num = $("#asiento_num").val();
                var fech = $("#datetimepicker1").val();
                var cod_grupo = $("#nom_grupo").val();
                var idlog = $("#idlog").val();
                var balances_realizados = $("#balances_realizados").val();
                var tablaDatos = $("#tblDatos");
                var gene_dh = "0.00";
                //alert("2");
                if (cod_cuenta != "" || nom_cuenta != "" || valor != "" || fech != "" || cod_grupo != "") {
                    tablaDatos.append("<tr id='datos'>\n\
<td style='display:none'><input type='text' readonly='readonly' name='campo1[]' class='compa2' value=' " + asiento_num + "'/></td>\n\
<td>" + cod_cuenta + "<input type='hidden' readonly='readonly' name='campo2[]' class='compa3' value='" + cod_cuenta + "'/></td>\n\
<td>" + nom_cuenta + "<input type='hidden' readonly='readonly' name='campo3[]' value='" + nom_cuenta + "'/></td>\n\
<td>" + fech + "<input type='hidden' readonly='readonly' name='campo4[]' class='compa2' value='" + fech + "'/></td>\n\
<td>" + gene_dh + "<input type='hidden' readonly='readonly' name='campo5[]' class='compa2' value='" + gene_dh + "'/></td>\n\
<td>" + valor + " <input type='hidden' readonly='readonly' name='campo6[]' class='compa2' value='" + valor + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='compa3' name='campo7[]' value='" + balances_realizados + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='compa3' name='campo8[]' value='" + cod_grupo + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='compa3' name='campo9[]' value='" + idlog + "'/></td><td><input type='button' value='Delete' onclick='deleteRow(this)'/></td>\n\
<td style='display:none'>" + mes + "<input type='hidden' readonly='readonly' name='campo10[]' class='compa3' value='" + mes + "'/></td>\n\
</tr>");
                    reset_campos();
                    SumarColumnaAsientos('tblDatos', 4);
                    SumarColumnaAsientosh('tblDatos', 5);
                }
            }
        }
    }

}

function addasientoAs() {
    var datocodigo = document.getElementById("nom_grupo").value;
    var datetimepicker1 = document.getElementById("datetimepicker1").value;
    if (datetimepicker1 == "") {
        alert("Ingrese la fecha");
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
                var fech = $("#datetimepicker1").val();
                var cod_grupo = $("#nom_grupo").val();
                var idlog = $("#idlog").val();
                var balances_realizados = $("#balances_realizados").val();
                var tablaDatos = $("#tblDatosAs");
                var gene_dh = "0.00";
                //alert("1");
                if (cod_cuenta != "" || nom_cuenta != "" || valor != "" || fech != "" || cod_grupo != "") {
                    tablaDatos.append("<tr id='datos'>\n\
<td style='display:none'><input type='text' readonly='readonly' name='campo1[]' class='compa2' value=' " + asiento_num + "'/></td>\n\
<td>" + cod_cuenta + "<input type='hidden' readonly='readonly' name='campo2[]' class='compa3' value='" + cod_cuenta + "'/></td>\n\
<td>" + nom_cuenta + "<input type='hidden' readonly='readonly' name='campo3[]' value='" + nom_cuenta + "'/></td>\n\
<td>" + fech + "<input type='hidden' readonly='readonly' name='campo4[]' class='compa2' value='" + fech + "'/></td>\n\
<td>" + valor + "<input type='hidden' readonly='readonly' name='campo5[]' class='compa2' value='" + valor + "'/></td>\n\
<td>" + gene_dh + " <input type='hidden' readonly='readonly' name='campo6[]' class='compa2' value='" + gene_dh + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='compa3' name='campo7[]' value='" + balances_realizados + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='compa3' name='campo8[]' value='" + cod_grupo + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='compa3' name='campo9[]' value='" + idlog + "'/></td><td><input type='button' value='Delete' onclick='deleteRow(this)'/></td>\n\\n\
<td style='display:none'>" + mes + "<input type='hidden' readonly='readonly' name='campo10[]' class='compa3' value='" + mes + "'/></td>\n\
</tr>");
                    reset_campos();
                    SumarColumnaAsientos('tblDatosAs', 4);
                    SumarColumnaAsientosh('tblDatosAs', 5);
                }
            }
            else {
                var mes = $("#mes").val();
                var cod_cuenta = $("#cod_cuenta").val();
                var nom_cuenta = $("#nom_cuenta").val();
                var valor = $("#valor").val();
                var asiento_num = $("#asiento_num").val();
                var fech = $("#datetimepicker1").val();
                var cod_grupo = $("#nom_grupo").val();
                var idlog = $("#idlog").val();
                var balances_realizados = $("#balances_realizados").val();
                var tablaDatos = $("#tblDatosAs");
                var gene_dh = "0.00";
                //alert("2");
                if (cod_cuenta != "" || nom_cuenta != "" || valor != "" || fech != "" || cod_grupo != "") {
                    tablaDatos.append("<tr id='datos'>\n\
<td style='display:none'><input type='text' readonly='readonly' name='campo1[]' class='compa2' value=' " + asiento_num + "'/></td>\n\
<td>" + cod_cuenta + "<input type='hidden' readonly='readonly' name='campo2[]' class='compa3' value='" + cod_cuenta + "'/></td>\n\
<td>" + nom_cuenta + "<input type='hidden' readonly='readonly' name='campo3[]' value='" + nom_cuenta + "'/></td>\n\
<td>" + fech + "<input type='hidden' readonly='readonly' name='campo4[]' class='compa2' value='" + fech + "'/></td>\n\
<td>" + gene_dh + "<input type='hidden' readonly='readonly' name='campo5[]' class='compa2' value='" + gene_dh + "'/></td>\n\
<td>" + valor + " <input type='hidden' readonly='readonly' name='campo6[]' class='compa2' value='" + valor + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='compa3' name='campo7[]' value='" + balances_realizados + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='compa3' name='campo8[]' value='" + cod_grupo + "'/></td>\n\
<td style='display:none'><input type='text'  readonly='readonly' class='compa3' name='campo9[]' value='" + idlog + "'/></td><td><input type='button' value='Delete' onclick='deleteRow(this)'/></td>\n\
<td style='display:none'>" + mes + "<input type='hidden' readonly='readonly' name='campo10[]' class='compa3' value='" + mes + "'/></td>\n\
</tr>");
                    reset_campos();
                    SumarColumnaAsientos('tblDatosAs', 4);
                    SumarColumnaAsientosh('tblDatosAs', 5);
                }
            }
        }
    }

}

function SumarColumnaAsientos(grilla, columna) {
    var resultVal = 0.0;
    $("#" + grilla + " tbody tr").not(':first').not(':last').each(
            function () {
                var celdaValor = $(this).find('td:eq(' + columna + ')');
                if (celdaValor.val() != null)
                    resultVal += parseFloat(celdaValor.html().replace(',', '.'));
            } //function christian
    ) //each
    $("#camposumadebe").val(resultVal.toFixed(2).toString().replace('.', ','));
    //$("#" + grilla + " tbody tr:last td:eq(" + columna + ")").html(resultVal.toFixed(2).toString().replace('.',','));   
}

function SumarColumnaAsientosh(grilla, columna) {
    var resultVal = 0.0;
    $("#" + grilla + " tbody tr").not(':first').not(':last').each(
            function () {
                var celdaValor = $(this).find('td:eq(' + columna + ')');
                if (celdaValor.val() != null)
                    resultVal += parseFloat(celdaValor.html().replace(',', '.'));
            } //function christian
    ) //each
    $("#camposumahaber").val(resultVal.toFixed(2).toString().replace('.', ','));
    //$("#" + grilla + " tbody tr:last td:eq(" + columna + ")").html(resultVal.toFixed(2).toString().replace('.',','));   
}

function deleteRow(btn) {
    var answer = confirm("Al aceptar se eliminara un registro")
    if (answer) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        SumarColumnaAsientos('tblDatos', 4);
        SumarColumnaAsientosh('tblDatos', 5);
    } else {
    }
}

function reset_campos() {
    $("#cod_cuenta").val("");
    $("#nom_grupo").val("");
    $("#cod_grupo").val("");
    $("#nom_cuenta").val("");
    $("#valor").val("0.00");
}

function reset_tab(){
    var answer = confirm("Deseas cancelar el asiento?")
    if (answer) {//actualizar();
        location.reload();
    } else {
    }
}

function imprimir_balance(){
    var answer = confirm("Desea imprimir el asiento realizado?")
    if (answer) {
        var idlogeo = $("#idlog").val();
        var fech_url = $("#fech").val();
        window.location = 'impresiones/balanceimp.php?idlogeo=' + idlogeo +
                '&fech_url=' + fech_url;
    } else {
        location.reload();
    }
}

function cargacodgrupo(){
    var miVariableJS = $("#cod_clasetxt").val();
    $.post("./funciones/archivoobtengrupo.php", {"texto": miVariableJS},
    function (respuesta) {
        document.getElementById('codgrupo').value = respuesta;
    });
    cargacodgruponom(miVariableJS);
}

function cargacodgruponom(){
    var miVariable = $("#cod_clasetxt").val();
    $.post("./funciones/archivoobtengruponom.php", {"texto": miVariable},
    function (respuest) {
        document.getElementById('nombredelgrupo').value = respuest;
    });
}

function cargacodgrupo_sb(){
    var miVariableJS = $("#cod_clasetxt").val();
    $.post("./funciones/archivoobtensubcuenta.php", {"texto": miVariableJS},
    function (respuesta) {
        document.getElementById('codgrupo').value = respuesta;
    });
    cargacodgruponom_sb(miVariableJS);
}

function cargacodgruponom_sb(){
    var miVariable = $("#cod_clasetxt").val();
    $.post("./funciones/archivoobtennombreaux.php", {"texto": miVariable},
    function (respuest) {
        document.getElementById('nombredelgrupo').value = respuest;
    });
}

function cargacodgruponom_sbaux(){
    var miVariable = $("#codgrupo").val();
    $.post("./funciones/archivoobtenaux.php", {"texto": miVariable},
    function (respuest) {
        document.getElementById('nombredelgrupo').value = respuest;
    });
}


//varias impre en uno
function imp_pdf(id){
//    var id =this.id;
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fechabi").val();
    var id_asientourl = $("#asiento_num").val();
    window.open('../documentos/impresiones/'+id+'.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&idlogeo=' + idlogeo + '&year=2010&fechaurl=' + fech_url + '&i=' + id_asientourl + '&1=1'+'&prmlg='+idlogeo);
}
//exportacion a excel todos archivos se exportan desde aqui, reciber parametro el nombre del archivo.
function exp_ex(id){
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fechabi").val();
    var id_asientourl = $("#asiento_num").val();
    window.open('../documentos/export/'+id+'.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&idlogeo=' + idlogeo + '&year=2010&fechaurl=' + fech_url + '&i=' + id_asientourl + '&1=1'+'&prmlg='+idlogeo);
}
function exp_ex_by_cta(id){
    var tip_cuentadh = $("#cmp_my").val();
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fechabi").val();
    var id_asientourl = $("#asiento_num").val();
    window.open('documentos/export/'+id+'.php?link&43&vlink*data=11&cta='+tip_cuentadh+'&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&idlogeo=' + idlogeo + '&year=2010&fechaurl=' + fech_url + '&i=' + id_asientourl + '&1=1'+'&prmlg='+idlogeo);
}
function exp_wd(id){
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fechabi").val();
    var id_asientourl = $("#asiento_num").val();
    window.open('../documentos/export/'+id+'.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&idlogeo=' + idlogeo + '&year=2010&fechaurl=' + fech_url + '&i=' + id_asientourl + '&1=1'+'&prmlg='+idlogeo);
}

//root
function rr_add_trs(ass, y, m, d, bl) { 
    var datetimepicker1 = $("#datetimepicker1").val();
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', '../r_paginascont/new_trs.php?y=' + y + "&m=" + m + "&d=" + d + "&ass=" + ass + "&bl=" + bl+"&f="+datetimepicker1, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}

function rr_add_trs_ass(ass, y, m, d, bl) {
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', '../r_paginascont/new_trs_ass.php?y=' + y + "&m=" + m + "&d=" + d + "&ass=" + ass + "&bl=" + bl, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}