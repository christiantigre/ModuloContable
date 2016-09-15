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
		$query=$db->query("update blnini set ".$_POST["campo"]."='".$_POST["valor"]."'"
                        . " where idBlnIni='".intval($_POST["id"])."' limit 1");
		if ($query) echo "<span class='ok'>Valores modificados correctamente.</span>";
		else echo "<span class='ko'>".$db->error."</span>";
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
		$query=$db->query("select * from blnini where fecha='".$date."'");
		$datos=array();
		while ($usuarios=$query->fetch_array())
		{
			$datos[]=array(	"ids"=>$usuarios["idBlnIni"],
							"asiento"=>$usuarios["asiento"],
							"fecha"=>$usuarios["fecha"],
							"cod_cuenta"=>$usuarios["cod_cuenta"],
							"Cuenta"=>$usuarios["Cuenta"],
							"Ac_debe"=>$usuarios["Ac_debe"],
							"Ac_haber"=>$usuarios["Ac_haber"],
							"sld_acreedor"=>$usuarios["sld_acreedor"],
							"sld_deudor"=>$usuarios["sld_deudor"]
			);
		}
		echo json_encode($datos);
	}
}
?>