<?php require_once("dbconnection.php") ?>
<?php require_once("functions.php") ?>

<?php 

    $result = email_exist( $_POST["email"] );
    
    echo $result;
?>

