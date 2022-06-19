<?php
ob_start();
session_start();
// Pokud nikdo neni prihlasen nebo se pokusi dostat sem, redirect na login



// Databaze
$host = "localhost";
$username = "root";
$pass = "";
$db = "blog";


// Pripojeni k databazi

$con = mysqli_connect($host,$username,$pass,$db);
$role = $_SESSION['ROLE'];

// Kontrola pripojeni
// ID,jmeno,prezdivka,password,email,role

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
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script src="../js/bootstrap.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
        <a href='../panel/sprava.php'>
            <span class='icon'><i class='fas fa-database'></i></span>
            <span class='item'>Sprava uzivatelu</span>
        </a>
    </li>
    <li>
    <li>
        <a href='../panel/opravneni.php'>
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
<div class="content clearfix" style="padding-left: 10%">
<div class="main-content">
<?php

$sql = "SELECT * FROM opravneni WHERE role = '$role'";
$dotazz = mysqli_query($con,$sql);
while($radek1 = mysqli_fetch_assoc($dotazz)) {
   //$crt = $radek1['vtv_prispevek'];
   $upr = $radek1['upr_prispevek'];
   $smz = $radek1['smz_prispevek'];

}

   if($upr != "1" || $smz != "1") {
      header("location:../main.php");
   } else {

   

   

$prispevky = "SELECT * FROM prispevky ORDER BY ID DESC ";
$dotaz3 = mysqli_query($con,$prispevky);

while ($radek = mysqli_fetch_assoc($dotaz3)) {
    $img = $radek['thumbnail'];
    $prispevek = $radek['ID'];
    $nadpis = $radek['nadpis'];
    $kategorie = $radek['nazev_kategorie'];
    $jmeno = $_SESSION['NAME'];
    $vytvoren = $radek['vytvoren'];
    $content = $radek['content'];

    $preview = strip_tags($content);
    $text = mb_strimwidth("$preview",0,200,"...");

    echo "
   <div class='post clearfix'>
    <a href='prispevek.php?id=$prispevek'>
    <img src='$img' alt='$img' class='post-image'></a>
    <div class='post-preview'>
    <h2><a href='prispevek.php?id=$prispevek'>$nadpis</a> <span class='kategorie'>$kategorie</span> </h2>
    <i class='far fa-user'> $jmeno</i>
    &nbsp;
    <i class='far fa-calendar'> $vytvoren</i>
    <p class='preview-text'>$text</p>
    <a href='update_prispevek.php?id=$prispevek' class='btn read-more' style='margin-right: 3%'>Upravit prispevek</a>
    <a href='delete_prispevek.php?id=$prispevek' class='btn read-more' style='margin-right: 35%'>Smazat prispevek</a>
    </div>
    
    </div>
    ";
   }
  }


?>
</div>
</div>


</body>
</html>
<?php ob_end_flush(); ?>