<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../login.php"
</script>';
}
require '../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$idlogeobl = $_SESSION['id_user'];
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];
$date = date("Y-m-d");

$hh = '../';
$sess = '../../';
$raiz = '../../';
$carpetas = '../../../';
//include '../../Clases/guardahistorial.php';
//$accion = "/ CONTABILIDAD / Mayorizacion / Ingreso a mayorización";
//generaLogs($user, $accion);
$mes = date('F');
$year = date('Y');

$consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
$query_bl = mysqli_query($c, $consul_bal_inicial);
$row = mysqli_fetch_array($query_bl);
$idcod = $row['contador'];
$idcod_sig = $row['Siguiente'];

$contador_de_asientosSQL = "select count(year)+1 as CON from num_asientos"
        . " where `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "'";
$query_contador = mysqli_query($c, $contador_de_asientosSQL);
$row_cont = mysqli_fetch_array($query_contador);
$contador_ass = $row_cont['CON'];


$valores = "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, "
        . "sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,"
        . "sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sld_deudor,"
        . "sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as sld_acreedor FROM vistabalanceresultadosajustados WHERE "
        . "`t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "'";
$res_valores = mysqli_query($c, $valores);
while ($resultb = mysqli_fetch_assoc($res_valores)) {
    $Tdebe = $resultb['debe'];
    $Thaber = $resultb['haber'];
    $Sdeudor = $resultb['sld_deudor'];
    $Sacreedor = $resultb['sld_acreedor'];
    $Tdebe = number_format($Tdebe, 2, '.', '');
    $Thaber = number_format($Thaber, 2, '.', '');
    $Sdeudor = number_format($Sdeudor, 2, '.', '');
    $Sacreedor = number_format($Sacreedor, 2, '.', '');
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;" charset=UTF-8">
        <meta http-equiv="Content-Type" content="text/html;" charset=ISO-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="CONT APP">
        <meta name="author" content="CT">

        <title>:: CONTABILIDAD ::</title>

        <!-- Bootstrap Core CSS -->
        <link href="../../../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../../../css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="../../../css/plugins/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../../../css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="../../../css/plugins/morris.css" rel="stylesheet">

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
                    <a class="navbar-brand" rel="home" href="ini_cont.php" title="Buy Sell Rent Everyting">
                        <?Php
                        require('../../../templates/Clases/empresa.php');
                        $objClase = new Empresa;
                        ?>
                        <img src="../../../images/uploads/<?Php $objClase->logo_cl(); ?>" class="img-responsive img-rounded" style="width:329px;height: 50px; margin-top: -15px;"/>
                    </a>
                </div>
                <!-- /.navbar-header -->
                <?PHP
                require('../../../templates/Clases/menus.php');
                $objMenu = new menus();
                $objMenu->menu_header_root($hh, $sess, $user, $id);
                ?>
                <!-- /.navbar-top-links -->
                <div class="navbar-default sidebar" role="navigation">
                    <?PHP
                    $objMenu->menu_admin($raiz, $carpetas);
                    ?>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-12">
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                Mayorizaci&oacute;n de cuentas
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form id="formulariodetalles" name="formulariodetalles" method="post" action="cont_my.php">
                                        <table class="table table-hover">   
                                            <tr>
                                                <td>
                                                    <label>Buscar cuenta :</label>
                                                </td>
                                                <td>
                                                    <datalist id="cuenta">
                                                        <?php
                                                        $query = "SELECT DISTINCT (cuenta) AS dif_cuentas, cod_cuenta as cod FROM vistabalanceresultadosajustados WHERE `t_bl_inicial_idt_bl_inicial` ='" . $idcod . "'";
                                                        $resul1 = mysqli_query($c, $query);
                                                        while ($dato1 = mysqli_fetch_array($resul1)) {
                                                            $cod1 = $dato1['cod_cauxiliar'];
                                                            echo "<option value='" . $dato1['cod'] . "' >";
                                                            echo $dato1['cod'] . '      ' . utf8_decode($dato1['dif_cuentas']);
                                                            echo '</option>';
                                                        }
                                                        mysqli_close($c);
                                                        ?>
                                                    </datalist>
                                                    <div class="form-group">
                                                        <input type="text" list="cuenta" id="cta" name="cta" class="form-control">
                                                    </div>
                                                </td>
                                                <td> <input id="submit" class="btn btn-success" name="submit" type="submit" value="Detalle"/>
                                                    <input id="submit" class="btn btn-default" name="submit" type="submit" value="-"/> </td>
                                            </tr>
                                            <tr>                  
                                                <td>
                                                    <label>Cuentas Utilizadas</label>
                                                </td>
                                                <td>
                                                    <?php
                                                    $c = $dbi->conexion();
                                                    $SQLtipobaldh = "SELECT DISTINCT (cuenta) AS dif_cuentas, cod_cuenta as cod FROM vistabalanceresultadosajustados WHERE `t_bl_inicial_idt_bl_inicial` ='" . $idcod . "'";
                                                    $query_tipo_bldh = mysqli_query($c, $SQLtipobaldh);
                                                    ?>
                                                    <select name="tip_cuentadh" id="tip_cuentadh" class='form-control' size="0" style="alignment-adjust: central" onchange="generar_codigo_grupo()
                                                                    ;"><!--generar_codigo_grupo()-->
                                                                <?php
                                                                while ($arreglot_cuendh = mysqli_fetch_array($query_tipo_bldh)) {
                                                                    if ($_POST['tip_cuentadh'] == $arreglot_cuendh['cod']) {
                                                                        echo "<option value='" . $arreglot_cuendh['cod'] . "' selected>&nbsp;&nbsp;" . utf8_encode($arreglot_cuendh['dif_cuentas']) . "</option>";
                                                                    } else {
                                                                        ?>
                                                                <option class="text" value="<?php echo $arreglot_cuendh['cod'] ?>">
                                                                    <?php echo $arreglot_cuendh['dif_cuentas'] ?></option>     
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td> <input id="submit" class="btn btn-success" name="submit" type="submit" value="Detalle por cuenta"/>
                                                    <input id="submit" class="btn btn-default" name="submit" type="submit" value="-"/> </td>
                                                <?php
                                                if (isset($_POST["submit"])) {
                                                    $btntu = $_POST["submit"];
                                                    if ($btntu == "Detalle por cuenta") {
                                                        $tip_cuentadh = htmlspecialchars(trim($_POST['tip_cuentadh']));
                                                        $result = mysqli_query($c, "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`valor` , v.`valorp` , v.`t_bl_inicial_idt_bl_inicial` , v.ejercicio AS j, n.concepto FROM `v_mayorizacionaux` v JOIN num_asientos n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`t_bl_inicial_idt_bl_inicial` = n.t_bl_inicial_idt_bl_inicial and v.t_bl_inicial_idt_bl_inicial='" . $idcod . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "'");
                                                        $sqlaj = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`debe` , v.`haber` , v.`balance` , v.ejercicio AS j, n.concepto FROM `vmayorizacionajustes` v JOIN num_asientos_ajustes n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`balance` = n.t_bl_inicial_idt_bl_inicial and v.balance='" . $idcod . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "'";
                                                        $resulaj = mysqli_query($c, $sqlaj);
                                                        $result_d_m_mayor = mysqli_query($c, "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, 
        sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,
        sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sldeu,
        sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as slacr FROM vistabalanceresultadosajustados WHERE 
        `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "' and cod_cuenta='" . $tip_cuentadh . "'");
                                                        $dato_fila = mysqli_fetch_array($result_d_m_mayor);
                                                        $mayor_debe = $dato_fila['debe'];
                                                        $mayor_haber = $dato_fila['haber'];
                                                        $mayor_sldue = $dato_fila['sldeu'];
                                                        $mayor_sldacr = $dato_fila['slacr'];
                                                        echo "<table class='table table-hover'>";
                                                        echo "<tr> <center>T</center> </tr>";
                                                        echo "<tr class='success'>";
                                                        echo "<td style='display:none'>Ejercicio</td>";
                                                        echo "<td style='display:none'>balance</td>";
                                                        echo "<td>Fecha</td>";
                                                        echo "<td>Cod.</td>";
                                                        echo "<td>Cuenta</td>";
                                                        echo "<td>Debe</td>";
                                                        echo "<td>Haber</td>";
                                                        echo "<td>Concepto</td>";
                                                        echo "</tr>";
                                                        while ($row = mysqli_fetch_row($result)) {
                                                            $concepto = utf8_decode($row[7]);
                                                            echo "<tr class='warning'>";
                                                            echo "<td style='display:none'>$row[6]</td>";
                                                            echo "<td style='display:none'>$row[5]</td>";
                                                            echo "<td>$row[0]</td>";
                                                            echo "<td>$row[1]</td>";
                                                            echo "<td>$row[2]</td>";
                                                            echo "<td>$row[3]</td>";
                                                            echo "<td>$row[4]</td>";
                                                            echo "<td>$concepto</td>";
                                                            echo "</tr>";
                                                        }
                                                        echo "</table>";
                                                        echo '<center><h5>AJUSTES</h5></center>';
                                                        echo "<table class='table table-hover'>";
                                                        echo "<tr class='success'>";
                                                        echo "<td style='display:none'>Ejercicio</td>";
                                                        echo "<td style='display:none'>balance</td>";
                                                        echo "<td>Fecha</td>";
                                                        echo "<td>Cod.</td>";
                                                        echo "<td>Cuenta</td>";
                                                        echo "<td>Debe</td>";
                                                        echo "<td>Haber</td>";
                                                        echo "<td>Concepto</td>";
                                                        echo "</tr>";
                                                        while ($rowaj = mysqli_fetch_row($resulaj)) {
                                                            echo "<tr class='warning'>";
                                                            echo "<td style='display:none'>$rowaj[6]</td>";
                                                            echo "<td style='display:none'>$rowaj[5]</td>";
                                                            echo "<td>$rowaj[0]</td>";
                                                            echo "<td>$rowaj[1]</td>";
                                                            echo "<td>$rowaj[2]</td>";
                                                            echo "<td>$rowaj[3]</td>";
                                                            echo "<td>$rowaj[4]</td>";
                                                            echo "<td>$rowaj[7]</td>";
                                                            echo "</tr>";
                                                        }
                                                        echo "</table>";
                                                        ?>
                                                    <table>
                                                        <tr class="info" >
                                                            <td>
                                                                <label>Total debe :</label>
                                                                <input type="text" readonly="readonly" id="campomayor_debe" name="campomayor_debe" class="form-control" value="<?php echo $mayor_debe ?>"/>
                                                            </td>
                                                            <td>
                                                                <label>Total haber :</label>
                                                                <input type="text" readonly=readonly id="campomayor_haber" name="campomayor_haber" class="form-control" value="<?php echo $mayor_haber ?>"/>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <?php
//                                                    $accion = "/ CONTABILIDAD / MAYORIZACION / VISUALIZÓ DETALLE CUENTA:" . $tip_cuentadh;
//                                                    generaLogs($user, $accion);
                                                }
                                                if ($btntu == "Detalle") {
//                                                    echo '<script>alert("ver")</script>';
                                                    $tip_cuentadh = htmlspecialchars(trim($_POST['cta']));
                                                    $result = mysqli_query($c, "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`valor` , v.`valorp` , v.`t_bl_inicial_idt_bl_inicial` , v.ejercicio AS j, n.concepto FROM `v_mayorizacionaux` v JOIN num_asientos n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`t_bl_inicial_idt_bl_inicial` = n.t_bl_inicial_idt_bl_inicial and v.t_bl_inicial_idt_bl_inicial='" . $idcod . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "'");
                                                    $sqlaj = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`debe` , v.`haber` , v.`balance` , v.ejercicio AS j, n.concepto FROM `vmayorizacionajustes` v JOIN num_asientos_ajustes n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`balance` = n.t_bl_inicial_idt_bl_inicial and v.balance='" . $idcod . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "'";
                                                    $resulaj = mysqli_query($c, $sqlaj);
                                                    $result_d_m_mayor = mysqli_query($c, "SELECT sum((COALESCE(debe_aj, 0) + COALESCE(debe, 0))) as debe, 
        sum((COALESCE(haber_aj,0) + (COALESCE(haber,0)))) as haber,
        sum((COALESCE(slddeudor_aj, 0))+(COALESCE(sld_deudor))) as sldeu,
        sum((COALESCE(sldacreedor_aj,0))+(COALESCE(sld_acreedor,0))) as slacr FROM vistabalanceresultadosajustados WHERE 
        `t_bl_inicial_idt_bl_inicial`='" . $idcod . "' and year='" . $year . "' and cod_cuenta='" . $tip_cuentadh . "'");
                                                    $dato_fila = mysqli_fetch_array($result_d_m_mayor);
                                                    $mayor_debe = $dato_fila['debe'];
                                                    $mayor_haber = $dato_fila['haber'];
                                                    $mayor_sldue = $dato_fila['sldeu'];
                                                    $mayor_sldacr = $dato_fila['slacr'];
                                                    echo "<table class='table table-hover'>";
                                                    echo "<tr> <center>T</center> </tr>";
                                                    echo "<tr class='success'>";
                                                    echo "<td style='display:none'>Ejercicio</td>";
                                                    echo "<td style='display:none'>balance</td>";
                                                    echo "<td>Fecha</td>";
                                                    echo "<td>Cod.</td>";
                                                    echo "<td>Cuenta</td>";
                                                    echo "<td>Debe</td>";
                                                    echo "<td>Haber</td>";
                                                    echo "<td>Concepto</td>";
                                                    echo "</tr>";
                                                    while ($row = mysqli_fetch_row($result)) {
                                                        $concepto = utf8_decode($row[7]);
                                                        echo "<tr class='warning'>";
                                                        echo "<td style='display:none'>$row[6]</td>";
                                                        echo "<td style='display:none'>$row[5]</td>";
                                                        echo "<td>$row[0]</td>";
                                                        echo "<td>$row[1]</td>";
                                                        echo "<td>$row[2]</td>";
                                                        echo "<td>$row[3]</td>";
                                                        echo "<td>$row[4]</td>";
                                                        echo "<td>$concepto</td>";
                                                        echo "</tr>";
                                                    }
                                                    echo "</table>";
                                                    echo '<center><h5>AJUSTES</h5></center>';
                                                    echo "<table class='table table-hover'>";
                                                    echo "<tr class='success'>";
                                                    echo "<td style='display:none'>Ejercicio</td>";
                                                    echo "<td style='display:none'>balance</td>";
                                                    echo "<td>Fecha</td>";
                                                    echo "<td>Cod.</td>";
                                                    echo "<td>Cuenta</td>";
                                                    echo "<td>Debe</td>";
                                                    echo "<td>Haber</td>";
                                                    echo "<td>Concepto</td>";
                                                    echo "</tr>";
                                                    while ($rowaj = mysqli_fetch_row($resulaj)) {
                                                        echo "<tr class='warning'>";
                                                        echo "<td style='display:none'>$rowaj[6]</td>";
                                                        echo "<td style='display:none'>$rowaj[5]</td>";
                                                        echo "<td>$rowaj[0]</td>";
                                                        echo "<td>$rowaj[1]</td>";
                                                        echo "<td>$rowaj[2]</td>";
                                                        echo "<td>$rowaj[3]</td>";
                                                        echo "<td>$rowaj[4]</td>";
                                                        echo "<td>$rowaj[7]</td>";
                                                        echo "</tr>";
                                                    }
                                                    echo "</table>";
                                                    ?>
                                                    <table>
                                                        <tr class="info" >
                                                            <td>
                                                                <label>Total debe :</label>
                                                                <input type="text" readonly="readonly" id="campomayor_debe" name="campomayor_debe" class="form-control" value="<?php echo $mayor_debe ?>"/>
                                                            </td>
                                                            <td>
                                                                <label>Total haber :</label>
                                                                <input type="text" readonly=readonly id="campomayor_haber" name="campomayor_haber" class="form-control" value="<?php echo $mayor_haber ?>"/>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <?php
//                                                    $accion = "/ CONTABILIDAD / MAYORIZACION / VISUALIZÓ DETALLE CUENTA:" . $tip_cuentadh;
//                                                    generaLogs($user, $accion);
                                                } else {
                                                    
                                                }
                                            }
                                            ?>

                                            </tr>
                                        </table>
                                    </form>
                                    <form name="form_ejercicio" role="form" id="form_ejercicio" method="post" action="ini_cont.php">
                                        <fieldset>
                                            <!--<legend-->
                                            <div class="alert fade in" data-alert="alert" id="alert-area" >
                                                <a class="close" data-dismiss="alert" href="#">&times;</a>
                                            </div>
                                            <!--</legend>-->
                                            <input type="hidden" class="texto" name="balances_realizados" id="balances_realizados" value="<?Php echo $idcod; ?>"/>
                                            <input type="hidden" name="mes" id="mes" readonly="readonly" value="<?php echo $mes ?>"/>
                                            <input type="hidden" name="idlog" id="idlog" readonly="readonly" value="<?php echo $idlogeobl ?>"/>
                                            <datalist id="cuenta">
                                                <?php
                                                $c = $dbi->conexion();
                                                $query = "SELECT * FROM `t_plan_de_cuentas` order by `t_clase_cod_clase`,`t_grupo_cod_grupo`,`t_cuenta_cod_cuenta`,`t_subcuenta_cod_subcuenta`,`t_auxiliar_cod_cauxiliar`,`t_subauxiliar_cod_subauxiliar` DESC";
                                                $resul1 = mysqli_query($c, $query);
                                                while ($dato1 = mysqli_fetch_array($resul1)) {
                                                    $cod1 = $dato1['cod_cuenta'];
                                                    echo "<option value='" . $dato1['cod_cuenta'] . "' >";
                                                    echo $dato1['cod_cuenta'] . '      ' . utf8_decode($dato1['nombre_cuenta_plan']);
                                                    echo '</option>';
                                                }mysqli_close($c);
                                                ?>
                                            </datalist>
                                            <table id="table1" name="table1" class="table table-hover"> 

                                                <thead>
                                                    <tr class='success'>
                                                        <td style='display:none'>balance</td>
                                                        <td style='display:none'>Fecha</td>
                                                        <td><strong> Cod.</strong> </td>
                                                        <td><strong> Cuenta</strong> </td>
                                                        <td><strong>Debe</strong> </td>
                                                        <td><strong>Haber</strong> </td>
                                                        <td><strong>Deudor</strong> </td>
                                                        <td><strong>Acreedor</strong> </td>
                                                    </tr>
                                                </thead>
                                                <!--Zona Upload de cuentas para mayor-->
                                                <?Php
                                                $c = $dbi->conexion();
                                                $cargamayor = "SELECT `t_bl_inicial_idt_bl_inicial`,`tipo`,`cod_cuenta`, `cuenta`, 
    sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0)) as sdeb, 
    sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0)) as shab, 
    sum(COALESCE(debe_aj, 0)+COALESCE(debe,0)) - sum(COALESCE(haber_aj, 0) + COALESCE(haber, 0)) as sldeu, 
    CONCAT('0.00') as slacr FROM vistabalanceresultadosajustados WHERE `t_bl_inicial_idt_bl_inicial` = '" . $idcod . "' and year='" . $year . "'
    group BY cod_cuenta, cod_cuenta_aj HAVING sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0))>sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0))
UNION
SELECT `t_bl_inicial_idt_bl_inicial`,`tipo`,`cod_cuenta`, `cuenta`, sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0)) as sdeb, sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0)) as shab,
CONCAT('0.00') as slacr, sum(COALESCE(haber_aj, 0) + COALESCE(haber, 0))-sum(COALESCE(debe_aj, 0)+COALESCE(debe,0)) as sldeu  FROM vistabalanceresultadosajustados WHERE 
`t_bl_inicial_idt_bl_inicial` = '" . $idcod . "' and year='" . $year . "' group BY cod_cuenta, cod_cuenta_aj HAVING sum(COALESCE(debe_aj, 0)) + sum(COALESCE(debe, 0))<sum(COALESCE(haber_aj, 0)) + sum(COALESCE(haber, 0))
order by cod_cuenta";
                                                $result = mysqli_query($c, $cargamayor);
                                                while ($row = mysqli_fetch_row($result)) {
                                                    echo "<tbody>";
                                                    echo "<tr>";
                                                    //echo "<td style='display:none'>$row[5]</td>";
                                                    echo "<td style='display:none;'><input type='text' class='form-control' readonly='readonly' id='tipo' name='campo9[]' value='$row[1]'/></td>";
                                                    echo "<td style='display:none'><input type='text' class='form-control' readonly='readonly' id='t_bl_inicial_idt_bl_inicial' name='campo1[]' value='$row[0]'/></td>";
                                                    echo "<td style='display:none'><input type='text' class='form-control' readonly='readonly' id='fecha' name='campo2[]' value='$row[0]'/></td>";
                                                    echo "<td><input type='text' class='form-control' readonly='readonly' id='cod_cuenta' name='campo3[]' value='$row[2]'/></td>";
                                                    echo "<td><input type='text' class='form-control' readonly='readonly' id='cuenta' name='campo4[]'  value='$row[3]'/></td>";
                                                    echo "<td><input type='text' class='form-control' readonly='readonly' id='deb' name='campo5[]' value='$row[4]'/></td>";
                                                    echo "<td><input type='text' class='form-control' readonly='readonly' id='hab' name='campo6[]' value='$row[5]'/></td>";

                                                    echo "<td><input type='text' class='form-control' readonly='readonly' id='saldodeudor' name='campo7[]' onkeyup='validar(this.id);' value='";
                                                    echo $row[6];
                                                    echo "'/></td>";
                                                    echo "<td><input type='text' readonly='readonly' class='form-control' id='saldoacreedor' name='campo8[]' onkeyup='validar(this.id);' value='";
                                                    echo $row[7];
                                                    echo"'/></td>";
                                                    echo "</tr>";
                                                    echo "</tbody>";
                                                }mysqli_close($c);
                                                ?>
                                                <tr>
                                                <tfoot>
                                                <td></td>
                                                <td> <strong>Total :</strong> </td>
                                                <td>
                                                    <div class="col-xs-8 form-group has-success">
                                                        <input type="text" readonly="readonly"  class="form-control" name="tdebe" id="tdebe" value="<?php echo $Tdebe ?>"/> 
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-xs-8 form-group has-success">
                                                        <input type="text"  readonly="readonly" class="form-control info" name="thaber" id="thaber" value="<?php echo $Thaber ?>"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-xs-8 form-group has-success">
                                                        <input type="text" readonly="readonly"  class="form-control" name="tdeudor" id="tdeudor" value="<?php echo $Sdeudor ?>"/> 
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-xs-8 form-group has-success">
                                                        <input type="text"  readonly="readonly" class="form-control info" name="tacreedor" id="tacreedor" value="<?php echo $Sacreedor ?>"/>
                                                    </div>
                                                </td>
                                                </tfoot>            
                                                </tr>
                                            </table>    
                                        </fieldset>


                                    </form>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        <!-- jQuery -->
        <script src="../../../js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../../../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../../js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->

        <!-- DataTables JavaScript -->
        <script src="../../../js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="../../../js/plugins/dataTables/dataTables.bootstrap.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../../../js/sb-admin-2.js"></script>
        <script src="../../../js/js.js"></script>
        <script src="js/jslevel.js"></script>
        <script src="../../../js/script.js"></script>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">DETALLE DE ASIENTO</h4>
                    </div>
                    <div class="modal-body" id="caja">

                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
