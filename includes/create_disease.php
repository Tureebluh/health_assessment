<?php require_once("dbconnection.php") ?>
<?php require_once("functions.php") ?>
<?php 
        
    $result = create_disease($_POST["body_system"], $_POST["disease_name"], $_POST["subjective"], $_POST["objective"],
            $_POST["icd_codes"], $_POST["labs"], $_POST["diagnostics"], $_POST["referral"], $_POST["medication"], $_POST["patient_ed"], $_POST["follow_up"]);
        
?>