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

if (empty($_GET['filtr_small'])) {
    header("location:../main.php");
}

$like = $_GET['filtr_small'];



$sql1 = "SELECT * FROM prispevky WHERE ID = '$like' AND premium = 'ne'";
//$result1 = $con->query($sql1);
$sql2 = "SELECT * , MAX(libi) FROM komentare WHERE ID_prispevek '$like' GROUP BY ID ";
//SELECT * , MAX(libi) FROM komentare WHERE ID_prispevek '$like' GROUP BY ID;
$result2 = $con->query($sql2);


?>

    <html>
    <head>
        <link rel="stylesheet" href="../css/forms.css">
        <link rel="stylesheet" href="../css/bootstrap-grid.css">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/prispevky.css">
        <link rel="stylesheet" href="../css/prispevek.css">
        <link rel="stylesheet" href="../css/komentare.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
              integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/design.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

            <li class='nav-item dropdown'>
          <a class='nav-link dropdown-toggle' href='#' id='navbarDarkDropdownMenuLink' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
            <i class='fa fa-user'></i> Airsoft</a>
         
          <ul class='dropdown-menu' aria-labelledby='navbarDarkDropdownMenuLink'>
            <li><a class='dropdown-item' href='../ars-design.php'>Airsoft</a></li>
            <li><a class='dropdown-item' href='../galerie.php'>Galerie</a></li>
          </ul>
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
                <a class='nav-link' href=''><i class='fa fa-user'></i> Vyzbroj</a>
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
    <div class="content clearfix">
        <div class="main-content">

            <?php
            //$ID = $con->real_escape_string($_GET['id']);  // Ziskani ID prispevku pro vypis prispevku
            // $sql = "SELECT * FROM prispevky WHERE ID = '$ID' AND premium = 'ne'";
            $dotaz = mysqli_query($con,$sql1);
            $radek = mysqli_fetch_assoc($dotaz);
            $ID = $radek['ID'];
            $content = $radek['content'];
            $thumbnail = $radek['thumbnail'];
            $nadpis = $radek['nadpis'];
            $autor = $radek['jmeno_uzivatel'];
            $delka = $radek['delka'];
            $kategorie = $radek['nazev_kategorie'];

            //Dulezite! Reseni spatneho ID nebo obsahu
            if (empty($content) || empty($thumbnail) || empty($nadpis)) { header("location:/PRJ-Blog/main.php");} // Nelze ziskat obsah nebo ID

            echo "
<div class='container'>
<div class='row'>
<div class='col-xl-12'>
<div class='detail' style='padding-left: 5%; margin-left: 20%'>
      <h1>$nadpis  <span class='kategorie'>$kategorie</span></h1>
      <h5><i class='far fa-clock'> Čtení na $delka minut</i></h5>
      <h5><i class='far fa-user'> Napsal $autor</i></h5>
    <figure class='thumbnail col-xl-8'>
    <img src='$thumbnail' alt='thumbnail'>
       </figure>
   <div class='detail-text col-lg-9'>
            $content
       </div>
 </div>
</div>
</div>
</div>
";
            ?>
            <!-- </div> -->

            <?php
            echo "<h5><a href='filtr_komentare_b.php?filtr_big=$ID'>Nejvetsi</a> </h5>
<h5><a href='filtr_komentare_s.php?filtr_small=$ID'>Nejmensi</a> </h5>";
            ?>
            <?php
            /** Reseni komentaru + nahrani do databaze a zobrazeni
             *
             * Zapiseme komentar do databaze a priradime prislusne ID prispevku,
             * pomoci tohoto ID pak muzeme vypisovat komentare, podle ID.
             * Zapis komentaru je klasicky pres formu, data se ulozi do
             * promennych $_POST['neco'] a potom jsou SQL Dotazem poslana
             * do databaze pro ulozeni / dalsi praci s nima.
             *
             **/
            // POKUD NENI UZIVATEL PRIHLASEN (NEMA ROLI), NEBUDE MOCT KOMENTOVAT!
            // RESENI JE NA RADCICH 207 - 214, KDE SE ZOBRAZI ZPRAVA.

            if (!isset($_SESSION['ROLE'])) {
                echo "<div class='col-xl-8'>
    <div class='komentar' style='background-color: #a6a6a6'>
    <div class='koment-text'>
        <p>Nejsi prihlasen a proto nemuzes odesilat komentare!</p>
    </div>
</div>
</div>";
            } else {

                if (isset($_POST['komentuj'])) {
                    $ID_prispevek = $con->real_escape_string($_GET['id']); // Ziskani ID prispevku pro komentare
                    $autor = $_SESSION['NAME'];
                    $komentar = $con->real_escape_string($_POST['komentar']);

                    $sql2 = "INSERT INTO komentare (ID_prispevek,komentar,autor) VALUES ('$ID_prispevek','$komentar','$autor')";
                    mysqli_query($con,$sql2);
                    header("location:/PRJ-Blog/prispevky/prispevek.php?id=$ID");
                }
                ?>
                <!-- Zde se nachazi box pro psani komentare -->
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="komentar" style="margin-left: 38%; margin-top: 5%;width: 40%; background-color: #626262">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label><h2 style="color: white">Napiste komentar</h2></label>
                                        <label><h4>Jste prihlasen jako: <?php echo $_SESSION['NAME']; ?> </p></h4></label>
                                        <textarea class="form-control" name="komentar" rows="3" style="color: black"></textarea>
                                    </div>
                                    <br>
                                    <button type="submit" name="komentuj" class="btn btn-dark">Odeslat komentar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>





            <?php }?>
            <?php
            /** Vypis komentaru
             *
             * Prislusne komentare ziskame pomoci ID z prispevku, toto ID zjistime pomoci
             * metody GET['id'], do databaze posleme dotaz, ktery vybere vsechny komentare,
             * ktere maji toto ID prispevku a vypiseme je pomoci funkce while.
             * vybereme si z DB komentar, autora komentare a kdy byl napsan.
             *
             **/

            //$ID = $con->real_escape_string($_GET['id']);



                $sql3 = "SELECT * FROM komentare WHERE ID_prispevek = '$like' ORDER BY libi ASC";
            $dotaz2 = mysqli_query($con,$sql3);

            //$radek2 = mysqli_fetch_assoc($dotaz2);




            while ($radek2 = mysqli_fetch_assoc($dotaz2)) {
                $koment = $radek2['komentar'];
                $autork = $radek2['autor'];
                $vytvoren = $radek2['vytvoren'];
                $id = $radek['ID'];
                $ID_komentar = $radek2['ID'];
                $libi = $radek2['libi'];
                $nelibi = $radek2['nelibi'];


                echo "
<div class='container'>
<div class='row'>
<div class='col-xl-8'>
<div class='komentar'>
    <div class='komentar-header'>
        <div class='koment-autor'>
            <div class='koment-jmeno'><i class='far fa-user'><strong> $autork</strong></i></div>
        </div>
        <div class='koment-datum'>
            <i class='far fa-clock'> $vytvoren</i>
            <i class='far fa-calendar'> $vytvoren</i>
        </div>
    </div>
    <div class='koment-text'>
        <p>$koment</p>
        <span id='like' onclick='like($ID_komentar)'> <i class='far fa-thumbs-up'></i><span id='pocet_like'> $libi Like </span></span>
        <br>
        <span id='dislike' onclick='dislike($ID_komentar)'> <i class='far fa-thumbs-down'></i>$nelibi Dislike</span>
    </div>
</div>
</div>
</div>
</div>
";
            }
            ?>

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
                        <?php echo "<li><a href='filtr.php?filtr=$nzv'>• $nzv</a></li>"; ?>
                    </ul>
                <?php }?>

            </div>
        </div>
    </div>
    <script>
        function like(id) {

            jQuery.ajax({
                url: 'update_like.php',
                type: 'POST',
                data: 'type=libi&id='+id,
                success: function(result) {
                    window.location.reload(true);
                }
            });
        }

        function dislike(id) {

            jQuery.ajax({
                url: 'update_like.php',
                type: 'POST',
                data: 'type=nelibi&id='+id,
                success: function(result) {
                    window.location.reload(true);
                }
            });
        }
    </script>
    </body>
    </html>
<?php ob_end_flush(); ?>