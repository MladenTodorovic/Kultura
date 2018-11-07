<?php
$poruka = "";
include_once "moduli/loginModul.php";

include_once "moduli/brojac.php";

if(isset($_GET['kod'])){
    $kod = $_GET['kod']; //kod iz email-a za registraciju
    $vreme_prijavljivanja = date("Y-m-d H:i:s", $kod);
    mysqli_query($link, "UPDATE organizacija SET nivo='1' WHERE vreme_prijavljivanja='$vreme_prijavljivanja'");
    $poruka = '<div class="container-fluid text-white text-center"><div class="row"><div class="col-sm-3"></div><div class="col-sm-6 bg-danger"><h1>Hvala što ste se registrovali.<br/>Možete se ulogovati.</h1></div><div class="col-sm-3"></div></div></div>';
} else {

    $username = "";
    $password = "";
    $email = "";
    $naziv_organizacije = "";
    $sediste = "";
    $web_adresa = "";
    $kontakt_osoba= "";
    $oblast_delovanja = "";
    $tekst_organizacije = "";
    $telefon1 = "";
    $telefon2 = "";
    $telefon3 = "";
    $telefon4 = "";
    $telefon5 = "";
    
    
    /* promenljive nazivam po kljucu iz $_POST iz dodeljujem im setovane vrednosti iz $_POST */
    if(isset($_POST["username"])){
        foreach($_POST as $key => $value){
                $$key = $value;
        }
    }
    
    //Formiram niz telefoni od unesenih telefona. Mora da postoji najmanje jedan.
    $telefoni = array($telefon1);
    if(!empty($telefon2)){array_push($telefoni, $telefon2);}
    if(!empty($telefon3)){array_push($telefoni, $telefon3);}
    if(!empty($telefon4)){array_push($telefoni, $telefon4);}
    if(!empty($telefon5)){array_push($telefoni, $telefon5);}
    
    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["naziv_organizacije"]) && isset($_POST["sediste"]) && isset($_POST["web_adresa"]) && isset($_POST["kontakt_osoba"]) && isset($_POST["telefon1"]) && isset($_POST["oblast_delovanja"]) && isset($_POST["tekst_organizacije"])){
        
        $queryO = "INSERT INTO organizacija (username, password, email, naziv_organizacije, sediste, web_adresa, kontakt_osoba, oblast_delovanja, tekst_organizacije) VALUES ('$username', '$password', '$email', '$naziv_organizacije', '$sediste', '$web_adresa', '$kontakt_osoba', '$oblast_delovanja', '$tekst_organizacije')";
         
        if(mysqli_query($link, $queryO)){
            $id_organizacija = "SELECT id_organizacija FROM organizacija WHERE username='$username'";
            $organizacija_id_organizacija = mysqli_query($link, $id_organizacija);
            $organizacija_id_organizacijaRed = mysqli_fetch_array($organizacija_id_organizacija);
            $id_organizacija = $organizacija_id_organizacijaRed['id_organizacija'];
            
            foreach($telefoni as $telefon){
                $queryT = "INSERT INTO telefon (telefon, organizacija_id_organizacija) VALUES ('$telefon', '$id_organizacija')";
                mysqli_query($link, $queryT);
            }
        $poruka = '<div class="container-fluid text-white text-center"><div class="row"><div class="col-sm-3"></div><div class="col-sm-6 bg-danger"><h1>Kliknite na link u emailu koji smo vam poslali na unetu email adresu da bi ste uspešno završili registraciju!</h1></div><div class="col-sm-3"></div></div></div>';
        
        // kreiram kod za link u emailu za registraciju
        $vreme = mysqli_query($link, "SELECT vreme_prijavljivanja FROM organizacija WHERE username='$username'");
        $vreme = mysqli_fetch_array($vreme);
        $kod = strtotime($vreme['vreme_prijavljivanja']);
        
        include_once "mailZaRegistrovanje.php";
        
        unset($_POST);//da se na reload ne bi ponovo prijavio
    } else {
        $poruka = "Error: " . $queryO . "<br>" . mysqli_error($link);
        //$poruka = '<div class="container-fluid text-white text-center"><div class="row"><div class="col-sm-3"></div><div class="col-sm-6 bg-danger"><h1>Došlo je do greške!</h1></div><div class="col-sm-3"></div></div></div>';
    }
    }  
}
    mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
    
<?php
    include_once "moduli/bootstrapModul.php";
?>
    
    <title>Registracija</title>
</head>
<body>
<?php
    include_once "moduli/headerModul.php";
?>
    <!-- END jumbotron -->
 
<?php
    include_once "moduli/navModul.php";
?>
    <!-- END navbar -->
    
<?php
if($poruka){
    echo $poruka;
} else {
?>
<div class="container">
    <div class="row">
        <div class="col-sm-4 list-group bg-light"></div>
        <div class="col-sm-4 list-group bg-light">
    <form action="signin.php" method="POST">
        <div class="form-group">
            <h5 class="bg-warning">Obavezna polja -> <span style="color:red">&#10033;</span></h5>
            <label for="username">Korisničko ime:<span style="color:red"> &#10033;</span></label>
            <input type="text" class="form-control shadow-sm" name="username" id="username" placeholder="Korisničko ime..." value="<?php echo $username; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Lozinka:<span style="color:red"> &#10033;</span></label>
            <input type="password" class="form-control shadow-sm" name="password" id="password" placeholder="Lozinka..." value="<?php echo $password; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email adresa:<span style="color:red"> &#10033;</span></label>
            <input type="email" class="form-control shadow-sm" name="email" id="email" placeholder="Email adresa..." value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
            <label for="naziv_organizacije">Naziv organizacije:<span style="color:red"> &#10033;</span></label>
            <input type="text" class="form-control shadow-sm" name="naziv_organizacije" id="naziv_organizacije" placeholder="Naziv organizacije..." value="<?php echo $naziv_organizacije; ?>" required>
        </div>
        <div class="form-group">
            <label for="sediste">Sedište (Ulica, Broj, Mesto):<span style="color:red"> &#10033;</span></label>
            <input type="text" class="form-control  shadow-sm" name="sediste" id="sediste" placeholder="Sedište(Ulica, Broj, Mesto)..." value="<?php echo $sediste; ?>" required>
        </div>
        <div class="form-group">
            <label for="web_adresa">Web adresa:<span style="color:red"> &#10033;</span></label>
            <input type="text" class="form-control shadow-sm" name="web_adresa" id="web_adresa" placeholder="Web adresa..." value="<?php echo $web_adresa; ?>" required>
        </div>
        <div class="form-group">
            <label for="kontakt_osoba">Kontakt osoba:<span style="color:red"> &#10033;</span></label>
            <input type="text" class="form-control shadow-sm" name="kontakt_osoba" id="kontakt_osoba" placeholder="Kontakt osoba..." value="<?php echo $kontakt_osoba; ?>" required>
        </div>
        <div class="form-group">
            <label for="telefon1">Kontakt telefon:<span style="color:red"> &#10033;</span></label>
            <input type="text" class="form-control shadow-sm" name="telefon1" id="telefon1" placeholder="Kontakt telefon..." value="<?php echo $telefon1; ?>" required>
        </div>
        
<!-- Script kreira novo polje za unos telefona u divu sa id=telefon. Moze da se unese maksimalno 5 telefona. Nije bas najelegantnije resenje.-->
        <div class="form-group" id="telefon2"></div>
        <div class="form-group" id="telefon3"></div>
        <div class="form-group" id="telefon4"></div>
        <div class="form-group" id="telefon5"></div>

        <div class="form-group" id="dodajTelefon">
            <input type="button" class="btn bg-warning shadow align-auto" onclick="dodajTelefon()" value="Još telefona"/>
        </div>

        <div class="form-group">
            <label for="oblast_delovanja">Oblast delovanja:<span style="color:red"> &#10033;</span></label>
            <input type="text" class="form-control shadow-sm" name="oblast_delovanja" id="oblast_delovanja" placeholder="Oblast delovanja..." value="<?php echo $oblast_delovanja; ?>" required>
        </div>
        <div class="form-group">            
            <label for="tekst_organizacije">Tekst o organizaciji:<span style="color:red"> &#10033;</span></label>
            <textarea rows="10" cols="30" class="form-control shadow-sm" id="tekst_organizacije" name="tekst_organizacije" required>Tekst o organizaciji...</textarea>
        </div>
        <button type="submit" class="btn btn-info shadow">Prijavi se</button>
    </form>
        </div>
    <div class="col-sm-4 list-group bg-light"></div>
    </div>
</div>
<?php
}
    include_once "moduli/footerModul.php";
?>
    
<script>
    var brojPolja = 1;
    function dodajTelefon(){
        ++brojPolja;
        document.getElementById("telefon" + brojPolja).innerHTML = '<label for="tel' + brojPolja + '">Kontakt telefon ' + brojPolja + ':</label><br/><input type="text" class="form-control" name="telefon' + brojPolja + '" id="tel' + brojPolja + '" placeholder="Kontakt telefon ' + brojPolja + '...">';
        if(brojPolja == 5){
            document.getElementById("dodajTelefon").style.visibility = "hidden";
        }
    }
</script>
</body>
</html>