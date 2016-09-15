<?php
session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../login.php"
</script>';
}
$ids = $_GET['id'];
$usuario = $ids;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <form role="form" class="form-inline">
                <div class="panel-heading">
                </div>
                <div class="form-inline">
                    <label>Usuario : </label>
                    <input class="form-control" type="text" id="name_us" value="<?Php echo $ids; ?>" readonly="readonly"> 
                </div>       
                <br>                                              
                <br>  
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> Selecci&oacute;n </th>
                            <th> Eliminar </th>
                            <th> Actualiz&aacute;r </th>
                            <th> Insertar </th>
                            <th> Archivos </th>
                            <th> Crear Us. </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?Php
                            $c = new mysqli("localhost", $_SESSION['username'], $_SESSION['clave'], 'mysql');
                            $sql_us = "SELECT * FROM `user` WHERE `User`='".$usuario."' and host='localhost'";
                            $result = mysqli_query($c, $sql_us) or trigger_error("Query Failed! SQL: $sql_us - Error: " . mysqli_error($c), E_USER_ERROR);
                            while ($rw = mysqli_fetch_assoc($result)) {
                                $ids = $rw['User'];
                                $Password = $rw['Password'];
                                ?>
                                <td class="center"><?Php
                                    if ($rw['Select_priv'] == "N") {
                                        echo '<input type="checkbox" value="">';
                                    } else {
                                        echo '<input type="checkbox" value="" checked="">';
                                    }
                                    ?></td>
                                <td class="center"><?Php
                                    if ($rw['Insert_priv'] == "N") {
                                        echo '<input type="checkbox" value="">';
                                    } else {
                                        echo '<input type="checkbox" value="" checked="">';
                                    }
                                    ?></td>
                                <td class="center"><?Php
                                    if ($rw['Update_priv'] == "N") {
                                        echo '<input type="checkbox" value="">';
                                    } else {
                                        echo '<input type="checkbox" value="" checked="">';
                                    }
                                    ?></td>
                                <td class="center"><?Php
                                    if ($rw['Delete_priv'] == "N") {
                                        echo '<input type="checkbox" value="">';
                                    } else {
                                        echo '<input type="checkbox" value="" checked="">';
                                    }
                                    ?></td>
                                <td class="center"><?Php
                                    if ($rw['File_priv'] == "N") {
                                        echo '<input type="checkbox" value="">';
                                    } else {
                                        echo '<input type="checkbox" value="" checked="">';
                                    }
                                    ?></td>
                                <td class="center"><?Php
                                    if ($rw['Create_user_priv'] == "N") {
                                        echo '<input type="checkbox" value="">';
                                    } else {
                                        echo '<input type="checkbox" value="" checked="">';
                                    }
                                ?>
                            </td>
                            <?Php    } ?>
                        </tr>   
                    </tbody>
                </table>
            </form>


        </div>
    </div>
</div>


