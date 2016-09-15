<!DOCTYPE html>
<!--Christian Tigre-->
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../login.php"
</script>';
}
?>
<html>
    <head>
        <title>Mayorizacion</title>
        <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <script src="../../js/jquery.min.js"></script>
        <script src="../../js/jquery-1.3.1.min.js"></script>
        <link href="../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <script src="../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../js/jquery.functions.js" type="text/javascript"></script>
        <script src="../../js/script.js" type="text/javascript"></script>
        <script>
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

            $('.clsGuardar22').live('click', function () {
                var inputs = $('#form_ejercicio').serialize();
                //alert(inputs.trim());
                $.ajax({
                    url: 'almacenartablamayorizada.php',
                    type: "POST",
                    data: inputs,
                    success: function (inputs) {
                        alert(inputs)
                    }
                });
                return false;
            });

            $('.clsGuardar2').live('click', function () {
                $('#form_ejercicio').submit(function (msg) {
                    //alert($(this).serialize()); // check to show that all form data is being submitted
                    //$.post("ggrillamayor.php", $(this).serialize(), function (data) {
                    $.post("almacenartablamayorizada.php", $(this).serialize(), function (data) {
                        alert(data); //post check to show that the mysql string is the same as submit                        
                    });
                    return false; // return false to stop the page submitting. You could have the form action set to the same PHP page so if people dont have JS on they can still use the form
                });
                $('#submitsave').css('display', 'none');
            });



        </script>
        <style>
            .contenedoresm{margin:60px auto;width:960px;font-family:sans-serif;font-size:15px}
            table {width:100%;box-shadow:0 0 10px #ddd;text-align:left}
            th {padding:5px;background:#555;color:#fff}
            td {padding:5px;border:solid #ddd;border-width:0 0 1px;}
            .editable span{display:block;}
            .editable span:hover {background:url(images/edit.png) 90% 50% no-repeat;cursor:pointer}

            td input {height:24px;width:155px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
            .compa2{width: 85px}
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
                width : 150px;
            }
            select:focus {
                outline : none;
            } 

            #table1
            {
                width:700px; height:auto;
            }
            .table1
            {
                width:700px; height:auto;
            }
        </style>
    </head>
    <body onBeforeUnload="return antesdecerrar()">
        <div id="contenedor_bl">
            <center>
                <!--header-->
                <?Php include './component/headercont.php'; ?>
                <!--fin header-->
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

                <!--formulario 2    javascript: fn_agregar();-->
                <div id="form2"> 
                    <!--formulario detalle por cuenta-->
                    <?Php $objblinicial->det_porcuenta(); ?>
                    <!--fin formulario detalle por cuenta-->
                    <div id="new_ejercicio">
                        <!--formularrio mayorizacion-->
                        <?Php $objblinicial->mayorizacion(); ?>
                        <!--fin formularrio mayorizacion-->
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>	

