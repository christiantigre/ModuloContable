<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="es"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="es"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="es"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="es"> <!--<![endif]-->
    <?php ?>
<head>
	<meta charset="UTF-8">
	<title>Ejercicios de Balance</title>
        <style>
	.contenedor{margin:60px auto;width:960px;font-family:sans-serif;font-size:15px}
	table {width:100%;box-shadow:0 0 10px #ddd;text-align:left}
        table{overflow: auto;}
	th {padding:5px;background:#555;color:#fff}
	td {padding:5px;border:solid #ddd;border-width:0 0 1px;}
		.editable span{display:block;}
		.editable span:hover {background:url(../../../../images/edit.png) 90% 50% no-repeat;cursor:pointer}
		
		td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
		a.enlace{display:inline-block;width:24px;height:24px;margin:0 0 0 5px;overflow:hidden;text-indent:-999em;vertical-align:middle}
			.guardar{background:url(../../../../images/save.png) 0 0 no-repeat}
			.cancelar{background:url(../../../../images/cancell.png) 0 0 no-repeat}
	
	.mensaje{display:block;text-align:center;margin:0 0 20px 0}
		.ok{display:block;padding:10px;text-align:center;background:green;color:#fff}
		.ko{display:block;padding:10px;text-align:center;background:red;color:#fff}
	</style>	
</head>
<body>
    <form id="fom_cuadrar_balance" action="index.php" method="POST">
	<div class="contenedor">
            <center>
            <span id="refrescar"><a href="index.php"><img src="../../../../images/update.png" alt="Actualizar" title="Actualizar"/></a></span>
		<h1>Ejercicios de Balance Inicial</h1>
		<div class="mensaje"></div>
		<table class="editinplace">
			<tr>
				<th style="display:none">Cod.</th>
				<th>Asiento</th>
                                <th>Fecha</th>
                                <th>Ref</th>
                                <th>Cuenta</th>
                                <th>Debe</th>
                                <th>Haber</th>
                                <th>Acreedor</th>
                                <th>Deudor</th>
			</tr>
		</table>
                </center>
            <center>
                <table class="cuadrar">
			<tr>
				<th>Cod.</th>
				<th>Debe</th>
                                <th>Haber</th>
                                <th>Acreedor</th>
                                <th>Deudor</th>
			</tr>
                        <tr>
                            <td><input name="con" id="con" type="text" value="<?php echo $con?>"/></td>
                            <td><input name="deb" id="deb" type="text" value="<?php echo $deb?>"/></td>
                            <td><input name="hab" id="hab" type="text" value="<?php echo $hab?>"/></td>
                            <td><input name="acree" id="acree" type="text" value="<?php echo $acree?>"/></td>
                            <td><input name="deud" id="deud" type="text" value="<?php echo $deud?>"/></td>
                        </tr>
		</table>
            </center>
	</div>
	
    <script type="text/javascript" src="jquery-1.10.2.min.js"></script>
    <script>
	$(document).ready(function() 
	{
		/* OBTENEMOS TABLA */
		$.ajax({
			type: "GET",
			url: "editinplace.php?tabla=1"
		})
		.done(function(json) {
			json = $.parseJSON(json)
			for(var i=0;i<json.length;i++)
			{
				$('.editinplace').append(
					"<tr><td class='id' style='display:none'>"+json[i].ids+
                                        "</td><td class='editable' data-campo='asiento'><span>"+json[i].asiento+
                                        "</span></td><td class='editable' data-campo='fecha'><span>"+json[i].fecha+
                                        "</span></td><td class='editable' data-campo='cod_cuenta'><span>"+json[i].cod_cuenta+
                                        "</span></td><td class='editable' data-campo='Cuenta'><span>"+json[i].Cuenta+
                                        "</span></td><td class='editable' data-campo='Ac_debe'><span>"+json[i].Ac_debe+
                                        "</span></td><td class='editable' data-campo='Ac_haber'><span>"+json[i].Ac_haber+
                                        "</span></td><td class='editable' data-campo='sld_acreedor'><span>"+json[i].sld_acreedor+
                                        "</span></td><td class='editable' data-campo='sld_deudor'><span>"+json[i].sld_deudor+
                                        "</span></td></tr>");
			}
		});
		
		var td,campo,valor,id;
		$(document).on("click","td.editable span",function(e)
		{
			e.preventDefault();
			$("td:not(.id)").removeClass("editable");
			td=$(this).closest("td");
			campo=$(this).closest("td").data("campo");
			valor=$(this).text();
			id=$(this).closest("tr").find(".id").text();
			td.text("").html("<input type='text' name='"+campo+"' value='"+valor+"'><a class='enlace guardar' href='#'>Guardar</a><a class='enlace cancelar' href='#'>Cancelar</a>");
		});
		
		$(document).on("click",".cancelar",function(e)
		{
			e.preventDefault();
			td.html("<span>"+valor+"</span>");
			$("td:not(.id)").addClass("editable");
		});
		
		$(document).on("click",".guardar",function(e)
		{
			$(".mensaje").html("<img src='../../../../images/loading.gif'>");
			e.preventDefault();
			nuevovalor=$(this).closest("td").find("input").val();
			if(nuevovalor.trim()!="")
			{
				$.ajax({
					type: "POST",
					url: "editinplace.php",
					data: { campo: campo, valor: nuevovalor, id:id }
				})
				.done(function( msg ) {
					$(".mensaje").html(msg);
					td.html("<span>"+nuevovalor+"</span>");
					$("td:not(.id)").addClass("editable");
					setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
				});
			}
			else $(".mensaje").html("<p class='ko'>Debes ingresar un valor</p>");
		});
	});
	
	</script>	
    </form>
	
	
	
	
</body>
</html>