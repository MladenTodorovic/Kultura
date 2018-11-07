<?php
    $poruka = "";
    include_once "moduli/loginModul.php";
    
    include_once "moduli/brojac.php";
    
    if(!isset($_GET['search'])){
        if(isset($_GET['id'])){
            $id = trim($_GET['id']);
            $id = mysqli_real_escape_string($link, $id);
            $oglas = mysqli_query($link, "SELECT * FROM oglas WHERE id_oglas = {$id}");
            if(mysqli_num_rows($oglas) != 1){
                $poruka = "Greška: Nema traženog oglasa.";
            } else {
            $oglas = mysqli_fetch_array($oglas);
            }
        }
    } else {
        $search = trim($_GET['search']);
	if(!empty($search)){
            $search = mysqli_real_escape_string($link, $search);
            $query = "SELECT * FROM oglas og, organizacija o WHERE og.organizacija_id_organizacija=o.id_organizacija AND og.naslov LIKE '%{$search}%'";
            $oglasi = mysqli_query($link, $query);
            if(mysqli_num_rows($oglasi) == 0){
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

    <title><?php echo $oglas['naslov']; ?></title>
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
        echo "<div class='list-group-item list-group-item-action shadow'><h2>". $oglas['naslov']. "</h1></div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h5>Vreme održavanja: " . $oglas['vreme_postavljanja']."</h5></div><br/>";
        echo "<img src='slike/oglasi/oglas_" . $oglas['id_oglas'] . ".jpg'>";
        echo "<div class='list-group-item list-group-item-action shadow'>".$oglas['tekst']."</div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h5>Autor: " . $oglas['autor']."</h5></div><br/>";
    }
} else {
    if($poruka){
        echo $poruka;
    } else {
        while($oglas = mysqli_fetch_array($oglasi))
            echo "<div class='list-group-item list-group-item-action'><div class='d-flex'>" . $oglas['vreme_postavljanja']." &nbsp; <a href='oglasVise.php?id=" . $oglas['id_oglas'] . "'>" . $oglas['naslov']."</a> <div class='ml-auto'>Autor: " . $oglas['autor'] . "</div></div></div><br/>";
    }
}
?>

</div>

<?php
    include_once "moduli/footerModul.php";
?>
</body>
</html>