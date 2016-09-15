<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?Php
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../login.php"
</script>';
}
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];
$id= $_SESSION['id_user'];
include '../../../templates/PanelAdminLimitado/Clases/guardahistorialcuentas.php';
$accion = "/ ADMIN USUARIOS / listar / Ingreso a listado de usuarios";
generaLogs($user, $accion);
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

        <title> Usuarios </title>

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

    <body onload="listar_us()">

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
<!--                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="glyphicon glyphicon-user">
                                Usuario : 
                                <?php echo $_SESSION['username']; ?> 
                            </i> 
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="../../../templates/logeo/desconectar_usuario.php">
                            <img src="../../../images/logout.png" title="Salir" alt="Salir" />
                        </a> 
                    </li>
                </ul>-->

                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <!--                        <li class="sidebar-search">
                                                        <div class="input-group custom-search-form">
                                                            <input type="text" class="form-control" placeholder="Search...">
                                                            <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                        </div>
                                                         /input-group 
                                                    </li>-->
                            <li>
                                <a href="../../../index.php"><i class="glyphicon glyphicon-home"></i> Panel de Administraci&oacute;n </a>
                            </li>
                            <li>
                                <a href="../../../templates/PaneldeAdministrador/funcionesdeadministrador/plangrupos.php"><i class="fa fa-bar-chart-o fa-fw"></i> Catalogo de ctas</a>

                            </li>
                            <li>
                                <a href="../../../templates/PaneldeAdministrador/users/admin_us.php"><i class="fa fa-table fa-fw" ></i> Admin Usuarios </a>
                            </li>
                            <li>
                                <a href="../../../templates/ModuloContable/index_modulo_contable.php"><i class="fa fa-edit fa-fw"></i> Contabilidad </a>
                            </li>
                            <li>
                                <a href="../../../templates/PaneldeAdministrador/documentos/documentos.php"><i class="fa fa-files-o fa-fw"></i> Documentos </a>

                            </li>
                            <li>
                                <a href="../../../templates/PaneldeAdministrador/record/record.php"><i class="fa fa-sitemap fa-fw"></i> Actividad </a>

                            </li>
                            <li class="active">
                                <a href="../../../templates/PaneldeAdministrador/configuracion/indexconfig.php"><i class="fa fa-wrench fa-fw"></i> Configuracion </a>

                            </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <span id="resultado"></span>
            <div id="page-wrapper">



                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery Version 1.11.0 -->
        <script src="../../../js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../../../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../../js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="../../../js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="../../../js/plugins/dataTables/dataTables.bootstrap.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="../../../js/sb-admin-2.js"></script>

        <!--funciones js para usuario-->
        <script src="../../../js/usuarios.js"></script>
        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
        </script>

    </body>

</html>

