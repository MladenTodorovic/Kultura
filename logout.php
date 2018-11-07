<?php

    session_start(); /* mora da se napise da bi se dohvatila sesija */
    session_destroy();
    header("location: index.php");

?>