<?php
/**
 * Description of admin_component
 *
 * @author ANDRES
 */
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set("America/Guayaquil");
$fecha = date("d-m-Y");
$_SESSION['username'] = $_SESSION['loginu'];
$id_usuario = $_SESSION['username'];
$user = strtoupper($id_usuario);
$idlogeobl = $_SESSION['id_user'];
class admin_component {
    //put your code here
}
