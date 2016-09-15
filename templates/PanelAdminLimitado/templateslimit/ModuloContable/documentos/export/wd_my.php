<?Php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
include '../../../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
include '../../../../../../templates/Clases/acentos.php';
include '../../../../../../templates/Clases/construc_export.php';
date_default_timezone_set("America/Guayaquil");
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=mayor.doc");
include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
$accion = "/ Exporto / Exporto mayor documento .doc";
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
        $tab = $objTab->tab_my($c);
        ?>
    </body>
</html>