<?Php
include '../../../../../../templates/Clases/construc_export.php';
include '../../../../../../templates/Clases/Conectar.php';
include '../../../../../../templates/Clases/acentos.php';
date_default_timezone_set("America/Guayaquil");
$dbi = new Conectar();
$c = $dbi->conexion();
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=balance_inicial.doc");
include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
    $accion="/ Exporto / Exporto en documento .doc";
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