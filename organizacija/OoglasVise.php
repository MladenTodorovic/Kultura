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

$id_oglas = trim($_GET['id']);
$_SESSION['id'] = $id_oglas;
$id_oglas = mysqli_real_escape_string($link, $id_oglas);
$oglasi = mysqli_query($link, "SELECT * FROM oglas WHERE id_oglas = {$id_oglas} AND organizacija_id_organizacija = {$_SESSION['id_organizacija']}");
if(mysqli_num_rows($oglasi) != 1){
    $poruka = "Greška: Nema traženog oglasa.";
} else {
$oglas = mysqli_fetch_array($oglasi);
$naslov = $oglas['naslov'];
$vreme_postavljanja = $oglas['vreme_postavljanja'];
$vreme_isticanja = $oglas['vreme_isticanja'];
$tekst = $oglas['tekst'];
$autor = $oglas['autor'];
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
    <title><?php if(isset($oglas['naslov'])){
                    echo $oglas['naslov']; 
                   } else {
                       echo "Oglasi";
                   }
            ?></title>
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
                <a class="nav-link text-warning active" href="dodajOglas.php">Dodaj oglas</a>
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
                <form action="izmeniOglas.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="naslov"><h6>Naslov oglasa:</h6></label>
                        <input type="text" class="form-control shadow-sm" name="naslov" id="naslov" value="<?php echo $naslov; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="vreme_postavljanja"><h6>Vreme postavljanja:</h6></label>
                        <input type="text" class="form-control shadow-sm datetimepicker" name="vreme_postavljanja" value="<?php echo $vreme_postavljanja; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="vreme_isticanja"><h6>Vreme isticanja:</h6></label>
                        <input type="text" class="form-control shadow-sm datetimepicker" name="vreme_isticanja" value="<?php echo $vreme_isticanja; ?>" required>
                    </div>
                    <div class="form-group">
                    <img class="form-control shadow-sm"  id="thumbnil" src="../slike/oglasi/oglas_<?php echo $id_oglas; ?>.jpg">
                    </div>
                    
    <!-- dugme je uradjeno u jQuery-u -->
                    <input style="display: none; visibility: hidden;" id="myFileInput" name="fileToUpload" type="file" accept="image/*" onchange="showMyImage(this)">
<button type="button" class="btn shadow btn-info" name="fileToUpload" id="fileToUpload" onclick="$('#myFileInput').trigger('click');">Promeni sliku</button>
                    <br/><br/>
                    
                    <div class="form-group">
                        <label for="tekst"><h6>Tekst oglasa:</h6></label>
                        <textarea rows="10" cols="30" class="form-control shadow-sm" id="tekst" name="tekst" required><?php echo $tekst; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="autor"><h6>Autor:</h6></label>
                        <input type="text" class="form-control shadow-sm" name="autor" id="autor" value="<?php echo $autor; ?>" required>
                    </div>
                    <button type="submit" class="btn shadow btn-info" style="margin-botom:100px;">Izmeni oglas</button><br/>
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