<?php
    session_start();
if(!isset($_SESSION['username'])){
        header("location: ../greska.php");
    }
    
$link = mysqli_connect("localhost", "root", "", "kultura")
        or die("Greška prilikom konekcije na bazu!");
mysqli_set_charset($link,"utf8");

$poruka = "";
if(isset($_SESSION['poruka'])){
    $poruka = $_SESSION['poruka'];
}
$username = $_SESSION['username'];
$id_organizacija = $_SESSION['id_organizacija'];

if(isset($_GET['id']) && isset($_GET['kategorija_sifre'])){
    $_SESSION['id'] = $_GET['id'];
    $_GET['id'] = "";
    $_SESSION['kategorija_sifre'] = $_GET['kategorija_sifre'];
    $_GET['kategorija_sifre'] = "";
}
$sifarnik_id_sifra = $_SESSION['id'];
$kategorija_sifre = $_SESSION['kategorija_sifre'];
$popunjeneStavke = [];

if(isset($_POST['submit'])){
    /* promenljive nazivam po kljucu iz $_POST i dodeljujem im setovane vrednosti iz $_POST */
    foreach($_POST as $key => $value){
            $$key = $value;
            if($key=='stavka1' || $key=='stavka2' || $key=='stavka3' || $key=='stavka4' || $key=='stavka5'){
                $br = substr($key, 6);
                array_push($popunjeneStavke, $br);
            }
    }
    
    $porukaS = "Ove stavke već postoje: ";
    foreach($popunjeneStavke as $value){
        $stavka = ${'stavka'. $value};
        $vreme_postavljanja = ${'vreme_postavljanja'.$value};
        $vreme_isticanja = ${'vreme_isticanja'.$value};
        //prvo proveravamo da li stavka vec postoji
        $query = "SELECT * FROM stavka_sifarnik WHERE stavka='$stavka'";
        $rezultat = mysqli_query($link, $query);
        $brojRedova = mysqli_num_rows($rezultat);
        if($brojRedova === 0){
        $query = "INSERT INTO stavka_sifarnik (stavka, vreme_postavljanja, vreme_isticanja, sifarnik_id_sifra) VALUES ('$stavka', '$vreme_postavljanja', '$vreme_isticanja', '$sifarnik_id_sifra')";
        mysqli_query($link, $query);
        } elseif($brojRedova === 1) {
            $porukaS .= $stavka.", ";
        } else{
            $porukaS = "Došlo je do greške u bazi!";
        }
    }
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
    <title><?php echo "Šifra: ".$kategorija_sifre; ?></title>
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
                <h4><?php echo "Šifra: ".$kategorija_sifre; ?></h4>
                <h4 class="text-danger"><?php if(isset($porukaS)){ echo $porukaS;} ?></h4>
                <form action="dodajStavku.php" method="POST">
                    <div id="stavka1" class="border">
                        <div class="form-group p-1">
                            <label for="naslov"><h6>Stavka:</h6></label>
                            <input type="text" class="form-control shadow-sm" name="stavka1" placeholder="Stavka..." required>
                        </div>
                        <div class="form-group p-1">
                            <label for="vreme_postavljanja1"><h6>Vreme postavljanja:</h6></label>
                            <input type="text" class="form-control shadow-sm datetimepicker" name="vreme_postavljanja1" placeholder="Vreme postavljanja..." required>
                        </div>
                        <div class="form-group p-1">
                            <label for="vreme_isticanja1"><h6>Vreme isticanja:</h6></label>
                            <input type="text" class="form-control shadow-sm datetimepicker" name="vreme_isticanja1" placeholder="Vreme isticanja..." required>
                        </div>
                    </div>
                    
                    <div id="stavka2" class="border border-top-0"></div>
                    <div id="stavka3" class="border border-top-0"></div>
                    <div id="stavka4" class="border border-top-0"></div>
                    <div id="stavka5" class="border border-top-0"></div>
                    <div class="form-group" id="josStavki">
                        <input type="button" class="btn shadow bg-warning align-auto" onclick="josStavki()" value="Još stavki"/>
        </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn shadow bg-info align-auto" value="Dodaj stavke"/>
        </div>
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

var brojPolja = 1;
function josStavki(){
    ++brojPolja;
    document.getElementById("stavka" + brojPolja).innerHTML = '<div class="form-group p-1"><label for="naslov"><h6>Stavka:</h6></label><input type="text" class="form-control shadow-sm" name="stavka' + brojPolja + '" placeholder="Stavka..." required></div><div class="form-group p-1"><label for="vreme_postavljanja' + brojPolja + '"><h6>Vreme postavljanja:</h6></label><input type="text" class="form-control shadow-sm datetimepicker" name="vreme_postavljanja' + brojPolja + '" placeholder="Vreme postavljanja..." required></div><div class="form-group p-1"><label for="vreme_isticanja' + brojPolja + '"><h6>Vreme isticanja:</h6></label><input type="text" class="form-control shadow-sm datetimepicker" name="vreme_isticanja' + brojPolja + '" placeholder="Vreme isticanja..." required></div>';
    if(brojPolja == 5){
        document.getElementById("josStavki").style.visibility = "hidden";
    }
// ponovo pozivam datetimepicker da bi se u dodatim poljima pojavio
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
}
</script>
<?php
    }
    include_once "../moduli/footerModul.php";
?>
</body>
</html>