<?php

session_start();
// Pokud nikdo neni prihlasen nebo se pokusi dostat sem, redirect na login
if (!isset($_SESSION['ID']) && !isset($_SESSION['EMAIL']) && !isset($_SESSION['USERNAME'])) {
    header("Location: /PRJ-Blog/auth/login.php");
    exit();
}

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

if (isset($_POST['odeslat'])) {



    /** Value z input checkboxu 1 = povoleno a 0 = zakazano **/

    $nazev = $_POST['nazev'];
    if (isset($_POST['vtvp'])) {
        $hodnota = "1";
    } else {$hodnota = "0";}
    if (isset($_POST['uprp'])) {
        $hodnota2 = "1";
    } else {$hodnota2 = "0";}
    if (isset($_POST['smzp'])) {
        $hodnota3 = "1";
    } else {$hodnota3 = "0";}
    if (isset($_POST['upru'])) {
        $hodnota4 = "1";
    } else {$hodnota4 = "0";}
    if (isset($_POST['smzu'])) {
        $hodnota5 = "1";
    } else {$hodnota5 = "0";}
    if (isset($_POST['vtvk'])) {
        $hodnota6 = "1";
    } else {$hodnota6 = "0";}
    if (isset($_POST['uprk'])) {
        $hodnota7 = "1";
    } else {$hodnota7 = "0";}
    if (isset($_POST['smzk'])) {
        $hodnota8 = "1";
    } else {$hodnota8 = "0";}




    $sql = "INSERT INTO opravneni (role,vtv_prispevek,upr_prispevek,smz_prispevek,upr_uzivatel,smz_uzivatel,vtv_kategorie,upr_kategorie,smz_kategorie) VALUES ('$nazev','$hodnota','$hodnota2','$hodnota3','$hodnota4','$hodnota5','$hodnota6','$hodnota7','$hodnota8')";
    mysqli_query($con,$sql);
    header("location:../panel/opravneni.php");
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
    <script src="js/bootstrap.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>


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

<div class="container">
    <div class="row">
        <div class="col-xl-10">
            <form action="" method="post">
            <table class='table table-bordered'>
                <thead>
                <tr>
                    <th scope='col'>Role nazev</th>
                    <th scope='col'>Vtv Prispevek</th>
                    <th scope='col'>Upr Prispevek</th>
                    <th scope='col'>Smz Prispevek</th>
                    <th scope='col'>Upr Uzivatel</th>
                    <th scope='col'>Smz Uzivatel</th>
                    <th scope='col'>Vtv Kategorie</th>
                    <th scope='col'>Upr Kategorie</th>
                    <th scope='col'>Smz Kategorie</th>
                    <th scope='col'>Odeslat</th>
                </tr>
                </thead>


                    <tbody>
                    <tr>

                        <td><input type="text" name="nazev" required> </td>
                        <td><div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='vtvp'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='uprp'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='smzp'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='upru'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='smzu'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='vtvk'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='uprk'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='smzk'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><button type="submit" name="odeslat">Odeslat</button> </td>
                    </tr>

                    </tbody>
            </table>
            </form>
        </div>
    </div>
</div>

</body>
</html>