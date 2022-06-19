<?php
session_start();
// Pokud nikdo neni prihlasen nebo se pokusi dostat sem, redirect na login
if (!isset($_SESSION['ID']) && !isset($_SESSION['EMAIL']) && !isset($_SESSION['USERNAME'])) {
    header("Location: /PRJ-Blog/auth/login.php");
    exit();
}

// Databaze

$host = "localhost";
$username = "root";
$pass = "";
$db = "blog";


// Pripojeni k databazi

$con = mysqli_connect($host,$username,$pass,$db);

// Kontrola pripojeni
if (!$con || $con->connect_error) {
    die("Pripojeni k databazi selhalo!". $con->connect_error);
}


$role = $_GET['role'];

$sql = "DELETE FROM opravneni WHERE role = '$role'";
mysqli_query($con,$sql);
header("location:../panel/opravneni.php");
