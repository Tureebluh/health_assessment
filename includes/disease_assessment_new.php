<?php require_once("dbconnection.php") ?>
<?php require_once("functions.php") ?>
<?php

    $q = intval($_GET['q']);
    $selected_disease = find_disease_by_id_json( $q );
    echo $selected_disease;
?>