<?php

session_start();

// Pokud nikdo neni prihlasen nebo se pokusi dostat sem, redirect na login


// Databaze
$host = "localhost";
$username = "root";
$pass = "";
$db = "blog";


// Pripojeni k databazi

$con = mysqli_connect($host,$username,$pass,$db);
$role = $_SESSION['ROLE'];
// Kontrola pripojeni
// ID,jmeno,prezdivka,password,email,role

if (!$con || $con->connect_error) {
    die("Pripojeni k databazi selhalo!". $con->connect_error);
}


$ID = $_GET['id'];
$dotaz = "SELECT * FROM prispevky WHERE ID = '$ID'";
$result = mysqli_query($con,$dotaz);
$radek = mysqli_fetch_assoc($result);
$content = $radek['content'];

if (isset($_POST['upravit'])) {

    $nazev_souboru = $_FILES['file']['name'];
    $temp_nazev_souboru = $_FILES['file']['tmp_name'];
    if (isset($nazev_souboru)) {
        $umisteni = '../images/';
        $soubor = $umisteni . $nazev_souboru;

        if (move_uploaded_file($temp_nazev_souboru, $umisteni . $nazev_souboru)) {
            $soubor = $umisteni . $nazev_souboru;
        }
        // Pokud nechceme/nenahrajeme thumbnail, bude pouzit stavajici thumbnail
        if (empty($nazev_souboru)) {
            $soubor = $radek['thumbnail'];
        }

        $uprava = $con->real_escape_string($_POST['prispevek']);
        $nazev = $_POST['nazev'];
        $zmena_premium = $_POST['premium'];
        $zmena_kat = $_POST['id_kategorie'];
        $sql = "UPDATE prispevky SET content = '$uprava', nadpis = '$nazev', thumbnail = '$soubor', nazev_kategorie = '$zmena_kat', premium = '$zmena_premium' WHERE ID = '$ID'";
        mysqli_query($con, $sql);
        header('location:/PRJ-Blog/prispevky/prispevky.php');

    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=UTF-8>
    <script src="https://cdn.tiny.cloud/1/gp173yaahydyotwdmiyy5zisypll2u3rtmu4thpdyvnclmr3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
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



    </style>

</head>
<body>
<script>
    function example_image_upload_handler (blobInfo, success, failure, progress) {
        var xhr, formData;

        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '../uploadery/postAcceptor.php');

        xhr.upload.onprogress = function (e) {
            progress(e.loaded / e.total * 100);
        };

        xhr.onload = function() {
            var json;

            if (xhr.status === 403) {
                failure('HTTP Error: ' + xhr.status, { remove: true });
                return;
            }

            if (xhr.status < 200 || xhr.status >= 300) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }

            json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }

            success(json.location);
        };

        xhr.onerror = function () {
            failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };

        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    };
    tinymce.init({
        selector: '#editor',
        forced_root_block : false,
        images_upload_handler: example_image_upload_handler,
        plugins: 'print preview importcss tinydrive searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons',
        toolbar: 'undo redo | bold italic underline strikethrough | fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample ltr rtl |',
        menubar: 'file edit view insert format table tc',
        quickbars_selection_toolbar: 'bold italic | alignleft aligncenter alignright | quicklink h1 h2 h3 h4 hr quote | blockquote quickimage quicktable | color',
        toolbar_mode: 'sliding',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        images_upload_url: 'postAcceptor.php',
        automatic_uploads: true,
        branding: false,
        language: 'cs',
        height: 500,
        width: 1000
    });
</script>

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

<?php
$sql = "SELECT * FROM opravneni WHERE role = '$role'";
$dotazz = mysqli_query($con,$sql);
while($radek1 = mysqli_fetch_assoc($dotazz)) {
    //$crt = $radek1['vtv_prispevek'];
    $upr = $radek1['upr_prispevek'];

}

       if ($upr != "1") {
           header("location:../main.php");
       } else {



   

?>

    <div class="container" style="margin-left: 20%">
        <div class="row">
            <div class="col-md-auto">
                <form action="" method="post" enctype="multipart/form-data">

                    <textarea id="editor" name="prispevek" style="width: 50%;"><?php echo $radek['content']; ?></textarea>

                    <label><strong>Nadpis</strong></label>
                    <input type="text" name="nazev" placeholder="Zmena nazvu prispevku" value="<?php echo $radek['nadpis'];?>">
                <br>
                    <label><strong>Kategorie</strong></label>
                    <select name="id_kategorie">

        <?php $sql = "SELECT * FROM kategorie";
        $dotaz = mysqli_query($con,$sql);
        while ($kat = mysqli_fetch_assoc($dotaz)) {

            $KATEGORIE = "";
            $KATEGORIE = '<option value = "'. $kat['nazev'] . '">' . $kat['nazev'] . '</option>';

            ?>

            <?php echo $KATEGORIE; }?>
    </select>
    <br>
    <label><strong>Premium clanek</strong></label>
    <select name="premium">
        <option value="ano">Premium</option>
        <option value="ne">Neni premium</option>
    </select>
<br>
                    <label><strong>Zmena thumbnailu</strong></label>
                    <input type="file" name="file">

                    <button type="submit" name="upravit" class="btn btn-dark">Odeslat upravy</button>
                </form>
            </div>
        </div>
    </div>
        <?php }        ?>
</body>
</html>


