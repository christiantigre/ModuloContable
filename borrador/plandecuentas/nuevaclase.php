<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
session_start();
$user = $_SESSION['username'];
require('../../../templates/Clases/Conectar.php');
$dbi = new Conectar();
$conn = $dbi->conexion();
$sql = " SELECT count( `cod_clase` ) +1 AS id FROM t_clase ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {$id = trim($row["id"]);
    }
}
$conn->close();
if (isset($_POST['submit'])) {
    require('../Clases/admin.class.php');
    $nombre_clase = htmlspecialchars(trim($_POST['nombre_clase']));
    $cod_clase = htmlspecialchars(trim($_POST['cod_clase']));
    $cod_clasefn=$cod_clase.'.';
    $descrip_class = htmlspecialchars(trim($_POST['descrip_class']));

    $objClase = new ClaseAdmin;
    if ($objClase->insertarAdmin(array($nombre_clase, $cod_clasefn, $descrip_class)) == true) {            
                if ($objClase->insertar_planAdmin(array($nombre_clase, $cod_clasefn, $descrip_class)) == true) {
                        echo 'Guardado, exitosamente en Clases y Plan de Cuentas';
    include '../Clases/guardahistorialcuentas.php';
    $accion=" / plan de cuentas / Usuario agrego nueva clase ".$id;
    generaLogs($user, $accion);
                } 
    } 
} else {
    ?>
<form id="frmClienteNuevo" name="frmClaseNuevo" method="post" action="nuevaclase.php"
      onsubmit="GrabarDatosClaseAdmin();    return false">
        <p><label>Nombre<br />
                <input class="text" type="text" name="nombre_clase" id="nombre_clase" />
            </label>
        </p>
        <p>
           <!-- <label>Codigo<br />-->
           <input  readonly="readonly" class="text" type="hidden" name="cod_clase" id="cod_clase" style="text-align:center" value="<?Php print $id ?>"/>
           <!-- </label>-->
        </p>
        <p>
            <label>Descripcion<br />
                <input class="text" type="text" name="descrip_class" id="descrip_class" />
            </label>
        </p>
        <p>

        <p>
            <input type="submit" name="submit" class="btn" id="button" value="Enviar"/>
            <label></label>
            <!--<input type="button" class="cancelar" name="cancelar" id="cancelar" value="Cancelar" onclick="Cancelar()"/>-->
        </p>
    </form>
    <?php
}
//mysql_close($ctu);
//$conn->close();
?>