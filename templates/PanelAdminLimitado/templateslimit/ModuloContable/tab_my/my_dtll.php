<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?Php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../../login.php"
</script>';
}

require '../../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$idlogeobl = $_SESSION['id_user'];
$_SESSION['username'] = $_SESSION['loginu'];
$user = $_SESSION['loginu'];

$date = date("Y-m-d");
//include '../../Clases/guardahistorial.php';
//$accion = "7 CONTABILIDAD / Mayorizacion / Ingreso a mayorización";
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
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>.: Detalle ctas T :.</title>

        <!-- Bootstrap Core CSS -->
        <link href="../../../../../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../../../../../css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link href="../../../../../css/plugins/dataTables.bootstrap.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../../../../../css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../../../../../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php
        // put your code here
        ?>
        <div class="row">
            <div class="col-lg-12">
                <form id="formulariodetalles" name="formulariodetalles" method="post" action="my_dtll.php">
                    <a href='../cont_my.php' title='AJUSTES' class='glyphicon glyphicon-text-background'>
                        <i class=' btn btn-outline btn-info glyphicon glyphicon-resize-small'></i></a>


                    <table class="table table-hover">   
                        <tr>
                            <td>
                                <label>Buscar cuenta :</label>
                            </td>
                            <td>
                                <datalist id="cuenta">
                                    <?php
                                    $c = $dbi->conexion();
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
                                    <input autocomplete="off" type="text" list="cuenta" id="cta" name="cta" class="form-control">
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
                        </tr>
                    </table>
                </form>
                <form name="form_ejercicio" role="form" id="form_ejercicio" method="post" action="my_dtll.php">
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
                            }
                            mysqli_close($c);
                            ?>
                        </datalist> 
                    </fieldset>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">

                    <?PHP
                    if (isset($_POST["submit"])) {
                        $btntu = $_POST["submit"];
                        if ($btntu == "Detalle por cuenta") {
                            ?>


                            <div class="panel-heading">
                                Mayor Ctas T
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                        <button type="submit" title="PRINT" name="ex_pdf" id="ex_pdf" class="btn btn-outline btn-danger " onclick="my(this.id)"><img src="../../../../../images/pdf.png" width="30" height="30" alt="pdf"/></button>
                                        <button type="submit" title="PRINT" name="ex_my" id="ex_my" class="btn btn-outline btn-success" onclick="my_ex(this.id)"><img src="../../../../../images/excel.png" width="30" height="30" alt="excel"/></button>
                                        </tr>
                                        <tr>
                                            <th style='display:none'>Ejercicio</th>
                                            <th style='display:none'>Balance</th>
                                            <th>Fecha</th>
                                            <th>Cod.</th>
                                            <th>Cuenta</th>
                                            <th>Debe</th>
                                            <th>Haber</th>
                                            <th>Concepto</th>
                                            <th>Asiento</th>
                                            <th>Accion</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?Php
                                            $c = $dbi->conexion();
                                            $tip_cuentadh = htmlspecialchars(trim($_POST['tip_cuentadh']));

                                            $result = mysqli_query($c, "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`valor` , v.`valorp` , "
                                                    . "v.`t_bl_inicial_idt_bl_inicial` , v.ejercicio AS j, n.concepto "
                                                    . "FROM `v_mayorizacionaux` v JOIN num_asientos n WHERE "
                                                    . "v.ejercicio = n.t_ejercicio_idt_corrientes AND "
                                                    . "v.`t_bl_inicial_idt_bl_inicial` = n.t_bl_inicial_idt_bl_inicial and"
                                                    . " v.t_bl_inicial_idt_bl_inicial='" . $idcod . "' AND"
                                                    . " v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "'");
                                            $sqlaj = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`debe` , v.`haber` , v.`balance` , v.ejercicio AS j, n.concepto FROM `vmayorizacionajustes` v JOIN num_asientos_ajustes n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`balance` = n.t_bl_inicial_idt_bl_inicial and v.balance='" . $idcod . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "'";
                                            $resulaj = mysqli_query($c, $sqlaj);
                                            $a = 1;
                                            while ($row = mysqli_fetch_row($result)) {
                                                $concepto = utf8_decode($row[7]);
                                                ?>
                                                <tr class="odd gradeX">
                                                    <?Php
                                                    echo "<input type='hidden' id='idcod' value='$idcod'>";
                                                    ;
                                                    echo "<input type='hidden' id='tip_cuentadh' value='$tip_cuentadh'>";
                                                    echo "<input type='hidden' id='year' value='$year'>";
                                                    echo "<td style='display:none'><input type='hidden' id='fechain_" . $a . "' value='$row[0]'>$row[6]</td>";
                                                    echo "<td style='display:none'><input type='hidden' id='assin_" . $a . "' value='$row[6]'>$row[5]</td>";
                                                    echo "<td>$row[0]</td>";
                                                    echo "<td>$row[1]</td>";
                                                    echo "<td>$row[2]</td>";
                                                    echo "<td>$row[3]</td>";
                                                    echo "<td>$row[4]</td>";
                                                    echo "<td>$concepto</td>";
                                                    echo "<td>$row[6]</td>";
                                                    echo "<td>";
                                                    if ($row[6] == '1') {
                                                        ?>
                                                <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                        class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_as_my_detall(<?Php echo $a; ?>);'></button>
                                                        <?Php
                                                    } else {
                                                        ?>
                                                <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                        class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_asiento_my_dtll(<?Php echo $a; ?>);'></button>
                                                        <?Php
                                                    }
                                                    echo "</td>";
                                                    ?>
                                            </tr>
                                            <?Php
                                            $a++;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                            <?Php
                        } if ($btntu == "Detalle") {
                            ?>


                            <div class="panel-heading">
                                Mayor Ctas T
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                        <button type="submit" title="PRINT" name="ex_pdf_dt" id="ex_pdf_dt" class="btn btn-outline btn-danger " onclick="my_data(this.id)"><img src="../../../../../images/pdf.png" width="30" height="30" alt="pdf"/></button>
                                        <button type="submit" title="PRINT" name="ex_my" id="ex_my" class="btn btn-outline btn-success" onclick="my_ex_dt(this.id)"><img src="../../../../../images/excel.png" width="30" height="30" alt="excel"/></button>
                                        </tr>
                                            <tr>
                                                <th style='display:none'>Ejercicio</th>
                                                <th style='display:none'>Balance</th>
                                                <th>Fecha</th>
                                                <th>Cod.</th>
                                                <th>Cuenta</th>
                                                <th>Debe</th>
                                                <th>Haber</th>
                                                <th>Concepto</th>
                                                <th>Asiento</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?Php
                                            $c = $dbi->conexion();
                                            $tip_cuentadh = htmlspecialchars(trim($_POST['cta']));
                                            $result = mysqli_query($c, "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`valor` , v.`valorp` , "
                                                    . "v.`t_bl_inicial_idt_bl_inicial` , v.ejercicio AS j, n.concepto FROM `v_mayorizacionaux` v "
                                                    . "JOIN num_asientos n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND "
                                                    . "v.`t_bl_inicial_idt_bl_inicial` = n.t_bl_inicial_idt_bl_inicial and"
                                                    . " v.t_bl_inicial_idt_bl_inicial='" . $idcod . "' AND"
                                                    . " v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "'");
                                            $sqlaj = "SELECT v.`fecha` , v.`cod_cuenta` , v.`cuenta` , v.`debe` , v.`haber` , v.`balance` , v.ejercicio AS j, n.concepto FROM `vmayorizacionajustes` v JOIN num_asientos_ajustes n WHERE v.ejercicio = n.t_ejercicio_idt_corrientes AND v.`balance` = n.t_bl_inicial_idt_bl_inicial and v.balance='" . $idcod . "' AND v.cod_cuenta = '" . $tip_cuentadh . "' AND v.year = '" . $year . "'";
                                            $resulaj = mysqli_query($c, $sqlaj);
                                            $a = 1;
                                            while ($row = mysqli_fetch_row($result)) {
                                                $concepto = utf8_decode($row[7]);
                                                ?>
                                                <tr class="odd gradeX">
                                                    <?Php
                                                    echo "<input type='hidden' id='idcod_dt' value='$idcod'>";
                                                    echo "<input type='hidden' id='tip_cuentadh_dt' value='$tip_cuentadh'>";
                                                    echo "<input type='hidden' id='year_dt' value='$year'>";
                                                    echo "<td style='display:none'><input type='hidden' id='fechain_" . $a . "' value='$row[0]'>$row[6]</td>";
                                                    echo "<td style='display:none'><input type='hidden' id='assin_" . $a . "' value='$row[6]'>$row[5]</td>";
                                                    echo "<td>$row[0]</td>";
                                                    echo "<td>$row[1]</td>";
                                                    echo "<td>$row[2]</td>";
                                                    echo "<td>$row[3]</td>";
                                                    echo "<td>$row[4]</td>";
                                                    echo "<td>$concepto</td>";
                                                    echo "<td>$row[6]</td>";
                                                    echo "<td>";
                                                    if ($row[6] == '1') {
                                                        ?>
                                                <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                        class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_as_my_detall(<?Php echo $a; ?>);'></button>
                                                        <?Php
                                                    } else {
                                                        ?>
                                                <button type='button' title='DETALL' data-toggle='modal' data-target='#myModal' 
                                                        class='btn btn-outline btn-info glyphicon glyphicon-eye-open ' onclick='detall_asiento_my_dtll(<?Php echo $a; ?>);'></button>
                                                        <?Php
                                                    }
                                                    echo "</td>";
                                                    ?>
                                            </tr>
                                            <?Php
                                            $a++;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                            <?php
                        }
                    }
                    ?>

                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- jQuery Version 1.11.0 -->
        <script src="../../../../../js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../../../../../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../../../../js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="../../../../../js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="../../../../../js/plugins/dataTables/dataTables.bootstrap.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../../../../../js/sb-admin-2.js"></script>
        <script src="../../../../../js/js.js"></script>

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
                                                            $(document).ready(function () {
                                                                $('#dataTables-example').dataTable();
                                                            });
        </script>


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
