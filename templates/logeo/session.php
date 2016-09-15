<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(0);
error_reporting == E_ALL & ~E_NOTICE & ~E_DEPRECATED;
date_default_timezone_set("America/Guayaquil");
if (!isset($_SESSION)) {
    session_start();
}

$usuario = htmlentities($_POST['loginu']);
$contrasena = htmlentities($_POST['clave']);
$_SESSION['loginu'] = $_POST['loginu'];
$_SESSION['clave'] = $_POST['clave'];

include '../Clases/save_hs.php';
if (isset($_POST['submit']) && isset($_POST['submit']) !== "") {
    if (isset($_POST['clave']) && !empty($_POST['clave'])) {
        if (isset($_POST['loginu']) && !empty($_POST['loginu'])) {
            $nom = $_SESSION['loginu'];
            require '../Clases/Conectar.php';
            $dbi = new Conectar();
            $c = $dbi->conexion();
            if ($c->connect_errno) {
                $accion = " / ACREDENCIALES ERRADOS";
                generaLogs($nom, $accion);
                echo '<script language = javascript>
	alert("Usuario no encontrado.")
	self.location = "../../login.php"
	</script>';
            } else {
                $consulta = "SELECT * FROM mysql.user WHERE User='" . $_SESSION['loginu'] . "' ";
                $resultado = mysqli_query($c, $consulta);
                $fila = mysqli_fetch_assoc($resultado);
                $select = $fila['Select_priv'];
                $delete = $fila['Delete_priv'];
                $update = $fila['Update_priv'];
                $insert = $fila['Insert_priv'];
                $file = $fila['File_priv'];
                $create_us = $fila['Create_user_priv'];

//                controlar tiempo de session
                $hora_inicio = date("Y-n-j H:i:s");
                $fechaGuardada = $_SESSION["ultimoAcceso"];


                if (($select == "Y") && ($delete == "Y") && ($update == "Y") && ($insert == "Y") && ($file == "Y") && ($create_us == "Y")) {
                    $usuario = "level1";
                    $id = '1';
                    $tipo = "Super Administrador";
                    $_SESSION['id_user'] = $id;
                    $_SESSION['username'] = $_SESSION['loginu'];
                    $_SESSION['tipo_user'] = $tipo;
                } elseif (($select == "Y") && ($delete == "Y") && ($update == "Y") && ($insert == "Y") && ($file == "N") && ($create_us == "Y")) {
                    $usuario = "level2";
                    $id = '2';
                    $_SESSION['id_user'] = $id;
                    $_SESSION['username'] = $_SESSION['loginu'];
                    $_SESSION["ultimoAcceso"] = date("Y-n-j H:i:s");
                } elseif (($select == "Y") && ($delete == "Y") && ($update == "Y") && ($insert == "Y") && ($file == "N") && ($create_us == "N")) {
                    $usuario = "level3";
                    $id = '3';
                    $_SESSION['id_user'] = $id;
                    $_SESSION['username'] = $_SESSION['loginu'];
                } elseif (($select == "Y") && ($delete == "N") && ($update == "N") && ($insert == "N") && ($file == "N") && ($create_us == "N")) {
                    $usuario = "level4";
                }

                if ($usuario == "level1") {
                    $_SESSION['id_user'] = $id;
                    $accion = " / ---- INICIO SESIÓN ----";
                    generaLogs($nom, $accion);
//                    header("Location: ../../index.php");
                    header("Location: ../PaneldeAdministrador/indexadmin.php");
                } elseif ($usuario == "level2") {
                    $_SESSION['id_user'] = $id;
                    $accion = " / CONTABILIDAD / ----  INICIO SESIÓN ---- ";
                    generaLogs($nom, $accion);
                    header("Location: ../PanelAdminLimitado/indexadmin.php");
//                    header("Location: ../PanelAdminLimitado/templateslimit/ModuloContable/ini_cont.php");
                } elseif ($usuario == "level3") {
                    $_SESSION['id_user'] = $id;
                    $accion = " / ---- INICIO SESIÓN ---- ";
                    generaLogs($nom, $accion);
//                    header("Location: ../PanelAdminLimitado/templateslimit/ModuloContable/secretaria/index_modulo_contable.php");
                    header("Location: ../Panelsecretaria/indexsec.php");
                } elseif ($usuario == "level4") {
                    $_SESSION['id_user'] = $id;
                    $accion = " / ----  INICIO SESIÓN ---- ";
                    generaLogs($nom, $accion);
                    echo '<script language = javascript>
	alert("Lo sentimos, actualmente en desarrollo")
	self.location = "../../login.php"
	</script>';
                } elseif ($usuario == "") {
                    $accion = " / ----  INICIO SESIÓN ---- ";
                    generaLogs($nom, $accion);
                    echo '<script language = javascript>
	alert("Usuario o Password errados, por favor verifique.")
	self.location = "../../login.php"
	</script>';
                }
            }
            mysqli_close($c);
        } else {
            $accion = " / USERNAME ERRADO";
            generaLogs($nom, $accion);
            echo '<script language = javascript>
	alert("INGRESE USUARIO")
	self.location = "../../login.php"
	</script>';
        }
    } else {
        $accion = " / PASSWORD ERRADA";
        generaLogs($nom, $accion);
        echo '<script language = javascript>
	alert("INGRESE CLAVE.")
	self.location = "../../login.php"
	</script>';
    }
}
?>
