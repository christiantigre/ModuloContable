<?Php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;


if (isset($_GET['tar'])) {
    if (isset($_GET['fh'])) {
        include '../../../../../../templates/Clases/Conectar.php';
        include '../../../../../../templates/Clases/acentos.php';
        include '../../../../../../templates/Clases/construc_export.php';
        date_default_timezone_set("America/Guayaquil");
        $dbi = new Conectar();
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Disposition: attachment; filename=asiento".$_GET['tar'].".xls");
        include '../../../../../PanelAdminLimitado/Clases/guardahistorialdocrecord.php';
        $accion = "/ Exporto / Exporto asiento '" . $_GET['tar'] . "' a excel";
        generaLogs($user, $accion);
        ?>
        <!DOCTYPE>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Asientos</title>
            </head>
            <body>
                <?Php
                $objTab = new construc_export();
                $tab = $objTab->tab_in_num_as($dbi, $_GET['tar'],$_GET['fh']);
            }
        }
        ?>
    </body>
</html>