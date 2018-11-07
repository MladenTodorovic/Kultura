<?php
    $poruka = "";
    include_once "moduli/loginModul.php";
    
    include_once "moduli/brojac.php";
    
    
    $podaci_o_sajtu = mysqli_query($link, "SELECT * FROM podaci_o_sajtu");
    $podaci_o_sajtu = mysqli_fetch_array($podaci_o_sajtu);
    $kontakt_osoba = $podaci_o_sajtu['kontakt_osoba'];
    $email = $podaci_o_sajtu['email'];
    $telefon1 = $podaci_o_sajtu['telefon1'];
    $telefon2 = $podaci_o_sajtu['telefon2'];
    $telefon3 = $podaci_o_sajtu['telefon3'];
    
    mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
    
<?php
    include_once "moduli/bootstrapModul.php";
?>
    
    <title>Kontakt</title>
</head>
<body>
<?php
    include_once "moduli/headerModul.php";
?>
    <!-- END jumbotron -->
 
<nav class="navbar navbar-expand-md bg-secondary navbar-dark sticky-top">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav align-content-center mx-auto">
            <li class="nav-item flex-fill">
                <a class="nav-link text-warning active" href="index.php">Događaji</a>
            </li>
            <li class="nav-item flex-fill">
                <a class="nav-link text-warning" href="vesti.php">Vesti</a>
            </li>
            <li class="nav-item flex-fill">
                <a class="nav-link text-warning" href="oglasi.php">Oglasi</a>
            </li>
            <li class="nav-item flex-fill">
                <a class="nav-link text-warning" href="ankete.php">Ankete</a>
            </li>
    </ul>
  </div>
</nav>
    <!-- END navbar -->
<div class="container">
    <div class="row">
        <div class="col-sm-4 list-group bg-light"></div>
<div class="col-sm-4 list-group bg-light">
<?php 
    echo "<div class='list-group-item list-group-item-action shadow'><h6>Kontakt osoba: " .$kontakt_osoba. "</h6></div><br/>";
    echo "<div class='list-group-item list-group-item-action shadow'><h6>email: " .$email. "</h6></div><br/>";
    echo "<div class='list-group-item list-group-item-action shadow'><h6>Telefoni: <br/>" .$telefon1."<br/>".$telefon2."<br/>".$telefon3. "</h6></div><br/>";    
?>
        </div>
        <div class="col-sm-4 list-group bg-light"></div>
    </div>
</div>
    <!-- END podaci o sajtu -->

<?php
    include_once "moduli/footerModul.php";
?>
</body>
</html>
