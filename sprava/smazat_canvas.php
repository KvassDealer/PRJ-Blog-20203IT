<?php
session_start();
if (!isset($_SESSION['ROLE'])) {
    header("location:../PRJ-Blog/main.php");
}
// Databaze
$host = "localhost";
$username = "root";
$pass = "";
$db = "blog";


// Pripojeni k databazi

$con = mysqli_connect($host,$username,$pass,$db);



$ID_canvas = $con->real_escape_string($_GET['id']);

$sql = "DELETE FROM planky WHERE ID = '$ID_canvas'";
$dotaz = mysqli_query($con,$sql);
header("location: canvas_control.php");



