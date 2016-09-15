<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?Php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../../login.php"
</script>';
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <link href="../../templateslimit/ModuloContable/css/estyle_tablas_modcontable.css" rel='stylesheet' type='text/css' />
        <link href="../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <style>
            table.bl tr:nth-child(2) {
            }
        </style>
        <title>Balance de Comprobaci&oacute;n</title>
    </head>
    <body>
        <div id="contenedor">
            <center>
                <!--header-->   
                <?Php
                include './component/headercont.php';
                ?>
                <!--fin header-->   
            </center>
        </div>
        <div id="cuerpo">
            <div id="banner_left"></div>
            <!--formulario 1-->
            <div id="form1">
                <!--informacion del balance-->
                <?Php
                include '../Clases/class_binicial.php';
                $objblinicial = new class_binicial;
                $objblinicial->info_balance();
                ?>
                <!--fin informacion del balance-->
            </div>    
            <!--formulario 2-->
            <div id="form2"> 
                <div id="formulario_bl">
                    <center>
                        <form name="BalancedeComprobacion" id="BalancedeComprobacion" action="balancederesultados.php" method="post">
                            <center>
                                <div class="mensaje"></div>
                                <?php
                                $objblinicial->balance_res();
                                ?>
                                <!--fin carga de el balance de resultados por grupos-->


                                <!--Inicia tabla de resultados en campos-->
                                <?Php
                                $objblinicial->totval_blres();
                                ?>
                                <!--Termina tabla de resultados en campos-->

                            </center>

                        </form>
                    </center>
                </div>
            </div>
        </div>
    </body>
</html>

