<?php
    $poruka = "";
    include_once "moduli/loginModul.php";
    
    include_once "moduli/brojac.php";

    if(isset($_POST["email"])){
        $email = $_POST["email"];
        $email = mysqli_real_escape_string($link, $email);
        $query = "SELECT naziv_organizacije FROM organizacija WHERE email='$email'";
        $query = mysqli_query($link, $query);
        
        if(mysqli_num_rows($query) == 0){
            $poruka = "Email ne postoji.";
        }else{
            $naziv_organizacije = mysqli_fetch_array($query)[0];
            session_start();
            $_SESSION['naziv_organizacije'] = $naziv_organizacije;
            $_SESSION['email'] = $email;
            header ("Location: phpmailer.php");
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
    
    <title>Reset lozinke</title>
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

    
<?php
if($poruka){
    echo $poruka;
} else {
?>
<div class="container">
    <div class="row">
        <div class="col-sm-4 list-group bg-light"></div>
        <div class="col-sm-4 list-group bg-light">
    <form action="<?php $_SERVER['REQUEST_URI'] ?>" method="POST">
        <div class="form-group">
            <h5 class="bg-warning">Unesite vaš email da bi smo vam poslali novu loziku!</h5>
            <label for="email">Email adresa:</label>
            <input type="email" class="form-control shadow-sm" name="email" id="email" placeholder="Email adresa..."  required>
        </div>
        <button type="submit" class="btn btn-info shadow">Pošalji</button>
    </form>
        </div>
    <div class="col-sm-4 list-group bg-light"></div>
    </div>
</div>
<?php
}
    include_once "moduli/footerModul.php";
?>
</body>
</html>