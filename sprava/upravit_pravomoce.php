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

$role = $_GET['role'];

$sql = "SELECT * FROM opravneni WHERE role = '$role'";
$data = mysqli_query($con,$sql);


if (isset($_POST['odeslat'])) {

    if (isset($_POST['prispevek'])) {
        $pravo = "1";
    } else {$pravo = "0";};

    if (isset($_POST['prispevek2'])) {
        $pravo2 = "1";
    } else {$pravo2 = "0";};
    if (isset($_POST['prispevek3'])) {
        $pravo3 = "1";
    } else {$pravo3 = "0";};
    if (isset($_POST['uzivatel'])){
        $pravo4 = "1";
    } else {$pravo4 = "0";};
    if (isset($_POST['uzivatel2'])){
        $pravo5 = "1";
    } else {$pravo5 = "0";};
    if (isset($_POST['kategorie'])){
        $pravo6 = "1";
    } else {$pravo6 = "0";}
    if (isset($_POST['kategorie2'])){
        $pravo7 = "1";
    } else {$pravo7 = "0";}
    if (isset($_POST['kategorie3'])){
        $pravo8 = "1";
    } else {$pravo8 = "0";}

    $dotaz = "UPDATE opravneni SET vtv_prispevek = '$pravo', upr_prispevek = '$pravo2', smz_prispevek = '$pravo3', upr_uzivatel = '$pravo4', smz_uzivatel = '$pravo5', vtv_kategorie = '$pravo6', upr_kategorie = '$pravo7', smz_kategorie = '$pravo8' WHERE role = '$role'";
    mysqli_query($con,$dotaz);
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
        <div class="col-xl-10">
<form action="" method="post">
            <table class='table table-bordered'>
                <thead>
                <tr>
                    <th scope='col'>Role</th>
                    <th scope='col'>Vtv Prispevek</th>
                    <th scope='col'>Upr Prispevek</th>
                    <th scope='col'>Smz Prispevek</th>
                    <th scope='col'>Upr Uzivatel</th>
                    <th scope='col'>Smz Uzivatel</th>
                    <th scope='col'>Vtv Kategorie</th>
                    <th scope='col'>Upr Kategorie</th>
                    <th scope='col'>Smz Kategorie</th>
                    <th scope='col'>Upravit</th>
                </tr>
                </thead>
                <?php

                while ($radek = mysqli_fetch_assoc($data)) {
                    $prispevek1 = $radek['vtv_prispevek'];
                    $prispevek2 = $radek['upr_prispevek'];
                    $prispevek3 = $radek['smz_prispevek'];
                    $uzivatel1 = $radek['upr_uzivatel'];
                    $uzivatel2 = $radek['smz_uzivatel'];
                    $kategorie1 = $radek['vtv_kategorie'];
                    $kategorie2 = $radek['upr_kategorie'];
                    $kategorie3 = $radek['smz_kategorie'];
                    ?>

                    <tbody>
                    <tr>

                        <td><?php echo "$role"?></td>
                        <td><?php echo "$prispevek1"?> <div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='prispevek'> Povolit

                            </div>
                        </td>
                        <td><?php echo "$prispevek2"?> <div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='prispevek2'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><?php echo "$prispevek3"?> <div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='prispevek3'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><?php echo "$uzivatel1"?> <div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='uzivatel'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><?php echo "$uzivatel2"?> <div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='uzivatel2'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><?php echo "$kategorie1"?> <div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='kategorie'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><?php echo"$kategorie2"?> <div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='kategorie2'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><?php echo "$kategorie3"?> <div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' name='kategorie3'>
                                <label class='custom-control-label' for='customCheck1'>Povolit</label>
                            </div></td>
                        <td><button type="submit" name="odeslat">Upravit</button> </td>
                    </tr>

                    </tbody>


                <?php } ?>
            </table>
        </form>
        </div>
    </div>
</div>

</body>
</html>
