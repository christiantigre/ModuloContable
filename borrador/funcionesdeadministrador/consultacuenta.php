<?php
require('../Clases/cliente.class.php');
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
<span id="nuevo"><a href="nuevosubcuenta.php"><img src="../img/add.png" alt="Agregar dato" />Nuevo</a></span>
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
        while ($clase = mysql_fetch_array($consulta)) {
            ?>

            <tr id="fila-<?php echo $clase['idt_cuenta'] ?>">
                <td><?php echo $clase['nombre_cuenta'] ?></td>
                <td><?php echo $clase['cod_cuenta'] ?></td>
                <td><?php echo $clase['descrip_cuenta'] ?></td>
<!--                <td><span class="modi"><a href="actualizarcuenta.php?idt_cuenta=<?php echo $clase['idt_cuenta'] ?>">
                            <img src="../img/database_edit.png" title="Editar" alt="Editar" /></a></span></td>
                            <td><span class="dele"><a onClick="EliminarDatoCuenta(<?php echo $clase['idt_cuenta'] ?>);
                                return false" href="eliminarcuenta.php?idt_cuenta=<?php echo $clase['idt_cuenta'] ?>">
                            <img src="../img/delete.png" title="Eliminar" alt="Eliminar" /></a></span></td>-->
            </tr>
            <?php
        }
    }
    ?>
</table>