<?php
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;

if(isset($_POST['submit'])){
	require('../../Clases/cliente.class.php');
	$objClase=new Clase;	
	$nombre_clase= htmlspecialchars(trim($_POST['nombre_clase']));
	$cod_clase= htmlspecialchars(trim($_POST['cod_clase']));
	$descrip_class = htmlspecialchars(trim($_POST['descrip_class']));	
	if ( $objClase->actualizar(array($nombre_clase,$cod_clase,$descrip_class),$cod_clase) == true){
            if ($objClase->actualizargrupoplan(array($nombre_clase,$descrip_class,),$cod_clase) == true) {
                echo 'Datos guardados';
            }  else {
                echo 'No se puede actualizar en el plan de cuentas...!!!';
            }
	}else{
		echo 'Se produjo un error. Intente nuevamente';
	} 
}else{
	if(isset($_GET['cod_clase'])){		
		require('../../Clases/cliente.class.php');
		$objClase=new Clase;
		$consulta = $objClase->mostrar_clase($_GET['cod_clase']);
		$clase = mysqli_fetch_array($consulta);
	?>
	<form id="frmClienteActualizar" name="frmClienteActualizar" method="post" action="actualizar.php" onsubmit="ActualizarDatos(); return false">
    	<input type="hidden" name="cod_clase" id="idt_clase" value="<?php echo $clase['cod_clase']?>" />
        <p>
	  <label>Nombre<br />
	  <input class="text" type="text" name="nombre_clase" id="nombre_clase" value="<?php echo $clase['nombre_clase']?>" />
	  </label>
      </p>
	  <p>
		<!--<label>Codigo<br />-->
                <input class="text" type="hidden" name="cod_clase" id="cod_clase" value="<?php echo $clase['cod_clase']?>" />
		<!--</label>-->
	  </p>
	  <p>
		<label>Descripcion de Cuenta<br />
		<input class="text" type="text" name="descrip_class" id="descrip_class" value="<?php echo $clase['descrip_class']?>" />
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