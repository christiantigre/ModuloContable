<?Php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
include '../../../../../../templates/Clases/Conectar.php';
include '../../../../../../templates/Clases/acentos.php';
include '../../../../../../templates/Clases/construc_export.php';
date_default_timezone_set("America/Guayaquil");
$dbi = new Conectar();
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=situacion_final.xls");
include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
$accion = "/ Exporto / Exporto situacion final a documento excel";
generaLogs($user, $accion);
?>
<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SITUACION FINAL</title>
    </head>
    <body>
        <?Php
        $objTab = new construc_export();
        $tab = $objTab->st_fnl($dbi);
        ?>
    </body>
</html>