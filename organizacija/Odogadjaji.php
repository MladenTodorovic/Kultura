<?php
session_start();
if(!isset($_SESSION['username'])){
        header("location: ../greska.php");
    }
    
$link = mysqli_connect("localhost", "root", "", "kultura")
            or die ("Greska prilikom konekcije na bazu!");
mysqli_set_charset($link,"utf8");

$poruka = "";

$dogadjaji = mysqli_query($link, "SELECT * FROM dogadjaj WHERE organizacija_id_organizacija={$_SESSION['id_organizacija']} ORDER BY vreme_dogadjaja ASC");
    
    mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
    
<?php
    include_once "../moduli/bootstrapModul.php";
?>

    <style>
        #one {
            position:relative;
            display:block;
        }
        #two {
            position:absolute;
            width:200px;
            height:30px;
            display:none;
            color:red;
        }
        #one:hover #two {
            display:block;
            left:10px;
        }
    </style>
    
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
                <a class="nav-link text-warning active" href="dodajDogadjaj.php">Dodaj događaj</a>
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
    while($dogadjaj = mysqli_fetch_array($dogadjaji)){
        if($dogadjaj['vreme_isticanja'] < date("Y-m-d h:i:s")){
            $arhiva = "<div class='ml-auto text-danger'>Arhiviran</div>";
        } else {
            $arhiva = "<div class='ml-auto text-success'>Aktuelan</div>";
        }
        if($dogadjaj['brisanje'] == 1){
            $brisanje = '<div id="one"><a href="zatraziBrisanje.php?id_dogadjaj='.$dogadjaj['id_dogadjaj'].'"><img style="width:25px" src="../slike/obrisi.png"><div id="two">Zatraži brisanje</div></a></div>';
        } elseif($dogadjaj['brisanje'] == 0){
            $brisanje = '<div id="one"><img style="width:25px" src="../slike/tacno.png"><div id="two">Čeka se brisanje od administratora</div></a></div>';
        } else {
            $brisanje = '<div id="one"><img style="width:25px" src="../slike/uzvicnik.png"><div id="two">Došlo je do greške!</div></a></div>';
        }
        echo "<div class='list-group-item list-group-item-action shadow'><div class='d-flex'>" . $dogadjaj['vreme_dogadjaja']." &nbsp; <a href='OdogadjajVise.php?id=" . $dogadjaj['id_dogadjaj'] . "'>" . $dogadjaj['naslov']."</a>" . $arhiva. " &nbsp;" . $brisanje."</div></div><br/>";
    }
}
?>

</div>
<?php
    include_once "../moduli/footerModul.php";
?>
</body>
</html>
