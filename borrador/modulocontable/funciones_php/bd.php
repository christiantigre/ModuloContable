<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$DBHOST	= 'localhost';
$DBUSER	= 'root';
$DBPASS	= 'alberto2791';
$DBNAME	= 'condata';
 
//Conectar al Servidor
$conn = new mysqli($DBHOST, $DBUSER, $DBPASS, $DBNAME);
 
//Verificando Conexión
if (mysqli_connect_errno()) {
	exit('Fallo Conexion: '. mysqli_connect_error());
}
?>