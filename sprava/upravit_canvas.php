<?php
session_start();

if (!isset($_SESSION['ROLE'])) {
    header("location:../PRJ-Blog/main.php");
}

// Databaze
$host = "localhost";
$username = "root";
$pass = "";
$db = "blog";


// Pripojeni k databazi

$con = mysqli_connect($host,$username,$pass,$db);

$id_canvas = $_GET['id'];

$sql = "SELECT * FROM planky WHERE ID = '$id_canvas'";
$dotaz = mysqli_query($con,$sql);


if (empty($id_canvas)) {
    header("Location: ../main.php");
} else {

?>

<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/bootstrap-grid.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/design.css">
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

    while ($radek = mysqli_fetch_assoc($dotaz)) {

     $planek = $radek['planek'];
     $popis = $radek['popis'];

?>

        <div class="container">
            <div class="col-xl-12" style="margin-left: 20%">
                <br>
                <canvas width="512" height="512"  id="canvas" name="obr"></canvas>
                <br>
                <br>
                <div id="output"></div>
                <textarea class="form-control" name="popis" id="popis" rows="3" style="width: 30%; color: black"><?php echo "$popis" ?></textarea>
                <br>
                <i class="fa fa-download"></i>
                <a download="planek.jpg" id="nahrat-obrazek" onclick="downloadCanvas(this)">Stahnout obrazek</a>
                <br>
                <input type="file" id="nahrat" class="btn btn-dark">
                <br>
                <br>
                <button type="button" id="upload" class="btn btn-dark" onclick="smazat()">Smazat</button>
                <button type="submit" name="push" class="btn btn-dark" id="push">Odeslat</button>
            </div>
        </div>


<?php }?>
</body>
</html>

<script>




    var imageLoader = document.getElementById('nahrat');
    imageLoader.addEventListener('change', handleImage, false);


    puvodni_planek();

    function puvodni_planek() {
        planek = new Image();
        planek.src = "<?php echo $planek; ?>"; // Puvodni planek (obrazek)
        planek.onload = function() {
            ctx.drawImage(planek, 0, 0);
        }
    }

    function handleImage(e){
        var reader = new FileReader();
        reader.onload = function(c){
            var obr = new Image();
            obr.onload = function(){
                canvas.width = obr.width;
                canvas.height = obr.height;
                ctx.drawImage(obr,0,0);
                alert("Obrazek se nahral!");
            }
            obr.src = c.target.result;
        }
        reader.readAsDataURL(e.target.files[0]);
    }



    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');

    var canvasx = $(canvas).offset().left;
    var canvasy = $(canvas).offset().top;
    var last_mousex = last_mousey = 0;
    var mousex = mousey = 0;
    var mousedown = false;
    var tooltype = 'draw';


    $(canvas).on('mousedown', function(e) {
        last_mousex = mousex = parseInt(e.clientX-canvasx);
        last_mousey = mousey = parseInt(e.clientY-canvasy);
        mousedown = true;
    });


    $(canvas).on('mouseup', function(e) {
        mousedown = false;
    });

    //Mousemove
    $(canvas).on('mousemove', function(e) {
        mousex = parseInt(e.clientX-canvasx);
        mousey = parseInt(e.clientY-canvasy);
        if(mousedown) {
            ctx.beginPath();
            if(tooltype==='draw') {
                ctx.globalCompositeOperation = 'source-over';  // Kreslime pres nakreslene veci
                ctx.strokeStyle = 'gray';
                ctx.lineWidth = 5;
            } else {
                ctx.globalCompositeOperation = 'destination-out';
                ctx.lineWidth = 10;
            }
            ctx.moveTo(last_mousex,last_mousey);
            ctx.lineTo(mousex,mousey);
            ctx.lineJoin = ctx.lineCap = 'round';
            ctx.stroke();
        }
        last_mousex = mousex;
        last_mousey = mousey;

        $('#output').html('Pozice: ' +mousex+' '+'X'+' , '+mousey+' '+'Y');
    });

    //Use draw|erase
    use_tool = function(tool) {
        tooltype = tool; //update
    }

    function smazat()
    {
        var canvas=document.getElementById("canvas");
        var context=canvas.getContext("2d");
        context.clearRect(0,0,canvas.width,canvas.height);
        window.location.reload(true);
    }

     function downloadCanvas(el) {
         const imageURI = canvas.toDataURL("image/jpg");
         el.href = imageURI;
     }



    $(function(f) {
        $("#push").click(function() {
            var obr_src = canvas.toDataURL("image/png");
            console.log(obr_src);
            console.log(obr_src.size);
            var dataURL = canvas.toDataURL();
            var popis = document.getElementById("popis").value;

                    $.ajax({
                        type: "POST",
                        url: "canvas_update_handler.php",
                        data: {
                            canvas_data: dataURL,
                            popisek: popis,
                            id: <?php echo $id_canvas; ?>
                        }
                    }).done(function(o) {
                console.log('Ulozeno!');
                window.location="canvas_control.php";

            });
        });
    });
</script>
<?php } ?>