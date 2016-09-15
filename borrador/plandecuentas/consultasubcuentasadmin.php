
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
        <th></th>
        <th></th>
    </tr>
    <?php
    $conn = $dbi->conexion();
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM t_subcuenta";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
      while($clase = $result->fetch_assoc()) {
     ?>

    <tr id="fila-<?php echo $clase['cod_cuenta'] ?>">
                <td><?php echo utf8_decode($clase['nombre_subcuenta']) ?></td>
                <td><?php echo $clase['cod_subcuenta'] ?></td>
            </tr>
            <?php
        }
        
    }
    $conn->close();
    ?>
</table>