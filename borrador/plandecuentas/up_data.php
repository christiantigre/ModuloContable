


<?Php
if (isset($_GET['codigo'])) {
    include '../../../templates/Clases/Conectar.php';
    $dbi = new Conectar();
    $c = $dbi->conexion();
    $sql = "SELECT * FROM t_auxiliar where cod_cauxiliar='" . $_GET['codigo'] . "'";
    $reali = mysqli_query($c, $sql) or die(mysqli_errno($c));
    while ($row = mysqli_fetch_array($reali)) {
        ?>
        <center>
            <h3>DETALLE DE CUENTA</h3>
        </center>
        <form method="POST" action="../templateslimit/up_data.php" name="form_up" id="form_up">
            <input class="text" type="hidden" name="id" id="id" value="<?Php echo $row[1] ?>"/>
            <p>
                <label>Nombre<br />
                    <input class="text" type="text" name="nombre_cuenta" id="nombre_cuenta" value="<?Php echo utf8_decode($row[0]); ?>" readonly="readonly"/>
                </label>
            </p>      
            <p>
                <label>Descripci&oacute;n<br />
                    <input class="text" type="text" name="descrip_cuenta" id="descrip_cuenta" value="<?Php echo $row[2] ?>" />
                </label>
            </p>
            <table>
                <p>
                    <label>Veh&iacute;culo</br> 
                        <input type="text" name="v_placa" id="v_placa" class="text-medio" placeholder="Ingrese placa" value="<?Php echo $row[7] ?>"/>
                    </label>
                </p>
                <p>
                    <label>Cliente</br>
                        <input type="text" name="c_id" id="c_id" class="text-medio" placeholder="Ingrese id" value="<?Php echo $row[8] ?>"/>
                    </label>
                </p> 
            </table>
            <p>
            <center>
                <input type="submit" class="btn-success" name="submit" onclick="return confirmar();" id="submit" value="GUARDAR" />                         
            </center>
            <script>
                function confirmar() {
                    var formulario = document.getElementById("form_up");
                    var dato = formulario[0];
                    respuesta = confirm('¿Esta seguro que desea realizar los cambios?\n ');
                    if (respuesta) {
                        formulario.submit();
                        return true;
                    } else {
                        alert("No se aplicaran los cambios...!!!");
                        return false;
                    }
                }
            </script>


        </form>
        <?Php
    }
    mysqli_close($c);
}
if (isset($_REQUEST["submit"])) {
    $btntu = $_REQUEST["submit"];
    if ($btntu == "GUARDAR") {
        include '../../../templates/Clases/Conectar.php';
        $dbi = new Conectar();
        $c = $dbi->conexion();
        $nombre_cuenta = htmlspecialchars(trim($_POST['nombre_cuenta']));
        $descrip_cuenta = htmlspecialchars(trim($_POST['descrip_cuenta']));
        $v_placa = htmlspecialchars(trim($_POST['v_placa']));
        $c_id = htmlspecialchars(trim($_POST['c_id']));
        $id = htmlspecialchars(trim($_POST['id']));
        $sql_up = "UPDATE `t_auxiliar` SET `nombre_cauxiliar`='".utf8_encode($nombre_cuenta)."',`descrip_auxiliar`='$descrip_cuenta',"
                . "`placa_id`='$v_placa',`cli_id`='$c_id' WHERE `cod_cauxiliar`='$id'";
        mysqli_query($c, $sql_up) or trigger_error("Query Failed! SQL: $sql_up - Error: " . mysqli_error($c), E_USER_ERROR);
        echo '<script language = javascript>
alert("Datos guardados")
self.location = "planauxcuenta.php"
</script>';
    }
}
?>