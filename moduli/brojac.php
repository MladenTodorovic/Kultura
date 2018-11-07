<?php
    //BROJAC POSETA I GOSTIJU
    $id_gost = time(); //broj milisekundi od 1.1.1970.
    $datum = date("Y-m-d",$id_gost);
    if(!isset($_COOKIE['danas'])){
        setcookie('danas', $datum, strtotime('tomorrow'));
        $query = "SELECT * FROM posete WHERE datum='$datum'";
        $posete = mysqli_query($link, $query);
        if(mysqli_num_rows($posete)==0){
            $query = "INSERT INTO posete (datum) VALUES ('$datum')";
            mysqli_query($link, $query);
        } elseif(mysqli_num_rows($posete)==1){
            $poseta = mysqli_fetch_array($posete);
            $broj_poseta = $poseta['broj_poseta'];
            $broj_poseta++;
            $query = "UPDATE posete SET broj_poseta='$broj_poseta' WHERE datum='$datum'";
            mysqli_query($link, $query);
        } else {
            echo "Doslo je do greske!";
        }
    }
    
    if(!isset($_COOKIE['gost'])){
        $vreme = $id_gost + ((86400 * 365));
        $vreme_prijavljivanja = date("Y-m-d h:i:s", $id_gost);
        setcookie('gost', $id_gost, $vreme);
        $query = "INSERT INTO gost (id_gost, vreme_prijavljivanja) VALUES ('$id_gost', '$vreme_prijavljivanja')";
        mysqli_query($link, $query);
    } else {
        $id_gost = $_COOKIE['gost'];
    }