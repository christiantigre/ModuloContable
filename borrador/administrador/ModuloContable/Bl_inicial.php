<!DOCTYPE html>
<!--Christian Tigre-->
<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
?>
<html>
    <head>
        <title>Asientos contables</title>
        <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <script src="../../js/jquery.min.js"></script>
        <script src="../../js/jquery-1.3.1.min.js"></script>
        <link href="../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <script src="../../js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script src="../../js/jquery.functions.js" type="text/javascript"></script>
        <script src="../../js/script.js" type="text/javascript"></script>
        <style>
            .contenedores{margin:60px auto;width:960px;font-family:sans-serif;font-size:15px}
            table {width:100%;box-shadow:0 0 10px #ddd;text-align:left}
            th {padding:5px;background:#555;color:#fff}
            td {padding:5px;border:solid #ddd;border-width:0 0 1px;}
            .editable span{display:block;}
            .editable span:hover {background:url(images/edit.png) 90% 50% no-repeat;cursor:pointer}

            td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
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
        <div class="wrapper">
            <?Php
            include './component/headercont.php';
            ?>
            <div id="cuerpo">
                <div id="banner_left"></div>
                <!--formulario 1-->   
                <?Php
                include '../Clases/class_binicial.php';
                $objblinicial = new class_binicial;
                $objblinicial->info_balance();
                ?>
                <!--fin formulario 1-->   
                <!--formulario 2-->
                <?Php
                $objblinicial->form_blinicial();
                ?>
                <!--fin formulario 2-->
            </div>
            <div id="cargatablaasientos">
                <?Php 
                    $objblinicial->tab_asientos();
                ?>
            </div>
                <?Php
                    $objblinicial->tab_binicial();
                ?>
        </div>
    </body>
</html>	
