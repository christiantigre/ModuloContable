<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
require('../../Clases/Conectar.php');
$dbi = new Conectar();
$c = $dbi->conexion();
$stu = " SELECT count( `cod_clase` ) +1 AS id FROM t_clase ";
$query = mysqli_query($c,$stu);
if ($row = mysqli_fetch_row($query)) 
 {   $id = trim($row[0]); }

if (isset($_POST['submit'])) {
    require('../../Clases/cliente.class.php');

    $nombre_clase = htmlspecialchars(trim($_POST['nombre_clase']));
    $cod_clase = htmlspecialchars(trim($_POST['cod_clase']));
    $cod_clase=$cod_clase.'.';
    $descrip_class = htmlspecialchars(trim($_POST['descrip_class']));

    $objClase = new Clase;
    if ($objClase->insertar(array($nombre_clase, $cod_clase, $descrip_class)) == true) {
        if ($objClase->insertar_plan(array($nombre_clase, $cod_clase, $descrip_class)) == true) {
        echo 'Datos guardados en clase';
    } else {
        echo 'Se produjo un error. al insertar la en el Plan de Cuentas';
    }
        echo ' y plan de Cuentas';
    } else {
        echo 'Se produjo un error. al insertar la Clase';
    }
} else {
    ?>
<form id="frmClienteNuevo" name="frmClaseNuevo" method="post" action="nuevo.php"
      onsubmit="GrabarDatosClase();    return false">
    <center><label>Nueva clase</label></center> 
        <p><label>Nombre<br />
                <input class="text" type="text" name="nombre_clase" id="nombre_clase" />
            </label>
        </p>
        <p>
           <!-- <label>Codigo<br />-->
                <input  readonly="readonly" class="text" type="hidden" name="cod_clase" id="cod_clase" style="text-align:center" value="<?Php echo $id ?>"/>
           <!-- </label>-->
        </p>
        <p>
            <label>Descripcion<br />
                <input class="text" type="text" name="descrip_class" id="descrip_class" />
            </label>
        </p>
        <p>

        <p>
            <input type="submit" name="submit" id="button" value="Enviar" />
            <label></label>
            <input type="button" class="cancelar" name="cancelar" id="cancelar" value="Cancelar" onclick="Cancelar()"/>
        </p>
    </form>
    <?php
}
mysqli_close($c);
?>