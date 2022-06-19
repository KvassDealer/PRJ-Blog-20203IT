<?php //include('auth_registr_login.php')
session_start();
if (isset($_SESSION['ID'])) {
    header('Location: /PRJ-Blog/main.php');
}
// Udaje k databazi
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




//require_once ("config.php"); // Databaze

// Reseni prihlaseni

 if (isset($_POST['login'])) {
     $error = "";

     //$username = $con->real_escape_string($_POST['username']);
     //$password = $con->real_escape_string(md5($_POST['password']));
     //$password = $con->real_escape_string($_POST['password']);



     if ($login = $con->prepare('SELECT ID,password,role,premium FROM uzivatele WHERE prezdivka = ? ')) { // Predpripraveny SQL prikaz

             $login->bind_param('s',$_POST['username']);
             $login->execute(); // Odesle drive predpripraveny SQL Prikaz (35 radek)
             $login->store_result(); // Ulozi ziskana data z SQL Prikazu

             if ($login->num_rows > 0) {
                 $login->bind_result($ID,$PASSWORD,$ROLE,$PREMIUM);  // Data z SQL Dotazu (Musi byt presne za sebou: 1.ID,2.Heslo,3.ROLE !!!)
                 $login->fetch();  // Data jsou ulozena do promennych, ktere jsme si nastavili nahore
                 //Kontrola hesla
                 if (password_verify($_POST['password'],$PASSWORD)) {
                     session_regenerate_id();  // Refresh session pri uspesnem prihlaseni
                     $_SESSION['NAME'] = $_POST['username'];
                     $_SESSION['ROLE'] = $ROLE;
                     $_SESSION['ID'] = $ID;
                     $_SESSION['PREMIUM'] = $PREMIUM;
                     header('location:/PRJ-Blog/main.php');
                 } else {
                     $errorMsg = "Spatne zadane jmeno nebo heslo!";
                 }
             }

             $login->close();

     }
 }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prihlaseni</title>
    <link rel="stylesheet" href="../css/forms.css">
    <link rel="stylesheet" href="../css/bootstrap-grid.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php if (isset($errorMsg)) { ?>
<div class="alert alert-danger alert-dismissible">
    <?php echo $errorMsg; ?>
</div>
<?php } ?>

<div class="signup-form">
    <form action="" method="post">
        <h2 style="color: white">Prihlaseni</h2>
        <p class="text" style="color: white">Prihlaseni do vaseho osobniho uctu</p>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                <input type="text" class="form-control" name="username" placeholder="Uzivatelske jmeno *" required="required">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Heslo *" required="required">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="login" class="btn btn-primary btn-block btn-lg" style="margin-left: 80px">Prihlasit</button>
            <p style="color: white">Nejsi registrovany? <a href="registrace.php">Klikni sem a registruj se!</a></p>
        </div>
    </form>
</div>




</body>
</html>