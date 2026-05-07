<?php


session_start();
session_unset();
session_destroy();
header("Location: pages/sistema/login/index.php"); 
exit;

?>

