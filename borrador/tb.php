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
        <link href="../../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../../css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="../../css/plugins/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../../css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="../../css/plugins/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                                            <th>IMPRIMIR</th>
                                        </tr>
                                    </thead>
                                       <tbody>
        <?php
       require '../../templates/Clases/Conectar.php';
        $year = date("Y");
        $dbi = new Conectar();
        $sqlmaxingreso = "SELECT max(`idt_bl_inicial`) as id FROM `t_bl_inicial`";
        $query1 = $dbi->execute($sqlmaxingreso);
        while ($rw = $dbi->fetch_row($query1)) {
            $maxbalancedato = trim($rw['id']);
        }
        
        $sql = "SELECT * FROM `num_asientos` where t_bl_inicial_idt_bl_inicial = '".$maxbalancedato."' and year = '".$year."'";
        $ej = $dbi->execute($sql);
        while ($row = $dbi->fetch_row($ej) ){
            $asiento = $row['t_ejercicio_idt_corrientes'];
            $fecha = $row['fecha'];
            $mes = $row['mes'];
            $concep= $row['concepto'];
            ?>
                                 
                                        <tr class="gradeA">
                                            <td><?Php echo $asiento ?></td>
                                            <td><?Php echo $fecha ?></td>
                                            <td class="center"><?Php echo $mes ?></td>
                                            <td class="center"><?Php echo $concep ?></td>
                                            <td class="center"><button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-outline btn-info glyphicon glyphicon-eye-open" onclick=""></button></td>
                                            <td class="center"><a class="btn btn-outline btn-info glyphicon glyphicon-wrench" href="./templateslimit/ModuloContable/up_ass_in.php?id_asientourl=' . $assi . '&fechaurl=' . $fech . '" onclick="listar();" "></a></td>
                                            <td class="center"><button type="submit" class="btn btn-outline btn-info glyphicon glyphicon-print"></button></td>
                                        </tr>
                                        
        
                        <?Php
        }
        ?>
                                        
                                    </tbody>
                                </table>
        
        
        <!--js-->
         <script src="../../js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->

        <!-- DataTables JavaScript -->
        <script src="../../js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="../../js/plugins/dataTables/dataTables.bootstrap.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../../js/sb-admin-2.js"></script>
        <script src="../../js/js.js"></script>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
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
