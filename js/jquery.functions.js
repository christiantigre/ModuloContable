function ActualizarDatos() {
    var cod_clase = $('#cod_clase').attr('value');
    var nombre_clase = $('#nombre_clase').attr('value');
    var cod_clase = $('#cod_clase').attr('value');
    var descrip_class = $("#descrip_class").attr("value");

    $.ajax({
        url: 'actualizar.php',
        type: "POST",
        data: "submit=&nombre_clase=" + nombre_clase
                + "&cod_clase=" + cod_clase + "&descrip_class=" + descrip_class + "&cod_clase=" + cod_clase,
        success: function (datos) {
            alert(datos);
            ConsultaDatos();
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}
function ActualizarDatosGrupo() {
    var nombre_grupo = $('#nombre_grupo').attr('value');
    var cod_grupo = $('#cod_grupo').attr('value');
    var descrip_grupo = $("#descrip_grupo").attr("value");

    $.ajax({
        url: 'actualizargrupo.php',
        type: "POST",
        data: "submit=&nombre_grupo=" + nombre_grupo + "&cod_grupo=" + cod_grupo + "&descrip_grupo=" + descrip_grupo,
        success: function (datos) {
            alert(datos);
            ConsultaDatosGrupo();
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}

function ActualizarDatosCuenta() {
    var nombre_cuenta = $('#nombre_cuenta').attr('value');
    var cod_cuenta = $('#cod_cuenta').attr('value');
    var descrip_cuenta = $("#descrip_cuenta").attr("value");

    $.ajax({
        url: 'actualizarcuenta_det.php',
        type: "POST",
        data: "submit=&nombre_cuenta=" + nombre_cuenta
                + "&cod_cuenta=" + cod_cuenta + "&descrip_cuenta=" + descrip_cuenta,
        success: function (datos) {
            alert(datos);
            ConsultaDatosCuenta();
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}

function generar_codigo_grupo()
{
    var seleccion = document.getElementById('t_clase_cod_clase');
    document.getElementById('cod_clasetxt').value = seleccion.options[seleccion.selectedIndex].value;
    document.getElementById('texto').value = seleccion.options[seleccion.selectedIndex].value;

}

function generar_clase_UpLogin()
{
    var seleccion = document.getElementById('crg_us');
    document.getElementById('campoaux').value = seleccion.options[seleccion.selectedIndex].value;

}

function cargarfuncion()
{

    alert('fun');

}
function ActualizarDatosSubCuenta() {
    var idt_subcuenta = $('#idt_subcuenta').attr('value');
    var nombre_subcuenta = $('#nombre_subcuenta').attr('value');
    var cod_subcuenta = $('#cod_subcuenta').attr('value');
    var descrip_subcuenta = $("#descrip_subcuenta").attr("value");

    $.ajax({
        url: 'actualizarsubcuenta.php',
        type: "POST",
        data: "submit=&nombre_subcuenta=" + nombre_subcuenta
                + "&cod_subcuenta=" + cod_subcuenta + "&descrip_subcuenta=" + descrip_subcuenta + "&idt_subcuenta=" + idt_subcuenta,
        success: function (datos) {
            alert(datos);
            ConsultaDatosSubCuenta();
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}
function ActualizarDatosCuentaAux() {
    var idt_auxiliar = $('#idt_auxiliar').attr('value');
    var nombre_cauxiliar = $('#nombre_cauxiliar').attr('value');
    var cod_cauxiliar = $('#cod_cauxiliar').attr('value');
    var descrip_auxiliar = $("#descrip_auxiliar").attr("value");

    $.ajax({
        url: 'actualizarcuentaauxiliar.php',
        type: "POST",
        data: "submit=&nombre_cauxiliar=" + nombre_cauxiliar
                + "&cod_cauxiliar=" + cod_cauxiliar + "&descrip_auxiliar=" + descrip_auxiliar + "&idt_auxiliar=" + idt_auxiliar,
        success: function (datos) {
            alert(datos);
            ConsultaDatosCuentaAux()
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}
function ActualizarDatosCategoria() {
    var tipo_user = $('#tipo_user').attr('value');
    var descrip_user = $('#descrip_user').attr('value');
    var cod_user = $('#cod_user').attr('value');

    $.ajax({
        url: 'actualizar_category.php',
        type: "POST",
        data: "submit=&tipo_user=" + tipo_user
                + "&descrip_user=" + descrip_user + "&cod_user=" + cod_user,
        success: function (datos) {
            alert(datos);
            ConsultaDatosCategoria();
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}
function ActualizarDatosUsuario() {
    var idusuario = $('#idusuario').attr('value');
    var nombre = $('#nombre').attr('value');
    var apellido = $('#apellido').attr('value');
    var email = $('#email').attr('value');
    var nacionalidad = $('#nacionalidad').attr('value');
    var cargo = $('#cargo').attr('value');
    var foto = $('#foto').attr('value');
    var fecha_nacimiento = $('#fecha_nacimiento').attr('value');
    var cedula = $('#cedula').attr('value');
    var tlf = $('#tlf').attr('value');
    var cel = $('#cel').attr('value');
    var Descrip_user = $('#Descrip_user').attr('value');
    $.ajax({
        url: 'actualizar_usuario.php',
        type: "POST",
        data: "submit=&idusuario=" + idusuario + "&nombre=" + nombre + "&apellido=" + apellido
                + "&email=" + email + "&nacionalidad=" + nacionalidad + "&cargo=" + cargo + "&foto=" + foto + "&fecha_nacimiento=" + fecha_nacimiento + "&cedula=" + cedula +
                "&tlf=" + tlf + "&cel=" + cel + "&Descrip_user=" + Descrip_user,
        success: function (datos) {
            alert(datos);
            ConsultaDatosUsuario();
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}
function ActualizarDatos_login() {
    var idlogeo = $('#idlogeo').attr('value');
    var Username = $('#Username').attr('value');
    var Contrasena = $('#Contrasena').attr('value');
    var crg_us = $('#crg_us').attr('value');
    var idusuario = $('#idusuario').attr('value');
    $.ajax({
        url: 'actualizar_login.php',
        type: "POST",
        data: "submit=&idlogeo=" + idlogeo + "&Username=" + Username + "&Contrasena=" + Contrasena
                + "&crg_us=" + crg_us + "&idusuario=" + idusuario,
        success: function (datos) {
            alert(datos);
            ConsultaDatos_Log();
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}

function ConsultaDatosCategoria() {
    $.ajax({
        url: 'consultacategorias_users.php',
        cache: false,
        type: "GET",
        success: function (datos) {
            $("#tabla").html(datos);
        }
    });
}
function ConsultaDatosUsuario() {
    $.ajax({
        url: 'consulta_users.php',
        cache: false,
        type: "GET",
        success: function (datos) {
            $("#tabla").html(datos);
        }
    });
}
function ConsultaDatos_Log() {
    $.ajax({
        url: 'consulta_logeos.php',
        cache: false,
        type: "GET",
        success: function (datos) {
            $("#tabla").html(datos);
        }
    });
}
function ConsultaDatos() {
    $.ajax({
        url: 'consulta.php',
        cache: false,
        type: "GET",
        success: function (datos) {
            $("#tabla").html(datos);
        }
    });
}
function ConsultaDatosAdmin() {
    $.ajax({
        url: 'consultaclasesadmin.php',
        cache: false,
        type: "GET",
        success: function (datos) {
            $("#tabla").html(datos);
        }
    });
}
function ConsultaDatosGrupo() {
    $.ajax({
        url: 'consultagrupo.php',
        cache: false,
        type: "GET",
        success: function (datos) {
            $("#tabla").html(datos);
        }
    });
}
function ConsultaDatosLogeo() {
    $.ajax({
        url: 'panel_logeos.php',
        cache: false,
        type: "GET",
        success: function (datos) {
            $("#tabla").html(datos);
        }
    });
}
function ConsultaDatosCuenta() {
    $.ajax({
        url: 'plancuenta_det.php',
        cache: false,
        type: "GET",
        success: function (datos) {
            $("#tabla").html(datos);
        }
    });
}
function ConsultaDatosCuentaAux() {
    $.ajax({
        url: 'consultacuentaauxiliar.php',
        cache: false,
        type: "GET",
        success: function (datos) {
            $("#tabla").html(datos);
        }
    });
}
function ConsultaDatosSubCuenta() {
    $.ajax({
        url: 'consultasubcuentas.php',
        cache: false,
        type: "GET",
        success: function (datos) {
            $("#tabla").html(datos);
        }
    });
}

function EliminarDato(idt_clase) {
    var msg = confirm("Desea eliminar este dato?")
    if (msg) {
        $.ajax({
            url: 'eliminar.php',
            type: "GET",
            data: "idt_clase=" + idt_clase,
            success: function (datos) {
                ConsultaDatos();
                alert(datos);
                $("#formulario").hide();
                $("#tabla").show();
            }
        });
    }
    return false;
}
function EliminarDatoCat(cod_user) {
    var msg = confirm("Desea eliminar este dato?")
    if (msg) {
        $.ajax({
            url: 'eliminarcategoria.php',
            type: "GET",
            data: "idt_clase=" + idt_clase,
            success: function (datos) {
                ConsultaDatosCategoria();
                alert(datos);
                $("#formulario").hide();
                $("#tabla").show();
            }
        });
    }
    return false;
}
function Eliminar_Us(idusuario) {
    var msg = confirm("Desea eliminar este dato?")
    if (msg) {
        $.ajax({
            url: 'eliminar_us.php',
            type: "GET",
            data: "idusuario=" + idusuario,
            success: function (datos) {
                ConsultaDatosUsuario();
                alert(datos);
                $("#formulario").hide();
                $("#tabla").show();
            }
        });
    }
    return false;
}
function Eliminar_C_Log(idlogeo) {
    var msg = confirm("Desea eliminar este dato?")
    if (msg) {
        $.ajax({
            url: 'eliminar_c_login.php',
            type: "GET",
            data: "idlogeo=" + idlogeo,
            success: function (datos) {
                ConsultaDatos_Log()
                alert(datos);
                $("#formulario").hide();
                $("#tabla").show();
            }
        });
    }
    return false;
}
function EliminarDatoGrupo(cod_grupo) {
    var msg = confirm("Desea eliminar este dato?");
    if (msg) {
        $.ajax({
            url: 'eliminargrupo.php',
            type: "GET",
            data: "cod_grupo=" + cod_grupo,
            success: function (datos) {
                ConsultaDatosGrupo();
                alert(datos);
                $("#formulario").hide();
                $("#tabla").show();
            }
        });
    }
    return false;
}

function EliminarDatoClase(cod_clase) {
    var msg = confirm("Desea eliminar este dato?")
    if (msg) {
        $.ajax({
            url: 'eliminar.php',
            type: "GET",
            data: "cod_clase=" + cod_clase,
            success: function (datos) {
                ConsultaDatos();
                alert(datos);
                $("#formulario").hide();
                $("#tabla").show();
            }
        });
    }
    return false;
}
function EliminarDatoCuenta(idt_cuenta) {
    var msg = confirm("Desea eliminar este dato?")
    if (msg) {
        $.ajax({
            url: 'eliminarcuenta.php',
            type: "GET",
            data: "idt_cuenta=" + idt_cuenta,
            success: function (datos) {
                ConsultaDatosCuenta();
                alert(datos);
                $("#formulario").hide();
                $("#tabla").show();
            }
        });
    }
    return false;
}
function EliminarDatoCuenta_det(cod_cuenta) {
    var msg = confirm("Desea eliminar este dato?")
    if (msg) {
        $.ajax({
            url: 'eliminarcuenta_det.php',
            type: "GET",
            data: "cod_cuenta=" + cod_cuenta,
            success: function (datos) {
                ConsultaDatosCuenta();
                alert(datos);
                $("#formulario").hide();
                $("#tabla").show();
            }
        });
    }
    return false;
}
function EliminarDatoCuentaAux(idt_auxiliar) {
    var msg = confirm("Desea eliminar este dato?")
    if (msg) {
        $.ajax({
            url: 'eliminarauxiliar.php',
            type: "GET",
            data: "idt_auxiliar=" + idt_auxiliar,
            success: function (datos) {
                ConsultaDatosCuentaAux();
                alert(datos);
                $("#formulario").hide();
                $("#tabla").show();
            }
        });
    }
    return false;
}
function EliminarDatoSubCuenta(idt_subcuenta) {
    var msg = confirm("Desea eliminar este dato?")
    if (msg) {
        $.ajax({
            url: 'eliminarsubcuenta.php',
            type: "GET",
            data: "idt_subcuenta=" + idt_subcuenta,
            success: function (datos) {
                ConsultaDatosSubCuenta();
                alert(datos);
                $("#formulario").hide();
                $("#tabla").show();
            }
        });
    }
    return false;
}
function GrabarDatos() {
    var nombre_clase = $('#nombre_clase').attr('value');
    var cod_clase = $('#cod_clase').attr('value');
    var descrip_class = $("#descrip_class").attr("value");

    $.ajax({
        url: 'nuevo.php',
        type: "POST",
        data: "submit=&nombre_clase=" + nombre_clase + "&cod_clase=" + cod_clase + "&descrip_class=" + descrip_class,
        success: function (datos) {
            ConsultaDatos();
            alert(datos);
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}
function GrabarDatosCuenta() {
    var nombre_cuenta = $('#nombre_cuenta').attr('value');
    var cod_cuenta = $('#cod_cuenta').attr('value');
    var descrip_cuenta = $("#descrip_cuenta").attr("value");

    $.ajax({
        url: 'nuevocuenta.php',
        type: "POST",
        data: "submit=&nombre_cuenta=" + nombre_cuenta + "&cod_cuenta=" + cod_cuenta + "&descrip_cuenta=" + descrip_cuenta,
        success: function (datos) {
            ConsultaDatosCuenta();
            alert(datos);
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}
function GrabarLogin() {
    var newcod_us = $('#newcod_us').attr('value');
    var pass = $('#pass').attr('value');
    var usuario = $("#usuario").attr("value");
    var crg_us = $("#crg_us").attr("value");
    var idusuario = $("#idusuario").attr("value");

    $.ajax({
        url: 'new_logeo.php',
        type: "POST",
        data: "submit=&newcod_us=" + newcod_us + "&pass=" + pass + "&usuario=" + usuario + "&crg_us=" + crg_us + "&idusuario=" + idusuario,
        success: function (datos) {
            ConsultaDatosLogeo();
            alert(datos);
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}
function GrabarDatosSubCuenta() {
    var nombre_subcuenta = $('#nombre_subcuenta').attr('value');
    var cod_subcuenta = $('#cod_subcuenta').attr('value');
    var descrip_subcuenta = $("#descrip_subcuenta").attr("value");

    $.ajax({
        url: 'nuevosubcuenta.php',
        type: "POST",
        data: "submit=&nombre_subcuenta=" + nombre_subcuenta + "&cod_subcuenta=" + cod_subcuenta + "&descrip_subcuenta=" + descrip_subcuenta,
        success: function (datos) {
            ConsultaDatosSubCuenta();
            alert(datos);
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}
function GrabarDatosCuentaAux() {
    var nombre_cauxiliar = $('#nombre_cauxiliar').attr('value');
    var cod_cauxiliar = $('#cod_cauxiliar').attr('value');
    var descrip_auxiliar = $("#descrip_auxiliar").attr("value");

    $.ajax({
        url: 'nuevocuentaauxiliar.php',
        type: "POST",
        data: "submit=&nombre_cauxiliar=" + nombre_cauxiliar + "&cod_cauxiliar=" + cod_cauxiliar + "&descrip_auxiliar=" + descrip_auxiliar,
        success: function (datos) {
            ConsultaDatosCuentaAux();
            alert(datos);
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}
function GrabarDatos() {
    var nombre_clase = $('#nombre_clase').attr('value');
    var cod_clase = $('#cod_clase').attr('value');
    var descrip_class = $("#descrip_class").attr("value");

    $.ajax({
        url: 'nuevo.php',
        type: "POST",
        data: "submit=&nombre_clase=" + nombre_clase + "&cod_clase=" + cod_clase + "&descrip_class=" + descrip_class,
        success: function (datos) {
            ConsultaDatosGrupo();
            alert(datos);
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}
function GrabarDatosGrupo() {
    var nombre_grupo = $('#nombre_grupo').attr('value');
    var cod_grupo = $('#cod_grupo').attr('value');
    var descrip_grupo = $("#descrip_grupo").attr("value");
    var t_clase_cod_clase = $('#t_clase_cod_clase').attr('value');

    $.ajax({
        url: 'nuevogrupo.php',
        type: "POST",
        data: "submit=&nombre_grupo=" + nombre_grupo + "&cod_grupo=" + cod_grupo + "&descrip_grupo=" + descrip_grupo + "&t_clase_cod_clase=" + t_clase_cod_clase,
        success: function (datos) {
            ConsultaDatosGrupo();
            alert(datos);
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}
function GrabarDatosClaseAdmin() {
    var nombre_clase = $('#nombre_clase').attr('value');
    var cod_clase = $('#cod_clase').attr('value');
    var descrip_class = $("#descrip_class").attr("value");

    $.ajax({
        url: 'nuevaclase.php',
        type: "POST",
        data: "submit=&nombre_clase=" + nombre_clase + "&cod_clase=" + cod_clase + "&descrip_class=" + descrip_class,
        success: function (datos) {
            ConsultaDatosAdmin();
            alert(datos);
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}
function GrabarDatosClase() {
    var nombre_clase = $('#nombre_clase').attr('value');
    var cod_clase = $('#cod_clase').attr('value');
    var descrip_class = $("#descrip_class").attr("value");

    $.ajax({
        url: 'nuevo.php',
        type: "POST",
        data: "submit=&nombre_clase=" + nombre_clase + "&cod_clase=" + cod_clase + "&descrip_class=" + descrip_class,
        success: function (datos) {
            ConsultaDatos();
            alert(datos);
            $("#formulario").hide();
            $("#tabla").show();
        }
    });
    return false;
}

function Cancelar() {
    $("#formulario").hide();
    $("#tabla").show();
    return false;
}

//cargar datos desde datalist
//function cargarnombredecuenta(){        //alert('hola');    }


// funciones del calendario
function update_calendar() {
    var month = $('#calendar_mes').attr('value');
    var year = $('#calendar_anio').attr('value');

    var valores = 'month=' + month + '&year=' + year;

    $.ajax({
        url: 'calendario.php',
        type: "GET",
        data: valores,
        success: function (datos) {
            $("#calendario_dias").html(datos);
        }
    });
}
function update_calendar() {
    var month = $('#calendar_mes').attr('value');
    var year = $('#calendar_anio').attr('value');

    var valores = 'month=' + month + '&year=' + year;

    $.ajax({
        url: 'calendarios.php',
        type: "GET",
        data: valores,
        success: function (datos) {
            $("#calendario_dias").html(datos);
        }
    });
}

function set_date(date) {
    $('#fecha_nacimiento').attr('value', date);
    show_calendar();
}
function show_calendar() {
    $('#calendario').toggle();
}
     