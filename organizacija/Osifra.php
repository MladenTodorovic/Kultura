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

$kategorija_sifre = "";

if(isset($_POST['kategorija_sifre'])){
    $kategorija_sifre = $_POST['kategorija_sifre'];
    $sifre = mysqli_query($link,"SELECT * FROM sifarnik WHERE kategorija_sifre = '$kategorija_sifre'");
    if(mysqli_num_rows($sifre)===0){
        $query = "INSERT INTO sifarnik (kategorija_sifre) VALUES ('$kategorija_sifre')";
        mysqli_query($link, $query);
        unset($_POST);//unsetujemo POST da se na reload ne bi ponovo upisali isti podaci
    } elseif(mysqli_num_rows($sifre)==1){
        $porukaS = 'Šifra "'.$kategorija_sifre.'" već postoji!';
    } else {
        $porukaS = "Došlo je do greške u bazi!";
    }
}


$organizacija = mysqli_query($link, "SELECT * FROM organizacija WHERE username='$username'");
$podaci = mysqli_fetch_array($organizacija);

    $id_organizacija = $podaci['id_organizacija'];
    $_SESSION['id_organizacija'] = $id_organizacija;
    
    $sifre = mysqli_query($link, "SELECT * FROM sifarnik");
    $stavke = mysqli_query($link, "SELECT * FROM stavka_sifarnik");
    
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
                <a class="text-warning" style="display: flex; justify-content: center;" href="profil.php"><b>Vaš profil</b></a>
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
            </ul>
        </div>
    </nav>
    <!-- END navbar -->

    <div class="container">
        <div class="row">
            <div class="col-sm-3 list-group bg-light"></div>
            <div class="col-sm-6 list-group bg-light">
                <form action="Osifra.php" method="POST">
                    <div class="form-group">
                        <label for="kategorija_sifre"><h6>Kategorija šifre:</h6></label>
                        <input type="text" class="form-control shadow-sm" name="kategorija_sifre" id="kategorija_sifre" placeholder="Kategorija šifre" value="" required>
                    </div>               
                    <button type="submit" class="btn shadow btn-info" style="margin-botom:100px;">Unesi novu šifru</button><br/>
                </form>
                <br/>
                
<?php
if(isset($porukaS)){
    echo "<h4 class='text-danger'>" . $porukaS."</h4>";
}
if($poruka){
    echo $poruka;
} else {
    echo "<div class='list-group-item list-group-item-action shadow bg-secondary text-white'><div class='d-flex'><h4><u>Odobrene šifre:</u></h4></div></div>";
    while($sifra = mysqli_fetch_array($sifre)){
        mysqli_data_seek($stavke, 0);
        $id_sifra = $sifra['id_sifra'];
        if($sifra['odobreno'] == 1){
            echo "<div class='list-group-item list-group-item-action shadow'>
                    <div class='d-flex'>
                        <div class='dropdown mr-auto'>
                            <button type='button' class='btn btn-warning dropdown-toggle' data-toggle='dropdown'>" . $sifra['kategorija_sifre'] . "                        </button><div class='dropdown-menu'>";
            while($stavka = mysqli_fetch_array($stavke)){
                $sifarnik_id_sifra = $stavka['sifarnik_id_sifra'];
                if($id_sifra == $sifarnik_id_sifra){
                    echo "<a class='dropdown-item' href='#'>". $stavka['stavka'] ."</a>";
                }
            }
            echo '</div></div><a href="dodajStavku.php?id=' . $id_sifra . '&kategorija_sifre=' . $sifra['kategorija_sifre'] . '" class="btn btn-info" role="button">Dodaj stavku</a></div></div>';
        }
    }
}
?>
                  
<?php 
if($poruka){

} else {
    echo "<div class='list-group-item list-group-item-action shadow bg-secondary text-white'><div class='d-flex'><h4><u>Šifre koje čekaju odobrenje:</u></h4></div></div>";
    mysqli_data_seek($sifre, 0);
    while($sifra = mysqli_fetch_array($sifre)){
        mysqli_data_seek($stavke, 0);
        $id_sifra = $sifra['id_sifra'];
        if($sifra['odobreno'] == 0){
            echo "<div class='list-group-item list-group-item-action shadow'>
                    <div class='d-flex'>
                        <div class='dropdown mr-auto'>
                            <button type='button' class='btn btn-warning dropdown-toggle' data-toggle='dropdown'>" . $sifra['kategorija_sifre'] . "                        </button><div class='dropdown-menu'>";
            while($stavka = mysqli_fetch_array($stavke)){
                $sifarnik_id_sifra = $stavka['sifarnik_id_sifra'];
                if($id_sifra == $sifarnik_id_sifra){
                    echo "<a class='dropdown-item' href='#'>". $stavka['stavka'] ."</a>";
                }
            }
            echo '</div></div><a href="dodajStavku.php?id=' . $id_sifra . '&kategorija_sifre=' . $sifra['kategorija_sifre'] . '" class="btn btn-info" role="button">Dodaj stavku</a></div></div>';
        }
    }
}
?>
            </div>
            <div class="col-sm-3 list-group bg-light"></div>
        </div>
    </div>

<?php
include_once "../moduli/footerModul.php";
?>
</body>
</html>
