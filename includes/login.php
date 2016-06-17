<?php require_once("session.php"); ?>
<?php require_once("dbconnection.php") ?>
<?php require_once("functions.php") ?>
<?php 

    $found_user = attempt_login( $_POST["email"], $_POST["password"] );
    
    //If not equal to false, user was found
    if ($found_user){
            //Successful login
            //Set SESSION variables respectively
            $_SESSION["logged_in"] = true;
            $_SESSION["email"] = $found_user["email"];
            $_SESSION["admin"] = $found_user["admin"];
            
            echo "" + true;
    }else {
            //Failed login
            echo "" + false;
    }

?>