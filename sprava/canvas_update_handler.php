<?php
session_start();

$uzivatel = $_SESSION['NAME'];
$ID = $_POST['id'];

// Databaze
$host = "localhost";
$username = "root";
$pass = "";
$db = "blog";


// Pripojeni k databazi

$con = mysqli_connect($host,$username,$pass,$db);

// Logika canvasu na IMG a ulozeni do DB


$umisteni = '../planky/';  // Sem se ukladaji obrazky
$img = $_POST['canvas_data']; // Z canvasu Data
$popis = $_POST['popisek'];
if (empty($popis)) { $popis = "Uzivatel nepridal zadny popis k planku"; }
$img = str_replace('data:image/png;base64,', '', $img); // Najit a zamenit za prazdny char
$img = str_replace(' ', '+', $img);
$data_canvas = base64_decode($img);  // Decode Base64
$soubor = $umisteni . "takticky-planek-" . uniqid() . '.png';  //Umisteni kam pujde planek + jmeno + random ID + typ souboru
$nahrat = file_put_contents($soubor, $data_canvas); // Ulozime do souboru images


//$sql = "UPDATE planky SET (planek,jmeno,popis) VALUES ('$soubor','$uzivatel','$popis')";
$sql = "UPDATE planky SET planek = '$soubor', jmeno = '$uzivatel', popis = '$popis' WHERE ID = '$ID'";
mysqli_query($con,$sql);
header("Location: ../panel/canvas.php");