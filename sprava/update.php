<?php
session_start();
// Pokud nikdo neni prihlasen nebo se pokusi dostat sem, redirect na login
if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] == "admin") {
    echo "";
} else {
    header('location:/PRJ-Blog/panel/panel.php');
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
$dotaz = "SELECT * FROM uzivatele WHERE ID ='$ID'";  // Provede dotaz a vybere radek s daty podle ID
$result = mysqli_query($con,$dotaz); // Vysledek (pokud neco nalezneme, jinak error)
$radek = mysqli_fetch_assoc($result);  // Budeme vypisovat data z panelu (u admina) na form pro update dat

//header("Location:panel.php");
?>

<?php

if(isset($_POST['update'])) { // Pokud mame nova data z formu, provedeme UPDATE, pokud ne zobrazi se form na UPDATE

    if (empty($_REQUEST['password'])) {
        header("location: ../PRJ-Blog/main.php");
    }
    //$ID = $_REQUEST['id'];

    $ID = $radek['ID'];
    $JMENO = $_REQUEST['jmeno'];
    $PREZDIVKA = $_REQUEST['prezdivka'];
    $EMAIL = $_REQUEST['email'];
    if (empty($_REQUEST['password'])) { $PASSWORD = $radek['password'];} else {$PASSWORD = password_hash($_REQUEST['password'], PASSWORD_ARGON2ID, ['memory_cost'=> 2048, 'time_cost' => 10, 'threads' => 3]);}

    $PREMIUM = $_REQUEST['premium'];
    $ROLE = $_REQUEST['role'];
    if (empty($_REQUEST['role'])){$ROLE = $radek['role'];}

    $dotaz2 = "UPDATE uzivatele SET jmeno='" . $JMENO . "', prezdivka='" . $PREZDIVKA . "', email='" . $EMAIL . "', password='" . $PASSWORD . "', role='" . $ROLE . "', premium ='". $PREMIUM ."' where ID='" . $ID . "'"; // Update SQL
    if ($ROLE != "uzivatel" && $ROLE != "admin" && $ROLE != "redaktor" && $ROLE != "super_redaktor" && $ROLE != "premium") {
        header("location:/PRJ-Blog/panel/panel.php");

    } else if ($PREMIUM != "ano" && $PREMIUM != "ne") {
        header("location:/PRJ-Blog/panel/panel.php");
    } else {

        mysqli_query($con, $dotaz2) or die(mysqli_error()); // Odeslat SQL Prikaz
        header('Location:/PRJ-Blog/panel/panel.php'); // Presmerovani zpet na panel
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
        <a href='../sprava/vytvorit_roli.php'>
            <span class='icon'><i class='fas fa-database'></i></span>
            <span class='item'>Tvorba role</span>
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
        <div class="col-xl-8 uprava" style="margin-top: 10%; margin-left: 20%;">
            <form method="post" action="" style="margin-top: 10%; margin-left: 20%">
            <input type="hidden" name="update" value="1">
                <label><strong>Zmena Jmena</strong></label>
            <p><input type="text" name="jmeno" placeholder="Zadejte nove jmeno" value="<?php echo $radek['jmeno'];?>"></p>

                <label><strong>Zmena Emailu</strong></label>
            <p><input type="email" name="email" placeholder="Zadejte novy email" value="<?php echo $radek['email'];?>"></p>

                <label><strong>Zmena Prezdivky</strong></label>
            <p><input type="text" name="prezdivka" placeholder="Zadejte novou Prezdivku" value="<?php echo $radek['prezdivka'];?>"></p>

                <label><strong>Zmena Hesla</strong></label>
            <p><input type="password" name="password" placeholder="Zadejte nove heslo" value=""></p>

           <label><strong>Zmena role </strong>Aktualni role: <?php echo $radek['role']; ?></label> <br>
            <select name="role">
                <option value="">Zmena role</option>
                <?php
                /** Vypis dostupnych roli z DB a zobrazeni v selectu  **/

                $role = "SELECT role FROM opravneni";
                $dotaz3 = mysqli_query($con,$role);
                while ($radek2 = mysqli_fetch_assoc($dotaz3)) {
                    echo "<option value='" . $radek2['role'] . "'>" . $radek2['role'] . "</option>";
                }
                ?>
            </select>
            <br>
            <label><strong>Zmena premium statusu </strong><br><strong>Je premium? </strong><?php echo $radek['premium']; ?></label>
            <br>
            <select name="premium">
                <option value="ano">Premium</option>
                <option value="ne">Neni premium</option>
            </select>


            <p><input name="submit" type="submit" value="Update" class="btn btn-dark" style="margin-top: 20px"></p>
            <br>
            <a href="../panel/panel.php" class="btn btn-dark">Zpatky</a>


</form>
        </div>
    </div>
</div>

<?php } ?>
</body>
</html>