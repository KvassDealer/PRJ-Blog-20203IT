<?php
session_start();

// Databaze
$host = "localhost";
$username = "root";
$pass = "";
$db = "blog";



// Pripojeni k databazi

$con = mysqli_connect($host,$username,$pass,$db);
$role = $_SESSION['ROLE'];
$ID = $_GET['id'];


// Kontrola pripojeni
// ID,jmeno,prezdivka,password,email,role

if (!$con || $con->connect_error) {
    die("Pripojeni k databazi selhalo!". $con->connect_error);
}



$sql = "SELECT * FROM opravneni WHERE role = '$role'";
$dotazz = mysqli_query($con,$sql);
while($radek1 = mysqli_fetch_assoc($dotazz)) {
    $crt = $radek1['vtv_prispevek'];
}


if ($crt != "1") {
    header("location:../main.php");
} else {
    $sql2 = "DELETE FROM galerie WHERE ID = '$ID'";
    mysqli_query($con, $sql2);
    header("location:../galerie.php");
}
?>