<!DOCTYPE html>
<!--Christian Tigre-->
<?php
session_start();
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../login.php"
</script>';
}

if (isset($_GET['id_asientourl'])) {
    $id_asientourl = $_GET['id_asientourl'];
    $fechaurl = $_GET['fechaurl'];
    ?>
    <html>
        <head>
            <title>Detalle de Asiento</title>
            <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
            <link href="../../css/mod_contable.css" rel='stylesheet' type='text/css' />            
        </head>
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
        </style>
        <body>
            <div id="contenedor">
                <center>
                    <?Php
                    include './component/headercont.php';
                    ?>
                </center>
                <div id="cuerpo">
                    <div id="banner_left">
                        <!--formulario 1-->   
                        <?Php
                        include '../Clases/class_binicial.php';
                        $objblinicial = new class_binicial;
                        $objblinicial->info_balance();
                        ?>
                        <!--fin formulario 1--> 
                    </div>
                    <div id="formulario_bl">
                        <center>                        
                            <?Php
                            $objblinicial->detalleasiento($id_asientourl, $fechaurl);
                            ?>
                            <?php
                            }
                        ?>

                    </center>
                </div>
            </div>
        </div>        
    </body>
</html>	
