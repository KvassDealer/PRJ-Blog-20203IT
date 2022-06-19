<?php

session_start();

// Pokud nikdo neni prihlasen nebo se pokusi dostat sem, redirect na login
if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] == "admin") {
    echo "";
} else {
    header('location:panel.php');
}

// Databaze
$host = "localhost";
$username = "root";
$pass = "";
$db = "blog";

$role = $_SESSION['ROLE'];

// Pripojeni k databazi

$con = mysqli_connect($host,$username,$pass,$db);

// Kontrola pripojeni
// ID,jmeno,prezdivka,password,email,role

if (!$con || $con->connect_error) {
    die("Pripojeni k databazi selhalo!". $con->connect_error);
}


/** Je potreba spojit 2 SQL Dotazy abychom mohli smazat prispevek kvuli FK v DB (komentare - Prispevek ID)
 *  Dotaz ukoncime (;)
 *  Pote pouzijeme php funkci - mysqli_multi_query($pripojeni,$dotaz)
 *  Multi query vezme dva nebo vice SQL Dotazu a vsechny je provede.
 **/

$sql = "SELECT * FROM opravneni WHERE role = '$role'";
$dotazz = mysqli_query($con, $sql);
while($radek1 = mysqli_fetch_assoc($dotazz)) {
    //$crt = $radek1['vtv_prispevek'];
    $smz = $radek1['smz_prispevek'];

}

if ($smz != "1") {
    header("location:../main.php");
} else {


    $ID = $_GET['id'];
    $dotaz = "DELETE FROM komentare WHERE ID_prispevek = '$ID';";
    $dotaz .= "DELETE FROM prispevky WHERE ID = '$ID';";

//$result = mysqli_query($con,$dotaz2,$dotaz);
    $result = mysqli_multi_query($con, $dotaz);
    header('location:prispevky.php');
}

