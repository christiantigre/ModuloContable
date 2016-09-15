<?Php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
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

<span id="new"><a href="newcuenta_aux.php"><img src="../../../images/add.png" alt="Agregar dato" /></a></span>
<span id="refrescar"><a href="planauxcuenta.php"><img src="../../../images/update.png" alt="Actualizar" title="Actualizar"/></a></span>
<table>
    <tr>
        <th>Nombre</th>
        <th>Codigo</th>
        <th></th>
        <th></th>
    </tr>
    <?php
$conn = $dbi->conexion();
//$servername = "localhost";
//$usernamedb = "root";
//$password = "alberto2791";
//$dbname = "condata";
//$conn = new mysqli($servername, $usernamedb, $password, $dbname);
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM t_auxiliar";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
      while($clase = $result->fetch_assoc()) {
     ?>

            <tr id="fila-<?php echo $clase['cod_cauxiliar'] ?>">
                <td><?php echo $clase['nombre_cauxiliar'] ?></td>
                <td><?php echo $clase['cod_cauxiliar'] ?></td>
            </tr>
            <?php
        }
        
    }
    $conn->close();
    ?>
</table>