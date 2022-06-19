<?php
session_start();
if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] == "admin" || $_SESSION['ROLE'] == "super_redaktor") {
    echo "OK";
} else {
    header('location:panel.php');
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
// Mazeme radek v databazi podle prislusneho ID

$ID = $_GET['id'];  // Ziskame ID po kliknuti na tlacitko
$dotaz = "DELETE FROM kategorie WHERE ID_kategorie ='$ID'";
$result = mysqli_query($con,$dotaz);
header("Location:../panel/kategorie.php");

?>