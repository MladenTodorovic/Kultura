<?php
$user = "";
$uri = $_SERVER["REQUEST_URI"];
$link = mysqli_connect("localhost", "root", "", "kultura")
        or die ("Greska prilikom konekcije na bazu!");
mysqli_set_charset($link,"utf8");
$porukaU = "";
$porukaP = "";

if(isset($_POST["user"])){
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    $organizacija = mysqli_query($link, "SELECT * FROM organizacija WHERE username='$user'");        
    $admin = mysqli_query($link, "SELECT * FROM admin WHERE username='$user'");
    $organizacijaRed = mysqli_fetch_array($organizacija);
    $nivo = $organizacijaRed['nivo'];
    $adminRed = mysqli_fetch_array($admin);
    $passO = $organizacijaRed['password'];
    $passA = $adminRed['password'];

    if($nivo == '0'){
        $poruka = '<div class="container-fluid text-white text-center"><div class="row"><div class="col-sm-3"></div><div class="col-sm-6 bg-danger"><h1>Da bi ste se ulogovali morate kliknuti na link koji vam je poslat emailom!</h1></div><div class="col-sm-3"></div></div></div>';
        
    }elseif(mysqli_num_rows($organizacija) > 0 && $pass == $passO && $nivo > 0){
        session_start();

        //postavljam sve podatke iz organizacije u $_SESSION
        foreach($organizacijaRed as $kolona => $podatak){
            $_SESSION[$kolona] = $podatak;
        }
        header ("Location: organizacija/organizacija.php");
        
    } elseif(mysqli_num_rows($admin) > 0 && $pass == $passA){
        session_start();
        $_SESSION['user'] = $user;
        header ("Location: admin/admin.php");
        
    } elseif((mysqli_num_rows($organizacija) > 0 || mysqli_num_rows($admin) > 0) && ($pass != $passO || $pass != $passA)){
        $porukaP = "Pogresno ste uneli vašu lozinku.";
        $porukaU = "";
        
    } else {
        $user = "";
        $porukaP = "";
        $porukaU = "Pogresno ste uneli vase korisničko ime.";
    }
}