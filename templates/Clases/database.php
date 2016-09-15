<?php
if (!isset($_SESSION)) {
    session_start();
}
return array(
    "driver"    =>"mysql",
    "host"      =>"localhost",
    "user"      =>  htmlentities($_SESSION['loginu']),
    "pass"      =>  htmlentities($_SESSION['clave']),
    "database"  =>"condata",
    "charset"   =>"utf8"
);
?>
