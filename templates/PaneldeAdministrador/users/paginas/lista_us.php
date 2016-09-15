<?Php
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../login.php"
</script>';
}
?>
<form method="get" name="form" action="#">
<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Administraci&oacute;n de Usuarios</h1>
                        <div class="panel panel-default">
                            <button type="submit" class="btn btn-success glyphicon glyphicon-plus" onclick="new_us();"></button>
                            <div class="panel-heading">
                                Usuarios
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Usuario</th>
                                                <th>Clave</th>
                                                <th>Selecci&oacute;n</th>
                                                <th>Eliminar</th>
                                                <th>Actualizar</th>
                                                <th>Insertar</th>
                                                <th>Crear Us.</th>
                                                <!--<th> Acción  </th>-->
                                            </tr>
                                        </thead>
                                        <tbody>         

                                            <?Php
                                            $c = new mysqli("localhost", $_SESSION['username'], $_SESSION['clave'], 'mysql');
                                            $sql_us = "SELECT * FROM `user` WHERE `Host`='localhost' and User !='pma'";
                                            $result = mysqli_query($c, $sql_us) or trigger_error("Query Failed! SQL: $sql_us - Error: " . mysqli_error($c), E_USER_ERROR);
                                            while ($rw = mysqli_fetch_assoc($result)) {
                                                $id = $rw['User']; 
                                                $Password = $rw['Password']; 
                                                ?>
                                                <tr class="gradeU">
                                                    <td><?Php echo $id; ?></td>
                                                    <td><?Php echo $Password; ?></td>
                                                    <td class="center"><?Php if ($rw['Select_priv'] == "N") {
                                                echo '<input type="checkbox" value="">';
                                            } else {
                                                echo '<input type="checkbox" value="" checked="">';
                                            } ?></td>
                                                    <td class="center"><?Php if ($rw['Insert_priv'] == "N") {
                                                echo '<input type="checkbox" value="">';
                                            } else {
                                                echo '<input type="checkbox" value="" checked="">';
                                            } ?></td>
                                                    <td class="center"><?Php if ($rw['Update_priv'] == "N") {
                                                echo '<input type="checkbox" value="">';
                                            } else {
                                                echo '<input type="checkbox" value="" checked="">';
                                            } ?></td>
                                                    <td class="center"><?Php if ($rw['Delete_priv'] == "N") {
                                                echo '<input type="checkbox" value="">';
                                            } else {
                                                echo '<input type="checkbox" value="" checked="">';
                                            } ?></td>
                                                    <td class="center"><?Php if ($rw['Create_user_priv'] == "N") {
                                                echo '<input type="checkbox" value="">';
                                            } else {
                                                echo '<input type="checkbox" value="" checked="">';
                                            } ?></td>
<!--                                                    <td class="center">
                                                        <input type="submit" class="btn btn-primary btn-sm" value="EDITAR" data-toggle="modal" data-target="#myModal" onclick="envia_id(<?Php echo 1; ?>)">

                                                    </td>-->
                                                </tr>
                                                <?Php
                                                }
                                                ?>
                                        </tbody>
                                    </table>

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="myModalLabel">EDITAR USUARIO</h4>
                                                </div>
                                                <div class="modal-body" id="caja">
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
    </form>