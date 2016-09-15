<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
if(isset($_POST['submit'])){
	require('../../clases/cliente.class.php');
	$objGrupo=new Clase;	
	$nombre_grupo= htmlspecialchars(trim($_POST['nombre_grupo']));
	$descrip_grupo= htmlspecialchars(trim($_POST['descrip_grupo']));
        $idt_grupo= htmlspecialchars(trim($_POST['cod_grupo']));
	
	if ( $objGrupo->actualizargrupo(array($nombre_grupo,$descrip_grupo),$idt_grupo) == true){
            if ($objGrupo->actualizargrupoplan(array($nombre_grupo,$descrip_grupo),$idt_grupo) == true) {
                echo 'Datos guardados';
            }  else {
                echo 'No se pudo editar en el plan de cuentas';
            }
	}else{
		echo 'Se produjo un error. Intente nuevamente';
	} 
}else{
	if(isset($_GET['cod_grupo'])){
		require('../../Clases/cliente.class.php');
		$objGrupo=new Clase;
		$consulta = $objGrupo->mostrar_grupo($_GET['cod_grupo']);
		$clase = mysqli_fetch_array($consulta);
	?>
<form id="frmClienteActualizar" name="frmClienteActualizar" method="post" action="actualizargrupo.php" onsubmit="ActualizarDatosGrupo(); return false">
    <center><strong>Actualizar Cuentas de Grupo</strong></center>	
    <input type="hidden" name="cod_grupo" id="cod_grupo" value="<?php echo $clase['cod_grupo']?>" />
        <p>
	  <label>Nombre<br />
	  <input class="text" type="text" name="nombre_grupo" id="nombre_grupo" value="<?php echo $clase['nombre_grupo']?>" />
	  </label>
      </p>
	  <p>
		<!--<label>Codigo<br />-->
                    <input class="text" type="hidden" name="cod_grupo" id="cod_grupo" value="<?php echo $clase['cod_grupo']?>" />
		<!--</label>-->
	  </p>
	  <p>
		<label>Descripcion de Cuenta<br />
		<input class="text" type="text" name="descrip_grupo" id="descrip_grupo" value="<?php echo $clase['descrip_grupo']?>" />
		</label>
	  </p>
	  
	  <p>
		<input type="submit" name="submit" id="button" value="Enviar" />
		<label></label>
		<input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="Cancelar()" />
	  </p>
	</form>
	<?php
	}
}
?>