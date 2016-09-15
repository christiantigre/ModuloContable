<?php
require('../../../Clases/cliente.class.php');
$objClase = new Clase;
$consulta = $objClase->mostrar_usuarios();
?>
<script type="text/javascript">
    $(document).ready(function () {
        // mostrar formulario de actualizar datos
        $("table tr .modi a").click(function () {
            $('#tabla').hide();
            $("#formulario").show();
            $.ajax({
                url: this.href,
                type: "GET",
                success: function (datos) {
                    $("#formulario").html(datos);
                }
            });
            return false;
        });

        // llamar a formulario nuevo
        $("#nuevo a").click(function () {
            $("#formulario").show();
            $("#tabla").hide();
            $.ajax({
                type: "GET",
                url: 'nuevo.php',
                success: function (datos) {
                    $("#formulario").html(datos);
                }
            });
            return false;
        });
    });

</script>
<span id="new_cat"><a href="new_user.php"><img src="../../../../images/add.png" alt="Agregar dato" title="Nuevo registro"/></a></span>
<span id="refrescar"><a href="panel_reg_user.php">
        <img src="../../../../images/update.png" alt="Actualizar" title="Actualizar"/></a></span>
                                
<table>
    <tr>
        <th>Usuario</th>
        <th>Cedula</th>
        <th>Email</th>
        <th>Descrpcion</th>
        <!--<th>Foto</th>-->
        <!--<th></th>-->
        <!--<th></th>-->
    </tr>
    <?php
    if ($consulta) {
        while ($clase = mysql_fetch_array($consulta)) {
            ?>
            <tr id="fila-<?php echo $clase['idusuario'] ?>">
                <td><?php echo $clase['Usuario'] ?></td>
                <td><?php echo $clase['cedula'] ?></td>
                <td><?php echo $clase['email'] ?></td>
                <td><?php echo $clase['Descrip_user'] ?></td>
                <!--<td><img src="<?php // echo $clase['foto'] ?>" width="25" height="25"/></td>-->
<!--                <td><span class="modi"><a href="actualizar_usuario.php?idusuario=<?php echo $clase['idusuario'] ?>">
                            <img src="../../../../images/database_edit.png" title="Editar" alt="Editar" /></a></span></td>-->
<!--                            <td><span class="dele"><a onClick="Eliminar_Us(<?php echo $clase['idusuario'] ?>);
                                return false" href="eliminar_us.php?idusuario=<?php echo $clase['idusuario'] ?>">
                            <img src="../../../../images/delete.png" title="Eliminar" alt="Eliminar" /></a></span></td>-->
            </tr>
            <?php
        }
    }
    ?>
</table>