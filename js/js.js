/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function objetoAjax() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }

    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

$(document).ready(function () {
    document.oncontextmenu = function () {
        return false;
    }
});

$(document).ready(function () {
    var totd = $("#totd").val();
    var toth = $("#toth").val();
    if (totd == toth) {
        $("#totd").css({background: "#c1e2b9"});
        $("#toth").css({background: "#c1e2b9"});
    }
    if (totd != toth) {
        $("#totd").css({background: "#f2dede"});
        $("#toth").css({background: "#f2dede"});
    }
});

function upmod(campo) {
    var elem = campo.split('-');
    var a = elem[0];
    var b = elem[1];//    alert(b)
    document.getElementById("debe" + b + "_2").value = '0.00';
    document.getElementById("debe" + b + "_2").disabled = false;
    document.getElementById("haber" + b + "_3").value = '0.00';
    document.getElementById("haber" + b + "_3").disabled = false;
    sumarcajasdh();
}

function modifica() {
    tab = document.getElementById('tabedit');
    for (i = 0; ele = tab.getElementsByTagName('input')[i]; i++) {
        if (ele.checked)
            edita(ele);
        ele.checked = false;
    }
}

function edita(obj) {
    padre = obj.parentNode.parentNode;
    celda = padre.getElementsByTagName('td');
    inicio = 1;//celda para comenzar
    fin = 8;//celda para terminar
    for (i = inicio; i < fin; i++) {
        var celdaTmp = celda[i];
        txt = celdaTmp.innerHTML;
        celdaTmp.innerHTML = '';
        inp = celdaTmp.appendChild(document.createElement('input'));
        inp.value = txt;
        inp.onblur = function () {
            this.parentNode.innerHTML = this.value
        }
    }
}
function cont(n) {

}
function ver(n) {
//    alert(n);
    var miVariableJS = $("#cuentfas" + n + "_1").val();
    $.post("archivo.php", {"texto": miVariableJS},
    function (a) {
        document.getElementById('cuentafas' + n).value = a;
    });
    vercodgrupo(n);
}

function vercodgrupo(n) {
    var miVariableJS = $("#cuentfas" + n + "_1").val();
    $.post("archivogrupo.php", {"texto": miVariableJS},
    function (a) {
        document.getElementById('codgrupofas' + n).value = a;
    });
    vergrupo(n);
}

function vergrupo(n) {
    var miVariableJS = $("#cuentfas" + n + "_1").val();
    $.post("archivogruponombre.php", {"texto": miVariableJS},
    function (a) {
        document.getElementById('grupofas' + n).value = a;
    });
}

//validar debe y haber
function deb_hab(n) {
//    alert(n);
    var table = document.getElementById("tabedit");
    var rows = table.rows.length;
    for (i = 1; i < rows; i++) {
        var midh = $("#debe" + n + "_2").val();
//    document.getElementById('camposumadebe').value = midh;
        alert(midh);
    }
}

function validarupd(campo) {
//    alert(campo)
    var elcampo = document.getElementById(campo);
    if ((!validarNumero(elcampo.value)) || (elcampo.value == "")) {
        elcampo.value = "";
        elcampo.focus();
        document.getElementById('mensajemal').innerHTML = 'DEBE INGRESAR UN NÚMERO...';
    } else {
        document.getElementById('mensajemal').innerHTML = '';
        var name = campo;
        name = name.replace("debe", "haber");
        var elem = name.split('_');
        first = elem[0];
        second = elem[1];
        campo2 = first + "_3";

        document.getElementById(campo2).value = '0.00';
//        document.getElementById(campo2).disabled = true;
        sumarcajasdh();
    }
}

function validaruph(campo) {
//    alert(campo)
    var elcampo = document.getElementById(campo);
    if ((!validarNumero(elcampo.value)) || (elcampo.value == "")) {
        elcampo.value = "";
        elcampo.focus();
        document.getElementById('mensajemal').innerHTML = 'DEBE INGRESAR UN NÚMERO...';
    } else {
        document.getElementById('mensajemal').innerHTML = '';
        var name = campo;
        name = name.replace("haber", "debe");
        var elem = name.split('_');
        first = elem[0];
        second = elem[1];
        campo2 = first + "_2";
        document.getElementById(campo2).value = '0.00';
//        document.getElementById(campo2).disabled = true;
        sumarcajasdh();
    }
}

function sumarcajasdh() {
    var rows = tabedit.rows.length;
    var resultVal = 0.0;
    var resultVal_h = 0.0;
    var rows = tabedit.rows.length;
    for (var i = 1; i < rows; i++) {
        var val = document.getElementById('debe' + i + "_2").value;
        var val_h = document.getElementById('haber' + i + "_3").value;
        val_h = parseFloat(val_h.replace(',', '.'));
        val = parseFloat(val.replace(',', '.'));
        resultVal_h = val_h + resultVal_h;
        resultVal = val + resultVal;
        document.getElementById('camposumadebe').value = resultVal.toFixed(2);
        document.getElementById('camposumahaber').value = resultVal_h.toFixed(2);
    }

}
function upmod_ini(campo) {
    var elem = campo.split('-');
    var a = elem[0];
    var b = elem[1];
//        alert(b)
    document.getElementById("debe" + b + "_2").value = '0.00';
    document.getElementById("debe" + b + "_2").disabled = false;
    document.getElementById("haber" + b + "_3").value = '0.00';
    document.getElementById("haber" + b + "_3").disabled = false;
    sumarcajasdh_ini();
}
function validaruph_ini(campo) {
//    alert(campo)
    var elcampo = document.getElementById(campo);
    if ((!validarNumero(elcampo.value)) || (elcampo.value == "")) {
        elcampo.value = "";
        elcampo.focus();
        document.getElementById('mensajemal').innerHTML = 'DEBE INGRESAR UN NÚMERO...';
    } else {
        document.getElementById('mensajemal').innerHTML = '';
        var name = campo;
        name = name.replace("haber", "debe");
        var elem = name.split('_');
        first = elem[0];
        second = elem[1];
        campo2 = first + "_2";
        document.getElementById(campo2).value = '0.00';
//        document.getElementById(campo2).disabled = true;
        sumarcajasdh_ini();
    }
}
function sumarcajasdh_ini() {
    var rows = tabedit.rows.length;
    var resultVal = 0.0;
    var resultVal_h = 0.0;
    var rows = tabedit.rows.length;
    for (var i = 1; i < rows; i++) {
        var val = document.getElementById('debe' + i + "_2").value;
        var val_h = document.getElementById('haber' + i + "_3").value;
        val_h = parseFloat(val_h.replace(',', '.'));
        val = parseFloat(val.replace(',', '.'));
        resultVal_h = val_h + resultVal_h;
        resultVal = val + resultVal;
        document.getElementById('camposumadebet').value = resultVal.toFixed(2);
        document.getElementById('camposumahabert').value = resultVal_h.toFixed(2);
    }

}
//var elcampo = document.getElementById(caja);
//var rows = tabedit.rows.length;
//alert(rows)
//}

function validarNumero(input) {
    return (!isNaN(input) && parseInt(input) == input) || (!isNaN(input) && parseFloat(input) == input);
}
//funciones de alumno guardar editar
function lista_ass() {

    var resultado = document.getElementById('page-wrapper');
//    resultado.innerHTML = '<br><br><br><center><img src="img/45.gif"></center>';
    ajax = objetoAjax();
    ajax.open("GET", "./editasiento/asientoedit.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {

            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}

function verif() {
    var fecha = $("#datetimepicker1").val();
    var camposumadebe = $("#camposumadebe").val();
    var camposumahaber = $("#camposumahaber").val();
    respuesta = confirm('¿ Esta seguro que desea aplicar los cambios ?');
    var pagina = "index_modulo_contable.php";
    if (respuesta) {
        if (fecha != "") {
            if (camposumadebe == camposumahaber) {
                $('#form').submit(function (msg) {
                    $.post("./editasiento/scriptupdata.php", $(this).serialize(), function (data) {
                        alert(data);
                        location.href = pagina;
                    });
                    return false;
                });
            } else {
                alert("las sumas no estan correctas");
            }
        } else {
            alert("Seleccione la fecha");
        }
    } else {
        alert("Transaccion cancelada");
    }
}

function verifasslib() {
    var fecha = $("#datetimepicker1").val();
    var camposumadebe = $("#camposumadebe").val();
    var camposumahaber = $("#camposumahaber").val();
    respuesta = confirm('¿ Esta seguro que desea aplicar los cambios ?');
    var pagina = "index_modulo_contable.php";
    if (respuesta) {
        if (fecha != "") {
            if (camposumadebe == camposumahaber) {
                $('#form').submit(function (msg) {
                    $.post("./editasiento/scriptupdatalib.php", $(this).serialize(), function (data) {
                        alert(data);
                        location.href = pagina;
                    });
                    return false;
                });
            } else {
                alert("las sumas no estan correctas");
            }
        } else {
            alert("Seleccione la fecha");
        }
    } else {
        alert("Transaccion cancelada");
    }
}
function verifasslibsec() {
    var fecha = $("#datetimepicker1").val();
    var camposumadebe = $("#camposumadebe").val();
    var camposumahaber = $("#camposumahaber").val();
    respuesta = confirm('¿ Esta seguro que desea aplicar los cambios ?');
    var pagina = "../secretaria/index_modulo_contable.php";
    if (respuesta) {
        if (fecha != "") {
            if (camposumadebe == camposumahaber) {
                $('#form').submit(function (msg) {
                    $.post("./../editasiento/scriptupdatasec.php", $(this).serialize(), function (data) {
                        alert(data);
                        location.href = pagina;
                    });
                    return false;
                });
            } else {
                alert("las sumas no estan correctas");
            }
        } else {
            alert("Seleccione la fecha");
        }
    } else {
        alert("Transaccion cancelada");
    }
}

function listar() {
    var resultado = document.getElementById('page-wrapper');
//    resultado.innerHTML = '<br><br><br><center><img src="img/45.gif"></center>';
    ajax = objetoAjax();
    ajax.open("GET", "./editasiento/listar_asientos.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}

function pago_alumno(id) {
    var resultado = document.getElementById('page-wrapper');
//    resultado.innerHTML = '<br><br><br><center><img src="img/45.gif"></center>';
    ajax = objetoAjax();
    ajax.open("GET", "./editasiento/arch.php?id=" + id, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {

            resultado.innerHTML = ajax.responseText;
//            tables();
        }
    }
    ajax.send(null);
}

function listado_cuota(id) {
    var resultado = document.getElementById('caja');
//    resultado.innerHTML = '<br><br><br><center><img src="img/45.gif"></center>';
    ajax = objetoAjax();
    ajax.open("GET", "./editasiento/form_up.php?id=" + id, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {

            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}



function check() {
    if (document.getElementById('todos').checked == true) {
        $('input[type=checkbox]').each(function () {
            this.checked = true;
        });
    } else {
        $('input[type=checkbox]').each(function () {
            this.checked = false;
        });
    }
}

function enviar_r(check) {
    var total = 0;
    var cadena = "";
    var c = 0;
    var nuevoDiv = "";
    var nuevoInput = "";
    for (var i = 1; i <= check; i++) {
        if (document.getElementById('cuota' + i).checked == true) {
            var cadena = document.getElementById('cuota' + i).value;
            var elem = cadena.split('-');
            monto = elem[0];
            concepto = elem[1];
            cuotaid = elem[2];
            total = total + parseInt(monto);
            c = c + 1;
            nuevoDiv = nuevoDiv.concat("<li class='list-group-item'>" + concepto + "<span class='badge pull-right'>" + monto + "</span></li>");
            nuevoInput = nuevoInput.concat("<input type='hidden' name='idcuota[]' id='idcuota[]' value='" + cuotaid + "'>")
            document.getElementById('divCaja').style.display = "block";
            document.getElementById('detalle').innerHTML = nuevoDiv;
            document.getElementById('cuotas').innerHTML = nuevoInput;
        }
    }
    if (c == 1) {
        document.getElementById('concepto').value = concepto;
    } else if (c > 1) {
        document.getElementById('concepto').value = "Barias cuotas " + c;
    }
    document.getElementById('monto').value = total;
}

function send_data(check) {
    var idfas = $("#idfas").val();
//     alert(check);
//    for (var i = 1; i <= check; i++) {
//        if (document.getElementById('campo'+ i).checked == true) {
//            var campo = document.getElementById('campo'+ i).value;
//            alert(campo);
//    }
//    }
    if (check == idfas) {
        alert("valores son" + idfas + " " + check);
    } else {
        alert("ERROR!!!...NO SE PUEDE REALIZAR ESTA ACTUALIZACIÓN " + idfas + " " + check);
    }
//    alert("idfas="+idfas);
//    alert("idtej"+idtej);
}



function detall_asin(a) {
    var f = $("#fecha_" + a).val();
    var ass = $("#ass_" + a).val();
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', './templateslimit/paginascont/detall_ass.php?fecha=' + f + "&ass=" + ass, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {

            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}
function detall_asin_ajustes(cod, y, m, d) {
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', './../paginascont/detall_ass_aj.php?y=' + y + "&m=" + m + "&d=" + d + "&ass=" + cod, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {

            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}
function rr_detall_asin_ajustes(cod, y, m, d) {
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', './../r_paginascont/detall_ass_aj.php?y=' + y + "&m=" + m + "&d=" + d + "&ass=" + cod, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {

            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}


function detall_asini(a) {
    var f = $("#fechain_" + a).val();
    var ass = $("#assin_" + a).val();
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', './templateslimit/paginascont/detall_assini.php?fecha=' + f + "&ass=" + ass, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {

            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}

function my(id) {
    var idbl = $("#idcod").val();
    var cta = $("#tip_cuentadh").val();
    var y = $("#year").val();
    window.open('./../../../templateslimit/ModuloContable/impresiones/my_cta.php?cta=' + cta + '&bl=' + idbl + '&y=' + y, true);
}

function my_ex(id) {
    var idbl = $("#idcod").val();
    var cta = $("#tip_cuentadh").val();
    var y = $("#year").val();
//    alert(idbl);    alert(cta);    alert(y);    
    window.open('./../../../templateslimit/ModuloContable/documentos/export/ex_my_cta.php?cta=' + cta + '&bl=' + idbl + '&y=' + y, true);
}
function my_ex_dt(id) {
    var idbl = $("#idcod_dt").val();
    var cta = $("#tip_cuentadh_dt").val();
    var y = $("#year_dt").val();
//    alert(idbl);    alert(cta);    alert(y);    
    window.open('./../../../templateslimit/ModuloContable/documentos/export/ex_my_cta.php?cta=' + cta + '&bl=' + idbl + '&y=' + y, true);
}

function my_data(id) {
    var idbl = $("#idcod_dt").val();
    var cta = $("#tip_cuentadh_dt").val();
    var y = $("#year_dt").val();
//    alert(idbl);    alert(cta);    alert(y);    
    window.open('./../../../templateslimit/ModuloContable/impresiones/my_cta.php?cta=' + cta + '&bl=' + idbl + '&y=' + y, true);
}
//print x cuenta individual
function imp_taMay() {
    var cod = $("#cmp_my").val();
    var year = $("#year").val();
    var bl = $("#bl").val();
    window.open('./../../templateslimit/ModuloContable/impresiones/my_ctaindiv.php?cod=' + cod + '&year=' + year + '&bl=' + bl, true);
}
//print x periodos
function imp_taMaydatafech() {
//    var cod = $("#cmp_my").val();
    var year = $("#year").val();
    var bl = $("#bl").val();
    var fechai = $("#fechai").val();
    var fechaf = $("#fechaf").val();
//    alert(fechai);
//    alert(fechaf);
    window.open('./../../templateslimit/ModuloContable/impresiones/my_fechdata.php?year=' + year + '&bl=' + bl + '&fechai=' + fechai + '&fechaf=' + fechaf, true);
}
//print filtro cuenta y fechas
function imp_taMaydatafechf() {
//    var cod = $("#cmp_my").val();
    var year = $("#year").val();
    var bl = $("#bl").val();
    var fechai = $("#fechai").val();
    var fechaf = $("#fechaf").val();
    var tip_cuentadhp = $("#tip_cuentadhp").val();
//    alert(fechai);
//    alert(fechaf);
    window.open('./../../templateslimit/ModuloContable/impresiones/my_ffpechdata.php?year=' + year + '&bl=' + bl + '&fechai=' + fechai + '&fechaf=' + fechaf + '&ccta=' + tip_cuentadhp, true);
}

function detall_as_my(a) {
    var f = $("#fechain_" + a).val();
    var ass = $("#assin_" + a).val();
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', './../../templateslimit/paginascont/detall_as_my_ini.php?fecha=' + f + "&ass=" + ass, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {

            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}
function detall_as_my_detall(a) {
    var f = $("#fechain_" + a).val();
    var ass = $("#assin_" + a).val();
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', './../../../templateslimit/paginascont/detall_as_my_ini.php?fecha=' + f + "&ass=" + ass, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}

function detall_asiento_my_dtll(a) {
    var f = $("#fechain_" + a).val();
    var ass = $("#assin_" + a).val();
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', './../../../templateslimit/paginascont/detall_as_my.php?fecha=' + f + "&ass=" + ass, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}

function detall_asiento_my(a) {
    var f = $("#fechain_" + a).val();
    var ass = $("#assin_" + a).val();
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', './../../templateslimit/paginascont/detall_as_my.php?fecha=' + f + "&ass=" + ass, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}

function imp_libro() {
    window.open('./templateslimit/ModuloContable/documentos/impresiones/balanceimp.php');

}
function imp_assin(a) {
    var f = $("#fechain_" + a).val();
    var ass = $("#assin_" + a).val();
    window.open('./templateslimit/ModuloContable/impresiones/impasientowh.php?fechaurl=' + f + "&id_asientourl=" + ass + "&idlogeo=");
}

function imp_assin_search(a) {
    var f = $("#fechain_" + a).val();
    var ass = $("#assin_" + a).val();
    window.open('./impresiones/impasientowh.php?fechaurl=' + f + "&id_asientourl=" + ass + "&idlogeo=");
}
function imp_assin_ass_search(a) {
    var f = $("#fecha_" + a).val();
    var ass = $("#ass_" + a).val();
    window.open('./impresiones/impasientos.php?fech_url=' + f + "&id_asientourl=" + ass + "&idlogeo=");
}
function imp_assin_ass(a) {
    var f = $("#fecha_" + a).val();
    var ass = $("#ass_" + a).val();
    window.open('./templateslimit/ModuloContable/impresiones/impasientos.php?fech_url=' + f + "&id_asientourl=" + ass + "&idlogeo=");
}
function imp_assin_ass_sec() {
    var a = $("#as").val();
    var f = $("#f").val();
    var l = $("#log").val();
    window.open('../impresiones/impasientos.php?fech_url=' + f + "&id_asientourl=" + a + "&idlogeo=" + l);
}
function imp_blres(id) {
//    window.open('./impresiones/impbalanceresultados.php?prmlg=' + id);
    window.open('./impresiones/impSituacionFinanciera.php?prmlg=' + id);
}
function imp_blresUtil(id) {
    var mes = $("#mes").val();
    if (!isFinite(mes)) {
        alert("No es posible imprimir este documento");
    } else {
        window.open('./impresiones/impEstadoResultados.php?prmlg=' + id + '&month=' + mes);
    }
}
function imp_blresfechas(id, fechamin, fechamax) {
    var fechadesde = $("#fechadesde").val();
    var fechahasta = $("#fechahasta").val();
    if (fechadesde === "") {
        alert("No es posible imprimir este documento");
    } else if (fechahasta === "") {
        alert("No es posible imprimir este documento");
    } else {
        window.open('./impresiones/impFechasEstadoResultados.php?prmlg=' + id + '&datemin=' + fechadesde + '&datemax=' + fechahasta);
    }
}
function imp_ajs(ass, y, m, d, id) {
    var fec = y + '_' + m + '_' + d;
    window.open('./impresiones/impajustedetall.php?id_asientourl=' + ass + '&y=' + y + '&m=' + m + '&d=' + d + '&fechaurl=' + fec + '&idlogeo=' + id);
}
function imp_ajs_detall(ass, y, m, d, id) {
    var fec = y + '_' + m + '_' + d;
    window.open('./impresiones/impajustedetall.php?id_asientourl=' + ass + '&y=' + y + '&m=' + m + '&d=' + d + '&fechaurl=' + fec + '&idlogeo=' + id);
}
function imp_stfnl(id) {
    window.open('./impresiones/imphojadetrabajo.php?prmlg=' + id);
}
function imp_assini(a) {
    var f = $("#fechain_" + a).val();
    var ass = $("#assin_" + a).val();
    window.open('./templateslimit/ModuloContable/impresiones/impasientowh.php?fechaurl=' + f + "&id_asientourl=" + ass + "&idlogeo=");
}

//documento
function imprimir_libron()
{
    var idlogeo = $("#idlog").val();
    var year = $("#fechadoc").val();
    var id_asientourl = $("#asiento_num").val();
    window.open('./templateslimit/ModuloContable/documentos/impresiones/balanceimp.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&idlogeo=' + idlogeo + '&fechaurl=' + year);

}
function rr_imprimir_libron()
{
    var idlogeo = $("#idlog").val();
    var year = $("#fechadoc").val();
    var id_asientourl = $("#asiento_num").val();
    window.open('./ModuloContable/documentos/impresiones/balanceimp.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&idlogeo=' + idlogeo + '&fechaurl=' + year);

}
function imprimir_libronl()
{
    var idlogeo = $("#idlog").val();
    var year = $("#fechadoc").val();
    var id_asientourl = $("#asiento_num").val();
    window.open('./documentos/impresiones/balanceimp.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&idlogeo=' + idlogeo + '&fechaurl=' + year);

}
function imprimirasiento_inn()
{
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fechabi").val();
    var id_asientourl = "1";//$("#asiento_num").val()
    window.open('./templateslimit/ModuloContable/documentos/impresiones/impasiento.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&idlogeo=' + idlogeo + '&year=2010&fechaurl=' + fech_url + '&i=' + id_asientourl + '&1=1');

}
function rr_imprimirasiento_inn()
{
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fechabi").val();
    var id_asientourl = $("#asiento_num").val();
    window.open('./ModuloContable/documentos/impresiones/impasiento.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&idlogeo=' + idlogeo + '&year=2010&fechaurl=' + fech_url + '&i=' + id_asientourl + '&1=1');

}
function imprimirasiento_innl()
{
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fechabi").val();
    var id_asientourl = "1";
    window.open('./documentos/impresiones/impasiento.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&idlogeo=' + idlogeo + '&year=2010&fechaurl=' + fech_url + '&i=' + id_asientourl + '&1=1');

}
function imprimirasiento_innl_ct()
{
    alert("Esta acción no es posible desde aqui, dirigase al panel principal")
}
function imprimirmayorn()
{
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fecham").val();
    window.open('./templateslimit/ModuloContable/documentos/impresiones/impmayor.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&idlogeo=' + idlogeo + '&fechaurl=' + fech_url);
}
function rr_imprimirmayorn()
{
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fecham").val();
    window.open('./ModuloContable/documentos/impresiones/impmayor.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&idlogeo=' + idlogeo + '&fechaurl=' + fech_url);
}
function imprimirmayornl()
{
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fecham").val();
    window.open('./documentos/impresiones/impmayor.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&idlogeo=' + idlogeo + '&fechaurl=' + fech_url);
}


function imprimirbalancecompn()
{
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fechacom").val();
//    window.open('./templateslimit/ModuloContable/documentos/impresiones/impbalanceresultados.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
//    u_link&413&vlink*data_kykwww=121&key=00.003&prmlg=' + idlogeo + '&fechaurl=' + fech_url);
    window.open('./templateslimit/ModuloContable/documentos/impresiones/impSituacionFinanciera.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&prmlg=' + idlogeo + '&fechaurl=' + fech_url);

}

function rr_imprimirbalancecompn()
{
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fechacom").val();
    window.open('./ModuloContable/documentos/impresiones/impbalanceresultados.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&prmlg=' + idlogeo + '&fechaurl=' + fech_url);

}


function imprimirbalancecompnl()
{
    var idlogeo = $("#idlog").val();
    window.open('./documentos/impresiones/impbalanceresultados.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&prmlg=' + idlogeo + '&fechaurl=');

}
function imprimirsituacionfinaln()
{
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fechacom").val();
    window.open('./templateslimit/ModuloContable/documentos/impresiones/impsituacionfinal.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&prmlg=' + idlogeo + '&fechaurl=' + fech_url);

}
function rr_imprimirsituacionfinaln()
{
    var idlogeo = $("#idlog").val();
    var fech_url = $("#fechacom").val();
    window.open('./ModuloContable/documentos/impresiones/impsituacionfinal.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&prmlg=' + idlogeo + '&fechaurl=' + fech_url);

}
function imprimirsituacionfinalnl()
{
    var idlogeo = $("#idlog").val();
    window.open('./documentos/impresiones/impsituacionfinal.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&prmlg=' + idlogeo + '&fechaurl=');

}
function impplancuentasn()
{
    var idlogeo = $("#idlog").val();
    window.open('./templateslimit/ModuloContable/documentos/impresiones/impplan.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&i=' + idlogeo);
}
function rr_impplancuentasn()
{
    var idlogeo = $("#idlog").val();
    window.open('./ModuloContable/documentos/impresiones/impplan.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&i=' + idlogeo);
}
function impplancuenta_cc()
{
    var idlogeo = $("#idlog").val();
    window.open('../ModuloContable/documentos/impresiones/impplan.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&i=' + idlogeo);
}
function impplancuentasnl()
{
    var idlogeo = $("#idlog").val();
    window.open('./documentos/impresiones/impplan.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&i=' + idlogeo);
}

function conf_ass(as, fech) {
    alert(as)
    window.open('./templateslimit/ModuloContable/updatass.php?id_asientourl=' + as + '&fechaurl=' + fech);
}


function validarupd_t(campo) {
    var elcampo = document.getElementById(campo);
    if ((!validarNumero(elcampo.value)) || (elcampo.value == "")) {
        elcampo.value = "";
        elcampo.focus();
    } else {
        var name = campo;
        name = name.replace("debe", "haber");
        var elem = name.split('_');
        first = elem[0];
        second = elem[1];
        campo2 = first + "_3";

        document.getElementById(campo2).value = '0.00';
        sumarcajasdh_t();
    }
}
function validaruph_t(campo) {
    var elcampo = document.getElementById(campo);
    if ((!validarNumero(elcampo.value)) || (elcampo.value == "")) {
        elcampo.value = "";
        elcampo.focus();
    } else {
        var name = campo;
        name = name.replace("haber", "debe");
        var elem = name.split('_');
        first = elem[0];
        second = elem[1];
        campo2 = first + "_2";
        document.getElementById(campo2).value = '0.00';
        sumarcajasdh_t();
    }
}

function sumarcajasdh_t() {
    var rows = tabedit.rows.length;
    var resultVal = 0.0;
    var resultVal_h = 0.0;
    var rows = tabedit.rows.length;
    for (var i = 1; i < rows; i++) {
        var val = document.getElementById('debe' + i + "_2").value;
        var val_h = document.getElementById('haber' + i + "_3").value;
        val_h = parseFloat(val_h.replace(',', '.'));
        val = parseFloat(val.replace(',', '.'));
        resultVal_h = val_h + resultVal_h;
        resultVal = val + resultVal;
        document.getElementById('camposumadebet').value = resultVal.toFixed(2);
        document.getElementById('camposumahabert').value = resultVal_h.toFixed(2);
    }

}

function agregar_new() {
    var seleccion = document.getElementById("tip_cuentadht").value;
    var valor = $("#valort").val();
    var cod_cuentat = $("#cod_cuentat").val();
    var nom_cuentat = $("#nom_cuentat").val();
    var datetimepickert = $("#datetimepickert").val();
    var cod_grupot = $("#cod_grupot").val();
    var asiento_numt = $("#asiento_numt").val();
    var balances_realizadost = $("#balances_realizadost").val();
    var idlogt = $("#idlogt").val();
    var answer = confirm("Deseas agregar una transacción al asiento?");
    if (seleccion == 1) {
        if (answer) {
            newAlert("success", "        Agragado !!!");
//                alert("aqui")
            $.post("./scriptsPHP/add_fl_bl.php?\n\
    deb=" + valor + '&hab=' + '0.00' +
                    '&datetimepickert=' + datetimepickert +
                    '&cod_cuentat=' + cod_cuentat +
                    '&nom_cuentat=' + nom_cuentat +
                    '&cod_grupot=' + cod_grupot +
                    '&asiento_numt=' + asiento_numt +
                    '&balances_realizadost=' + balances_realizadost +
                    '&idlogt=' + idlogt, $(this).serialize(), function (data) {
                alert(data);
//                newAlert("success", " " + data);
                location.reload();
                return false;
            });
        } else {
            newAlert("success", "        Error");
        }
    } else {
        if (answer) {
            newAlert("success", "        Agregado !!!");
            $.post("./scriptsPHP/add_fl_bl.php?deb=" + '0.00' + '&hab=' + valor +
                    '&datetimepickert=' + datetimepickert +
                    '&cod_cuentat=' + cod_cuentat +
                    '&nom_cuentat=' + nom_cuentat +
                    '&cod_grupot=' + cod_grupot +
                    '&asiento_numt=' + asiento_numt +
                    '&balances_realizadost=' + balances_realizadost +
                    '&idlogt=' + idlogt, $(this).serialize(), function (data) {
                alert(data);
//                newAlert("success", " " + data);
                location.reload();
                return false;
            });
        } else {
            newAlert("success", "        Error");
        }
    }
}

function agregar_new_ass() {
    var seleccion = document.getElementById("tip_cuentadht").value;
    var valor = $("#valort").val();
    var cod_cuentat = $("#cod_cuentat").val();
    var nom_cuentat = $("#nom_cuentat").val();
    var datetimepickert = $("#datetimepickert").val();
    var cod_grupot = $("#cod_grupot").val();
    var asiento_numt = $("#asiento_numt").val();
    var balances_realizadost = $("#balances_realizadost").val();
    var idlogt = $("#idlogt").val();
    var answer = confirm("Deseas agregar una transacción al asiento?");
    if (seleccion == 1) {
        if (answer) {
            newAlert("success", "        Agregado !!!");
//                alert("aqui")
            $.post("./scriptsPHP/add_fl_ass.php?\n\
    deb=" + valor + '&hab=' + '0.00' +
                    '&datetimepickert=' + datetimepickert +
                    '&cod_cuentat=' + cod_cuentat +
                    '&nom_cuentat=' + nom_cuentat +
                    '&cod_grupot=' + cod_grupot +
                    '&asiento_numt=' + asiento_numt +
                    '&balances_realizadost=' + balances_realizadost +
                    '&idlogt=' + idlogt, $(this).serialize(), function (data) {
                alert(data);
//                newAlert("success", " " + data);
                location.reload();
                return false;
            });
        } else {
            newAlert("success", "        Error");
        }
    } else {
        if (answer) {
            newAlert("success", "        Agregado !!!");
            $.post("./scriptsPHP/add_fl_ass.php?deb=" + '0.00' + '&hab=' + valor +
                    '&datetimepickert=' + datetimepickert +
                    '&cod_cuentat=' + cod_cuentat +
                    '&nom_cuentat=' + nom_cuentat +
                    '&cod_grupot=' + cod_grupot +
                    '&asiento_numt=' + asiento_numt +
                    '&balances_realizadost=' + balances_realizadost +
                    '&idlogt=' + idlogt, $(this).serialize(), function (data) {
                alert(data);
//                newAlert("success", " " + data);
                location.reload();
                return false;
            });
        } else {
            newAlert("success", "        Error");
        }
    }
}

function deleteRowini(btn) {
    var answer = confirm("Al aceptar se eliminara un registro");
    if (answer) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    } else {
    }
}

function guardanewBalance()
{
    var answer = confirm("Al aceptar se guardara automaticamente el balance actual generado...");
    if (answer) {
        $('#formulario').submit(function (msg) {
            $.post("guardanewbalance.php", $(this).serialize(), function (data) {
                alert(data);
                var paginanuevobalance = "../../indexadmin.php";
                location.href = paginanuevobalance;
            });
            return false;
        });
    } else {
        alert("Se cancelo el registro del balance actual generado...");
    }
}
function rr_guardanewBalance()
{
    var answer = confirm("Al aceptar se guardara automaticamente el balance actual generado...");
    if (answer) {
        $('#formulario').submit(function (msg) {
            $.post("guardanewbalance.php", $(this).serialize(), function (data) {
                alert(data);
                var paginanuevobalance = "../indexadmin.php";
                location.href = paginanuevobalance;
            });
            return false;
        });
    } else {
        alert("Se cancelo el registro del balance actual generado...");
    }
}

function new_class() {
    location.href = './pag_ctas/clss.php';
}
function new_gpr() {
    location.href = './pag_ctas/gpr.php';
}
function new_cta() {
    location.href = './pag_ctas/cta.php';
}
function new_sbcta() {
    location.href = './pag_ctas/sb_cta.php';
}
function new_aux() {
    location.href = './pag_ctas/auxl.php';
}
function new_sbaux() {
    location.href = './pag_ctas/sbauxl.php';
}


//root
function r_detall_asin(a) {
    var f = $("#fecha_" + a).val();
    var ass = $("#ass_" + a).val();
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', './r_paginascont/detall_ass.php?fecha=' + f + "&ass=" + ass, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {

            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}

function r_detall_asini(a) {
    var f = $("#fechain_" + a).val();
    var ass = $("#assin_" + a).val();
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', './r_paginascont/detall_assini.php?fecha=' + f + "&ass=" + ass, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {

            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}

function r_imp_assin_ass(a) {
    var f = $("#fecha_" + a).val();
    var ass = $("#ass_" + a).val();
    window.open('./ModuloContable/impresiones/impasientos.php?fech_url=' + f + "&id_asientourl=" + ass + "&idlogeo=");
}
function sec_imp_assin_ass(a) {
    var f = $("#fecha_" + a).val();
    var ass = $("#ass_" + a).val();
    window.open('./impresiones/impasientosec.php?fech_url=' + f + "&fechaurl=" + f + "&id_asientourl=" + ass + "&idlogeo=");
}

function r_imp_assin(a) {
    var f = $("#fechain_" + a).val();
    var ass = $("#assin_" + a).val();
    window.open('./ModuloContable/impresiones/impasientowh.php?fechaurl=' + f + "&id_asientourl=" + ass + "&idlogeo=");
}

//root



function rr_agregar_new() {
    var seleccion = document.getElementById("tip_cuentadht").value;
    var valor = $("#valort").val();
    var cod_cuentat = $("#cod_cuentat").val();
    var nom_cuentat = $("#nom_cuentat").val();
    var datetimepickert = $("#datetimepickert").val();
    var cod_grupot = $("#cod_grupot").val();
    var asiento_numt = $("#asiento_numt").val();
    var balances_realizadost = $("#balances_realizadost").val();
    var idlogt = $("#idlogt").val();
    var answer = confirm("Deseas agregar una transacción al asiento?");
    //alert(""+seleccion+" "+valor+" "+" "+cod_cuentat+" "+nom_cuentat+" "+datetimepickert);
    if (seleccion == 1) {
        if (answer) {
            newAlert("success", "        Agragado !!!");
            $.post("./r_scriptsPHP/add_fl_bl.php?\n\
    deb=" + valor + '&hab=' + '0.00' +
                    '&datetimepickert=' + datetimepickert +
                    '&cod_cuentat=' + cod_cuentat +
                    '&nom_cuentat=' + nom_cuentat +
                    '&cod_grupot=' + cod_grupot +
                    '&asiento_numt=' + asiento_numt +
                    '&balances_realizadost=' + balances_realizadost +
                    '&idlogt=' + idlogt, $(this).serialize(), function (data) {
                alert(data);
//                newAlert("success", " " + data);
                location.reload();
                return false;
            });
        } else {
            newAlert("success", "        Error");
        }
    } else {
        if (answer) {
            newAlert("success", "        Agregado !!!");
            $.post("./r_scriptsPHP/add_fl_bl.php?deb=" + '0.00' + '&hab=' + valor +
                    '&datetimepickert=' + datetimepickert +
                    '&cod_cuentat=' + cod_cuentat +
                    '&nom_cuentat=' + nom_cuentat +
                    '&cod_grupot=' + cod_grupot +
                    '&asiento_numt=' + asiento_numt +
                    '&balances_realizadost=' + balances_realizadost +
                    '&idlogt=' + idlogt, $(this).serialize(), function (data) {
                alert(data);
//                newAlert("success", " " + data);
                location.reload();
                return false;
            });
        } else {
            newAlert("success", "        Error");
        }
    }
}

function rr_agregar_new_ass() {
    var seleccion = document.getElementById("tip_cuentadht").value;
    var valor = $("#valort").val();
    var cod_cuentat = $("#cod_cuentat").val();
    var nom_cuentat = $("#nom_cuentat").val();
    var datetimepickert = $("#datetimepickert").val();
    var cod_grupot = $("#cod_grupot").val();
    var asiento_numt = $("#asiento_numt").val();
    var balances_realizadost = $("#balances_realizadost").val();
    var idlogt = $("#idlogt").val();
    var answer = confirm("Deseas agregar una transacción al asiento?");
    if (seleccion == 1) {
        if (answer) {
            newAlert("success", "        Agregado !!!");
//                alert("aqui")
            $.post("./r_scriptsPHP/add_fl_ass.php?\n\
    deb=" + valor + '&hab=' + '0.00' +
                    '&datetimepickert=' + datetimepickert +
                    '&cod_cuentat=' + cod_cuentat +
                    '&nom_cuentat=' + nom_cuentat +
                    '&cod_grupot=' + cod_grupot +
                    '&asiento_numt=' + asiento_numt +
                    '&balances_realizadost=' + balances_realizadost +
                    '&idlogt=' + idlogt, $(this).serialize(), function (data) {
                alert(data);
//                newAlert("success", " " + data);
                location.reload();
                return false;
            });
        } else {
            newAlert("success", "        Error");
        }
    } else {
        if (answer) {
            newAlert("success", "        Agregado !!!");
            $.post("./r_scriptsPHP/add_fl_ass.php?deb=" + '0.00' + '&hab=' + valor +
                    '&datetimepickert=' + datetimepickert +
                    '&cod_cuentat=' + cod_cuentat +
                    '&nom_cuentat=' + nom_cuentat +
                    '&cod_grupot=' + cod_grupot +
                    '&asiento_numt=' + asiento_numt +
                    '&balances_realizadost=' + balances_realizadost +
                    '&idlogt=' + idlogt, $(this).serialize(), function (data) {
                alert(data);
//                newAlert("success", " " + data);
                location.reload();
                return false;
            });
        } else {
            newAlert("success", "        Error");
        }
    }
}

function exp_wd_num_as(id) {
    var tar = $("#tar").val();
    var fh = $("#fh").val();
    window.open('../../templates/PanelAdminLimitado/templateslimit/ModuloContable/documentos/export/' + id + '.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&tar=' + tar + '&year=2010&fh=' + fh);
}
function exp_asiento(id, b) {
    var c = b;
    var tar = $("#tara_" + c).val();
    var fh = $("#fha_" + c).val();
    window.open('../../templates/PanelAdminLimitado/templateslimit/ModuloContable/documentos/export/' + id + '.php?link&43&vlink*data=11&key=00.001u_link&423&vlink*data_ky=121&key=00.002\n\
    u_link&413&vlink*data_kykwww=121&key=00.003&tar=' + tar + '&year=2010&fh=' + fh);
}

function up_log() {
    var resultado = document.getElementById('caja');
    ajax = objetoAjax();
    ajax.open('GET', './templates/logeo/frm_log.php', true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
            tab_log();
        }
    }
    ajax.send(null);
}

function tab_log() {
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
}