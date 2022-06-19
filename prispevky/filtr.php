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

if (empty($_GET['filtr'])) {
    header("location:../main.php");
}

$kat = $_GET['filtr'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hlavni stranka</title>
    <link rel="stylesheet" href="../css/forms.css">
    <link rel="stylesheet" href="../css/bootstrap-grid.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/prispevky.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/design.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html {

        }
    </style>
</head>
<body>
<?php if (isset($_SESSION['ROLE']) || isset($_SESSION['NAME'])) {
    echo "<!-- Navbar -->
<nav class='navbar navbar-expand-md navbar-dark'>

    <div class='mx-auto order-1 w-75'>
        <a class='navbar-brand mx-lg-5' href='#'>Vojenský informační web</a>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#dual-collapse2'>
            <span class='navbar-toggler-icon'></span>
        </button>
    </div>

    <div class='navbar-collapse collapse w-100 order-2' id='dual-collapse2'>
        <ul class='navbar-nav ml-auto'>

            <li class='nav-item'>
                <a class='nav-link' href='../main.php'><i class='fa fa-home'></i> Domů</a>

            </li>

            <li class='nav-item'>
                <a class='nav-link' href=''><i class='fa fa-university'></i> Historie</a>

                <!-- <i class='fa fa-calendar-check-o'></i> -->
            </li>


            <li class='nav-item'>
                <a class='nav-link' href=''><i class='fa fa-car'></i> Technika</a>

                <!-- <i class='fa fa-calendar-check-o'></i> -->
            </li>

            <li class='nav-item'>
                <a class='nav-link' href=''><i class='fa fa-user'></i> Airsoft</a>
            </li>

            <li class='nav-item'>
                <a class='nav-link' href=''><i class='fa fa-address-book'></i> Redakce</a>
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='../panel/panel.php'><i class='fa fa-users'></i> Panel</a>
            </li>
        </ul>
    </div>

    <div class='navbar-collapse collapse w-25  order-3' id='dual-collapse2'>
    <ul class='navbar-nav ml-auto'>
            <li class='nav-item'>
                <a class='nav-link' href='../auth/logout.php'><i class='fa fa-reply-all'></i> Logout</a>
            </li>
        </ul>

    </div>
</nav>";
} else {
    echo "<!-- Navbar -->
<nav class='navbar navbar-expand-md navbar-dark'>

    <div class='mx-auto order-1 w-75'>
        <a class='navbar-brand mx-lg-5' href='#'>Vojenský informační web</a>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#dual-collapse2'>
            <span class='navbar-toggler-icon'></span>
        </button>
    </div>

    <div class='navbar-collapse collapse w-100 order-2' id='dual-collapse2'>
        <ul class='navbar-nav ml-auto'>

            <li class='nav-item'>
                <a class='nav-link' href='../main.php'><i class='fa fa-home'></i> Domů</a>

            </li>

            <li class='nav-item'>
                <a class='nav-link' href=''><i class='fa fa-university'></i> Historie</a>

                <!-- <i class='fa fa-calendar-check-o'></i> -->
            </li>


            <li class='nav-item'>
                <a class='nav-link' href=''><i class='fa fa-car'></i> Technika</a>

                <!-- <i class='fa fa-calendar-check-o'></i> -->
            </li>

            <li class='nav-item'>
                <a class='nav-link' href=''><i class='fa fa-user'></i> Airsoft</a>
            </li>

            <li class='nav-item'>
                <a class='nav-link' href=''><i class='fa fa-address-book'></i> Redakce</a>
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='../panel/panel.php'><i class='fa fa-users'></i> Panel</a>
            </li>
        </ul>
    </div>

    <div class='navbar-collapse collapse w-25  order-3' id='dual-collapse2'>
        <ul class='navbar-nav ml-auto'>
            <li class='nav-item'>
                <a class='nav-link' href='../auth/login.php'><i class='fa fa-share'></i> Login</a>
            </li>
        </ul>

    </div>
</nav>";
} ?>



<!-- Bootstrap Clearfix na float -->

<div class="content clearfix">

    <!-- Prispevky -->
    <div class="col-xl-10">
        <div class="main-content">
            <h1 class="recent-post-title">Nové příspěvky</h1>


            <?php

            $prispevky = "SELECT * FROM prispevky WHERE nazev_kategorie = '$kat'";
            $dotaz3 = mysqli_query($con,$prispevky);

            while ($radek = mysqli_fetch_assoc($dotaz3)) {
                $img = $radek['thumbnail'];
                $prispevek = $radek['ID'];
                $nadpis = $radek['nadpis'];
                $kategorie = $radek['nazev_kategorie'];
                $jmeno = $radek['jmeno_uzivatel'];
                $vytvoren = $radek['vytvoren'];
                $content = $radek['content'];
                $premium_clanek = $radek['premium'];

                $komentare = "SELECT COUNT(komentar) AS 'pocet' FROM komentare WHERE ID_prispevek = '$prispevek'";
                $dotaz4 =  mysqli_query($con,$komentare);
                $komentar = mysqli_fetch_assoc($dotaz4);
                $pocet = $komentar['pocet'];

                /** Zobrazovani pocet komentaru podle poctu komentaru **/

                $komentaru = "";
                if ($pocet == 0) {
                    $komentaru = "Neni zadny komentar";
                } else if ($pocet == 1) {
                    $komentaru = "Komentar";
                } else if ($pocet <= 4) {
                    $komentaru = "Komentare";
                } else if ($pocet >= 5) {
                    $komentaru = "Komentaru";
                }

                /** Nahledovy text, text je bran z databaze a potom je zkracen, maximalne se muze zobrazit 200 znaku, v pripade premium clanku 70 **/

                $preview = strip_tags($content);
                $text = mb_strimwidth("$preview",0,200," . . .");

                if ($premium_clanek == 'ano' && isset($_SESSION['PREMIUM']) && $_SESSION['PREMIUM'] == 'ne' || !isset($_SESSION['PREMIUM'])) {
                    $premium_error = "Tento obsah je pouze pro PREMIUM";
                    $text_premium_error = mb_strimwidth("$preview",0,70," . . .");
                } else {
                    $premium_error = "";
                    $text_premium_error = $text;
                }

                // $premium_error = "";
                //        $text_premium_error = $text;
                /**  Zobrazovani premium clanku a klasickeho clanku (bere se z databaze ANO a NE) **/

                if ($premium_clanek == 'ano') {
                    echo "
   <div class='post clearfix'>
    <a href='prispevek_premium.php?id=$prispevek'>
    <img src='../PRJ-Blog/$img' alt='$img' class='post-image'></a>
    <div class='post-preview'>
    <h2><a href='prispevek_premium.php?id=$prispevek'>$nadpis</a> <span class='kategorie'>$kategorie</span><span class='kategorie' style='margin-left: 20px'>Premium</span> </h2>
    <i class='far fa-user'> $jmeno</i>
    <i class='far fa-user'> $pocet $komentaru</i>
    &nbsp;
    <i class='far fa-calendar'> $vytvoren</i>
    <p class='preview-text'>$text_premium_error  &nbsp; $premium_error</p>
    
    <a href='prispevek_premium.php?id=$prispevek' class='btn read-more'>Cist clanek</a>
    </div>
    
    </div>
    ";
                } else if ($premium_clanek == 'ne') {
                    echo "
   <div class='post clearfix'>
    <a href='prispevek.php?id=$prispevek'>
    <img src='../PRJ-Blog/$img' alt='$img' class='post-image'></a>
    <div class='post-preview'>
    <h2><a href='prispevek.php?id=$prispevek'>$nadpis</a> <span class='kategorie'>$kategorie</span> </h2>
    <i class='far fa-user'> $jmeno</i>
    <i class='far fa-user'> $pocet $komentaru</i>
    &nbsp;
    <i class='far fa-calendar'> $vytvoren</i>
    <p class='preview-text'>$text</p>
    <a href='prispevek.php?id=$prispevek' class='btn read-more'>Cist clanek</a>
    </div>
    
    </div>
    ";
                }

            }
            ?>
        </div>
    </div>


    <!-- Sidebar Vedle Prispevku -->

    <div class="sidebar">

        <div class="section search">
            <h2 class="section-title">Vyhledavani</h2>
            <form action="#" method="post">
                <input type="text" name="search-term" class="hledej" placeholder="Vyhledavani prispevku . . .">
            </form>
        </div>

        <div class="section topics">
            <h2 class="section-title">Kategorie</h2>
            <?php
            // Vypis seznamu kategorii do sidebaru

            $kategorie = "SELECT * FROM kategorie ORDER BY ID_kategorie DESC  ";
            $vse = "SELECT * FROM kategorie LEFT JOIN podkategorie ON podkategorie.ID_kat=kategorie.ID_kategorie ORDER BY ID_kat";
            $dotaz2 = mysqli_query($con,$vse);
            $dotaz = mysqli_query($con,$kategorie);



            while ($radek = mysqli_fetch_assoc($dotaz)) {
                $nzv = $radek['nazev'];

                ?>
                <ul>
                    <?php echo "<li><a href='filtr.php?filtr.php=$nzv'>• $nzv</a></li>"; ?>
                </ul>
            <?php }?>

        </div>
    </div>
</div>




<!-- Konec Bootstrap Clearfixu -->


</body>
</html>
