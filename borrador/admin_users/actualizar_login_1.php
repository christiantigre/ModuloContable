<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
require './functions.php';require '../../Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();
$consul_cargos = " SELECT * FROM `user_tipo` WHERE tipo_user != 'Sup'";
$query_cargos = mysqli_query($c,$consul_cargos);
$rowcrg = mysqli_fetch_array($query_cargos);
if (isset($_POST['submit'])) {
    require('../../Clases/cliente.class.php');
    $objClase = new Clase;
    $Contrasena = htmlspecialchars(trim($_POST['Contrasena']));
    $Username = htmlspecialchars(trim($_POST['Username']));
    $crg_us = htmlspecialchars(trim($_POST['crg_us']));
    $idusuario = htmlspecialchars(trim($_POST['idusuario']));
    $idlogeo = htmlspecialchars(trim($_POST['idlogeo']));

    if ($objClase->actualizar_cuenta_log(array($Contrasena, $Username, $idusuario), $idlogeo) == true) {
        echo 'Datos guardados';
    } else {
        echo 'Se produjo un error. Intente nuevamente';
    }
} else {
    if (isset($_GET['idlogeo'])) {
        require('../../Clases/cliente.class.php');
        $objClase = new Clase;
        $consulta = $objClase->mostrar_cuenta_log($_GET['idlogeo']);
        $clase = mysqli_fetch_array($consulta);
        ?>
        <form id="frmClienteActualizar" name="frmClienteActualizar" method="post" action="actualizar_logeos.php" 
              onsubmit="ActualizarDatos_login();
                              return false">
            <center>  <strong>Actualizaci&oacute;n de Cuenta de Logeo</strong> </center>
            <input type="hidden" name="idlogeo" id="idlogeo" value="<?php echo $clase['idlogeo'] ?>" />
            <p>
                <label>Usuario<br />
                    <input class="text" type="text" name="Username" id="Username" value="<?php echo $clase['Username'] ?>" />
                </label>
            </p>
            <p>
                <label>Clave<br />
                    <input class="text" type="text" name="Contrasena" id="Contrasena" value="<?php echo $clase['Contrasena'] ?>" />
                </label>
            </p>
            <p><label>Cargo<br />
                    <input class="text" type="hidden" name="campoaux" id="campoaux" value="<?php echo $clase['Clase'] ?>" />
                    <select class="text" name="crg_us" id="crg_us" size="0" style="alignment-adjust: central" onchange="generar_clase_UpLogin()"><!--generar_codigo_grupo()-->
                        <?php while ($arreglotipo = mysqli_fetch_array($query_cargos)) { ?>
                            <option class="text" value="<?php echo $arreglotipo['cod_user'] ?>"><?php echo $arreglotipo['tipo_user'] ?></option>     
                            <?php
                        }
                        mysqli_close($c);
                        ?>
                    </select>
                </label>
            </p>
            <p>
                <label>Nombre<br />
                    <input class="text" type="text" readonly="readonly" name="Nombre" id="Nombre" value="<?php echo $clase['Nombre'] ?>" />
                    <input class="text" type="hidden" readonly="readonly" name="idusuario" id="idusuario" value="<?php echo $clase['idus'] ?>" />
                </label>
            </p>

            <p><label>CI.<br />
                    <input class="text" type="text" readonly="readonly" name="CI" id="CI" value="<?php echo $clase['CI'] ?>" />
                </label>
            </p>

            <p>
                <input type="submit" name="submit" id="button" class="btn"  value="Enviar" />
                <label></label>
                <input type="button" name="cancelar" id="cancelar" class="btn"  value="Cancelar" onclick="Cancelar()" />

            </p>
        </form>
        <?php
    }
}
?>