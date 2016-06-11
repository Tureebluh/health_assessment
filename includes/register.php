<?php require_once("dbconnection.php") ?>
<?php require_once("functions.php") ?>
<?php

    $result = attempt_registration( $_POST["email"], $_POST["password"] );
    echo "" . $result;

?>
