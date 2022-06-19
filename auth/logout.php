<?php
session_start();
session_destroy();
session_unset();
unset($_SESSION['NAME']);
unset($_SESSION['ROLE']);
unset($_SESSION['ID']);
header('Location: /PRJ-Blog/main.php');
die();

?>
