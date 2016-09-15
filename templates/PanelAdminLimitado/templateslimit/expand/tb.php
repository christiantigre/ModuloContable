<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../../login.php"
</script>';
}
?>
<!DOCTYPE html>

<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;" charset=UTF-8">
        <meta http-equiv="Content-Type" content="text/html;" charset=ISO-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="CONT APP">
        <meta name="author" content="CT">

        <title>:: CONTABILIDAD ::</title>

        <!-- Bootstrap Core CSS -->
        <link href="../../../../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../../../../css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="../../../../css/plugins/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../../../../css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="../../../../css/plugins/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../../../../css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <title></title>
    </head>
    <body>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th>Asiento</th>
                    <th>Fecha</th>
                    <th>Mes</th>
                    <th>Concepto</th>
                    <th>VER</th>
                    <th>EDITAR</th>
                    <th>PDF</th>
                    <th>EXC</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require '../../../../templates/Clases/Conectar.php';
                $year = date("Y");
                $dbi = new Conectar();
                $sqlmaxingreso = "SELECT max(`idt_bl_inicial`) as id FROM `t_bl_inicial`";
                $query1 = $dbi->execute($sqlmaxingreso);
                while ($rw = $dbi->fetch_row($query1)) {
                    $maxbalancedato = trim($rw['id']);
                }

                $sql = "SELECT * FROM `num_asientos` where t_bl_inicial_idt_bl_inicial = '" . $maxbalancedato . "' and year = '" . $year . "'";
                $ej = $dbi->execute($sql);
                $a = 1;
                $b = 2;
                while ($row = $dbi->fetch_row($ej)) {
                    $id = $row['idnum_asientos'];
                    $asiento = $row['t_ejercicio_idt_corrientes'];
                    $fecha = $row['fecha'];
                    $mes = $row['mes'];
                    $concep = $row['concepto'];
                    if ($asiento == "1") {
                        ?>

                        <tr class="gradeA">
                    <input type="hidden" id="fechain_<?Php echo $a; ?>" name="fechain_<?Php echo $a; ?>" value="<?Php echo $fecha; ?>" />
                    <input type="hidden" id="assin_<?Php echo $a; ?>" name="assin_<?Php echo $a; ?>" value="<?Php echo $id; ?>" />
                    <input type="hidden" id="tar" name="tar" value="<?Php echo $asiento; ?>" />
                    <input type="hidden" id="fh" name="fh" value="<?Php echo $fecha; ?>" />
                    <td><?Php echo $asiento ?></td>
                    <td><?Php echo $fecha ?></td>
                    <td class="center"><?Php echo $mes ?></td>
                    <td class="center"><?Php echo $concep ?></td>
                    <td class="center"><button type="button" title="VIEW" data-toggle="modal" data-target="#myModal" class="btn btn-outline btn-info glyphicon glyphicon-eye-open " onclick="detall_asini(<?Php echo $a; ?>);"></button></td>
                    <td class="center"><a class="btn btn-outline btn-info glyphicon glyphicon-wrench " title="UPDATE" href="./templateslimit/ModuloContable/up_ass_in.php?id_asientourl=<?Php echo $asiento ?>&fechaurl=<?Php echo $fecha ?>" onclick="listar();" ></a></td>
                    <td class="center"><button type="submit" title="PRINT" class="btn btn-outline btn-danger " onclick="imp_assin(<?Php echo $a; ?>)"><img src="../../images/pdf.png" width="30" height="30" alt="pdf"/></button></td>
                    <td class="center"><button type="submit" title="PRINT" name="ex_as_num" id="ex_as_num" class="btn btn-outline btn-success" onclick="exp_wd_num_as(this.id)"><img src="../../images/excel.png" width="30" height="30" alt="excel"/></button></td>
                </tr>


                <?Php
            } else {
                ?>

                <tr class="gradeA">
                <input type="hidden" id="fecha_<?Php echo $b; ?>" name="fecha_<?Php echo $b; ?>" value="<?Php echo $fecha; ?>" />
                <input type="hidden" id="ass_<?Php echo $b; ?>" name="ass_<?Php echo $b; ?>" value="<?Php echo $id; ?>" />                
                <input type="hidden" id="tara_<?Php echo $b; ?>" name="tara_<?Php echo $b; ?>" value="<?Php echo $asiento; ?>" />
                <input type="hidden" id="fha_<?Php echo $b; ?>" name="fha_<?Php echo $b; ?>" value="<?Php echo $fecha; ?>" />
                <td><?Php echo $asiento ?></td>
                <td><?Php echo $fecha ?></td>
                <td class="center"><?Php echo $mes ?></td>
                <td class="center"><?Php echo $concep ?></td>
                <td class="center"><button type="button" data-toggle="modal" title="VIEW" data-target="#myModal" class="btn btn-outline btn-info glyphicon glyphicon-eye-open " onclick="detall_asin(<?Php echo $b; ?>);"></button></td>
                <td class="center"><a class="btn btn-outline btn-info glyphicon glyphicon-wrench" title="UPDATE" href="./templateslimit/ModuloContable/up_ass.php?id_asientourl=<?Php echo $asiento ?>&fechaurl=<?Php echo $fecha ?>" onclick="listar();" ></a></td>
                <td class="center"><button type="submit" class="btn btn-outline btn-danger " title="PRINT" onclick="imp_assin_ass(<?Php echo $b; ?>)"><img src="../../images/pdf.png" width="30" height="30" alt="pdf"/></button></td>
                <td class="center"><button type="submit" class="btn btn-outline btn-success" title="PRINT" name="ex_asiento" id="ex_asiento" onclick="exp_asiento(this.id, <?Php echo $b; ?>)"><img src="../../images/excel.png" width="30" height="30" alt="excel"/></button></td>
                </tr>


                <?Php
            }
            $b++;
        }
        $a++;
        ?>

        </tbody>
        </table>

<!--js-->
<script src="../../../../js/jquery-1.11.0.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../../../js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../../../../js/plugins/metisMenu/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->

<!-- DataTables JavaScript -->
<script src="../../../../js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="../../../../js/plugins/dataTables/dataTables.bootstrap.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../../../../js/sb-admin-2.js"></script>
<script src="../../../../js/js.js"></script>
<!--<script src="../../js/sc"></script>-->
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