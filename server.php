<?php
session_start();



// Databaze
$host = "localhost";
$username = "root";
$pass = "";
$db = "blog";


// Pripojeni k databazi

$con = mysqli_connect($host,$username,$pass,$db);

// Kontrola pripojeni
// ID,jmeno,prezdivka,password,email,role

if (!$con || $con->connect_error) {
    die("Pripojeni k databazi selhalo!". $con->connect_error);
}

$slovo = $_POST['slovo'];
if (empty($slovo)) {
    echo "Prazdny vyraz";
} else {



//$data = "SELECT nadpis FROM prispevky WHERE nadpis LIKE '%".$_POST['slovo']."%'";
$data = "SELECT * FROM prispevky WHERE nadpis LIKE '$slovo%' AND premium = 'ne'";
$data2 = "SELECT * FROM prispevky WHERE nadpis LIKE '$slovo%' AND premium = 'ano'";
$result = $con -> query($data);
if (!empty($result->num_rows) && $result->num_rows > 0) {
    while ($radek = $result -> fetch_assoc()) {
        echo "

      <p> <a href='prispevky/prispevek.php?id=".$radek['ID']."'>• ".$radek['nadpis']."</a> </p> 
        
        
        
        
        ";
    }
 }


    $result = $con -> query($data2);
    if (!empty($result->num_rows) && $result->num_rows > 0) {
        while ($radek = $result -> fetch_assoc()) {
            echo "

      <p> <a href='prispevky/prispevek_premium.php?id=".$radek['ID']."'>• ".$radek['nadpis']."</a> </p> 
        
        
        
        
        ";
        }
    }


}