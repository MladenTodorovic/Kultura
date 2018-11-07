<!DOCTYPE html>
<html>
<head>
<?php
    include_once "moduli/bootstrapModul.php";
?>
    <title>Greška</title>
</head>
<body onload="setTimeout(redirect, 6000)">
<?php
    echo '<div class="container-fluid text-white text-center"><div class="row"><div class="col-sm-3"></div><div class="col-sm-6 bg-danger"><h1>Morate biti ulogovani da pristupite toj strani!<br/>Sačekajte da vas prebacimo na početnu stranu!</h1></div><div class="col-sm-3"></div></div></div>';
?>
<script>
    function redirect(){
        window.location.replace('index.php');
    }
</script>
</body>
</html>