<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menus
 *
 * @author ANDRES
 */
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");
$_SESSION['username'] = $_SESSION['loginu'];
$id_usuario = $_SESSION['username'];
$user = strtoupper($id_usuario);
$idlogeobl = $_SESSION['id_user'];

class menus {

//menus para root
    function menu_header_root($hh, $sess, $user, $id) {
        ?>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="<?Php echo $hh ?>indexadmin.php" ><i class="glyphicon glyphicon-home"></i> PANEL INICIAL </a>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> <?Php echo strtoupper($user); ?></a>
                    </li>
        <!--                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>-->
                    <li class="divider"></li>
                    <li><a href="<?Php echo $sess ?>logeo/desconectar_usuario.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <?Php
    }

    function menu_admin($raiz, $carpetas) {
        ?>
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="<?Php echo $raiz ?>PaneldeAdministrador/indexadmin.php"><i class="glyphicon glyphicon-home"></i> Panel de Administraci&oacute;n </a>
                </li>
                <li>
                    <a href="" onClick="">
                        <i class="glyphicon glyphicon-list-alt"></i> Cat&aacute;logo de cuentas 
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/cuentas/cc_ini.php"><i class="glyphicon glyphicon-stats"></i> Catalogo de cuentas</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/cuentas/cc_clss.php"><i class="glyphicon glyphicon-stats"></i> Clases</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/cuentas/cc_gpr.php"><i class="glyphicon glyphicon-stats"></i> Grupos</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/cuentas/cc_ctas.php"><i class="glyphicon glyphicon-stats"></i> Cuentas</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/cuentas/cc_sbctas.php"><i class="glyphicon glyphicon-stats"></i> Sub - Cuentas</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/cuentas/cc_aux.php"><i class="glyphicon glyphicon-stats"></i> Cuenta Auxiliar</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/cuentas/cc_sbaux.php"><i class="glyphicon glyphicon-stats"></i> Sub - Cuenta Auxiliar</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href=""><i class="fa fa-table fa-fw" ></i> Admin Usuarios <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/users/admin_us.php"><i class="glyphicon glyphicon-user"></i> Usuarios</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href=""><i class="fa fa-edit fa-fw"></i> Contabilidad <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/indexadmin.php"><i class="glyphicon glyphicon-list-alt"></i> Libro</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/ModuloContable/ini_cont.php"><i class="glyphicon glyphicon-list-alt"></i> Balance Inicial</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/ModuloContable/as_cont.php"><i class="glyphicon glyphicon-list-alt"></i> Asientos</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/ModuloContable/cont_my.php"><i class="glyphicon glyphicon-list-alt"></i> Mayorizaci&oacute;n</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/ModuloContable/cont_bresult.php"><i class="glyphicon glyphicon-list-alt"></i> Balance de Comprobaci&oacute;n</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/ModuloContable/cont_stfnl.php"><i class="glyphicon glyphicon-list-alt"></i> Situaci&oacute;n Final </a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/ModuloContable/cont_aj_lib.php"><i class="glyphicon glyphicon-list-alt"></i> Ajustes </a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/ModuloContable/cont_op.php"><i class="glyphicon glyphicon-list-alt"></i> Buscar </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-files-o fa-ban"></i> Documentos <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="" onclick="rr_imprimirasiento_inn()"><i class="glyphicon glyphicon-print"></i> Imp Bl Inicial</a>
                        </li>
                        <li>
                            <a href="" onclick="rr_imprimir_libron();"><i class="glyphicon glyphicon-print"></i> Imp Asientos</a>
                        </li>
                        <li>
                            <a href="" onclick="rr_imprimirmayorn();"><i class="glyphicon glyphicon-print"></i> Imp Mayor</a>
                        </li>
                        <li>
                            <a href="" onclick="rr_imprimirbalancecompn()"><i class="glyphicon glyphicon-print"></i> Imp Balance comparaci&oacute;n</a>
                        </li>
                        <li>
                            <a href="" onclick="rr_imprimirsituacionfinaln()"><i class="glyphicon glyphicon-print"></i> Imp Perdidas y Ganancias</a>
                        </li>                                    
                        <li>
                            <a href="" onclick="rr_impplancuentasn()"><i class="glyphicon glyphicon-print"></i> Plan de Cuentas</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href=""><i class="fa fa-sitemap fa-fw"></i> Actividad <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/record/rcd.php"><i class="glyphicon glyphicon-list-alt"></i> Registro</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <!--class="active"-->
                    <a href=""><i class="fa fa-wrench fa-fw"></i> Configuracion <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/configuracion/confemp.php"><i class="glyphicon glyphicon-data"></i> Database</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/configuracion/confemp.php"><i class="glyphicon glyphicon-wrench"></i> Confiruraci&oacute;n</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/PaneldeAdministrador/backups/bk_up.php"><i class="glyphicon glyphicon-hdd"></i> Backup</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <?Php
    }

    //menus cont  

    function menu_header($carpeta,$user, $id) {
        ?>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/indexadmin.php" ><i class="glyphicon glyphicon-home"></i> PANEL INICIAL</a>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> <?Php echo strtoupper($user); ?></a>
                    </li>
        <!--                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>-->
                    <li class="divider"></li>
                    <li><a href="<?Php echo $carpeta; ?>logeo/desconectar_usuario.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <?Php
    }

    function menu_indexadmin_row($carpeta) {
        ?>
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">

                <li>
                    <a href="#" onClick="">
                        <i class="glyphicon glyphicon-list-alt"></i> CATALOGO DE CUENTAS 
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/cuentas/cc_ini.php"><i class="glyphicon glyphicon-stats"></i> Catalogo de cuentas</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/cuentas/cc_clss.php"><i class="glyphicon glyphicon-stats"></i> Clases</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/cuentas/cc_gpr.php"><i class="glyphicon glyphicon-stats"></i> Grupos</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/cuentas/cc_ctas.php"><i class="glyphicon glyphicon-stats"></i> Cuentas</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/cuentas/cc_sbctas.php"><i class="glyphicon glyphicon-stats"></i> Sub - Cuentas</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/cuentas/cc_aux.php"><i class="glyphicon glyphicon-stats"></i> Cuenta Auxiliar</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/cuentas/cc_sbaux.php"><i class="glyphicon glyphicon-stats"></i> Sub - Cuenta Auxiliar</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> CONTABILIDAD <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/indexadmin.php"><i class="glyphicon glyphicon-list-alt"></i> Libro</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/ModuloContable/ini_cont.php"><i class="glyphicon glyphicon-list-alt"></i> Balance Inicial</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/ModuloContable/as_cont.php"><i class="glyphicon glyphicon-list-alt"></i> Asientos</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/ModuloContable/cont_my.php"><i class="glyphicon glyphicon-list-alt"></i> Mayorizaci&oacute;n</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/ModuloContable/cont_EstResult.php"><i class="glyphicon glyphicon-list-alt"></i> Estado de Situaci&oacute;n Financiera.</a>
                        </li>
                        <li>
                            <!--<a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/ModuloContable/cont_EstResultUtil.php"><i class="glyphicon glyphicon-list-alt"></i> Estado de resultados </a>-->
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/ModuloContable/cont_stfnl.php"><i class="glyphicon glyphicon-list-alt"></i> Estado de resultados </a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/ModuloContable/cont_aj_lib.php"><i class="glyphicon glyphicon-list-alt"></i> Ajustes </a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/ModuloContable/cont_op.php"><i class="glyphicon glyphicon-list-alt"></i> Buscar </a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-files-o fa-ban"></i> DOCUMENTOS <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="" onclick="imprimirasiento_inn()"><i class="glyphicon glyphicon-print"></i> Imp Bl Inicial</a>
                        </li>
                        <li>
                            <a href="" onclick="imprimir_libron();"><i class="glyphicon glyphicon-print"></i> Imp Asientos</a>
                        </li>
                        <li>
                            <a href="" onclick="imprimirmayorn();"><i class="glyphicon glyphicon-print"></i> Imp Mayor</a>
                        </li>
                        <li>
                            <a href="" onclick="imprimirbalancecompn()"><i class="glyphicon glyphicon-print"></i> Imp Estado de Situaci&oacute;n Financiera</a>
                        </li>
                        <li>
                            <a href="" onclick="imprimirsituacionfinaln()"><i class="glyphicon glyphicon-print"></i> Imp Estado de resultados</a>
                        </li>                                    
                        <li>
                            <a href="" onclick="impplancuentasn()"><i class="glyphicon glyphicon-print"></i> Plan de Cuentas</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/ModuloContable/export/export_files.php"><i class="glyphicon glyphicon-export"></i> Exportar </a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="forms.html"><i class="glyphicon glyphicon-calendar"></i> ACTIVIDAD <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?Php echo $carpeta; ?>PanelAdminLimitado/templateslimit/ModuloContable/hs_record.php"><i class="glyphicon glyphicon-folder-open"></i> Ver Historial</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <!--class="active"-->
                    <a href=""><i class="fa fa-wrench fa-fw"></i> CONFIGURACI&Oacute;N <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?Php echo $carpeta ?>PanelAdminLimitado/templateslimit/backups/bk_up.php"><i class="glyphicon glyphicon-hdd"></i> Backup</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <?php
    }

    

//    secretaria


    function menu_sec($raiz, $carpetas) {
        ?>
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="<?Php echo $raiz ?>Panelsecretaria/indexsec.php"><i class="glyphicon glyphicon-home"></i> Panel de Administraci&oacute;n </a>
                </li>
                 <li>
                    <a href=""><i class="fa fa-edit fa-fw"></i> Contabilidad <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/Panelsecretaria/indexsec.php"><i class="glyphicon glyphicon-list-alt"></i> Libro</a>
                        </li>
                        <li>
                            <a href="<?Php echo $carpetas ?>templates/Panelsecretaria/Bl_inicialsecre.php"><i class="glyphicon glyphicon-list-alt"></i> Asientos</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <?Php
    }

     function menu_header_sec($hh, $sess, $user, $id) {
        ?>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="<?Php echo $hh ?>indexsec.php" ><i class="glyphicon glyphicon-home"></i> PANEL INICIAL </a>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> <?Php echo strtoupper($user); ?></a>
                    </li>
        <!--                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>-->
                    <li class="divider"></li>
                    <li><a href="<?Php echo $sess ?>logeo/desconectar_usuario.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <?Php
    }
}
