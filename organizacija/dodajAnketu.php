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
    <title>Dodaj anketu</title>
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
                <h4 class="text-danger"><?php if(isset($porukaS)){ echo $porukaS;} ?></h4>
                <form action="dodajAnketu.php" method="POST">
                    <div id="naslov" class="border">
                        <div class="form-group p-1">
                            <label for="naslov"><h6>Naslov ankete:</h6></label>
                            <input type="text" class="form-control shadow-sm" name="naslov" placeholder="Naslov ankete..." required>
                        </div>
                        <div class="form-group p-1">
                            <label for="vreme_postavljanja"><h6>Vreme postavljanja:</h6></label>
                            <input type="text" class="form-control shadow-sm datetimepicker" name="vreme_postavljanja" placeholder="Vreme postavljanja..." readonly required>
                        </div>
                        <div class="form-group p-1">
                            <label for="vreme_isticanja"><h6>Vreme isticanja:</h6></label>
                            <input type="text" class="form-control shadow-sm datetimepicker" name="vreme_isticanja" placeholder="Vreme isticanja..." readonly required>
                        </div>
                        <div class="form-group p-1">
                            <label for="autor"><h6>Autor:</h6></label>
                            <input type="text" class="form-control shadow-sm" name="autor" placeholder="Autor..." required>
                        </div>
                    </div>
                    <div id="pitanje1" class="border">
                        <div class="form-group p-1">
                            <label for="pitanje1"><h6>Pitanje:</h6></label>
                            <input type="text" class="form-control shadow-sm" name="pitanje1" placeholder="Pitanje..." required>
                        </div>
                        <div class="form-group p-1">
                            <label for="1odgovor1"><h6>Odgovor:</h6></label>
                            <input type="text" class="form-control shadow-sm" name="1odgovor1" placeholder="Odgovor..." required>
                        </div>
                        <div class="form-group p-1">
                            <label for="1odgovor2"><h6>Odgovor:</h6></label>
                            <input type="text" class="form-control shadow-sm" name="1odgovor2" placeholder="Odgovor..." required>
                        </div>
                        <div id="1odgovor3"></div>
                        <div id="1odgovor4"></div>
                        <div id="1odgovor5"></div>
                        <div class="form-group">
                            <input type="button" id="1" class="btn shadow bg-warning align-auto ml-1" onclick="josOdgovora()" value="Još odgovora"/>
                        </div>
                    </div>
                    
                    <div id="pitanje2" class="border border-top-0"></div>
                    <div id="pitanje3" class="border border-top-0"></div>
                    <div id="pitanje4" class="border border-top-0"></div>
                    <div id="pitanje5" class="border border-top-0"></div>
                    <div class="form-group" id="josPitanja">
                        <input type="button" class="btn shadow bg-warning align-auto" onclick="josPitanja()" value="Još pitanja"/>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn shadow bg-info align-auto" value="Dodaj anketu"/>
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

var brojPitanja = 1;
function josPitanja(){
    ++brojPitanja;
    document.getElementById("pitanje" + brojPitanja).innerHTML = '<div id="pitanje'+brojPitanja+'" class="border"><div class="form-group p-1"><label for="pitanje'+brojPitanja+'"><h6>Pitanje:</h6></label><input type="text" class="form-control shadow-sm" name="pitanje'+brojPitanja+'" placeholder="Pitanje..." required></div><div class="form-group p-1"><label for="'+brojPitanja+'odgovor1"><h6>Odgovor:</h6></label><input type="text" class="form-control shadow-sm" name="'+brojPitanja+'odgovor1" placeholder="Odgovor..." required></div><div class="form-group p-1"><label for="'+brojPitanja+'odgovor2"><h6>Odgovor:</h6></label><input type="text" class="form-control shadow-sm" name="'+brojPitanja+'odgovor2" placeholder="Odgovor..." required></div><div id="'+brojPitanja+'odgovor3"></div><div id="'+brojPitanja+'odgovor4"></div><div id="'+brojPitanja+'odgovor5"></div><div class="form-group"><input type="button" id="'+brojPitanja+'" class="btn shadow bg-warning align-auto ml-1" onclick="josOdgovora()" value="Još odgovora"/></div></div>';
    if(brojPitanja == 5){
        document.getElementById("josPitanja").style.visibility = "hidden";
    }
}

var brojOdgovora1 = 2;
var brojOdgovora2 = 2;
var brojOdgovora3 = 2;
var brojOdgovora4 = 2;
var brojOdgovora5 = 2;

function josOdgovora(){
    var idPitanja = event.srcElement.id;// dobavlja id kliknutog button-a koji istovremeno predstavlja redni broj pitanja
    ++(window['brojOdgovora' + idPitanja]);//ovako formiram jednu od varijabli brojOdgovora
    var idOdgovora = window['brojOdgovora' + idPitanja];
    var idCeo = idPitanja + "odgovor" + idOdgovora;
    var idCeoN = "'" + idPitanja + "odgovor" + idOdgovora + "'";
    document.getElementById(idCeo).innerHTML = '<div class="form-group p-1 '+idCeo+'"><label for="'+idCeo+'"><h6>Odgovor:</h6></label><div class="clearfix"><input type="text" class="form-control float-left shadow-sm" name="'+idCeo+'" style="width:85%" placeholder="Odgovor..." required><a href="#" onClick="obrisiOdgovor('+idPitanja+','+idCeoN+')"><img style="width:40px" src="../slike/obrisi.png"></a></div></div>';
    if(idOdgovora == 5){
        document.getElementById(idPitanja).style.visibility = "hidden";
    }
}
function obrisiOdgovor(idPitanja, idCeo){
    --(window['brojOdgovora' + idPitanja]);
    var parent = document.getElementById(idCeo);
    var child = document.getElementsByClassName(idCeo);
    parent.removeChild(child);
    
    /*var elem = document.getElementById(idCeo);
    return elem.parentNode.removeChild(elem);*/
}
</script>
<?php
    }
    include_once "../moduli/footerModul.php";
?>
</body>
</html>