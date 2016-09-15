<?php
$dbhost="localhost";
$dbname="condata";
$dbuser="root";
$dbpass="alberto2791";
$db = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

if (isset($_POST) && count($_POST)>0)
{
	if ($db->connect_errno) 
	{
		die ("<span class='ko'>Fallo al conectar a MySQL: (" . $db->connect_errno . ") " . $db->connect_error."</span>");
	}
	else
	{
		$query=$db->query("update libro set ".$_POST["campo"]."='".$_POST["valor"]."'"
                        . " where idlibro='".intval($_POST["id"])."' limit 1");
		if ($query) echo "<span class='ok'>Valores modificados correctamente.</span>";
		else echo "<span class='ko'>".$db->error."</span>";
	}
}

$consulta = "SELECT MAX(idt_bl_inicial) AS id FROM t_bl_inicial";
$result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $query - Error: ". mysqli_error($mysqli), E_USER_ERROR);
if($result) {
	while($row = mysqli_fetch_assoc($result)) {
		//echo $row['id'] . '<br>';	
            $maxbalancedato = $row['id'];
	}
} 

if (isset($_GET) && count($_GET)>0)
{
	if ($db->connect_errno) 
	{
		die ("<span class='ko'>Fallo al conectar a MySQL: (" . $db->connect_errno . ") " 
                        . $db->connect_error."</span>");
	}
	else
	{
                $date=  date("Y-m-j");
		$query=$db->query("select idlibro,fecha,asiento,ref,cuenta,debe,haber"
                        . " from libro where t_bl_inicial_idt_bl_inicial='".$maxbalancedato."'");
		$datos=array();
		while ($usuarios=$query->fetch_array())
		{
			$datos[]=array(	"ids"=>$usuarios["idlibro"],
							"fecha"=>$usuarios["fecha"],
							"asiento"=>$usuarios["asiento"],
							"ref"=>$usuarios["ref"],
							"cuenta"=>$usuarios["cuenta"],
							"debe"=>$usuarios["debe"],
							"haber"=>$usuarios["haber"]
			);
		}
		echo json_encode($datos);
	}
}
?>