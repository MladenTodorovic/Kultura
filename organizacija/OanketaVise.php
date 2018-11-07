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

$id_anketa = trim($_GET['id']);
$_SESSION['id'] = $id_anketa;
$id_anketa = mysqli_real_escape_string($link, $id_anketa);

/*$ankete = mysqli_query($link, "SELECT * FROM odgovori LEFT JOIN pitanja ON odgovori.pitanja_id_pitanja=pitanja.id_pitanja LEFT JOIN anketa ON pitanja.anketa_id_anketa=anketa.id_anketa WHERE id_anketa = '$id_anketa' AND organizacija_id_organizacija = {$_SESSION['id_organizacija']}");*/

$ankete = mysqli_query($link, "SELECT * FROM anketa WHERE id_anketa = '$id_anketa' AND organizacija_id_organizacija = {$_SESSION['id_organizacija']}");
if(mysqli_num_rows($ankete) != 1){
    $poruka = "Greška: Nema tražene ankete.";
} else {
    $pitanja = mysqli_query($link, "SELECT * FROM pitanja WHERE anketa_id_anketa = '$id_anketa'");
    $anketa = mysqli_fetch_array($ankete);
    $naslov = $anketa['naslov'];
    $vreme_postavljanja = $anketa['vreme_postavljanja'];
    $vreme_isticanja = $anketa['vreme_isticanja'];
    $autor = $anketa['autor'];
    
    if($vreme_postavljanja < date("Y-m-d h:i:s")){
        $button = "<h4 class='text-danger'>Anketa je već počela, tako da ne može biti menjana!</h4>";
    } else {
        $button = '<button type="submit" class="btn shadow btn-info" style="margin-botom:100px;">Izmeni anketu</button>';
    }
        
}

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
    <title><?php if(isset($anketa['naslov'])){
                    echo $anketa['naslov']; 
                   } else {
                       echo "Ankete";
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
                <a class="nav-link text-warning" href="OAnkete.php">Ankete</a>
            </li>
            <li class="nav-item flex-fill">
                <a class="nav-link text-warning" href="dodajAnketu.php">Dodaj anketu</a>
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
                <form action="izmeniAnketu.php" method="POST">
                    <div class="form-group">
                        <label for="naslov"><h6>Naslov ankete:</h6></label>
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
                        <label for="autor"><h6>Autor:</h6></label>
                        <input type="text" class="form-control shadow-sm" name="autor" id="autor" value="<?php echo $autor; ?>" required>
                    </div>
                    <div class="form-group">
                        <?php 
                        while($pitanje = mysqli_fetch_array($pitanja)){
                            $id_pitanja = $pitanje['id_pitanja'];
                            $odgovori = mysqli_query($link, "SELECT * FROM odgovori WHERE pitanja_id_pitanja = '$id_pitanja'");
                            echo '<label for="pitanje"><h6>Pitanje:</h6></label><input type="text" class="form-control shadow-sm" name="pitanje" id="pitanje" value="'.$pitanje["pitanje"].'" required><br/><label for="odgovor"><h6>Ponuđeni odgovori:</h6></label>';
                            while($odgovor = mysqli_fetch_array($odgovori)){
                                echo '<input type="text" class="form-control shadow-sm" name="odgovor" id="odgovor" value="'.$odgovor["odgovor"].'" required><br/>';   
                            }
                            echo '<span class="border-top my-3"></span>';
                        }
                        ?>
                    </div>
                    <?php echo $button; ?>
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
</script>
<?php
    }
    include_once "../moduli/footerModul.php";
    mysqli_close($link);
?>
</body>
</html>