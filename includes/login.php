<?php require_once("session.php"); ?>
<?php require_once("functions.php") ?>

<?php 

    $_SESSION["logged_in"] = true;
    $_SESSION["email"] = $_POST["name"];
    redirect_to("./search_diseases.php");

?>