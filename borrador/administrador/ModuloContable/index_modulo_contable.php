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
        <title>Diario</title>
        <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <script src="../../js/jquery.min.js"></script>
        <link href="../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <script type="text/javascript">
            $(document).ready(function () {
                $('#horizontalTab').easyResponsiveTabs({
                    type: 'default', //Types: default, vertical, accordion           
                    width: 'auto', //auto or any width like 600px
                    fit: true   // 100% fit in a container
                });
            });


        </script>	

    </head>
    <style>
        .contenedores{margin:60px auto;width:960px;font-family:sans-serif;font-size:15px}
        table {width:72%;box-shadow:0 0 10px #ddd;text-align:left}
        th {padding:5px;background:#555;color:#fff}
        td {padding:5px;border:solid #ddd;border-width:0 0 1px;}
        .editable span{display:block;}
        .editable span:hover {background:url(images/edit.png) 90% 50% no-repeat;cursor:pointer}
        .tablib{margin-right:187px;}
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
                <div id="banner_left"></div>
                <div id="formulario_bl">
                    <center>
                        <form name="inmodcontable" id="inmodcontable" action="index_modulo_contable.php" method="post">
                            <input type="hidden" name="maxbalance" id="maxbalance" value="<?php echo $maxbalance ?>"/>
                            <h1>Libro Diario</h1>
                            <div class="mensaje"></div>
                            <?Php
                            include '../Clases/class_binicial.php';
                            $objblinicial = new class_binicial;
                            $objblinicial->tab_asientos();
                            $objblinicial->tab_binicial();
                            $objblinicial->tot_val();
                            ?>      
                        </form>      
                    </center>              
                </div>
            </div>
            
            
            <center>
                <?Php
                include './component/footer.php';
                ?>
            </center>
            
        </div>      
</body>
</html>	
