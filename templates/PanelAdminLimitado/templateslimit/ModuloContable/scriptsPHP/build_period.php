<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
require '../../../../../templates/Clases/Conectar.php';
$dbi = new Conectar();
$c = $dbi->conexion();

require('../../../../Clases/cliente.class.php');
$user = $_SESSION['loginu'];
$idlogeobl = $_SESSION['id_user'];
$consul_bal_inicial = "SELECT count(*) +1 as Siguiente,count( * ) AS contador FROM  `t_bl_inicial`";
$query_bl = mysqli_query($c, $consul_bal_inicial);
$row = mysqli_fetch_array($query_bl);
$idcod = $row['contador'];
$idcod_sig = $row['Siguiente'];
include '../../../Clases/guardahistorialsecretaria.php';
$accion = " / Balance Inicial / Ingreso en balance inicial";
generaLogs($user, $accion);

if (isset($_POST["submit"])) {
    $btntu = $_POST["submit"];
    $contenido = $_POST;
    if ($btntu == "Inicio de Contabilidad") {
        $objGrupo = new Clase;
        $balances_realizados = htmlspecialchars(trim($_POST['balances_realizados']));
        $contador_balances = $idcod_sig;
        $fecha_nacimiento = date("Y-m-d");
        if ($objGrupo->insertarbalance_ini(array($contador_balances, $fecha_nacimiento, $idlogeobl)) == true) {
            echo '<script language = javascript>alert("Nueva Orden Guardada")
            self.location = "../ini_cont.php"</script>';
            $accion = " / INICIO DE CONTABILIDAD / Creo un nuevo periodo contable";
            generaLogs($user, $accion);
        } else {
            echo '<script language = javascript>alert("Ocurrio un error, verifique los campos...")
            self.location = "../ini_cont.php"</script>';
            $accion = " / INICIO DE CONTABILIDAD / ERROR AL CREAR PERIODO CONTABLE";
            generaLogs($user, $accion);
        }
    }

    function limpiarForm() {
        unset($contenido);
    }

}