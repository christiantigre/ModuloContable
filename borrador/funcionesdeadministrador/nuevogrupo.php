<?php
$ctu = mysql_connect("localhost", "root", "alberto2791") or die("Error en la conexion");
$Btu = mysql_select_db("condata", $ctu) or die("Problema al seleccionar la base de datos");
$stu = "select * from t_clase";
$queryclases = mysql_query($stu);

if (isset($_POST['submit'])) {
    require('../../Clases/cliente.class.php');
    $nombre_grupo = htmlspecialchars(trim($_POST['nombre_grupo']));
    $cod_grupo = htmlspecialchars(trim($_POST['cod_grupo']));
    $descrip_grupo = htmlspecialchars(trim($_POST['descrip_grupo']));
    $t_clase_cod_clase = htmlspecialchars(trim($_POST['t_clase_cod_clase']));
    $objGrupo = new Clase;
    if ($objGrupo->insertargrupo(array($nombre_grupo, $cod_grupo, $descrip_grupo, $t_clase_cod_clase)) == true) {
        // echo "<script> alert('Guardado; '".$nombre_grupo + $cod_grupo + $descrip_grupo =$cod_claseaux."');</script>";
        echo 'Datos guardados';
    } else {
        echo 'Se produjo un error. Intente nuevamente';
    }
} else {
    ?>


    <form id="frmClienteNuevo" name="frmClaseNuevo" method="post" action="nuevogrupo.php" onsubmit="GrabarDatosGrupo();return false">        
        <?php include './generarcodigoscuentas.php'; ?>

        <p><label>Nombre<br />
                <input class="text" type="text" name="nombre_grupo" id="nombre_grupo" />
                <input class="text" type="text" name="cod_clasetxt" id="cod_clasetxt" />
            </label>
        </p>
        <p>
            <label>C&oacute;digo<br />

         <!--  <input class="text" type="text" name="cod_grupo" id="cod_grupo" value=""/>
        <!-- <input class="text" type="text" name="cod_clasetxt" id="cod_clasetxt" />-->
                <!--  </form>
              </label>-->
        </p>
        <p>
            <label>Descripcion<br />
                <input class="text" type="text" name="descrip_grupo" id="descrip_grupo" />
            </label>
        </p>
        <p>
            <!--<input type="button" name="buttongen" id="button" value="Gen" onclick="cargarfuncion();"/>-->
            <input type="submit" name="submit" id="button" value="Enviar" />
            <label></label>
            <input type="button" class="cancelar" name="cancelar" id="cancelar" value="Cancelar" onclick="Cancelar()"/>
        </p>
    </form>
    <?php
}
?>

