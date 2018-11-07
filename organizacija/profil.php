<?php
session_start();
$poruka = "";
if(!isset($_SESSION['username'])) {
    header("location: ../greska.php");
}
$link = mysqli_connect("localhost", "root", "", "kultura")
        or die("Greska prilikom konekcije na bazu!");
mysqli_set_charset($link, "utf8");

$username = $_SESSION['username'];

$organizacija = mysqli_query($link, "SELECT * FROM organizacija WHERE username='$username'");
$podaci = mysqli_fetch_array($organizacija);

    $id_organizacija = $podaci['id_organizacija'];
    $_SESSION['id_organizacija'] = $id_organizacija;
    
    $email = $podaci['email'];
    $naziv_organizacije = $podaci['naziv_organizacije'];
    $sediste = $podaci['sediste'];
    $web_adresa = $podaci['web_adresa'];
    $kontakt_osoba= $podaci['kontakt_osoba'];
    $oblast_delovanja = $podaci['oblast_delovanja'];
    $tekst_organizacije = $podaci['tekst_organizacije'];

$telefoni = mysqli_query($link, "SELECT telefon FROM telefon WHERE organizacija_id_organizacija = '$id_organizacija'");
    
    $brojTelefona = mysqli_affected_rows($link);//broji redove pogodjene prethodnim upitom
    $telefon1 = mysqli_fetch_array($telefoni)[0];
    $telefon2 = mysqli_fetch_array($telefoni)[0];
    $telefon3 = mysqli_fetch_array($telefoni)[0];
    $telefon4 = mysqli_fetch_array($telefoni)[0];
    $telefon5 = mysqli_fetch_array($telefoni)[0];
    
mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>

<?php
include_once "../moduli/bootstrapModul.php";
?>

    <title><?php echo $_SESSION['naziv_organizacije']; ?></title>
</head>
<body>
    <!-- JUMBOTRON -->
    <div class="container-fluid bg-info">
        <div class="row">
            <h1 class="col-sm-9" style="display: flex; justify-content: center; align-items: center;">Organizacija kulturnih događaja</h1>
            <div class="col-sm-3 border border-warning" style="align-items: center; padding-top:15px">
                <a class="text-warning" style="display: flex; justify-content: center;" href="../logout.php"><b>Izloguj se</b></a>
                <a class="text-warning" style="display: flex; justify-content: center;" href="../profil.php"><b>Vaš profil</b></a>
            </div>
        </div>
    </div>
    <!-- END jumbotron -->

    <!-- NAVBAR -->
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

    <div class="container">
        <div class="row">
            <div class="col-sm-3 list-group bg-light"></div>
            <div class="col-sm-6 list-group bg-light">
                <form action="izmeniProfil.php" method="POST">
                    <div class="form-group">
                        <label for="email"><h6>Email adresa:</h6></label>
                        <input type="email" class="form-control shadow-sm" name="email" id="email" placeholder="Email adresa..." value="<?php echo $email; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="naziv_organizacije"><h6>Naziv organizacije:</h6></label>
                        <input type="text" class="form-control shadow-sm" name="naziv_organizacije" id="naziv_organizacije" placeholder="Naziv organizacije..." value="<?php echo $naziv_organizacije; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="sediste"><h6>Sedište (Ulica, Broj, Mesto):</h6></label>
                        <input type="text" class="form-control shadow-sm" name="sediste" id="sediste" placeholder="Sedište(Ulica, Broj, Mesto)..." value="<?php echo $sediste; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="web_adresa"><h6>Web adresa:</h6></label>
                        <input type="text" class="form-control shadow-sm" name="web_adresa" id="web_adresa" placeholder="Web adresa..." value="<?php echo $web_adresa; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kontakt_osoba"><h6>Kontakt osoba:</h6></label>
                        <input type="text" class="form-control shadow-sm" name="kontakt_osoba" id="kontakt_osoba" placeholder="Kontakt osoba..." value="<?php echo $kontakt_osoba; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telefon1"><h6>Kontakt telefoni:</h6></label>
                        <input type="text" class="form-control shadow-sm" name="telefon1" id="telefon1" value="<?php echo $telefon1; ?>" required>
                    </div>
<?php if(isset($telefon2)){
            echo '<div class="form-group">
                    <div class="clearfix">
                        <input type="text" class="form-control float-left shadow-sm" name="telefon2" style="width:85%" id="telefon2" value="'.$telefon2.'">
                        <a href="brisanjeTelefona.php?telefon='.$telefon2.'"><img style="width:40px" src="../slike/obrisi.png"></a>   
                     </div>
                    </div>';
      }
      if(isset($telefon3)){
            echo '<div class="form-group">
                    <div class="clearfix">
                        <input type="text" class="form-control float-left shadow-sm" name="telefon3" style="width:85%" id="telefon3" value="'.$telefon3.'">
                        <a href="brisanjeTelefona.php?telefon='.$telefon3.'"><img style="width:40px" src="../slike/obrisi.png"></a>   
                     </div>
                    </div>';
      }
      if(isset($telefon4)){
            echo '<div class="form-group">
                    <div class="clearfix">
                        <input type="text" class="form-control float-left shadow-sm" name="telefon4" style="width:85%" id="telefon4" value="'.$telefon4.'">
                        <a href="brisanjeTelefona.php?telefon='.$telefon4.'"><img style="width:40px" src="../slike/obrisi.png"></a>   
                     </div>
                    </div>';
      }
      if(isset($telefon5)){
            echo '<div class="form-group">
                    <div class="clearfix">
                        <input type="text" class="form-control float-left shadow-sm" name="telefon5" style="width:85%" id="telefon5" value="'.$telefon5.'">
                        <a href="brisanjeTelefona.php?telefon='.$telefon5.'"><img style="width:40px" src="../slike/obrisi.png"></a>   
                     </div>
                    </div>';
      }
?>                   
<!-- Script kreira novo polje za unos telefona u divu sa id=telefon. Moze da se unese maksimalno 5 telefona. Nije bas najelegantnije resenje.-->
        <div class="form-group" id="telefon2"></div>
        <div class="form-group" id="telefon3"></div>
        <div class="form-group" id="telefon4"></div>
        <div class="form-group" id="telefon5"></div>
        <div class="form-group" id="dodajTelefon">
            <input type="button" class="btn shadow bg-warning align-auto" onclick="dodajTelefon()" value="Još telefona"/>
        </div>
        

                    <div class="form-group">
                        <label for="oblast_delovanja"><h6>Oblast delovanja:</h6></label>
                        <input type="text" class="form-control shadow-sm" name="oblast_delovanja" id="oblast_delovanja" placeholder="Oblast delovanja..." value="<?php echo $oblast_delovanja; ?>" required>
                    </div>
                    <div class="form-group">            
                        <label for="tekst_organizacije"><h6>Tekst o organizaciji:</h6></label>
                        <textarea rows="10" cols="30" class="form-control shadow-sm" id="tekst_organizacije" name="tekst_organizacije" required><?php echo $tekst_organizacije; ?></textarea>
                    </div>
                    <button type="submit" class="btn shadow btn-info" style="margin-botom:100px;">Izmeni podatke</button><br/>
                </form>
            </div>
            <div class="col-sm-3 list-group bg-light"></div>
        </div>
    </div>

<?php
include_once "../moduli/footerModul.php";
?>
<script>
    var brojPolja = <?php echo $brojTelefona; ?>;
    function dodajTelefon(){
        ++brojPolja;
        document.getElementById("telefon" + brojPolja).innerHTML = '<label for="tel' + brojPolja + '">Kontakt telefon ' + brojPolja + ':</label><br/><input type="text" class="form-control shadow-sm" name="telefon' + brojPolja + '" id="tel' + brojPolja + '" placeholder="Kontakt telefon ' + brojPolja + '...">';
        if(brojPolja == 5){
            document.getElementById("dodajTelefon").style.visibility = "hidden";
        }
    }
</script>
</body>
</html>
