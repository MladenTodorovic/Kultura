<?php
    session_start();
if(!isset($_SESSION['username'])){
        header("location: ../greska.php");
    }
    
$link = mysqli_connect("localhost", "root", "", "kultura")
            or die ("Greška prilikom konekcije na bazu!");
mysqli_set_charset($link,"utf8");

$poruka = "";
if(isset($_SESSION['poruka'])){
    $poruka = $_SESSION['poruka'];
}
$username = $_SESSION['username'];
$id_organizacija = $_SESSION['id_organizacija'];

$naslov = "";
$vreme_postavljanja = "";
$vreme_isticanja = "";
$tekst = "";
$autor = "";

/* promenljive nazivam po kljucu iz $_POST iz dodeljujem im setovane vrednosti iz $_POST */
if(isset($_POST["naslov"])){
    foreach($_POST as $key => $value){
            $$key = $value;
    }
}

if(isset($_POST["naslov"]) && isset($_POST["vreme_postavljanja"]) && isset($_POST["vreme_isticanja"]) && isset($_POST["tekst"]) && isset($_POST["autor"]) && isset($_FILES["fileToUpload"])){

    $query = "INSERT INTO vest (naslov, vreme_postavljanja, vreme_isticanja, tekst, autor, organizacija_id_organizacija) VALUES ('$naslov', '$vreme_postavljanja', '$vreme_isticanja', '$tekst', '$autor', '$id_organizacija')";

    if(mysqli_query($link, $query)){
        $id_vest = "SELECT id_vest FROM vest WHERE naslov='$naslov' AND organizacija_id_organizacija = {$_SESSION['id_organizacija']}";
        $id_vest = mysqli_query($link, $id_vest);
        $id_vestRed = mysqli_fetch_array($id_vest);
        $id_vest = $id_vestRed['id_vest'];
        
        //deo za upload slike
        $target_dir = "../slike/vesti/";
        $target_file = $target_dir . "vest_" . $id_vest . ".jpg";
        //basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Provera da li je stvarno slika (ne radi se tako ali...)
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
    // Proveri da li fajl vec postoji. *OVAJ DEO NE TREBA
        /*if (file_exists($target_file)) {
            echo "Fajl vec postoji.";
            $uploadOk = 0;
        }*/
    // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            echo "Fajl je preveliki.";
            $uploadOk = 0;
        }
    // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Samo JPG, JPEG, PNG & GIF fajlovi su dozvoljeni.";
            $uploadOk = 0;
        }
    // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    // cistim sva polja od setovanih vrednosti
    foreach($_POST as $key => $value){
        $$key = "";
    }
    } else {
        $poruka = "Error: " . $queryO . "<br>" . mysqli_error($link);    
    }
    header("location: OvestVise.php?id=".$id_vest);
}

mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
<?php
    include_once "../moduli/bootstrapModul.php";
?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="../dateAndTimePicker/jquery.datetimepicker.min.css">
<script src="../dateAndTimePicker/jquery.datetimepicker.full.js"></script>
    <title><?php echo $_SESSION['naziv_organizacije']; ?></title>
</head>
<body>
<div class="container-fluid bg-info">
        <div class="row">
            <h1 class="col-sm-9" style="display: flex; justify-content: center; align-items: center;">Organizacija kulturnih događaja</h1>
            <div class="col-sm-3 border border-warning" style="align-items: center; padding-top:15px">
                <a class="text-warning" style="display: flex; justify-content: center;" href="../logout.php"><b>Izloguj se</b></a>
                <a class="text-warning" style="display: flex; justify-content: center;" href="profil.php"><b>Vaš profil</b></a>
            </div>
        </div>
    </div>
    <!-- END jumbotron -->
 
<nav class="navbar navbar-expand-md bg-secondary navbar-dark sticky-top">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav align-content-center mx-auto">
        <li class="nav-item flex-fill">
                <a class="nav-link text-warning" href="organizacija.php"><?php echo $_SESSION['naziv_organizacije']; ?></a>
            </li>
            <li class="nav-item flex-fill">
                <a class="nav-link text-warning active" href="Odogadjaji.php">Događaji</a>
            </li>
            <li class="nav-item flex-fill">
                <a class="nav-link text-warning" href="Ovesti.php">Vesti</a>
            </li>
            <li class="nav-item flex-fill">
                <a class="nav-link text-warning" href="Ooglasi.php">Oglasi</a>
            </li>
            <li class="nav-item flex-fill">
                <a class="nav-link text-warning" href="Oankete.php">Ankete</a>
            </li>
            <li class="nav-item flex-fill">
                <a class="nav-link text-warning" href="Osifra.php">Šifre</a>
            </li>
    </ul>
  </div>
</nav>
    <!-- END navbar -->
    
<div class="container list-group bg-light">
<?php
    if($poruka){
        echo $poruka;
    } else {
?>
</div>
<div class="container">
        <div class="row">
            <div class="col-sm-3 list-group bg-light"></div>
            <div class="col-sm-6 list-group bg-light">
                <form action="dodajVest.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="naslov"><h6>Naslov vesti:</h6></label>
                        <input type="text" class="form-control shadow-sm" name="naslov" id="naslov" placeholder="Naslov vesti..." value="<?php echo $naslov; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="vreme_postavljanja"><h6>Vreme postavljanja:</h6></label>
                        <input type="text" class="form-control shadow-sm datetimepicker" name="vreme_postavljanja" placeholder="Vreme postavljanja..." value="<?php echo $vreme_postavljanja; ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="vreme_isticanja"><h6>Vreme isticanja:</h6></label>
                        <input type="text" class="form-control shadow-sm datetimepicker" name="vreme_isticanja" placeholder="Vreme isticanja..." value="<?php echo $vreme_isticanja; ?>" readonly required>
                    </div>
                    
                    <div class="form-group">
                    <img class="form-control shadow-sm" id="thumbnil" src="" alt="Slika vesti">
                    </div>
                    
    <!-- dugme je uradjeno u jQuery-u -->
                    <input style="display: none; visibility: hidden;" id="myFileInput" name="fileToUpload" type="file" accept="image/*" onchange="showMyImage(this)">
<button type="button" class="btn shadow btn-info" name="fileToUpload" id="fileToUpload" onclick="$('#myFileInput').trigger('click');">Dodaj sliku</button>
                    <br/><br/>
                    
                    <div class="form-group">
                        <label for="tekst"><h6>Tekst vesti:</h6></label>
                        <textarea rows="10" cols="30" class="form-control shadow-sm" id="tekst" name="tekst" required><?php echo $tekst; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="autor"><h6>Autor:</h6></label>
                        <input type="text" class="form-control shadow-sm" name="autor" id="autor" placeholder="Autor..." value="<?php echo $autor; ?>" required>
                    </div>
                    <button type="submit" class="btn shadow btn-info" style="margin-botom:100px;">Dodaj vest</button><br/>
                </form>
            </div>
            <div class="col-sm-3 list-group bg-light"></div>
        </div>
    </div>

<script>
$(function () {
    $('.datetimepicker').datetimepicker({        
       step: 1,
       useCurrent: false,
       minDate: new Date(),
       format: 'Y-m-d h:m:s',
       showTodayButton: true,
       sideBySide: true,
       showClose: true,
       showClear: true,
       toolbarPlacement: 'top'
    });
});

function showMyImage(fileInput) {
    var files = fileInput.files;
    for(var i = 0; i < files.length; i++) {           
        var file = files[i];
        var imageType = /image.*/;     
        if (!file.type.match(imageType)) {
            continue;
        }           
        var img=document.getElementById("thumbnil");            
        img.file = file;    
        var reader = new FileReader();
        reader.onload = (function(aImg) { 
            return function(e) { 
                aImg.src = e.target.result; 
            }; 
        })(img);
        reader.readAsDataURL(file);
    }    
}
</script>
<?php
    }
    include_once "../moduli/footerModul.php";
?>
</body>
</html>