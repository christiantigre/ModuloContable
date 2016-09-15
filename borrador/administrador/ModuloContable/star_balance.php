<!DOCTYPE html>
<!--Christian Tigre-->
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../login.php"
</script>';
}
?>
<html>
    <head>
        <title>Balance Inicial</title>
        <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <script src="../../js/jquery.min.js"></script>
        <script src="../../js/jquery-1.3.1.min.js"></script>
        <link href="../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <script src="../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../js/jquery.functions.js" type="text/javascript"></script>
        <script src="../../js/script.js" type="text/javascript"></script>
        <script>
            //Christian
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


        </script>
        <style>
            .contenedores{margin:60px auto;width:960px;font-family:sans-serif;font-size:15px}
            table {width:100%;box-shadow:0 0 10px #ddd;text-align:left}
            th {padding:5px;background:#555;color:#fff}
            td {padding:5px;border:solid #ddd;border-width:0 0 1px;}
            .editable span{display:block;}
            .editable span:hover {background:url(images/edit.png) 90% 50% no-repeat;cursor:pointer}

            td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
            .compa2{width: 98px}
            .compa3{width: auto;}
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

                <!--header-->
                <?Php
                include './component/headercont.php';
                ?>
                <!--header-->

            </center>
            <div id="cuerpo">
                <div id="banner_left"></div>

                <!--formulario 1-->  
                <?Php
                include '../Clases/class_binicial.php';
                $objblinicial = new class_binicial;
                $objblinicial->info_balance();
                ?>
                <!--fin formulario 1-->  

                <div id="form2"> 
                    <div id="new_ejercicio">
                        <!--formulario genera asiento-->
                        <?Php
                        $objblinicial->for_asientoini();
                        ?>
                        <!--fin formulario genera asiento-->
                    </div>
                </div>
            </div>


            <div id="contb">
                <?Php
                $objblinicial->tab_binicial();
                ?>
            </div>
        </div>

    </body>
</html>	
