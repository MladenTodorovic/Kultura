<?php
    session_start();
    $poruka = "";
    if (!isset($_SESSION['username'])) {
        header("location: ../greska.php");
    }
    $link = mysqli_connect("localhost", "root", "", "kultura")
            or die("Greska prilikom konekcije na bazu!");
    mysqli_set_charset($link, "utf8");

    $username = $_SESSION['username'];
    $id_organizacija = $_SESSION['id_organizacija'];
    $telefon = $_GET['telefon'];
    
    $query = "DELETE FROM telefon WHERE telefon='$telefon'";
    
    mysqli_query($link, $query);

    header("location: profil.php");


mysqli_close($link);