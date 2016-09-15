
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

<span id="new"><a href="newcuenta_aux.php"><img src="../../../images/add.png" alt="Agregar dato" /></a></span>
<span id="refrescar"><a href="planauxcuenta.php"><img src="../../../images/update.png" alt="Actualizar" title="Actualizar"/></a></span>
<table>
    <tr>
        <th>Nombre</th>
        <th>Id</th>
        <th>Codigo</th>
        <th></th>
        <th></th>
    </tr>
    <?php
    $conn = $dbi->conexion();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT cod_cauxiliar,nombre_cauxiliar,CONCAT(`placa_id` ,' / ', `cli_id`) as id FROM t_auxiliar";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($clase = $result->fetch_assoc()) {
            $nom_caux=$clase['nombre_cauxiliar'];
            ?>

            <tr id="fila-<?php echo $clase['cod_cauxiliar'] ?>">
                <td><?php echo utf8_decode($nom_caux); ?></td>
                <td><?php echo $clase['id'] ?></td>
                <td><?php echo $clase['cod_cauxiliar'] ?></td>
                <td>
                    <span class="modi">
                        <a href="up_data.php?codigo=<?php echo $clase['cod_cauxiliar'] ?>">
                            <img src="../../../images/database_edit.png" title="Editar" alt="Editar" />
                        </a>
                    </span>
                </td>

            </tr>
            <?php
        }
    }
    $conn->close();
    ?>
</table>