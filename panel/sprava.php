<?php
session_start();
// Pokud nikdo neni prihlasen nebo se pokusi dostat sem, redirect na login
if (!isset($_SESSION['ID']) && !isset($_SESSION['EMAIL']) && !isset($_SESSION['USERNAME'])) {
    header("Location:/PRJ-Blog/auth/login.php");
    exit();
}

$role = $_SESSION['ROLE'];

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
    <style>
        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 0px;
            padding: 0px;
            width: 100%;
            table-layout: fixed;
        }

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
            max-width: 150px;
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
                overflow: hidden;
            }

      @media only screen and (max-width: 900px) {
          table {
              border: 0;
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
                width: 100%;
                margin-left: unset;

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


<table>
    <thead>
    <tr>
        <th><strong>ID</strong></th>
        <th><strong>Jmeno</strong></th>
        <th><strong>Prezdivka</strong></th>
        <th><strong>Email</strong></th>
        <th><strong>Heslo</strong></th>
        <th><strong>Role</strong></th>
        <th><strong>Uprava</strong></th>
        <th><strong>Smazani</strong></th>
    </tr>
    </thead>
</table>

<?php
$sql = "SELECT * FROM opravneni WHERE role = '$role' ";
$dotaz = mysqli_query($con, $sql);

while ($radek2 = mysqli_fetch_assoc($dotaz)) {
    $sprava = $radek2['admin'];
}
    if ($sprava != "1") {
        header("location:../main.php");
    } else {





// Seznam uzivatelu pouze pro admina

$uzivatele = "SELECT * FROM uzivatele WHERE prezdivka !='".$_SESSION['NAME']."' ORDER BY ID desc ";  // Ignorujeme prihlaseneho administratora aby se nesmazal sam
$dotaz = mysqli_query($con,$uzivatele);
?>


<?php
while ($radek = mysqli_fetch_assoc($dotaz)) {
$heslo = $radek['password'];
$heslo_vypis = mb_strimwidth("$heslo",50,20)
?>

    <table>
<tbody>
<tr>
    <td responzivni_nadpis="ID"><?php echo $radek['ID']; ?></td>
    <td responzivni_nadpis="Jmeno"><?php echo "<i class='fas fa-address-card'></i>" . " ". $radek['jmeno'] ?></td>
    <td responzivni_nadpis="Prezdivka"><?php echo "<i class='fas fa-address-card'></i>" . " ". $radek['prezdivka'] ?></td>
    <td responzivni_nadpis="Email"><?php echo "<i class='fas fa-envelope'></i>" . " ". $radek['email'] ?></td>
    <td responzivni_nadpis="Heslo" id="heslo"><?php echo "<i class='fas fa-lock'></i>" . " ". $heslo_vypis ?></td>
    <td responzivni_nadpis="Role"><?php echo "<i class='fas fa-user'></i>" ." ". $radek['role']?></td>
    <td responzivni_nadpis="Uprava"><a href="../sprava/update.php?id=<?php echo $radek['ID']; ?>"><i class="fas fa-cog"></i> Upravit</a></td>
    <td responzivni_nadpis="Smazani"><a href="../sprava/delete.php?id=<?php echo $radek['ID']; ?>"><i class="fas fa-trash"></i> Smazat</a></td>
</tr>
</tbody>
    </table>


    <?php

       }

    }
    ?>

    </body>
    </html>
