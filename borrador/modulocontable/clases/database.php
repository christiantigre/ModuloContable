<?php
if (!isset($_SESSION)) {
    session_start();
}
return array(
    "driver"    =>"mysql",
    "host"      =>"localhost",
    "user"      =>$_SESSION['loginu'],
    "pass"      =>$_SESSION['clave'],
    "database"  =>"condata",
    "charset"   =>"utf8"
);
?>
