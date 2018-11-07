<?php
    $poruka = "";
    include_once "moduli/loginModul.php";
    
    include_once "moduli/brojac.php";
    
    if(!isset($_GET['search'])){
        if(isset($_GET['id'])){
            $id = trim($_GET['id']);
            $id = mysqli_real_escape_string($link, $id);
            $vest = mysqli_query($link, "SELECT * FROM vest WHERE id_vest = {$id}");
            if(mysqli_num_rows($vest) != 1){
                $poruka = "Greška: Nema tražene vesti.";
            } else {
            $vest = mysqli_fetch_array($vest);
            }
        }
    } else {
        $search = trim($_GET['search']);
	if(!empty($search)){
            $search = mysqli_real_escape_string($link, $search);
            $query = "SELECT * FROM vest v, organizacija o WHERE v.organizacija_id_organizacija=o.id_organizacija AND v.naslov LIKE '%{$search}%'";
            $vesti = mysqli_query($link, $query);
            if(mysqli_num_rows($vesti) == 0){
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

    <title><?php echo $vest['naslov']; ?></title>
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
        echo "<div class='list-group-item list-group-item-action shadow'><h2>". $vest['naslov']. "</h1></div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h5>Vreme održavanja: " . $vest['vreme_postavljanja']."</h5></div><br/>";
        echo "<img src='slike/vesti/vest_" . $vest['id_vest'] . ".jpg'>";
        echo "<div class='list-group-item list-group-item-action shadow'>".$vest['tekst']."</div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h5>Autor: " . $vest['autor']."</h5></div><br/>";
    }
} else {
    if($poruka){
        echo $poruka;
    } else {
        while($vest = mysqli_fetch_array($vesti))
            echo "<div class='list-group-item list-group-item-action'><div class='d-flex'>" . $vest['vreme_postavljanja']." &nbsp; <a href='vestVise.php?id=" . $vest['id_vest'] . "'>" . $vest['naslov']."</a> <div class='ml-auto'>Autor: " . $vest['autor'] . "</div></div></div><br/>";
    }
}
?>

</div>

<?php
    include_once "moduli/footerModul.php";
?>
</body>
</html>