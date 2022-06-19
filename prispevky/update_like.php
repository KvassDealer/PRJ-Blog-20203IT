<?php
session_start();
// Databaze
$host = "localhost";
$username = "root";
$pass = "";
$db = "blog";
$name = $_SESSION['NAME'];

// Pripojeni k databazi

$con = mysqli_connect($host,$username,$pass,$db);

// Kontrola pripojeni
// ID,jmeno,prezdivka,password,email,role

if (!$con || $con->connect_error) {
    die("Pripojeni k databazi selhalo!". $con->connect_error);
}

$typ_hodnoceni = $_POST['type'];
$id = $_POST['id'];

$sql = "SELECT * FROM komentare WHERE ID = '$id' OR autor = '$name'";
$dotaz = mysqli_query($con,$sql);


        if ($typ_hodnoceni == 'libi') {


            $sql = "UPDATE komentare SET libi = libi + 1  WHERE ID = '$id'";

                //$sql = "INSERT INTO hodnoceni (komentar_id,uzivatel,libi,prispevek) VALUES ('$id','$name',1,'$prispevek')";
                //$sql = "UPDATE komentare SET libi = libi + 1 WHERE ID = '$id'";



            //$sql = "INSERT INTO komentare (libi,like_komentar) VALUES (libi + 1,like_komentar + 1) WHERE ID = '$id'";
        } else {
            $sql = "UPDATE komentare SET nelibi = nelibi + 1 WHERE ID = '$id'";
        }
    $odsl = mysqli_query($con, $sql);








?>