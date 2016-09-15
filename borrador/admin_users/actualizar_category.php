<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['submit'])){
	require('../../Clases/cliente.class.php');
	$objClase=new Clase;
	
	$tipo_user= htmlspecialchars(trim($_POST['tipo_user']));
	$descrip_user= htmlspecialchars(trim($_POST['descrip_user']));
	$cod_user= htmlspecialchars(trim($_POST['cod_user']));
	
	if ( $objClase->actualizar_categoria(array($tipo_user,$descrip_user),$cod_user) == true){
		echo 'Datos guardados';
	}else{
		echo 'Se produjo un error. Intente nuevamente';
	} 
}else{
	if(isset($_GET['cod_user'])){
		
		require('../../Clases/cliente.class.php');
		$objClase=new Clase;
		$consulta = $objClase->mostrar_categoria($_GET['cod_user']);
		$clase = mysql_fetch_array($consulta);
	?>
<form id="frmClienteActualizar" name="frmClienteActualizar" method="post" action="actualizar_category.php" onsubmit="ActualizarDatosCategoria(); return false">
    	<input type="hidden" name="cod_user" id="cod_user" value="<?php echo $clase['cod_user']?>" />
        <p>
	  <label>Nombre<br />
	  <input class="text" type="text" name="tipo_user" id="tipo_user" value="<?php echo $clase['tipo_user']?>" />
	  </label>
      </p>
	  <p>		<!--<label>Codigo<br />-->
                <input class="text" type="hidden" name="cod_user" id="cod_user" value="<?php echo $clase['cod_user']?>" />
		<!--</label>-->
	  </p>
	  <p>		<label>Descripcion de Cuenta<br />
		<input class="text" type="text" name="descrip_user" id="descrip_user" value="<?php echo $clase['descrip_user']?>" />
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