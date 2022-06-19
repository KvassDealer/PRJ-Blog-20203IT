<?php
session_start();
// Pokud nikdo neni prihlasen nebo se pokusi dostat sem, redirect na login


// Databaze
$host = "localhost";
$username = "root";
$pass = "";
$db = "blog";
$role = $_SESSION['ROLE'];


// Pripojeni k databazi

$con = mysqli_connect($host,$username,$pass,$db);

// Kontrola pripojeni
// ID,jmeno,prezdivka,password,email,role

if (!$con || $con->connect_error) {
    die("Pripojeni k databazi selhalo!". $con->connect_error);
}

//$ID = $_GET['id'];  // Ziskame ID po kliknuti na tlacitko
//$dotaz = "SELECT * FROM uzivatele WHERE ID ='$ID'";  // Provede dotaz a vybere radek s daty podle ID
//$result = mysqli_query($con,$dotaz) or die ( mysqli_error()); // Vysledek (pokud neco nalezneme, jinak error)
//$radek = mysqli_fetch_assoc($result);  // Budeme vypisovat data z panelu (u admina) na form pro update dat

?>

<?php
// Tvorba Kategorii

if (isset($_POST['vytvorit']) && $_POST['vytvorit'] != 1 ) {
echo "Injection detected";
}



if(isset($_POST['vytvorit']) && $_POST['kontrola'] == 1) { // Pokud mame nova data z formu, provedeme UPDATE, pokud ne zobrazi se form na UPDATE

//$ID = $radek['ID'];

    $NAZEV = $con->real_escape_string($_POST['nazev']);
    if (empty($NAZEV) || $NAZEV === "") {
        echo "Hodnota nesmi byt prazdna!";
    }

    $dotaz2 = "INSERT INTO kategorie (nazev) VALUES ('$NAZEV')"; // Update SQL

    mysqli_query($con, $dotaz2) or die(mysqli_error()); // Odeslat SQL Prikaz
    header('Location:kategorie.php'); // Presmerovani zpet na panel

}

if (isset($_POST['vytvorit_podkategorii']) && $_POST['kontrola2'] == 1) {
    $ID_KAT = $_POST['id_kategorie'];
    $NAZEV_PODKATEGORIE = $_POST['nazev_subkat'];

    if (empty($_POST['nazev_subkat'])) {
        echo "Chyba!";
    } else {

    $sql = "INSERT INTO podkategorie (ID_kat,nazev_podkategorie) VALUES ('$ID_KAT', '$NAZEV_PODKATEGORIE')";
    $dotaz = mysqli_query($con, $sql);
    header('Location:kategorie.php');
   }
}


?>

<?php
$sql = "SELECT * FROM opravneni WHERE role = '$role'";
$dotazz = mysqli_query($con,$sql);
while($radek1 = mysqli_fetch_assoc($dotazz)) {

    $kat = $radek1['vtv_kategorie'];
    $kat2 = $radek1['upr_kategorie'];

}
if ($kat !="1" || $kat2 !="1") {
    header("location:../main.php");
} else {

?>

<html>
<head>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/forms.css">
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
    <style>
        .form-control {
            color: black;
        }


        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            padding: 0;
            margin-left: 10%;
            table-layout: fixed;
        }
        .fa {color: #00ADB5};

        table caption {
            font-size: 1.5em;
            margin: .5em 0 .75em;
        }

        table tr {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: .35em;

        }
        /* Zakryjeme overflow */

        table th,
        table td {
            padding: .625em;
            text-align: center;
            margin: 10px;
            max-width: 100px;
            max-height: 150px;
            overflow: hidden;

        }

        table th {
            font-size: .85em;
            letter-spacing: .1em;
            text-transform: uppercase;

        }

        @media only screen and (max-width: 900px) {
            table {
                border: 0;
                margin-left: unset;
            }

            table caption {
                font-size: 1.3em;
            }

            table thead {
                border: none;
                clip: rect(0 0 0 0);
                height: 1px;
                margin: -1px;
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 1px;
            }

            table tr {
                border-bottom: 3px solid #ddd;
                display: block;
                margin-bottom: .625em;
            }

            /*  */
            table td {
                border-bottom: 1px solid #ddd;
                display: block;
                font-size: .8em;
                text-align: right;
                overflow: unset;
                max-width: unset;
                max-height: unset;
            }

            @media only screen and (max-width: 900px) {
                table {
                    border: 0;
                    width: 100%;
                }

                table caption {
                    font-size: 1.3em;
                }

                table thead {
                    border: none;
                    clip: rect(0 0 0 0);
                    height: 1px;
                    margin: -1px;
                    overflow: hidden;
                    padding: 0;
                    position: absolute;
                    width: 1px;
                }

                table tr {
                    border-bottom: 3px solid #ddd;
                    display: block;
                    margin-bottom: .625em;
                }

                table td {
                    border-bottom: 1px solid #ddd;
                    display: block;
                    font-size: .8em;
                    text-align: right;
                }

                table td::before {
                    content: attr(responzivni_nadpis);  /* Nazev atributu muze byt jakykoliv */
                    float: left;
                    font-weight: bold;
                    text-transform: uppercase;
                }

                table td:last-child {
                    border-bottom: 0;
                }

            }
        }
        @media only screen and (min-width: 1000px) {
            table {
                width: 50%;
                margin-left: 35%;
            }

        }
        @media only screen and (min-width: 1800px) {
            table {
                width: 80%;
                margin-left: 15%;

            }
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
        <div class="col-xl-5">
            <div class="signup-form" style="margin-left: 30%; margin-bottom: 5%;" id="kategorie">
                <form method="post" action="" style="margin-left: 25%">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="hidden" name="kontrola" value="1">
                            <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                            <input type="text" name="nazev" class="form-control" placeholder="Zadejte nove jmeno" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <button type="submit" name="vytvorit" class="btn btn-primary btn-block btn-lg">Vytvorit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







<!--- Podkategorie -->



<table>
    <thead>

    <th><strong>ID Kategorie</strong></th>
    <th><strong>Nazev Kategorie</strong></th>
    <th><strong>Upravit Kategorii</strong></th>
    <th><strong>Smazat Kategorii</strong></th>

    </thead>
</table>


<?php
if($_SESSION['ROLE'] == 'admin' || $_SESSION['ROLE'] == "super_redaktor") {
// Seznam kategorii pro administratory a redaktory

//$kategorie = "SELECT * FROM kategorie ORDER BY ID_kategorie DESC";  // Ignorujeme prihlaseneho administratora aby se nesmazal sam
$sql = "SELECT * FROM kategorie LEFT JOIN podkategorie ON podkategorie.ID_kat=kategorie.ID_kategorie ORDER BY ID_kat";
$dotaz = mysqli_query($con,$sql);

while ($radek = mysqli_fetch_assoc($dotaz)) {

?>


<table>
<tbody>
<tr>
    <td responzivni_nadpis="ID Kategorie"><?php echo $radek['ID_kategorie']; ?></td>
    <td responzivni_nadpis="Nazev Kategorie"><?php echo $radek['nazev']; ?></td>
    <td responzivni_nadpis="Upravit Kategorii"><a href="../sprava/update_kategorie.php?id=<?php echo $radek['ID_kategorie']; ?>"><strong>Upravit</strong></a></td>
    <td responzivni_nadpis="Smazat Kategorii"><a href="../sprava/delete_kategorie.php?id=<?php echo $radek['ID_kategorie']; ?>"><strong>Smazat</strong></a></td>
  </tr>
    </tbody>
</table>


    <?php
     }
    } else if ($_SESSION['ROLE'] == "redaktor") {
    $kategorie = "SELECT * FROM kategorie ORDER BY ID_kategorie DESC  ";  // Ignorujeme prihlaseneho administratora aby se nesmazal sam
    $dotaz = mysqli_query($con,$kategorie);
    while ($radek = mysqli_fetch_assoc($dotaz)) {

    ?>
    <table>

        <thead>
        <tr>
            <th><strong>ID Kategorie</strong></th>
            <th><strong>Nazev Kategorie</strong></th>
        </tr>
        </thead>

        <td><?php echo $radek['ID_kategorie']; ?></td>
        <td><?php echo $radek['nazev']; ?></td>


    <?php }
      }
    ?>
<?php } ?>
</body>
</html>
