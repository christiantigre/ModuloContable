<?Php

session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../../login.php"
</script>';
}
$name_us = $_POST['name_us'];
$pass_usverif = $_POST['pass_usverif'];
if (isset($_POST['priv_usS'])) {
    $sel = "Y";
} else {
    $sel = "N";
}
if (isset($_POST['priv_usD'])) {
    $del = "Y";
} else {
    $del = "N";
}
if (isset($_POST['priv_usU'])) {
    $up = "Y";
} else {
    $up = "N";
}
if (isset($_POST['priv_usI'])) {
    $ins = "Y";
} else {
    $ins = "N";
}
if (isset($_POST['priv_usCU'])) {
    $cu = "Y";
} else {
    $cu = "N";
}

$db = new mysqli("localhost", $_SESSION['loginu'], $_SESSION['clave'], "mysql");
$consulta = "INSERT INTO mysql.user (`Host`, `User`, `Password`, `Select_priv`, `Insert_priv`, `Update_priv`, `Delete_priv`, `Create_priv`, "
        . "`Drop_priv`, `Reload_priv`, `Shutdown_priv`, `Process_priv`, `File_priv`, `Grant_priv`, `References_priv`, `Index_priv`, "
        . "`Alter_priv`, `Show_db_priv`, `Super_priv`, `Create_tmp_table_priv`, `Lock_tables_priv`, `Execute_priv`, `Repl_slave_priv`,"
        . " `Repl_client_priv`, `Create_view_priv`, `Show_view_priv`, `Create_routine_priv`, `Alter_routine_priv`, `Create_user_priv`,"
        . " `Event_priv`, `Trigger_priv`, `Create_tablespace_priv`, `ssl_type`, `max_questions`, `max_updates`, `max_connections`, "
        . "`max_user_connections`, `plugin`, `authentication_string`, `password_expired`, `is_role`, `default_role`, `max_statement_time`)"
        . " VALUES ('localhost', '" . $name_us . "', PASSWORD('" . $pass_usverif . "'), '" . $sel . "', '" . $ins . "', '" . $up . "', '" . $del . "', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N',"
        . " 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '" . $cu . "', 'N', 'N', 'N', '', '0', '0', '0', '0', '', '', 'N', 'N', '', '0.000000')";
$result = mysqli_query($db, $consulta) or trigger_error("Query Failed! SQL: $consulta - Error: " . mysqli_error($db), E_USER_ERROR);

$flush = "FLUSH PRIVILEGES";
$result_fl = mysqli_query($db, $flush) or trigger_error("Query Failed! SQL: $flush - Error: " . mysqli_error($db), E_USER_ERROR);

$sql_actu = "SELECT NOW() AS Hora_Fecha";
$resultfech = mysqli_query($db, $sql_actu) or trigger_error("Query Failed! SQL: $sql_actu - Error: " . mysqli_error($db), E_USER_ERROR);

if ($resultfech) {
    while ($row = mysqli_fetch_assoc($resultfech)) {
        $dato = $row['Hora_Fecha'];
        echo $dato;
        include '../../../../templates/PanelAdminLimitado/Clases/guardahistorial.php';
        $accion = "/ ADMIN USUARIOS / nuevo / creado usuario : ".$name_us;
        generaLogs($_SESSION['loginu'], $accion);
        echo '<script language = javascript>
alert("Usuario creado exitosamente")
self.location = "../admin_us.php"
</script>';
    }
}