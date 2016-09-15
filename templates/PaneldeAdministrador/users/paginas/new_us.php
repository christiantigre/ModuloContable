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
include '../../../../templates/PanelAdminLimitado/Clases/guardahistorial.php';
$accion = "/ ADMIN USUARIOS / nuevo / Ingreso a registro de usuarios";
generaLogs($user, $accion);
?>
<script type="text/javascript">
    $(document).ready(function () {

        //Checkbox
        $("input[name=checktodos]").change(function () {
            $('input[type=checkbox]').each(function () {
                if ($("input[name=checktodos]:checked").length == 1) {
                    this.checked = true;
                } else {
                    this.checked = false;
                }
            });
        });

    });
</script>
<form method="post" name="form" id="form" action="http://localhost/ModuloContable/templates/PaneldeAdministrador/users/paginas/save_us.php">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Administraci&oacute;n de Usuarios</h1>
            <div class="panel panel-default">
                <button type="submit" class="btn btn-primary glyphicon glyphicon-floppy-saved" onclick="return save_uss(this)"></button>
                <div class="panel-heading">
                    Nuevo Usuario
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="form-group">
                            <label> Usuario </label>
                            <input type="text" class="form-control" name="name_us" id="name_us" required="">
                        </div>
                        <div class="form-group">
                            <label> Clave </label>
                            <input type="password" class="form-control" name="pass_us" id="pass_us" required="">
                        </div>
                        <div class="form-group">
                            <label> Verifique clave</label>
                            <input type="password" class="form-control" name="pass_usverif" id="pass_usverif" onblur="verifi_pass();" required="">
                        </div>
                        <div class="form-group">
                            <label> Privilegios </label>
                        </div>

                        <div id="alerts">

                        </div>
                        <table class="table table table-striped">
                            <thead>
                                <tr>
                                    <th>Todos</th>
                                    <th>Selecci&oacute;n</th>
                                    <th>Eliminar</th>
                                    <th>Actualizar</th>
                                    <th>Insertar</th>
                                    <th>Crear Us.</th>
                                </tr>
                            </thead>
                            <tbody>        
                                <tr class="gradeU">                                                    
                                    <td><input type="checkbox" name="todos" id="todos" onclick="check();"></td>
                                    <td><input type="checkbox" name="priv_usS" id="priv_usS" value="" onclick="ver_check();"></td>
                                    <td><input type="checkbox" name="priv_usD" id="priv_usD" value="" onclick="ver_check();"></td>
                                    <td><input type="checkbox" name="priv_usU" id="priv_usU" value="" onclick="ver_check();"></td>
                                    <td><input type="checkbox" name="priv_usI" id="priv_usI" value="" onclick="ver_check();"></td>
                                    <td><input type="checkbox" name="priv_usCU" id="priv_usCU" value="" onclick="ver_check();"></td>
                                </tr>
                            </tbody>
                        </table>
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