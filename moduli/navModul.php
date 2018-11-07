<?php
if((basename($_SERVER['PHP_SELF']) == "index.php") OR (basename($_SERVER['PHP_SELF']) == "dogadjajVise.php")){
    $placeholder = "Događaji...";
} elseif((basename($_SERVER['PHP_SELF']) == "vesti.php") OR (basename($_SERVER['PHP_SELF']) == "vestVise.php")){
    $placeholder = "Vesti...";
} elseif((basename($_SERVER['PHP_SELF']) == "oglasi.php") OR (basename($_SERVER['PHP_SELF']) == "oglasVise.php")){
    $placeholder = "Oglasi...";
} else {
    $placeholder = "Ankete...";
}
echo '<nav class="navbar navbar-expand-md bg-secondary navbar-dark sticky-top">
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
            <li class="nav-item flex-fill">
                <a class="nav-link text-warning" href="kontakt.php">Kontakt</a>
            </li>';

if((basename($_SERVER['PHP_SELF']) == "signin.php") OR (basename($_SERVER['PHP_SELF']) == "reset.php") OR (basename($_SERVER['PHP_SELF']) == "podaciOrganizacija.php")){
    // Nema search polja na signin i reset strani
} else {
       echo '<li class="nav-item flex-fill">
                <form class="form-inline" method="GET" action="'.$_SERVER['PHP_SELF'].'">
                <input type="text" name="search" class="form-control input-lg" placeholder="' . $placeholder . '"/>
                <span class="input-group-btn">
                    <button class="btn btn-warning text-white" type="submit">Pretraži</button>
                </span>
                </form>
            </li>';
}

echo '</ul></div></nav>';