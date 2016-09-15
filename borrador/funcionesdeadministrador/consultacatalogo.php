<?php
require('../../Clases/cliente.class.php');
$objClase = new Clase;
$consulta = $objClase->mostrar_catalgogo_cuentas();
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
<span id="nuevo"><a href="nuevo.php"><img src="../../../images/add.png" alt="Agregar dato" title="Nuevo registro"/></a></span>
<span id="refrescar"><a href="plancuentas.php"><img src="../../../images/update.png" alt="Actualizar" title="Actualizar"/></a></span>
                                
<table>
    <tr>
        <th>Codigo Cta.</th>
        <th>Cuenta</th>
        <th>Descripcion</th>
        <th></th>
        <th></th>
    </tr>
    <?php
    if ($consulta) {
        while ($clase = mysqli_fetch_array($consulta)) {
            ?>

            <tr id="fila-<?php echo $clase['idt_plan_de_cuentas'] ?>">
                <td><?php echo $clase['cod_cuenta'] ?></td>
                <td><?php echo $clase['nombre_cuenta_plan'] ?></td>
                <td><?php echo $clase['descripcion_cuenta_plan'] ?></td>
<!--                <td><span class="modi"><a href="actualizar.php?cod_clase=<?php echo $clase['cod_clase'] ?>">
                            <img src="../../../images/database_edit.png" title="Editar" alt="Editar" /></a></span></td>
                            <td><span class="dele"><a onClick="EliminarDatoClase(<?php echo $clase['cod_clase'] ?>);
                                return false" href="eliminar.php?cod_clase=<?php echo $clase['cod_clase'] ?>">
                            <img src="../../../images/delete.png" title="Eliminar" alt="Eliminar" /></a></span></td>-->
            </tr>
            <?php
        }
    }
    ?>
</table>