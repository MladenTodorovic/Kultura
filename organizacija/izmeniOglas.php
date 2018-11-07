<?php
    session_start();
    $poruka = "";
    if (!isset($_SESSION['username'])) {
        header("location: ../greska.php");
    }
    $link = mysqli_connect("localhost", "root", "", "kultura")
            or die("Greška prilikom konekcije na bazu!");
    mysqli_set_charset($link, "utf8");
    
    $username = $_SESSION['username'];
    $id_organizacija = $_SESSION['id_organizacija'];
    
    $id_oglas = trim($_SESSION['id']);
    
    $naslov = mysqli_real_escape_string($link, $_POST['naslov']);
    $vreme_postavljanja = mysqli_real_escape_string($link, $_POST['vreme_postavljanja']);
    $vreme_isticanja = mysqli_real_escape_string($link, $_POST['vreme_isticanja']);
    $tekst = mysqli_real_escape_string($link, $_POST['tekst']);
    $autor = mysqli_real_escape_string($link, $_POST['autor']);
    
    $query = "UPDATE oglas SET naslov='$naslov', vreme_postavljanja='$vreme_postavljanja', vreme_isticanja='$vreme_isticanja', tekst='$tekst', autor='$autor' WHERE id_oglas='$id_oglas' AND organizacija_id_organizacija='$id_organizacija'";

    if(mysqli_query($link, $query) === FALSE){
        $poruka = "Traženi oglas ne postoji!";
        $_SESSION['poruka'] = $poruka;
        header("location: OoglasVise.php?id=".$id_oglas);
    } else{
        //deo za upload slike
        $target_dir = "../slike/oglasi/";
        $target_file = $target_dir . "oglas_" . $id_oglas . ".jpg";
                //basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
    // Check if file already exists OVAJ DEO NE TREBA
        /*if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }*/
    // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
    // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
    // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    header("location: OoglasVise.php?id=".$id_oglas);
    }
    
    mysqli_close($link);