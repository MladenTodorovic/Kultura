<?php
    $poruka = "";
    include_once "moduli/loginModul.php";
    
    include_once "moduli/brojac.php";

    if(!isset($_GET['search'])){
        if(isset($_POST['submit'])){
            $anketa = $_POST['anketa'];
            $id_anketa = $_POST['id_anketa'];
            $id_anketa = mysqli_real_escape_string($link, $id_anketa);
            $id_gost = $_POST['id_gost'];
            $id_gost = mysqli_real_escape_string($link, $id_gost);
            echo $id_anketa;
            echo "<br/>";
            echo $id_gost;
            mysqli_query($link, "INSERT INTO popunjena_anketa (anketa_id_anketa, gost_id_gost) VALUES ('$id_anketa', '$id_gost')");
            array_pop($_POST); // Izbacujem poslednja 4 elementa iz
            array_pop($_POST); // $_POST (anketa, id_anketa, id_gost
            array_pop($_POST); // i submit) da bih mogao da koristim
            array_pop($_POST); // foreach petlju.

            foreach($_POST as $pitanja_id_pitanja => $id_odgovor){
                $pitanja_id_pitanja = mysqli_real_escape_string($link, $pitanja_id_pitanja);
                $id_odgovor = mysqli_real_escape_string($link, $id_odgovor);
                $broj_odgovora = mysqli_query($link, "SELECT broj_odgovora FROM odgovori WHERE id_odgovor='$id_odgovor'");
                $broj_odgovora = mysqli_fetch_array($broj_odgovora);
                $broj_odgovora = $broj_odgovora['broj_odgovora'];
                $broj_odgovora++;
                mysqli_query($link, "UPDATE odgovori SET broj_odgovora='$broj_odgovora' WHERE id_odgovor='$id_odgovor'");
            }
        }
        header("location: anketaVise.php?id=".$id_anketa);
    }
?>