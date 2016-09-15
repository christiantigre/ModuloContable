<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
if(isset($_POST['submit'])){
	require('../../clases/cliente.class.php');
	$objCuenta=new Clase;
	
	$nombre_cuenta= htmlspecialchars(trim($_POST['nombre_cuenta']));
	$descrip_cuenta= htmlspecialchars(trim($_POST['descrip_cuenta']));
	$cod_cuenta= htmlspecialchars(trim($_POST['cod_cuenta']));
	
	if ( $objCuenta->actualizarcuenta(array($nombre_cuenta,$descrip_cuenta),$cod_cuenta) == true){
            if ($objCuenta->actualizargrupoplan(array($nombre_cuenta,$descrip_cuenta),$cod_cuenta) == true) {
                 echo 'Datos guardados'; 
            }  else {
                echo 'Error no se puede actualizar en el plan de cuentas...';
            }
	}else{
		echo 'Se produjo un error. Intente nuevamente';
	} 
}else{
	if(isset($_GET['cod_cuenta'])){		
		require('../../Clases/cliente.class.php');
		$objCuenta=new Clase;
		$consulta = $objCuenta->mostrar_cuenta($_GET['cod_cuenta']);
		$clase = mysqli_fetch_array($consulta);
	?>
<form id="frmClienteActualizar" name="frmClienteActualizar" method="post" action="actualizarcuenta_det.php" onsubmit="ActualizarDatosCuenta(); return false">
    	<input type="hidden" name="cod_cuenta" id="cod_cuenta" value="<?php echo $clase['cod_cuenta']?>" />
        <p>
	  <label>Nombre<br />
	  <input class="text" type="text" name="nombre_cuenta" id="nombre_cuenta" value="<?php echo $clase['nombre_cuenta']?>" />
	  </label>
      </p>
	  <p>
		<!--<label>Codigo<br />-->
                    <input class="text" type="hidden" name="cod_cuenta" id="cod_cuenta" value="<?php echo $clase['cod_cuenta']?>" />
		<!--</label>-->
	  </p>
	  <p>
		<label>Descripcion de Cuenta<br />
		<input class="text" type="text" name="descrip_cuenta" id="descrip_cuenta" value="<?php echo $clase['descrip_cuenta']?>" />
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