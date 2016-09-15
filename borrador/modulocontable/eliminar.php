
<?php

//$B_BUSCAR = "DELETE FROM `t_ejercicio` WHERE `t_ejercicio`.`idt_corrientes` = 1";
$dbhost = "localhost";
$dbname = "condata";
$dbuser = "root";
$dbpass = "alberto2791";
$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if (isset($_POST) && count($_POST) > 0) {
    if ($db->connect_errno) {
        die("<span class='ko'>Fallo al conectar a MySQL: (" . $db->connect_errno . ") " . $db->connect_error . "</span>");
    } else {
        $query = $db->query("DELETE FROM `t_ejercicio` "
                . "where idt_corrientes='" . intval($_POST["id"]) . "' limit 1");
        if ($query)echo '<script language = javascript>alert("Fila eliminada")
            self.location = "star_balance.php"</script>';
        else
            echo '<script language = javascript>alert("Ocurrio un error...")
            self.location = "star_balance.php"</script>';
    }
}    
?>