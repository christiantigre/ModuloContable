<?php
require('../../Clases/cliente.class.php');
$objClase = new Clase;
$consulta = $objClase->mostrar_logeos();
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
<span id="new_cat"><a href="new_logeo.php"><img src="../../../images/add.png" alt="Agregar dato" title="Nuevo registro"/></a></span>
<span id="refrescar"><a href="panel_logeos.php">
        <img src="../../../images/update.png" alt="Actualizar" title="Actualizar"/></a></span>
                                
<table>
    <tr>
        <th>Usuario</th>
        <th>Contrase&ncaron;a</th>
        <th>Clase</th>
        <th>Nombre</th>
        <th>CI</th>
        <th></th>
        <th></th>
    </tr>
    <?php
    if ($consulta) {
        while ($clase = mysql_fetch_array($consulta)) {
            ?>
            <tr id="fila-<?php echo $clase['idlogeo'] ?>">
                <td><?php echo $clase['Username'] ?></td>
                <td><?php echo $clase['Contrasena'] ?></td>
                <td><?php echo $clase['Clase'] ?></td>
                <td><?php echo $clase['Nombre'] ?></td>
                <td><?php echo $clase['CI'] ?></td>
                <td><span class="modi"><a href="actualizar_login.php?idlogeo=<?php echo $clase['idlogeo'] ?>">
                            <img src="../../../images/database_edit.png" title="Editar" alt="Editar" /></a></span></td>
                            <td><span class="dele"><a onClick="Eliminar_C_Log(<?php echo $clase['idlogeo'] ?>);
                                return false" href="eliminar_c_login.php?idlogeo=<?php echo $clase['idlogeo'] ?>">
                            <img src="../../../images/delete.png" title="Eliminar" alt="Eliminar" /></a></span></td>
            </tr>
            <?php
        }
    }
    ?>
</table>