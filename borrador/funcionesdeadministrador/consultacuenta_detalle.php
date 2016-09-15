<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
require('../../Clases/cliente.class.php');
$objCuenta = new Clase;
$consulta = $objCuenta->mostrar_cuentas();
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
                url: 'nuevocuenta.php',
                success: function (datos) {
                    $("#formulario").html(datos);
                }
            });
            return false;
        });
    });

</script>
<span id="nuevoc_detalle"><a href="newcuenta_detalle.php"><img src="../../../images/add.png" alt="Agregar dato" /></a></span>
<span id="refrescar"><a href="plancuen_detalle.php"><img src="../../../images/update.png" alt="Actualizar" title="Actualizar"/></a></span>
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

            <tr id="fila-<?php echo $clase['cod_cuenta'] ?>">
                <td><?php echo $clase['nombre_cuenta'] ?></td>
                <td><?php echo $clase['cod_cuenta'] ?></td>
                <td><?php echo $clase['descrip_cuenta'] ?></td>
<!--                <td><span class="modi"><a href="actualizarcuenta_det.php?cod_cuenta=<?php echo $clase['cod_cuenta'] ?>">
                            <img src="../../../images/database_edit.png" title="Editar" alt="Editar" /></a></span>
                </td>-->
<!--                            <td><span class="dele"><a onClick="EliminarDatoCuenta_det(<?php echo $clase['cod_cuenta'] ?>);
                                return false" href="eliminarcuenta_det.php?cod_cuenta=<?php echo $clase['cod_cuenta'] ?>">
                            <img src="../../../images/delete.png" title="Eliminar" alt="Eliminar" /></a></span></td>-->
            </tr>
            <?php
        }
    }
    ?>
</table>