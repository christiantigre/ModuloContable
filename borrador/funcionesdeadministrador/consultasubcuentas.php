<?Php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
$conn = $dbi->conexion();
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
                url: 'nuevogrupo.php',
                success: function (datos) {
                    $("#formulario").html(datos);
                }
            });
            return false;
        });
    });

</script>

<span id="new"><a href="newcuenta_detallesub.php"><img src="../../../images/add.png" alt="Agregar dato" /></a></span>
<span id="refrescar"><a href="plansubcuentaadmin.php"><img src="../../../images/update.png" alt="Actualizar" title="Actualizar"/></a></span>
<table>
    <tr>
        <th>Nombre</th>
        <th>Codigo</th>
        <th>Descripci&oacute;n</th>
        <th></th>
        <th></th>
    </tr>
    <?php
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM t_subcuenta";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
      while($clase = $result->fetch_assoc()) {
     ?>

            <tr id="fila-<?php echo $clase['cod_cuenta'] ?>">
                <td><?php echo $clase['nombre_subcuenta'] ?></td>
                <td><?php echo $clase['cod_subcuenta'] ?></td>
                <td><?php echo $clase['descrip_subcuenta'] ?></td>
<!--                <td><span class="modi"><a href="actualizarcuenta_detsub.php?cod_cuenta=<?php echo $clase['cod_cuenta'] ?>">
                            <img src="../../../images/database_edit.png" title="Editar" alt="Editar" /></a></span>
                </td>-->
            </tr>
            <?php
        }
        
    }
    $conn->close();
    ?>
</table>