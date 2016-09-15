<?php
require('../../../Clases/cliente.class.php');
$objClase = new Clase;
$consulta = $objClase->mostrar_categorias();
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
<span id="new_cat"><a href="new_category.php"><img src="../../../../images/add.png" alt="Agregar dato" title="Nuevo registro"/></a></span>
<span id="refrescar"><a href="panel_users.php"><img src="../../../../images/update.png" alt="Actualizar" title="Actualizar"/></a></span>
                                
<table>
    <tr>
        <th>Categoria de Usuario</th>
        <th>Codigo</th>
        <th>Descripci&oacute;n</th>
<!--        <th></th>
        <th></th>-->
    </tr>
    <?php
    if ($consulta) {
        while ($clase = mysql_fetch_array($consulta)) {
            ?>

            <tr id="fila-<?php echo $clase['cod_user'] ?>">
                <td><?php echo $clase['tipo_user'] ?></td>
                <td><?php echo $clase['cod_user'] ?></td>
                <td><?php echo $clase['descrip_user'] ?></td>
<!--                <td><span class="modi"><a href="actualizar_category.php?cod_user=<?php echo $clase['cod_user'] ?>">
                            <img src="../../../../images/database_edit.png" title="Editar" alt="Editar" /></a></span></td>
                            <td><span class="dele"><a onClick="EliminarDatoCat(<?php echo $clase['cod_user'] ?>);
                                return false" href="eliminarcategoria.php?cod_user=<?php echo $clase['cod_user'] ?>">
                            <img src="../../../../images/delete.png" title="Eliminar" alt="Eliminar" /></a></span></td>-->
            </tr>
            <?php
        }
    }
    ?>
</table>