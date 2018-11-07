<?php
    $poruka = "";
    include_once "moduli/loginModul.php";
    
    include_once "moduli/brojac.php";
    
    // search polje sa upitom za vesti
    if(!isset($_GET['search'])){
        $vesti = mysqli_query($link, "SELECT * FROM vest v, organizacija o WHERE v.vreme_postavljanja < CURDATE() AND v.organizacija_id_organizacija=o.id_organizacija ORDER BY v.vreme_postavljanja ASC");
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

    <title>Vesti</title>
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
    while($vest = mysqli_fetch_array($vesti))
        echo "<div class='list-group-item list-group-item-action shadow'><div class='d-flex'>" . $vest['vreme_postavljanja']." &nbsp; <a href='vestVise.php?id=" . $vest['id_vest'] . "'>" . $vest['naslov']."</a> <div class='ml-auto'>Autor: " . $vest['autor'] . "</div></div></div><br/>";
}
?>

</div>
    

<?php
    include_once "moduli/footerModul.php";
?>
</body>
</html>