<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
require('../../Clases/cliente.class.php');
$objClase = new Clase;
$consulta = $objClase->mostrar_grupos();
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
    });
</script>

<span id="new"><a href="newgrupo.php"><img src="../../../images/add.png" alt="Agregar dato" /></a></span>
<span id="refrescar"><a href="plangrupos.php"><img src="../../../images/update.png" alt="Actualizar" title="Actualizar"/></a></span>
<table>
    <tr>
        <th>Nombre</th>
        <th>Codigo</th>
        <th>Descripcion</th>
        <th></th>
        <th></th>
    </tr>
    <?php
    if ($consulta) {
        while ($clase = mysqli_fetch_array($consulta)) {
            ?>
            <tr id="fila-<?php echo $clase['cod_grupo'] ?>">
                <td><?php echo $clase['nombre_grupo'] ?></td>
                <td><?php echo $clase['cod_grupo'] ?></td>
                <td><?php echo $clase['descrip_grupo'] ?></td>
                <td><span class="modi"><a href="actualizargrupo.php?cod_grupo=<?php echo $clase['cod_grupo'] ?>">
                            <img src="../../../images/database_edit.png" title="Editar" alt="Editar" /></a></span></td><!--
                <td>
                    <span class="dele">-->
                        <!--<a onClick="EliminarDatoGrupo(<?php echo $clase['cod_grupo'] ?>);return false;" href="eliminargrupo.php?cod_grupo=<?php echo $clase['cod_grupo'] ?>">                            <img src="../../../images/delete.png" title="Eliminar" alt="Eliminar" /></a></span></td>-->
            </tr>
            <?php
        }
    }
    ?>
</table>