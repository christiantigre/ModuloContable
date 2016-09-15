<?Php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
include '../../../../../../templates/Clases/acentos.php';
include '../../../../../../templates/Clases/construc_export.php';
date_default_timezone_set("America/Guayaquil");
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=plan_de_cuentas.xls");
include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
$accion = "/ Exporto / Exporto plan de cuentas a excel";
generaLogs($user, $accion);
require('../../../../../../templates/Clases/cliente.class.php');
$objClase = new Clase;
$consulta = $objClase->mostrar_catalgogo_cuentas();
?>
<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>PLAN DE CUENTAS</title>
    </head>
    <body>
        <?Php
        $objTab = new construc_export();
        $tab = $objTab->pln($consulta);
        ?>
    </body>
</html>