
<?php include_once '../config/config.inc.php'; 
    $con=new Conect_MySql();
    $sq="select*from alumno";
    $qr=$con->execute($sq);?>
<div class="row">
    <div class="col-lg-12">
        <h1>Tabla Alumnos</h1>
    </div>
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">Lista</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombres y Apellidos</th>
                                <th>Estado</th>
                                <th>P</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c=1;
                            while ($rw=$con->fetch_row($qr)){ ?>
                            <tr class="odd gradeX">
                                <td><?php echo $c ?></td>
                                <td><?php echo $rw['nombrecompleto']; ?></td>
                                <td><?php if($rw['estado']==1){ ?>  
                                    <span class="label label-info">Activo</span>
                                    <?php }else{ ?>
                                    <span class="label label-danger">Desactivo</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <button class="btn btn-success" onclick="pago_alumno(<?php echo $rw['idalumno']; ?>);">
                                        <i class="glyphicon glyphicon-usd"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php $c++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>