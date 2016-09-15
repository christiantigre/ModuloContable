<?Php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
include '../../../../../../templates/Clases/construc_export.php';
include '../../../../../../templates/Clases/Conectar.php';
include '../../../../../../templates/Clases/acentos.php';
date_default_timezone_set("America/Guayaquil");
$dbi = new Conectar();
$c = $dbi->conexion();
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=balance_inicial.xls");
include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
$accion = "/ Exporto / Exporto en documento excel";
generaLogs($user, $accion);
?>
<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>BALANCE INICIAL</title>
    </head>
    <body>
         <?Php
        $objTab = new construc_export();
        $tab = $objTab->tab_as($c);
        ?>
    </body>
</html>