<?php
    $poruka = "";
    include_once "moduli/loginModul.php";
    
    include_once "moduli/brojac.php";
    
    if(!isset($_GET['search'])){
        if(isset($_GET['id'])){
            $id = trim($_GET['id']);
            $id = mysqli_real_escape_string($link, $id);
            $dogadjaji = mysqli_query($link, "SELECT * FROM dogadjaj WHERE id_dogadjaj = {$id}");
            if(mysqli_num_rows($dogadjaji) != 1){
                $poruka = "Greška: Nema traženog događaja.";
            } else {
            $dogadjaj = mysqli_fetch_array($dogadjaji);
            }
        }
    } else {
        $search = trim($_GET['search']);
	if(!empty($search)){
            $search = mysqli_real_escape_string($link, $search);
            $query = "SELECT * FROM dogadjaj d, organizacija o WHERE d.organizacija_id_organizacija=o.id_organizacija AND d.naslov LIKE '%{$search}%'";
            $dogadjaji = mysqli_query($link, $query);
            if(mysqli_num_rows($dogadjaji) == 0){
            $poruka = "Nema rezultata pretrage.";
            }
	}else{
            $poruka = "Kriterijum ne sme biti prazan.";
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

    <title><?php if($dogadjaj['naslov']){
                    echo $dogadjaj['naslov']; 
                   } else {
                       echo "Događaji";
                   }
            ?></title>
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

<div class="container list-group bg-light">
<?php
if(!isset($_GET['search'])){
    if($poruka){
        echo $poruka;
    } else {
        echo "<div class='list-group-item list-group-item-action shadow'><h2>". $dogadjaj['naslov']. "</h1></div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h5>Mesto održavanja: " . $dogadjaj['mesto']."</h5></div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h5>Vreme održavanja: " . $dogadjaj['vreme_dogadjaja']."</h5></div><br/>";
        echo "<img src='slike/dogadjaji/dogadjaj_" . $dogadjaj['id_dogadjaj'] . ".jpg'>";
        echo "<div class='list-group-item list-group-item-action shadow'>".$dogadjaj['tekst']."</div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h5>Autor: " . $dogadjaj['autor']."</h5></div><br/>";
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

<?php
    include_once "moduli/footerModul.php";
?>
</body>
</html>