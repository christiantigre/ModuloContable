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

function editarusuario() {
    alert("hola mundo");
}
function tables() {
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
}

function envia_id(id) {
    var resultado = document.getElementById('caja');
//    resultado.innerHTML = '<br><br><br><center><img src="img/45.gif"></center>';
    ajax = objetoAjax();
    ajax.open("GET", "./paginas/edit_us.php?id=" + id, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {

            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}

function listar_us() {
    var resultado = document.getElementById('page-wrapper');
    ajax = objetoAjax();
    ajax.open("GET", "./paginas/lista_us.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {

            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}

function new_us() {
    var resultado = document.getElementById('page-wrapper');
    ajax = objetoAjax();
    ajax.open("GET", "./paginas/new_us.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
            tables();
        }
    }
    ajax.send(null);
}


function ver_check() {
    var checkTod = document.getElementById('todos').checked;
    var checkS = document.getElementById('priv_usS').checked;
    var checkD = document.getElementById('priv_usD').checked;
    var checkU = document.getElementById('priv_usU').checked;
    var checkI = document.getElementById('priv_usI').checked;
    var checkCU = document.getElementById('priv_usCU').checked;
    if (checkS == true && checkD == true && checkU == true && checkI == true && checkCU == true) {
//        addAlert("CONTADOR");
        createAutoClosingAlertsucc("CONTADOR", 2000);
    }
    if (checkS == true && checkD == true && checkU == true && checkI == true && checkCU == false) {
//        addAlert("SECRETARIA");
        createAutoClosingAlertsucc("SECRETARIA", 2000);
    }
    if (checkS == true && checkD == false && checkU == false && checkI == false && checkCU == false) {
//        addAlert("INVITADO");
        createAutoClosingAlertsucc("INVITADO", 2000);
    }
}
function check() {
    var checkTod = document.getElementById('todos').checked;
    var checkS = document.getElementById('priv_usS').checked;
    var checkD = document.getElementById('priv_usD').checked;
    var checkU = document.getElementById('priv_usU').checked;
    var checkI = document.getElementById('priv_usI').checked;
    var checkCU = document.getElementById('priv_usCU').checked;
    var cadena = "Tipo de usuario a crear ";
    var nuevoDiv = "";
    var nuevoInput = "";

    if (checkTod == true) {
        $('input[type=checkbox]').each(function () {
            this.checked = true;
        });
        createAutoClosingAlertsucc("CONTADOR", 2000);
    } else {
        $('input[type=checkbox]').each(function () {
            this.checked = false;
        });
        createAutoClosingAlerterr("Seleccione los privilegios del usuario", 2000);
    }
}

function addAlert(message) {
    var cadena = "Tipo de usuario a crear es : ";
    $('#alerts').append(
            '<div class="alert alert-success alert-dismissable" id="alert">' +
            '<button type="button" class="close" data-dismiss="alert">' +
            '&times;</button>' + cadena + '<strong>' + message + '</strong></div>');
}
function addpriv(message) {
    $('#alerts').append(
            '<div class="alert alert-danger alert-dismissable" id="alert">' +
            '<button type="button" class="close" data-dismiss="alert">' +
            '&times;</button><strong>' + message + '</strong></div>');
}
function createAutoClosingAlerterr(selector, delay) {
    var alert = $('#alert').alert();
    addpriv(selector);
    window.setTimeout(function () {
        alert.alert('close')
    }, delay);
}
function createAutoClosingAlertsucc(selector, delay) {
    var alert = $('#alert').alert();
    addAlert(selector);
    window.setTimeout(function () {
        alert.alert('close')
    }, delay);
}

function verifi_pass() {
    var pass_us = document.forms.form.pass_us.value;
    var pass_usverif = document.forms.form.pass_usverif.value;
    if (pass_us != pass_usverif) {
        alert("Las claves no coinciden");
        document.forms.form.pass_us.value = "";
        document.forms.form.pass_usverif.value = "";
    }
}

var bPreguntar = true;
function save_uss() {
    var name_us = $("#name_us").val();
    var pass_usverif = $("#pass_usverif").val();
    var checkS = document.getElementById('priv_usS').checked;
    var checkD = document.getElementById('priv_usD').checked;
    var checkU = document.getElementById('priv_usU').checked;
    var checkI = document.getElementById('priv_usI').checked;
    var checkCU = document.getElementById('priv_usCU').checked;
    var formulario = document.getElementById("form");
    var dato = formulario[0];
    var checkboxes = document.getElementById("form").checkbox;
    if (checkS == true){  var sel = "Y";  }else{ var sel = "N";}
    if (checkD == true){  var del = "Y";  }else{ var del = "N";}
    if (checkU == true){  var up = "Y";  }else{ var up = "N";}
    if (checkI == true){  var ins = "Y";  }else{ var ins = "N";}
    if (checkCU == true){  var cu = "Y";  }else{ var cu = "N";}
    var cont = 0;
    for (var x = 0; x < checkboxes.length; x++) {
        if (checkboxes[x].checked) {
            cont = cont + 1;
        }
    }
    if (cont == 0){
        alert("Debe asignar permisos...!!!");
            return false;
    }else {
        respuesta = confirm('¿Desea guardar el nuevo usuario?');
        if (respuesta) {
            formulario.submit();
            return true;
        
        } else {
            alert("No se aplicaran los cambios...!!!");
            return false;
        }
    }
    
}



