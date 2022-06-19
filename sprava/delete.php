  <?php
  session_start();
  if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] == "admin") {
      echo "OK";
  } else {
      header('location:/PRJ-Blog/panel.php');
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
  // Mazeme radek v databazi podle prislusneho ID

  $ID = $_GET['id'];  // Ziskame ID po kliknuti na tlacitko
  $dotaz = "DELETE FROM uzivatele WHERE ID ='$ID'";
  mysqli_query($con,$dotaz);
  header("Location:/PRJ-Blog/panel/panel.php");

?>