<?php
session_start();
if(!isset($_SESSION['username'])){
        header("location: ../greska.php");
    }
    
$link = mysqli_connect("localhost", "root", "", "kultura")
            or die ("Greska prilikom konekcije na bazu!");
mysqli_set_charset($link,"utf8");

$telefoni = mysqli_query($link, "SELECT * FROM telefon WHERE organizacija_id_organizacija = {$_SESSION['id_organizacija']}");

$vesti = mysqli_query($link, "SELECT * FROM vest WHERE organizacija_id_organizacija={$_SESSION['id_organizacija']} ORDER BY vreme_postavljanja ASC");

$ankete = mysqli_query($link, "SELECT * FROM anketa WHERE organizacija_id_organizacija = {$_SESSION['id_organizacija']} ORDER BY vreme_postavljanja ASC");

$poruka = "";
    
// search polje sa upitom za dogadjaje ne treba ali neka stoji :o)
/*
if(!isset($_GET['search'])){
    $dogadjaji = mysqli_query($link, "SELECT * FROM dogadjaj d, organizacija o WHERE d.vreme_isticanja > CURDATE() AND d.organizacija_id_organizacija=o.id_organizacija ORDER BY d.vreme_dogadjaja ASC");
} else {
    $search = trim($_GET['search']);
    if(!empty($search)){
        $dogadjaji = mysqli_real_escape_string($link, $search);
        $query = "SELECT * FROM dogadjaj d, organizacija o WHERE d.naslov LIKE '%{$search}%'";
        $dogadjaji = mysqli_query($link, $query);
        if(mysqli_num_rows($dogadjaji) == 0){
        $poruka = "Nema rezultata pretrage.";
        }
    }else{
        $poruka = "Kriterijum ne sme biti prazan.";
    }
}
*/
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

<div class="container">
    <div class="row">
    <!-- deo za podatke o organizaciji -->
    <div class="col-sm-4 list-group bg-light">
    <?php 
    if(!isset($_GET['search'])){
        if($poruka){
            echo $poruka;
        } else {
            echo "<div class='list-group-item list-group-item-action shadow'><h6>Naziv: ". $_SESSION['naziv_organizacije']. "</h6></div><br/>";
            echo "<div class='list-group-item list-group-item-action shadow'><h6>Sedište: " . $_SESSION['sediste']."</h6></div><br/>";
            echo "<div class='list-group-item list-group-item-action shadow'><h6>Kontakt osoba: " . $_SESSION['kontakt_osoba']."</h6></div><br/>";
            echo "<div class='list-group-item list-group-item-action shadow'><h6>Telefoni: "; while($telefon = mysqli_fetch_array($telefoni)){
                    echo $telefon['telefon']. " &nbsp";
            }
            echo "</h6></div><br/>";
            echo "<div class='list-group-item list-group-item-action shadow'><h6>Email: " . $_SESSION['email']."</h6></div><br/>";
            echo "<div class='list-group-item list-group-item-action shadow'><h6>Oblast delovanja: " . $_SESSION['oblast_delovanja']."</h6></div><br/>";
            echo "<div class='list-group-item list-group-item-action shadow'><h6>".$_SESSION['tekst_organizacije']."</h6></div><br/>";
        } 
    } else {
        if($poruka){
            echo $poruka;
        } else {
            while($dogadjaj = mysqli_fetch_array($dogadjaji))
                echo "<div class='list-group-item list-group-item-action'><div class='d-flex'>" . $dogadjaj['vreme_dogadjaja']." &nbsp; <a href='dogadjajVise.php?id=" . $dogadjaj['id_dogadjaj'] . "'>" . $dogadjaj['naslov']."</a> <div class='ml-auto'>Organizator: <a href='podaciOrganizacija.php?id=" . $dogadjaj['id_organizacija'] . "'>" . $dogadjaj['naziv_organizacije'] . "</a></div></div></div><br/>";
        }
    }
    ?>
    </div>
    <!-- END podaci o organizaciji -->
    
    <!-- deo za vesti -->
    <div class="col-sm-4 list-group bg-light">
    <?php
    if ($poruka) {
        echo $poruka;
    } else {
        while($vest = mysqli_fetch_array($vesti))
            echo "<div class='list-group-item list-group-item-action shadow'><div class='d-flex'>" . $vest['vreme_postavljanja'] . " &nbsp; <a href='vestVise.php?id=" . $vest['id_vest'] . "'>" . $vest['naslov'] . "</a><div class='ml-auto'><h6>Autor: </h6>" . $vest['autor'] . "</div></div></div><br/>";
    }
    ?>
    </div>
    <!-- deo za ankete -->
    <div class="col-sm-4 list-group bg-light">
    <?php
    if($poruka){
    echo $poruka;
} else {
    while($anketa = mysqli_fetch_array($ankete)){
        echo "<div class='list-group-item list-group-item-action shadow'><div class='d-flex'>" . $anketa['vreme_postavljanja']." &nbsp; <a href='OanketaVise.php?id=" . $anketa['id_anketa'] . "'>" . $anketa['naslov']."</a></div></div><br/>";
    }
}
    ?>
    </div>
</div>
</div>
<?php
    include_once "../moduli/footerModul.php";
?>
</body>
</html>
