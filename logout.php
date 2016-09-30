<?php
session_start();
/*
ubijamo session tako da ga prvo ispraznimo (inicijaliziramo ga kao prazan niz)
a potom ga brisemo i redirektamo straicu na login.php
 */
$_SESSION = array();
session_destroy();
header("location: login.php");
exit();
?>