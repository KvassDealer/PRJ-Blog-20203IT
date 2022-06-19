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
if (!$con || $con->connect_error) {
    die("Pripojeni k databazi selhalo!". $con->connect_error);
}




$fotky = "SELECT * FROM galerie ORDER BY ID DESC";
$dotaz = mysqli_query($con,$fotky);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Galerie</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-grid.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/prispevky.css">
    <link rel="stylesheet" href="css/bootstrap-utilities.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="css/design.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0-beta.2/css/lightgallery.min.css" integrity="sha512-J3GvWzuXtDGv7Kmqhj1gbn/jM2i3G40XtSBcqGEQ7eLpP0izHygFgT0FMIVCWMVRZnz7u2rS6mhTtlQ3oJsr1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .card-img-top {
            width: 100%;
            height: 15vw;
            object-fit: cover;
        }
        .card-img-top:hover {
            transition: .25s;
            transform: translate(5px,5px);
        }
        @media screen and (max-width: 900px) {
            .card-img-top {
                width: unset;
                height: unset;
                object-fit: unset;
            }
            .obrazky img {
                width: 100%;
                height: auto;
            }
        }

        body {
            background-color: #EEEEEE;
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
        <div class="content clearfix">
        <div class="card-group" style="margin-top: 20px" id="obrazky">
       <?php
        $cislo = 0;


       while ($radek = mysqli_fetch_assoc($dotaz)) {
		   
           $nadpis = $radek['nazev'];
           $popis = $radek['popis'];
           $obrazek = $radek['cesta'];
           $vytvoren = $radek['vytvoren'];
           $id = $radek['ID'];
		   
            if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] == 'admin') {
               $upravit ="<a href='../PRJ-Blog/sprava/upravit_fotku.php?id=$id'> Upravit | </a>";
               $smazat ="<a href='../PRJ-Blog/sprava/smazat_fotku.php?id=$id'> Smazat </a>";
           } else { $upravit ="";$smazat="";}
           

           echo "
           <div class='card'>
           <div class='obrazky'>
                <img class='card-img-top' src='.../$obrazek' alt='$popis' id='obrz'>
                </div>
                <div class='card-body'>
                    <h5 class='card-title'>$nadpis</h5>
                    <p class='card-text'>$popis</p>
                    <p class='card-text'><small class='text-muted'>$vytvoren</small></p>
                    <p class='card-text'><small class='text-muted'>$upravit $smazat</small></p>  
                </div>
            </div> 
           ";
           $cislo++;
           if ($cislo % 3 == 0) {
               echo "</div><div class='card-group' id='obrazky' style='margin-top: 20px'>";
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
