<?php
// SBMD - Simple Backup Mysql Database script
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
date_default_timezone_set("America/Guayaquil");
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../login.php"
</script>';
}
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];
$id = $_SESSION['id_user'];

include '../../../templates/PanelAdminLimitado/Clases/guardahistorial_backups.php';
$accion = "/ BACKUPS / ingreso / Ingreso a respaldos";
generaLogs($user, $accion);

$lang = 'en';  //indice of the "lang_...json" file with texts
$dir = 'C:\Users\ANDRES/';  //folder to store the ZIP archive with SQL backup
//session_start();
$html = $bmd_re = '';

//set object of backupmysql class
include 'backupmysql.class.php';
$bk = new backupmysql($lang, $dir);

$frm = '<h1>' . $bk->langTxt('msg_bmk') . '</h1><form class="form-control" action="' . $_SERVER['PHP_SELF'] . '" method="post" id="frm">
<h4>' . $bk->langTxt('msg_connect') . '</h4>
' . $bk->langTxt('msg_server') . ': <input class="form-control" type="text" name="host" value="localhost"><br>
' . $bk->langTxt('msg_user') . ': <input class="form-control" type="password" name="user" value="' . $_SESSION['username'] . '"><br>
' . $bk->langTxt('msg_pass') . ': <input class="form-control" type="password" name="pass" value="" requerid="requerid"><br>
' . $bk->langTxt('msg_database') . ': <input class="form-control" type="password" name="dbname" value="condata"><br>
<input type="submit" class="btn btn-success" value="' . $bk->langTxt('msg_send') . '">
</form>';

//if not form send, set form wiith fields for connection data
if ((!isset($_POST) || count($_POST) == 0) && !isset($_SESSION['bmd_re'])) {
    if (isset($_SESSION['mysql']))
        unset($_SESSION['mysql']);
    if (isset($_SESSION['bmd_re']))
        unset($_SESSION['bmd_re']);
    $html = $frm;
}
else if (isset($_POST['host']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['dbname'])) {
    $_POST = array_map('trim', array_map('strip_tags', $_POST));
    $_SESSION['mysql'] = ['host' => $_POST['host'], 'user' => $_POST['user'], 'pass' => $_POST['pass'], 'dbname' => $_POST['dbname']];
}

//if session with data for connecting to MySQL database (MySQL server, user, password, database name)
if (isset($_SESSION['mysql'])) {
    @set_time_limit(600);

    $bk->setMysql($_SESSION['mysql']);  //set connection data
    //if form with tables to backup, create ZIP archive with backup. Else: restore backup, or Delete ZIP
    if (isset($_POST['tables']) || isset($_POST['bmd_zip'])) {
        if (isset($_POST['tables'])) {
            $tables = array_map('strip_tags', $_POST['tables']);  //store tables in object
            $bmd_re = $bk->saveBkZip($tables);
        } else if (isset($_POST['bmd_zip'])) {
            if (isset($_POST['file'])) {
                $_POST['file'] = trim(strip_tags($_POST['file']));
                if ($_POST['bmd_zip'] == 'res_file')
                    $bmd_re = $bk->restore($_POST['file']);
                else if ($_POST['bmd_zip'] == 'get_file')
                    $bmd_re = $bk->getZipFile($_POST['file']);  //when to get ZIP file
                else if ($_POST['bmd_zip'] == 'del_file')
                    $bmd_re = $bk->delFile($_POST['file']);  //when to delete ZIP
                
            } else
                $bmd_re = $bk->langTxt('er_sel_file');
        }

        //Keep response, Refresh to not send form-data again if refreshed
        $_SESSION['bmd_re'] = $bmd_re;
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    //get response after refresh, delete that session
    if (isset($_SESSION['bmd_re'])) {
        $bmd_re = $_SESSION['bmd_re'];
        unset($_SESSION['bmd_re']);
    }

    $html = '<h1>' . sprintf($bk->langTxt('msg_conn_to'), $_SESSION['mysql']['dbname']) . '</h1><div id="bmd_re">' . $bmd_re . '</div>';

    $tables = $bk->getListTables();  //array with [f, er] (form, error)
    //if not error when get to show tables, add form with checkboxes, else $frm
    if ($tables['er'] == '')
        $html .= '<a href="' . $_SERVER['PHP_SELF'] . '" title="' . $bk->langTxt('msg_conn_other') . '" id="a_cd">&bull; '
                . $bk->langTxt('msg_conn_other') . '</a><h2 id="tab_frm_cht" class="tabvi">'
                . '' . $tables['f'] . $bk->getListZip($dir);
    else
        $html = '<div id="bmd_re">' . $tables['er'] . '</div>' . $frm;
}


//set texts that will be added in JS (in bmd_lang)
$lang_js = '{
"msg_when_del":"' . str_replace('"', '\"', $bk->langTxt('msg_when_del')) . '",
"msg_loading":"' . str_replace('"', '\"', $bk->langTxt('msg_loading')) . '"
}';

header('Content-type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?Php
$hh = '../';
$sess = '../../';
$raiz = '../../';
$carpetas = '../../../';
?>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title> Backup </title>

        <!-- Bootstrap Core CSS -->
        <link href="../../../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../../../css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../../../css/sb-admin-2.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link href="../../../css/plugins/dataTables.bootstrap.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../../../css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        <?Php
                        require('../../../templates/Clases/empresa.php');
                        $objClase = new Empresa;
                        ?>
                        <img src="../../../images/uploads/<?Php $objClase->logo_cl(); ?>" class="img-responsive img-rounded" style="width:329px;height: 50px; margin-top: -15px;"/>
                    </a>
                </div>
                <!-- /.navbar-header -->
                <?Php
                require('../../../templates/Clases/menus.php');
                $objMenu = new menus();
                $objMenu->menu_header_root($hh, $sess, $user, $id);
                ?>

                <div class="navbar-default sidebar" role="navigation">
                    <?PHP
                    $objMenu->menu_admin($raiz, $carpetas);
                    ?>
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <span id="resultado"></span>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"> Respaldo de datos </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Copias de seguridad
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form method="POST" id="form" name="form" action="bk_up.php">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
<?php echo $html; ?>
                                        </table>
                                    </form>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        <script>
            // <![CDATA[
            var bmd_lang = <?php echo $lang_js; ?>  //object with texts from $lang

            //display loading message
            function bmdLoading() {
                document.querySelector('body').insertAdjacentHTML('beforeend', '<div id="bmd_load"><span>' + bmd_lang.msg_loading + '</span></div>');
            }

            function check1() {
                var checkTod = document.getElementById('todos').checked;
                if (checkTod == true) {
                    $('input[type=checkbox]').each(function () {
                        this.checked = true;
                    });
                    createAutoClosingAlertsucc("CONTADOR", 2000);
                } else {
                    $('input[type=checkbox]').each(function () {
                        this.checked = false;
                    });
                    createAutoClosingAlerterr("Seleccione los privilegios del usuario", 2000);
                }
            }

            //if #frm_zip
            var frm_zip = document.getElementById('frm_zip');
            if (frm_zip) {
                var dir_bk = document.getElementById('dir_bk').value + '/';
                var zip_files = document.querySelectorAll('#frm_zip .zip_files');

                //get buttons in #frm_zip, register click to submit form according to button
                if (zip_files) {
                    var btn_zip = document.querySelectorAll('#frm_zip #res_file, #frm_zip #get_file, #frm_zip #del_file');
                    for (var i = 0; i < btn_zip.length; i++) {
                        btn_zip[i].addEventListener('click', function (e) {
                            for (var i2 = 0; i2 < zip_files.length; i2++) {
                                if (zip_files[i2].checked === true) {
                                    var conf_del = (e.target.id == 'del_file') ? window.confirm(bmd_lang.msg_when_del) : true;
                                    if (conf_del) {
                                        frm_zip['bmd_zip'].value = e.target.id;
                                        if (e.target.id != 'get_file')
                                            bmdLoading();  //show Loading if not get_file request
                                        frm_zip.submit();
                                    }
                                    break;
                                }
                            }
                        });
                    }
                }

                /* Tabs effect ( http://coursesweb.net/ ) */

                var h2tabs = document.querySelectorAll('h2');
                var frm_cht = document.getElementById('frm_cht');
                // sets active tab, hides tabs content and shows content associated to current active tab
                // receives the id of active tab
                function tabsCnt(tab_id) {
                    document.querySelector('h2.tabvi').removeAttribute('class');
                    document.getElementById(tab_id).setAttribute('class', 'tabvi');
                    frm_zip.style.display = 'none';
                    frm_cht.style.display = 'none';
                    document.getElementById(tab_id.replace('tab_', '')).style.display = 'inline-block';
                }

                // registers click for tabs
                for (var i = 0; i < h2tabs.length; i++)
                    h2tabs[i].addEventListener('click', function () {
                        tabsCnt(this.id);
                    });

                //on submit forms, show Loading
                frm_cht.addEventListener('submit', bmdLoading);
                frm_zip.addEventListener('submit', bmdLoading);
            }
            // ]]>
        </script>
        <!-- jQuery Version 1.11.0 -->
        <script src="../../../js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../../../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../../js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../../../js/sb-admin-2.js"></script>


    </body>

</html>

