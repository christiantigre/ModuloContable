<?Php
$cta = $_GET['cta'];
$bl= $_GET['bl'];
$y = $_GET['y'];
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
include '../../../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
include '../../../../../../templates/Clases/construc_export.php';
include '../../../../../../templates/Clases/acentos.php';
date_default_timezone_set("America/Guayaquil");
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=mayor_cta.xls");
include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
$accion = "/ Exporto / Exporto mayor en documento excel";
generaLogs($user, $accion);

?>
<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>LIBR  DIARIO</title>
    </head>
    <body>
        <?Php
        $objTab = new construc_export();
        $tab = $objTab->tab_my_cta($c,$cta,$bl,$y);
        ?>
    </body>
</html>