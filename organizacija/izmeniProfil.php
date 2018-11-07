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
    $email = $_POST['email'];
    $naziv_organizacije = $_POST['naziv_organizacije'];
    $sediste = $_POST['sediste'];
    $web_adresa = $_POST['web_adresa'];
    $kontakt_osoba = $_POST['kontakt_osoba'];
    $oblast_delovanja = $_POST['oblast_delovanja'];
    $tekst_organizacije = $_POST['tekst_organizacije'];
    
    $queryO = "UPDATE organizacija SET naziv_organizacije='$naziv_organizacije', sediste='$sediste', web_adresa='$web_adresa', kontakt_osoba='$kontakt_osoba', oblast_delovanja='$oblast_delovanja', tekst_organizacije='$tekst_organizacije' WHERE id_organizacija='$id_organizacija'";
    
    if(isset($_POST['telefon1']))$telefon1 = $_POST['telefon1'];
    if(isset($_POST['telefon2']))$telefon2 = $_POST['telefon2'];
    if(isset($_POST['telefon3']))$telefon3 = $_POST['telefon3'];
    if(isset($_POST['telefon4']))$telefon4 = $_POST['telefon4'];
    if(isset($_POST['telefon5']))$telefon5 = $_POST['telefon5'];
    
    $telefoni = mysqli_query($link, "SELECT telefon FROM telefon WHERE organizacija_id_organizacija = '$id_organizacija'");
    $brojTelefona = mysqli_affected_rows($link);//broji redove pogodjene prethodnim upitom
    $Telefon1 = mysqli_fetch_array($telefoni)[0];
    $Telefon2 = mysqli_fetch_array($telefoni)[0];
    $Telefon3 = mysqli_fetch_array($telefoni)[0];
    $Telefon4 = mysqli_fetch_array($telefoni)[0];
    $Telefon5 = mysqli_fetch_array($telefoni)[0];
    
    if(mysqli_query($link,$queryO) === TRUE){
        if($telefon1 != $Telefon1){
            $query1 = "UPDATE telefon SET telefon='$telefon1' WHERE telefon='$Telefon1'";
            mysqli_query($link, $query1);
        }
        if((isset($telefon2)) && (isset($Telefon2)) && ($telefon2 != $Telefon2)){
            $query2 = "UPDATE telefon SET telefon='$telefon2' WHERE telefon='$Telefon2'";
            mysqli_query($link, $query2);
        } elseif((isset($telefon2)) && !isset($Telefon2)){
            $query2 = "INSERT INTO telefon (telefon, organizacija_id_organizacija) VALUES ('$telefon2', '$id_organizacija')";
            mysqli_query($link, $query2);
        }
        if((isset($telefon3)) && (isset($Telefon3)) && ($telefon3 != $Telefon3)){
            $query3 = "UPDATE telefon SET telefon='$telefon3' WHERE telefon='$Telefon3'";
            mysqli_query($link, $query3);
        } elseif((isset($telefon3)) && !isset($Telefon3)){
            $query3 = "INSERT INTO telefon (telefon, organizacija_id_organizacija) VALUES ('$telefon3', '$id_organizacija')";
            mysqli_query($link, $query3);
        }
        if((isset($telefon4)) && (isset($Telefon4)) && ($telefon4 != $Telefon4)){
            $query4 = "UPDATE telefon SET telefon='$telefon4' WHERE telefon='$Telefon4'";
            mysqli_query($link, $query4);
        } elseif((isset($telefon4)) && !isset($Telefon4)){
            $query4 = "INSERT INTO telefon (telefon, organizacija_id_organizacija) VALUES ('$telefon4', '$id_organizacija')";
            mysqli_query($link, $query4);
        }
        if((isset($telefon5)) && (isset($Telefon5)) && ($telefon5 != $Telefon5)){
            $query5 = "UPDATE telefon SET telefon='$telefon5' WHERE telefon='$Telefon5'";
            mysqli_query($link, $query5);
        } elseif((isset($telefon5)) && !isset($Telefon5)){
            $query5 = "INSERT INTO telefon (telefon, organizacija_id_organizacija) VALUES ('$telefon5', '$id_organizacija')";
            mysqli_query($link, $query5);
        }
            header("location: profil.php");
    }
    
    
mysqli_close($link);