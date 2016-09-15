<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Se incluye el archivo de BD
require_once("myDBC.php");
//Se crea un objeto
$consultas = new myDBC();
//Se reciben los datos del formulario del index.php
//Se les aplica trim para quitar espacios en blanco
$user = trim($_POST['loginu']);
$pass = trim($_POST['clave']);
//Se usa el método logueo de la clase y éste se encarga
//de mostrar la información necesaria
//echo"<script>alert('$user',' - ','$pass');</script>";
$log = $consultas->logueo($user, $pass);
?>