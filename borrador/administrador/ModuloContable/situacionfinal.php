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
$year = date("Y");
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../login.php"
</script>';
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        <link href="../../templateslimit/ModuloContable/css/estyle_tablas_modcontable.css" rel='stylesheet' type='text/css' />
        <link href="../../css/mod_contable.css" rel='stylesheet' type='text/css' />
        <title>Situaci&oacute;n Final</title>
    </head>
    <body>
        <div id="contenedor">
            <center>
                <?Php
                include './component/headercont.php';
                ?>    
            </center>
        </div>
        <div id="cuerpo">
            <div id="banner_left"></div>
            <!--formulario 1-->
            <div id="form1">
                <!--formulario 1-->   
                <?Php
                include '../Clases/class_binicial.php';
                $objblinicial = new class_binicial;
                $objblinicial->info_balance();
                ?>
                <!--fin formulario 1--> 
            </div>    
            <!--formulario 2-->
            <div id="form2"> 
                <div id="formulario_bl">
                    <center>
                        <!--situacion final-->
                        <?Php
                            $objblinicial->situacionfinal();
                        ?>
                        <!--fin situacion final-->
                    </center>
                </div>
            </div>
        </div>
           
</body>
</html>



