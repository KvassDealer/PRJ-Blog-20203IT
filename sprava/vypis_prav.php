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

$sql = "SELECT * FROM opravneni";
$data = ""; // Jsou prazdna od zakladu, pote je naplnime z DB
$dotaz = mysqli_query($con,$sql);

$data .= ' <div class="table-responsive">  
           <table class="table table-bordered">  
                <tr>  
                     <th>ROLE</th>  
                     <th>VTV PRISPEVEK</th>  
                     <th>UPR PRISPEVEK</th> 
                     <th>SMZ PRISPEVEK</th> 
                     <th>UPR UZIVATEL</th> 
                     <th>SMZ UZIVATEL</th> 
                     <th>VTV KATEGORIE</th> 
                     <th>UPR KATEGORIE</th> 
                     <th>SMZ KATEGORIE</th> 
                     <th>UPR KOMENTAR</th> 
                     <th>SMZ KOMENTAR</th> 
                     <th>VTV PLANEK</th> 
                     <th>UPR PLANEK</th> 
                     <th>SMZ PLANEK</th> 
                      
                </tr>';

    while($radek = mysqli_fetch_array($dotaz)) {
        $data .= '  
                <tr>  
                     <td></td>  
                     <td id="' . $radek['vtv_prispevek'].'"contenteditable>' . $radek['vtv_prispevek'] . '</td>
                     <td id="' . $radek['upr_prispevek'].'"contenteditable>' . $radek['upr_prispevek'] . '</td>
                     <td id="'.$radek['smz_prispevek'].'" contenteditable>'.$radek['smz_prispevek'].'</td> 
                     <td id="'.$radek['upr_uzivatel'].'" contenteditable>'.$radek['upr_uzivatel'].'</td> 
                     <td id="'.$radek['smz_uzivatel'].'" contenteditable>'.$radek['smz_uzivatel'].'</td> 
                     <td id="'.$radek['vtv_kategorie'].'" contenteditable>'.$radek['vtv_kategorie'].'</td> 
                     <td id="'.$radek['upr_kategorie'].'" contenteditable>'.$radek['upr_kategorie'].'</td> 
                     <td id="'.$radek['smz_kategorie'].'" contenteditable>'.$radek['smz_kategorie'].'</td> 
                     <td id="'.$radek['upr_komentar'].'" contenteditable>'.$radek['upr_komentar'].'</td> 
                     <td id="'.$radek['smz_komentar'].'" contenteditable>'.$radek['smz_komentar'].'</td> 
                     <td id="'.$radek['vtv_planek'].'" contenteditable>'.$radek['vtv_planek'].'</td> 
                     <td id="'.$radek['upr_planek'].'" contenteditable>'.$radek['upr_planek'].'</td> 
                     <td id="'.$radek['smz_planek'].'" contenteditable>'.$radek['smz_planek'].'</td>    
                </tr>  
           ';
    }
$data .= '</table>  
      </div>';
echo $data;








?>