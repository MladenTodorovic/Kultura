<?php
    $poruka = "";
    include_once "moduli/loginModul.php";
    
    include_once "moduli/brojac.php";

    // search polje sa upitom za dogadjaje
    if(!isset($_GET['search'])){
        $dogadjaji = mysqli_query($link, "SELECT * FROM dogadjaj d, organizacija o WHERE d.vreme_isticanja > CURDATE() AND d.organizacija_id_organizacija=o.id_organizacija ORDER BY d.vreme_dogadjaja ASC");
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
    while($dogadjaj = mysqli_fetch_array($dogadjaji))
        echo "<div class='list-group-item list-group-item-action shadow'><div class='d-flex'>" . $dogadjaj['vreme_dogadjaja']." &nbsp; <a href='dogadjajVise.php?id=" . $dogadjaj['id_dogadjaj'] . "'>" . $dogadjaj['naslov']."</a> <div class='ml-auto'>Organizator: <a href='podaciOrganizacija.php?id=" . $dogadjaj['id_organizacija'] . "'>" . $dogadjaj['naziv_organizacije'] . "</a></div></div></div><br/>";
}
?>

</div>

<?php
    include_once "moduli/footerModul.php";
?>
</body>
</html>
