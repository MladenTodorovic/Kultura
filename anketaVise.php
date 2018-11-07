<?php
    $poruka = "";
    include_once "moduli/loginModul.php";
    
    include_once "moduli/brojac.php";
    
    if(!isset($_GET['search'])){
        if(isset($_GET['id'])){
            $id = trim($_GET['id']);
            $id = mysqli_real_escape_string($link, $id);
            
            $ankete = mysqli_query($link, "SELECT * FROM anketa WHERE id_anketa = {$id}");
            if(mysqli_num_rows($ankete) != 1){
                $poruka = "Greška: Nema tražene ankete.";
            } else {
            //$ankete = mysqli_query($link, "SELECT * FROM odgovori LEFT JOIN pitanja ON odgovori.pitanja_id_pitanja=pitanja.id_pitanja LEFT JOIN anketa ON pitanja.anketa_id_anketa=anketa.id_anketa WHERE id_anketa = {$id}");
                $anketa = mysqli_fetch_array($ankete);
                $pitanja =  mysqli_query($link, "SELECT * FROM pitanja WHERE anketa_id_anketa = {$id}");
            }
        }
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

?>
<!DOCTYPE html>
<html>
<head>
    
<?php
    include_once "moduli/bootstrapModul.php";
?>

    <title><?php if($anketa['naslov']){
                    echo $anketa['naslov']; 
                   } else {
                       echo "Ankete";
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
        echo "<div class='list-group-item list-group-item-action shadow'><h2>". $anketa['naslov']. "</h1></div><br/>";
        echo "<div class='list-group-item list-group-item-action shadow'><h5>Anketa traje do: " . $anketa['vreme_isticanja']."</h5></div><br/>";
        // proveravam da li je gost vec popunio tu anketu
        $popunjenaAnketa = mysqli_query($link, "SELECT * FROM popunjena_anketa WHERE anketa_id_anketa='$id' AND gost_id_gost='$id_gost'");
        if(mysqli_num_rows($popunjenaAnketa) === 0){
            //POCETAK FORME
            echo "<form action='popuniAnketu.php' method='POST'>";
            while($pitanje = mysqli_fetch_array($pitanja)){
                echo "<div class='list-group-item list-group-item-action shadow'><h5>".$pitanje['pitanje']."</h5><br/>";
                $pitanja_id_pitanja = $pitanje['id_pitanja'];
                $odgovori = mysqli_query($link, "SELECT * FROM odgovori WHERE pitanja_id_pitanja = '$pitanja_id_pitanja'");

                $x = 1;//sluzi da bih automatski cekirao prvi odgovor
                while($odgovor = mysqli_fetch_array($odgovori)){
                    echo '<div class="form-check" required>
                            <label class="form-check-label" for="radio">
                            <input type="radio" class="form-check-input" id="radio" name="'.$pitanja_id_pitanja.'" value="'.$odgovor['id_odgovor'].'"';
                    if($x == 1){ $x++; echo "checked"; }
                    echo '>'.$odgovor['odgovor'].'
                            </label>
                          </div>';
                }
                echo "</div><br/>";
            }
            // sledeca 3 echo-a sluze da u $_POST ubacimo naslov i id ankete i id gosta
            echo "<input type='hidden' name='anketa' value='".$anketa['naslov']."'>";
            echo "<input type='hidden' name='id_anketa' value='".$id."'>";
            echo "<input type='hidden' name='id_gost' value='".$id_gost." '>";
            echo '<button type="submit" name="submit" class="btn btn-primary">Pošalji</button>
                </form>';
                //KRAJ FORME

        } elseif(mysqli_num_rows($popunjenaAnketa) === 1){
            while($pitanje = mysqli_fetch_array($pitanja)){
                echo "<div class='list-group-item list-group-item-action shadow'><h5>".$pitanje['pitanje']."</h5><br/>";
                $pitanja_id_pitanja = $pitanje['id_pitanja'];
                $odgovori = mysqli_query($link, "SELECT * FROM odgovori WHERE pitanja_id_pitanja = '$pitanja_id_pitanja'");
                $ukupanBroj = 0; // ukupan broj odgovora na ovo pitanje
                while($odgovor = mysqli_fetch_array($odgovori)){
                    $brojOdgovora = $odgovor['broj_odgovora'];
                    $ukupanBroj += $brojOdgovora;
                }
                $ukupanBroj = 100/$ukupanBroj;
                mysqli_data_seek($odgovori, 0);
                while($odgovor = mysqli_fetch_array($odgovori)){
                    $width = $ukupanBroj * $odgovor['broj_odgovora'];
                    echo $odgovor['odgovor']." <div class='progress'>
    <div class='progress-bar bg-info' style='width:".$width."%'>".$odgovor['broj_odgovora']."</div>
                        </div><br/>";
                }
                echo "</div><br/>";
            }
        }
    } 
} else {
    if($poruka){
        echo $poruka;
    } else {
        // deo za prikaz search-a
        while($anketa = mysqli_fetch_array($ankete))
            echo "<div class='list-group-item list-group-item-action shadow'><div class='d-flex'>" . $anketa['vreme_postavljanja']." &nbsp; <a href='anketaVise.php?id=" . $anketa['id_anketa'] . "'>" . $anketa['naslov']."</a> <div class='ml-auto'>Organizator: <a href='podaciOrganizacija.php?id=" . $anketa['id_organizacija'] . "'>" . $anketa['naziv_organizacije'] . "</a></div></div></div><br/>";
    }
}
?>

</div>

<?php
    include_once "moduli/footerModul.php";
    
    mysqli_close($link);
?>
</body>
</html>