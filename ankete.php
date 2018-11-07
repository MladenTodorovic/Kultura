<?php
    $poruka = "";
    include_once "moduli/loginModul.php";
    
    include_once "moduli/brojac.php";

    // search polje sa upitom za ankete
    if(!isset($_GET['search'])){
        $ankete = mysqli_query($link, "SELECT * FROM anketa a, organizacija o WHERE a.vreme_isticanja > CURDATE() AND a.organizacija_id_organizacija=o.id_organizacija ORDER BY a.vreme_postavljanja ASC");
    } else {
	$search = trim($_GET['search']);
	if(!empty($search)){
            $search = mysqli_real_escape_string($link, $search);
            $query = "SELECT * FROM anketa a, organizacija o WHERE a.organizacija_id_organizacija=o.id_organizacija AND a.naslov LIKE '%{$search}%'";
            $ankete = mysqli_query($link, $query);
            if(mysqli_num_rows($ankete) == 0){
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
    
    <title>Ankete</title>
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
    while($anketa = mysqli_fetch_array($ankete))
        echo "<div class='list-group-item list-group-item-action shadow'><div class='d-flex'>" . $anketa['vreme_postavljanja']." &nbsp; <a href='anketaVise.php?id=" . $anketa['id_anketa'] . "'>" . $anketa['naslov']."</a> <div class='ml-auto'>Organizator: <a href='podaciOrganizacija.php?id=" . $anketa['id_organizacija'] . "'>" . $anketa['naziv_organizacije'] . "</a></div></div></div><br/>";
}
?>

</div>

<?php
    include_once "moduli/footerModul.php";
?>
</body>
</html>
