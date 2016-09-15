<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
require './functions.php';
if (isset($_POST['submit'])) {
    require('../../Clases/cliente.class.php');
    $objClase = new Clase;
    $nombre= htmlspecialchars(trim($_POST['nombre']));
    $apellido= htmlspecialchars(trim($_POST['apellido']));
    $email= htmlspecialchars(trim($_POST['email']));
    $nacionalidad= htmlspecialchars(trim($_POST['nacionalidad']));
    $cargo= htmlspecialchars(trim($_POST['cargo']));
    $foto= htmlspecialchars(trim($_POST['foto']));
    $fecha_nacimiento= htmlspecialchars(trim($_POST['fecha_nacimiento']));
    $cedula= htmlspecialchars(trim($_POST['cedula']));
    $tlf= htmlspecialchars(trim($_POST['tlf']));
    $cel= htmlspecialchars(trim($_POST['cel']));
    $descrip_us= htmlspecialchars(trim($_POST['Descrip_user']));
    $idusuario= htmlspecialchars(trim($_POST['idusuario']));
    
    if ($objClase->actualizar_usuario(array($nombre,$apellido,$email,$nacionalidad,$cargo,$foto,
        $fecha_nacimiento,$cedula,$tlf,$cel,$descrip_us), $idusuario) == true) {
        echo 'Datos guardados';   
        } else {
        echo 'Se produjo un error. Intente nuevamente';    }
                } else {    if (isset($_GET['idusuario'])) {
        require('../../Clases/cliente.class.php');
        $objClase = new Clase;
        $consulta = $objClase->mostrar_usuario($_GET['idusuario']);
        $clase = mysqli_fetch_array($consulta);
        ?>
        <form id="frmClienteActualizar" name="frmClienteActualizar" method="post" action="actualizar_usuario.php" 
              onsubmit="ActualizarDatosUsuario();
                              return false">
            <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $clase['idusuario'] ?>" />
            <p>
                <label>Nombre<br />
                    <input class="text" type="text" name="nombre" id="nombre" value="<?php echo $clase['nombre'] ?>" />
                </label>
            </p>
            <p>
                <label>Apellido<br />
                    <input class="text" type="text" name="apellido" id="apellido" value="<?php echo $clase['apellido'] ?>" />
                </label>
            </p>
            <p>
                <label>Correo<br />
                    <input class="text" type="email" name="email" id="email" value="<?php echo $clase['email'] ?>" />
                </label>
            </p>
            <p>
                <label>Nacionalidad<br />
                    <input class="text" type="text" name="nacionalidad" id="nacionalidad" value="<?php echo $clase['nacionalidad'] ?>" />
                </label>
            </p>

<!--            <p><label>Cargo<br />
                    <input class="text" type="text" name="cargo" id="cargo" value="<?php echo $clase['cargo'] ?>" />
                </label>
            </p>-->
<!--            <p><label>Foto<br />
                    <img src="<?php echo $clase['foto'] ?>" width="50" height="50"/>
                    <input name="foto" type="foto" class="text" id="foto" value="<?php echo $clase['foto']; ?>">
                    <input name="userfile" type="file" class="text" id="userfile" value="<?php echo $clase['foto']; ?>">
                </label>
            </p>
            <p>
                <label>Fecha Nacimiento <a onclick="show_calendar()" style="cursor: pointer;">
                        <small>(calendario)</small>
                        <img src="../../../images/calendar.png" alt="Calendario" title="Calendario"/>
                    </a><br />
                    <input class="text" type="text" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo date("Y-m-j") ?>" />
                    <div id="calendario" style="display:none;"><?php echo calendar_html(); ?></div>
                </label>
            </p>-->
            <p>
                <label>Cedula<br />
                    <input class="text" type="text" name="cedula" id="cedula" value="<?php echo $clase['cedula']; ?>"/>
                </label>
            </p>
            <p>
                <label>Tel&eacute;fono<br />
                    <input class="text" type="text" name="tlf" id="tlf" value="<?php echo $clase['telefono']; ?>"/>
                </label>
            </p>
            <p>
                <label>Celular<br />
                    <input class="text" type="text" name="cel" id="cel" value="<?php echo $clase['celular']; ?>"/>
                </label>
            </p>
            <p>
                <label>Usuario : </label> <label><?Php echo $clase['username']; ?></label><br />
                <?Php
                $find = array('a', 'b', 'c', 'd', 'e', 'f', 'j', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
                    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                    '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '_', '!', '#', '@', '$', '%', '^', '&', '*', '(', ')', '=', '+', '{', '}', '[', ']', ';', ':', '/',);
                $pass = str_replace($find, "*", $clase['password']);
                ?>
                <label>Clave : </label> <label><?Php echo $pass; ?></label>
            </p>

            <p>
                <input type="submit" class="btn" name="submit" id="button" value="Enviar" />
                <label></label>
                <input type="button" class="btn" name="cancelar" id="cancelar" value="Cancelar" onclick="Cancelar()" />

            </p>
        </form>
        <?php
    }
}
?>