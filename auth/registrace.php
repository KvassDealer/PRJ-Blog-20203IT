<?php
session_start();
$host = "localhost";
$username = "root";
$pass = "";
$db = "blog";
$errors = array();
// Pripojeni k databazi

$con = mysqli_connect($host,$username,$pass,$db);

// Kontrola pripojeni

if (!$con || $con->connect_error) {
    die("Pripojeni k databazi selhalo!". $con->connect_error);
}

// Registrace uzivatelu

  if (isset($_POST['registr'])) {
      $username = $con->real_escape_string($_POST['username']);
      $email = $con->real_escape_string($_POST['email']);
      $password = $con->real_escape_string($_POST['heslo1']);
      $password2 = $con->real_escape_string($_POST['heslo2']);
      $name = $con->real_escape_string($_POST['jmeno']);
      $role = $con->real_escape_string("uzivatel");


      $kontrola_uz = "SELECT * FROM uzivatele WHERE prezdivka = '$username' OR email= '$email' LIMIT 1 ";
      $dotaz = mysqli_query($con, $kontrola_uz);
      $uzivatel = mysqli_fetch_assoc($dotaz);  // Pokud to uzivatele nalezne, hodime error

      if ($uzivatel) { // Pokud existuje uzivatel z dotazu nahore

          if ($uzivatel['prezdivka'] === $username || $uzivatel['email'] === $email) {
              array_push($errors, "");
              echo "<div class='alert alert-danger alert-dismissible'> Username nebo Email se jiz pouziva! </div>";

          }
      }
          //if (empty($username) || empty($email) || empty($password)) {
           //   $errors = "Zapln celou formu!";
          if ($password != $password2) {
              array_push($errors,"");
              echo "<div class='alert alert-danger alert-dismissible'> Hesla se neshoduji! </div>";
          }


             if (count($errors) == 0) {
              //$password = md5($password);  // Hashovani hesla algoritmem MD5
              //$password = hash('sha512',$password); // Hash hesla algoritmem SHA-512
              $password = password_hash($password, PASSWORD_ARGON2ID, ['memory_cost'=> 2048, 'time_cost' => 10, 'threads' => 3]);


              $query = "INSERT INTO uzivatele (jmeno, prezdivka, password, email, role) VALUES ('$name', '$username', '$password', '$email', '$role')";
              mysqli_query($con, $query);
              $_SESSION['ROLE'] = $role;
              $_SESSION['NAME'] = $name;
              $_SESSION['EMAIL'] = $email;
              $_SESSION['USERNAME'] = $username;
              header('Location:/PRJ-Blog/panel/panel.php');
             }
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registruj se</title>
    <link rel="stylesheet" href="../css/forms.css">
    <link rel="stylesheet" href="../css/bootstrap-grid.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
<div class="signup-form">
    <form action="" method="post">

        <h2 style="color: white;">Zaregistrujte se</h2>
        <p class="text" style="color: white;">Po registraci budete automaticky prihlaseni</p>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                <input type="text" class="form-control" name="username" placeholder="Uzivatelske jmeno *" required="required">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                <input type="text" class="form-control" name="jmeno" placeholder="Jmeno *" required="required">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control" name="email" placeholder="Emailova Adresa *" required="required">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" name="heslo1" placeholder="Heslo *" required="required">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-lock"></i>
				</span>
                <input type="password" class="form-control" name="heslo2" placeholder="Potvrzeni hesla *" required="required">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="registr" class="btn btn-primary btn-block btn-lg" style="margin-left: 80px">Zaregistrovat</button>
        </div>
        <p class="small text-center" style="color: white">Peclive si prosim <br>Zapamatujte zadane udaje!</p>
    </form>
</div>

</body>
</html>