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

?>

<html>
<head>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/bootstrap-grid.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/design.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0-beta.2/css/lightgallery.min.css" integrity="sha512-J3GvWzuXtDGv7Kmqhj1gbn/jM2i3G40XtSBcqGEQ7eLpP0izHygFgT0FMIVCWMVRZnz7u2rS6mhTtlQ3oJsr1A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>
    <script src="js/bootstrap.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
          td {
            border: 2px solid black;
              width: 16.6%;
              margin-top: 20px;


        }
          table { border: 1px solid black;


          }
    </style>
</head>
<body>

<?php

echo "
   
   <div class='wrapper'>
    <!-- Sidebar Menu (panel) -->
<div class='sidebar'>
    <ul>
    <li>
        <a href='../main.php' class='active'>
            <span class='icon'><i class='fas fa-home'></i></span>
            <span class='item'>Domu</span>
        </a>
    </li>
    <li>
        <a href='../prispevky/prispevky.php'>
            <span class='icon'><i class='fas fa-desktop'></i></span>
            <span class='item'>Prispevky</span>
        </a>
    </li>
    <li>
        <a href='../prispevky/create_prispevek.php'>
            <span class='icon'><i class='fas fa-plus-square'></i></span>
            <span class='item'>Vytvorit prispevek</span>
        </a>
    </li>
    <li>
        <a href='../panel/kategorie.php'>
            <span class='icon'><i class='fa fa-tags'></i></span>
            <span class='item'>Kategorie</span>
        </a>
    </li>
    <li>
        <a href='../sprava/canvas_control.php'>
            <span class='icon'><i class='fas fa-file-powerpoint'></i></span>
            <span class='item'>Planky</span>
        </a>
    </li>
    <li>
        <a href='sprava.php'>
            <span class='icon'><i class='fas fa-database'></i></span>
            <span class='item'>Sprava uzivatelu</span>
        </a>
    </li>
    <li>
    <li>
        <a href='opravneni.php'>
            <span class='icon'><i class='fas fa-database'></i></span>
            <span class='item'>Sprava opravneni</span>
        </a>
    </li>
    <li>
        <a href='../sprava/vytvorit_roli.php'>
            <span class='icon'><i class='fas fa-database'></i></span>
            <span class='item'>Tvorba role</span>
        </a>
    </li>
    <li>
        <a href='../sprava/galerie-uploader.php'>
            <span class='icon'><i class='fas fa-database'></i></span>
            <span class='item'>Galerie</span>
        </a>
    </li>
    <li>
        <a href='../auth/logout.php'>
            <span class='icon'><i class='fa fa-power-off'></i></span>
            <span class='item'>Odhlasit se</span>
        </a>
    </li>
    </ul>
 
</div>
</div>




<div class='col-xl-5 status' style='background-color: gray'>
<h1>Administrace</h1>
</div>

<div class='menu'>
<!-- Navbar -->
<nav class='navbar navbar-expand-md navbar-dark bg-dark'>

    <div class='mx-auto order-1 w-75'>
        <a class='navbar-brand mx-lg-5' href='#'>Vojensky blog</a>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#dual-collapse2'>
            <span class='navbar-toggler-icon'></span>
        </button>
    </div>

    <div class='collapse navbar-collapse order-2' id='dual-collapse2'>
        <ul class='navbar-nav ml-auto'>

            <li class='nav-item'>
                <a class='nav-link' href='main.php'><i class='fas fa-home'></i> Domů</a>

            </li>

            <li class='nav-item'>
                <a class='nav-link' href='#'><i class='fas fa-desktop'></i> Prispevky</a>

                <!-- <i class='fa fa-calendar-check-o'></i> -->
            </li>


            <li class='nav-item'>
                <a class='nav-link' href='kategorie.php'><i class='fa fa-tags'></i> Kategorie</a>

                <!-- <i class='fa fa-calendar-check-o'></i> -->
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='#'><i class='fas fa-file-powerpoint'></i> Planky</a>
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='sprava.php'><i class='fas fa-database'></i> Sprava uzivatelu</a>
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='logout.php'><i class='fa fa-power-off'></i> Odhlasit se</a>
            </li>
        </ul>
    </div>

</nav>
</div>

";


?>

<div class="container">
  <div class="row">
  
  <div class="col-xl-10" style="margin-left: 20%"><h2>Vítejte <?php echo $_SESSION['NAME']; ?> Navigujte se pomocí bočního menu</h2></div>
      <div class="col-xl-5" style="margin-left: 20%"><h1>Vase nakreslene planky:</h1></div>

      <div class="content clearfix">
          <div class="card-group" style="margin-top: 20px; margin-left: 20%" id="obrazky">
   <?php
   $jmeno = $_SESSION['NAME'];
   $sql = "SELECT * FROM planky WHERE jmeno = '$jmeno'";
   $dotaz = mysqli_query($con,$sql);


   $cislo = 0;

   while ($radek = mysqli_fetch_assoc($dotaz)) {
       $planek = $radek['planek'];
                    $uzivatel = $radek['jmeno'];
                    $id = $radek['ID'];
                    $vytvoren = $radek['vytvoren'];
                    $popis = $radek['popis'];


           $upravit ="<a href='../sprava/upravit_canvas.php?id=$id'> Upravit  </a>";
           //$smazat ="<a href='../sprava/smazat_canvas.php?id=$id'> Smazat </a>";



                    echo "
           <div class='card'>
           <div class='obrazky'>
                <img class='card-img-top' src='./$planek' alt='$planek' id='obrz'>
                </div>
                <div class='card-body'>
                    <h5 class='card-title'>$uzivatel</h5>
                    <p class='card-text'>$popis</p>
                    <p class='card-text'><small class='text-muted'>$vytvoren</small></p>
                    <p class='card-text'><small class='text-muted'>$upravit </small></p>
                </div>
            </div> 
           ";
                    $cislo++;
                    if ($cislo % 3 == 0) {
                        echo "</div><div class='card-group' id='obrazky' style='margin-top: 20px; margin-left: 20%'>";
                    }
                }




   ?>
     </div>
   </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0-beta.2/lightgallery.min.js" integrity="sha512-Z3EF+OVry8EO1N1EFn6/j1v+PQJ3UqRJ3X+PEFHhJRd7sbEbxI2mZ1suHiXPiofaH7GiKrIZewfGpO+G98Kq5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script> var elements = document.getElementsByClassName('obrazky');
    for (let item of elements) {
        lightGallery(item, {
            share:false,
            controls:false,
            counter:false,
            enableDrag:false,

        })
    }
</script>
</body>
</html>

