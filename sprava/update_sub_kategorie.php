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
if (empty($_GET['id'])) {
    header('Location:kategorie.php');
}

$ID = $_GET['id'];  // Ziskame ID po kliknuti na tlacitko
$dotaz = "SELECT * FROM podkategorie WHERE ID ='$ID'"; // Provede dotaz a vybere radek s daty podle ID
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

    //$ID = $radek['ID_kategorie'];
    $NAZEV_PODKAT = $_REQUEST['nazev_podkat'];

    $dotaz2 = "UPDATE podkategorie SET nazev_podkategorie = '".$NAZEV_PODKAT."' WHERE ID = '". $ID."'";


        mysqli_query($con, $dotaz2); // Odeslat SQL Prikaz
        header('Location:panel.php'); // Presmerovani zpet na panel

} else {
?>
<html>
<head>

</head>
<body>
<form method="post" action="">


    <input type="hidden" name="update" value="1">

    <label>Zmena Nazvu PodKategorie</label>
    <p><input type="text" name="nazev_podkat" placeholder="Zadejte novy nazev" value="<?php echo $radek['nazev_podkategorie'];?>" required></p>
    <p><input name="submit" type="submit" value="Upravit"></p>
    <br>
    <a href="panel.php">Zpatky</a>


</form>
<?php } ?>
</body>
</html>
