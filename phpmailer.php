<?php
session_start();
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'thetodor@gmail.com';                 // SMTP username
    $mail->Password = 'TAJNA';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    $mail->CharSet = 'UTF-8';
    
    //ovo je zaobilazno resenje za ssl ali sta da se radi ;op
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $link = mysqli_connect("localhost", "root", "", "kultura")
        or die ("Greška prilikom konekcije na bazu!");
    mysqli_set_charset($link,"utf8");
    $email = $_SESSION['email'];
    $naziv_organizacije = $_SESSION['naziv_organizacije'];
    $password = bin2hex(random_bytes(10)); //kreiramo novi random password
    $query = "UPDATE organizacija SET password='$password' WHERE naziv_organizacije='$naziv_organizacije'";
    mysqli_query($link, $query);
    
    //Recipients
    $mail->setFrom('thetodor@gmail.com', 'Kulturologija');
    $mail->addAddress($email, $naziv_organizacije);     // Add a recipient
    $mail->addAddress('thetodor@gmail.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');
    
    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Promena lozinke';
    $mail->Body    = 'Poštovani, ovo je vaša nova lozika: '.$password;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    include_once "moduli/bootstrapModul.php";
    echo '<!DOCTYPE html>
<html>
<head>
    <title>Promena lozinke</title>
</head>
<body onload="setTimeout(redirect, 6000)">
    <div class="container-fluid text-white text-center"><div class="row"><div class="col-sm-3"></div><div class="col-sm-6 bg-danger"><h1>Poslata vam je nova lozinka.<br/>Proverite vašu poštu!</h1></div><div class="col-sm-3"></div></div></div>

<script>
    function redirect(){
        window.location.replace("index.php");
    }
</script>
</body>
</html>';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}