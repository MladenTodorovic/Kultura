<?php
    $poruka = "";
    include_once "moduli/loginModul.php";
    
    include_once "moduli/brojac.php";
    
    // search polje sa upitom za oglase
    if(!isset($_GET['search'])){
        $oglasi = mysqli_query($link, "SELECT * FROM oglas og, organizacija o WHERE og.vreme_isticanja > CURDATE() AND og.organizacija_id_organizacija=o.id_organizacija ORDER BY og.vreme_postavljanja ASC");
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
    
    <title>Kulturologija</title>
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
if($poruka){
    echo $poruka;
} else {
    while($oglas = mysqli_fetch_array($oglasi))
        echo "<div class='list-group-item list-group-item-action shadow'><div class='d-flex'>" . $oglas['vreme_postavljanja']." &nbsp; <a href='oglasVise.php?id=" . $oglas['id_oglas'] . "'>" . $oglas['naslov']."</a> <div class='ml-auto'>Postavio: " . $oglas['autor'] . "</div></div></div><br/>";
}
?>

</div>

<?php
    include_once "moduli/footerModul.php";
?>
</body>
</html>
