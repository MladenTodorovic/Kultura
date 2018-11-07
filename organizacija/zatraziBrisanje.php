<?php
    session_start();
    $poruka = "";
    if(!isset($_SESSION['username'])) {
        header("location: ../greska.php");
    }
    $link = mysqli_connect("localhost", "root", "", "kultura")
            or die("Greška prilikom konekcije na bazu!");
    mysqli_set_charset($link, "utf8");

    $username = $_SESSION['username'];
    $id_organizacija = $_SESSION['id_organizacija'];
    
    if(isset($_GET['id_dogadjaj'])){
        $id_dogadjaj = $_GET['id_dogadjaj'];

        $query = "UPDATE dogadjaj SET brisanje = '0' WHERE id_dogadjaj='$id_dogadjaj' AND organizacija_id_organizacija='$id_organizacija'";

        mysqli_query($link, $query);

        header("location: Odogadjaji.php");
        
    } elseif(isset($_GET['id_vest'])){
        $id_vest = $_GET['id_vest'];

        $query = "UPDATE vest SET brisanje = '0' WHERE id_vest='$id_vest' AND organizacija_id_organizacija='$id_organizacija'";

        mysqli_query($link, $query);

        header("location: Ovesti.php");
        
    } elseif(isset($_GET['id_oglas'])){
        $id_oglas = $_GET['id_oglas'];

        $query = "UPDATE oglas SET brisanje = '0' WHERE id_oglas='$id_oglas' AND organizacija_id_organizacija='$id_organizacija'";

        mysqli_query($link, $query);

        header("location: Ooglasi.php");
        
    } elseif(isset($_GET['id_anketa'])){
        $id_anketa = $_GET['id_anketa'];

        $query = "UPDATE anketa SET brisanje = '0' WHERE id_anketa='$id_anketa' AND organizacija_id_organizacija='$id_organizacija'";

        mysqli_query($link, $query);

        header("location: Oankete.php");
    }

mysqli_close($link);