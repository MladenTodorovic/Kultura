<?php
    $poruka = "";
    include_once "moduli/loginModul.php";
    
    include_once "moduli/brojac.php";
    
    if(!isset($_GET['search'])){
        if(isset($_GET['id'])){
            $id = trim($_GET['id']);
            $id = mysqli_real_escape_string($link, $id);
            $organizacije = mysqli_query($link, "SELECT * FROM organizacija WHERE id_organizacija = {$id}");
            $telefoni = mysqli_query($link, "SELECT * FROM telefon WHERE organizacija_id_organizacija = {$id}");
            if(mysqli_num_rows($organizacije) != 1){
                $poruka = "Greška: Nema tražene organizacije.";
            } else {
            $organizacija = mysqli_fetch_array($organizacije);
            }
        }
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
    mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
    
<?php
    include_once "moduli/bootstrapModul.php";
?>

    <title><?php echo $organizacija['naziv_organizacije'];?></title>
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
        echo "<div class='list-group-item list-group-item-action shadow'><h2>". $organizacija['naziv_organizacije']. "</h1></div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h5>Sedište: " . $organizacija['sediste']."</h5></div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h5>Kontakt osoba: " . $organizacija['kontakt_osoba']."</h5></div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h5>Telefoni: "; while($telefon = mysqli_fetch_array($telefoni)){
                echo $telefon['telefon']. " &nbsp";
        }
        echo "</h5></div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h5>Email: " . $organizacija['email']."</h5></div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h5>Oblast delovanja: " . $organizacija['oblast_delovanja']."</h5></div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h6>".$organizacija['tekst_organizacije']."</h6></div><br/>";
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