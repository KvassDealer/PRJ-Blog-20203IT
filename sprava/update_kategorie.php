<?php
session_start();
// Pokud nikdo neni prihlasen nebo se pokusi dostat sem, redirect na login
if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] == "admin" || $_SESSION['ROLE'] == "super_redaktor") {
    echo "";
} else {
    header('location:panel.php');
}

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

$ID = $_GET['id'];  // Ziskame ID po kliknuti na tlacitko
$dotaz = "SELECT * FROM kategorie LEFT JOIN podkategorie ON podkategorie.ID_kat=kategorie.ID_kategorie WHERE ID_kategorie ='$ID'"; // Provede dotaz a vybere radek s daty podle ID
$result = mysqli_query($con,$dotaz) or die ( mysqli_error()); // Vysledek (pokud neco nalezneme, jinak error)
$radek = mysqli_fetch_assoc($result);  // Budeme vypisovat data z panelu (u admina) na form pro update dat
//header("Location:panel.php");
?>

<?php
if (isset($_POST['update']) && $_POST['update'] != 1 ) {
    echo "Injection detected";
}

if(isset($_POST['update']) && $_POST['update'] == 1) { // Pokud mame nova data z formu, provedeme UPDATE, pokud ne zobrazi se form na UPDATE




    //$ID = $_REQUEST['id'];

    $ID = $radek['ID_kategorie'];
    $NAZEV = $_REQUEST['nazev_kat'];
    //$NAZEV_PODKAT = $_REQUEST['nazev_podkat'];

    $dotaz2 = "UPDATE kategorie SET nazev ='" . $NAZEV . "' WHERE ID_kategorie = '". $ID."'"; // Update SQL
    if ($NAZEV == "") {
        echo("<script>alert('Neplatna role! Lze pouze = uzivatel - admin - redaktor')</script>");
        echo("<script>window.location = 'update.php?id=$ID';</script>");

    } else {

        mysqli_query($con, $dotaz2) or die(mysqli_error()); // Odeslat SQL Prikaz
        header('Location:../panel/kategorie.php'); // Presmerovani zpet na panel
    }


} else {
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
        <a href='../auth/logout.php'>
            <span class='icon'><i class='fa fa-power-off'></i></span>
            <span class='item'>Odhlasit se</span>
        </a>
    </li>
    </ul>
 
</div>
</div>


<div class='menu'>


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
                <a class='nav-link' href='../prispevky/prispevky.php'><i class='fas fa-desktop'></i> Prispevky</a>

                <!-- <i class='fa fa-calendar-check-o'></i> -->
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='../panel/kategorie.php'><i class='fa fa-tags'></i> Kategorie</a>

                <!-- <i class='fa fa-calendar-check-o'></i> -->
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='#'><i class='fas fa-file-powerpoint'></i> Planky</a>
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='../panel/sprava.php'><i class='fas fa-database'></i> Sprava uzivatelu</a>
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='../auth/logout.php'><i class='fa fa-power-off'></i> Odhlasit se</a>
            </li>
        </ul>
    </div>

</nav>
</div>
</div>




";


?>


<div class="container">
 <div class="row">
 <div class="col-xl-8 uprava" style="margin-left:20%; margin-top: 10%">
 <form method="post" action="">


    <input type="hidden" name="update" value="1">

    <label><strong>Zmena Nazvu Kategorie</strong></label><br>
    <p><input type="text" name="nazev_kat" placeholder="Zadejte novy nazev" value="<?php echo $radek['nazev'];?>" required></p>
    <p><input name="submit" type="submit" class="btn btn-dark" value="Upravit"></p>
    <br>
    <a href="../panel/kategorie.php" class="btn btn-dark">Zpatky</a>


</form>
 
 
 </div>
 </div>
</div>

<?php } ?>
</body>
</html>
