<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Incluimos la conexión a la base de datos.

include './funciones_php/bd.php';
 
//$registros nos entrega la cantidad de registros a mostrar.
$registros = 10;
 
//$contador como su nombre lo indica el contador.	
$contador = 1;
 
/**
 * Se inicia la paginación, si el valor de $pagina es 0 le asigna el valor 1 e $inicio entra con valor 0.
 * si no es la pagina 1 entonces $inicio sera igual al numero de pagina menos 1 multiplicado por la cantidad de registro
 */
if (!$pagina) { 
    $inicio = 0; 
    $pagina = 1; 
} else { 
    $inicio = ($pagina - 1) * $registros; 
} 
?>
	<!-- Se crea la tabla que mostrara los datos tabulados -->
	<table>
		<caption>Registros</caption>
		<thead>
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>Ciudad</th>
				<th>Pais</th>
				<th>Continente</th>
			</tr>
		</thead>		
		<tbody> 
			<?php
			/**
			 * Se inicia la consulta donde seleccionamos todos los campos de la tabla personas,
                         *  pero donde isActive = 1, esto lo hacemos para el manejo
			 * de registros si están activos o no.
			 */
			$resultados = mysqli_query($conn,"SELECT * FROM t_ejercicio ");
 			//Contamos la cantidad de filas entregadas por la consulta, de esta forma sabemos cuantos registros fueron retornados por la consulta.
			$total_registros = mysqli_num_rows($resultados); 
 
			//Generamos otra consulta la cual creara en si la paginación, ordenando y creando un límite en las consultas.
			$resultados = mysqli_query($conn,"SELECT * FROM t_ejercicio  ORDER BY ejercicio ASC LIMIT $inicio, $registros");	
 
			//Con ceil redondearemos el resultado total de las paginas 4.53213 = 5
			$total_paginas = ceil($total_registros / $registros); 		  			
 
			// Si tenemos un retorno en la variable $total_registro iniciamos el ciclo para mostrar los datos.
			if ($total_registros) {
				while ($personas = mysqli_fetch_array($resultados, MYSQLI_ASSOC)) {
				?>		
					<!-- Muestra de Datos usando el comodin <?=$variable; ?> es lo mismo que <?php echo $variable; ?> -->
					<tr>
						<td><?=$contador;?></td>	
						<td><?=$personas["idt_corrientes"];?></td>
						<td><?=$personas["ejercicio"];?></td>
						<td><?=$personas["cod_cuenta"];?></td>
						<td><?=$personas["cuenta"];?></td>
						<td><?=$personas["fecha"];?></td>
						<td><?=$personas["valor"];?></td>
						<td><?=$personas["valorp"];?></td>
						<td><?=$personas["t_bl_inicial_idt_bl_inicial"];?></td>
						<td><?=$personas["tipo"];?></td>
						<td><?=$personas["logeo_idlogeo"];?></td>
					</tr>		
 
					<?php			
					/**
					 * La variable $contador es la misma que iniciamos arriba con valor 1, en cada ciclo sumara 1 a este valor.
					 * $contador sirve para mostrar cuantos registros tenemos, es mas que nada una guía.
					 */
			 	   $contador++;
			    }		
			 } else {
			  echo "<font color='darkgray'>(sin resultados)</font>";
			}
 
			mysqli_free_result($resultados);	
			?>
		</tbody>
	</table>
 
	<div>	
		<?php
		if ($total_registros) {
			/**
			 * Acá activamos o desactivamos la opción "< Anterior", si estamos en la pagina 1 nos dará como resultado 0 por ende NO
			 * activaremos el primer if y pasaremos al else en donde se desactiva la opción anterior. Pero si el resultado es mayor
			 * a 0 se activara el href del link para poder retroceder.
			 */
			if (($pagina - 1) > 0) {
				echo "<a href='muestrabinicial.php?pagina=".($pagina-1)."'>< Anterior</a>";
			} else {
				echo "<a href='#'>< Anterior</a>";
			}
 
			// Generamos el ciclo para mostrar la cantidad de paginas que tenemos.
			for ($i = 1; $i <= $total_paginas; $i++) {
				if ($pagina == $i) {
					echo "<a href='#'>". $pagina ."</a>"; 
				} else {
					echo "<a href='muestrabinicial.php?pagina=$i'>$i</a> "; 
				}	
			}
 
	  		/**
	  		 * Igual que la opción primera de "< Anterior", pero acá para la opción "Siguiente >", si estamos en la ultima pagina no podremos
	  		 * utilizar esta opción.
	  		 */
			if (($pagina + 1)<=$total_paginas) {
				echo "<a href='muestrabinicial.php?pagina=".($pagina+1)."'>Siguiente ></a>";
			} else {
				echo "<a href='#'>Siguiente ></a>";
			}		 
		}
		?>	
	</div> 
 
	<?php
		// Cerramos conexión con MySQLi.
		mysqli_close($conn);
 	
//select * from t_ejercicio e join num_asientos n where 
//e.ejercicio=n.t_ejercicio_idt_corrientes  and 
//e.t_bl_inicial_idt_bl_inicial = n.t_bl_inicial_idt_bl_inicial and 
//e.fecha = n.fecha and
//e.fecha='2015-10-14' and e.t_bl_inicial_idt_bl_inicial='13'
        ?>