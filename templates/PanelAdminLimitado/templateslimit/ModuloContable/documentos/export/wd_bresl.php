<?Php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
include '../../../../../../templates/Clases/Conectar.php';
include '../../../../../../templates/Clases/acentos.php';
include '../../../../../../templates/Clases/construc_export.php';
date_default_timezone_set("America/Guayaquil");
$dbi = new Conectar();
$conn = $dbi->conexion();
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=balance_de_resultados.xls");
include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
$accion = "/ Exporto / Exporto balance de resultados documento .doc";
generaLogs($user, $accion);
?>
<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>BALANCE DE RESULTADOS</title>
    </head>
    <body>
        <?Php
        $objTab = new construc_export();
        $tab = $objTab->b_res($conn);
        ?>
    </body>
</html>