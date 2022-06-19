<?php
session_start();

// Databaze
$host = "localhost";
$username = "root";
$pass = "";
$db = "blog";



// Pripojeni k databazi

$con = mysqli_connect($host,$username,$pass,$db); // IP DB Nebo jine , USERNAME LOGIN, PASSWORD LOGIN, SELECT DB (BLOG)
$role = $_SESSION['ROLE'];



// Kontrola pripojeni
// ID,jmeno,prezdivka,password,email,role

if (!$con || $con->connect_error) {
    die("Pripojeni k databazi selhalo!". $con->connect_error);
}

$ID = $_GET['id'];

$sql = "SELECT * FROM galerie WHERE ID = '$ID'";
$result = mysqli_query($con,$sql);
$radek = mysqli_fetch_assoc($result);

if (isset($_POST['odeslat'])) {


    $nazev_souboru = $_FILES['file']['name'];  // typ: png | nazev: obrazek
    $temp_nazev_souboru = $_FILES['file']['tmp_name'];
    if (empty($nazev_souboru)) {
        $nazev_souboru = $radek['cesta'];
    }
    if (isset($nazev_souboru) and !empty($nazev_souboru)) {
        $umisteni = '../images/';  // Sem se ukladaji obrazky
        $soubor = $umisteni . $nazev_souboru;  // Nazev souboru: images/xxx.png/jpg . . .

        if (move_uploaded_file($temp_nazev_souboru, $umisteni . $nazev_souboru)) { // Odesleme soubor do nove slozky (images)
            $soubor = $umisteni . $nazev_souboru;
        }

        $nazev = $con->real_escape_string($_POST['nazev']);
        $popis =$con->real_escape_string($_POST['popis']);

        $sql = "UPDATE galerie SET nazev = '$nazev', popis = '$popis', cesta = '$soubor' WHERE ID = '$ID' ";
        $dotaz = mysqli_query($con, $sql) or die(mysqli_error($con));
        header('Location:/PRJ-Blog/galerie.php');

    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/bootstrap-grid.css">
    <link rel="stylesheet" href="../css/bootstrap-utilities.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/design.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
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
        <a href='#'>
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
                <a class='nav-link' href='../main.php'><i class='fas fa-home'></i> Domů</a>

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
            <li>
        <a href='../sprava/galerie-uploader.php'>
            <span class='icon'><i class='fas fa-database'></i></span>
            <span class='item'>Galerie</span>
        </a>
    </li>

            <li class='nav-item'>
                <a class='nav-link' href='../auth/logout.php'><i class='fa fa-power-off'></i> Odhlasit se</a>
            </li>
        </ul>
    </div>

</nav>
</div>

";


?>




<div class="container">
    <div class="row">
        <div class="col-xl-5">
            <form action="" method="post" style="margin-left: 35%" enctype="multipart/form-data">
                <label><strong>Nadpis obrazku</strong></label>
                <br>
                <input type="text" name="nazev" value="<?php echo $radek['nazev']; ?>">
                <br>
                <label><strong>Popis obrazku</strong></label>
                <br>
                <textarea name="popis"><?php echo $radek['popis']; ?></textarea>
                <br>
                <label>Obrazek</label>
                <br>
                <input type="file" name="file">
                <br>
                <br>
                <button type="submit" name="odeslat" class="btn btn-dark">Nahrat do galerie</button>
            </form>
        </div>
    </div>
</div>




</body>
</html>
