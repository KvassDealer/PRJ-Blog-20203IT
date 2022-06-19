<?php
session_start();

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/ars.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-grid.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="css/design.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-image: url("images/tank-wallpaper.jpg");
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
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
                <a class='nav-link' href='main.php'><i class='fa fa-home'></i> Domů</a>

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
            <li><a class='dropdown-item' href='ars-design.php'>Airsoft</a></li>
            <li><a class='dropdown-item' href='galerie.php'>Galerie</a></li>
            <li><a class='dropdown-item' href='panel/canvas.php'>Kresli planek</a></li>
          </ul>
        </li>

            <li class='nav-item'>
                <a class='nav-link' href=''><i class='fa fa-address-book'></i> Redakce</a>
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='panel/panel.php'><i class='fa fa-users'></i> Panel</a>
            </li>
        </ul>
    </div>

    <div class='navbar-collapse collapse w-25  order-3' id='dual-collapse2'>
    <ul class='navbar-nav ml-auto'>
            <li class='nav-item'>
                <a class='nav-link' href='auth/logout.php'><i class='fa fa-reply-all'></i> Logout</a>
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
                <a class='nav-link' href='main.php'><i class='fa fa-home'></i> Domů</a>

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
            <li><a class='dropdown-item' href='ars-design.php'>Airsoft</a></li>
            <li><a class='dropdown-item' href='galerie.php'>Galerie</a></li>
          </ul>
        </li>

            <li class='nav-item'>
                <a class='nav-link' href=''><i class='fa fa-address-book'></i> Redakce</a>
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='panel/panel.php'><i class='fa fa-users'></i> Panel</a>
            </li>
        </ul>
    </div>

    <div class='navbar-collapse collapse w-25  order-3' id='dual-collapse2'>
        <ul class='navbar-nav ml-auto'>
            <li class='nav-item'>
                <a class='nav-link' href='auth/login.php'><i class='fa fa-share'></i> Login</a>
            </li>
        </ul>

    </div>
</nav>";
} ?>

<div class="container">
    <div class="row">
        <div class="col-xl-6">
            <div class="obdelnik">
                <div class="obdelnik-obrazek">
                    <img src="images/2026817.svg">
                </div>
                <div class="obdelnik-popis">
                    <h1>• O airsoftu</h1>
                    <p>• Airsoft je označení pro hru, nebo také druh sportu, během kterého po sobě hráči střílejí z airsoftových pistolí.
                        Pod pojmem airsoft můžete však také najít zbraně užívané
                        při této hře – airsoftové zbraně. Zbraně na airsoft jsou typické svým vzhledem, neboť vypadají jako opravdové zbraně.</p>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="obdelnik">
                <div class="obdelnik-obrazek">
                    <img src="images/2026338.svg">
                </div>
                <div class="obdelnik-popis">
                    <h1>• Herní režimy</h1>
                    <p>• Airsoft ma 2 nejznamejsi herni mody. Mod CQB a mod Military-Simulator. Mod CQB se vetsinou odehrava v prostredi
                        uzavrenych budov nebo jinyc opustenych, ci jinak poskoyenych mist. Zatimco military-simulator, jak uz lze vycist ze jmena,
                        ma simulovat realnou vojenskou situaci nebo boje. Zahrnuje to boje v otevrenem poli, nekdy se vyuziva technika atp.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="obdelnik">
                <div class="obdelnik-obrazek">
                    <img src="images/41649.svg">
                </div>
                <div class="obdelnik-popis">
                    <h1>• Výbava</h1>
                    <p>• Zakladem je kryt si oci! Nikdy nezapomente na bryle! Do vystruje muzete pouzit libovolnou maskovaci sadu pro dany typ obdobi,
                        nosice platu, ochrana podloktu, vojenske boty, takticke rukavice, masku, helmu a pokud si to chcete zpestrit tak i aktivni sluchatka.</p>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="obdelnik">
                <div class="obdelnik-obrazek">
                    <img src="images/user.png">
                </div>
                <div class="obdelnik-popis">
                    <h1>• Pravidla</h1>
                    <p>• Pravidla stanovi poradajici akce, avsak jsou nektera pravidla "globalni". Nejvice rozsirene pravidlo je, zvedni ruku pokud jsi dostal
                        1 zasah. V nekterych hrac nemusi platit 1 zasah specificky, protoze na poli muze behat doktor. Pravidla, jak je psano vyse, zalezi na
                        poradateli akce.</p>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
