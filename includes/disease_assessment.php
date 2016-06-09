<?php require_once("dbconnection.php") ?>
<?php require_once("functions.php") ?>
<?php
    echo "<div class=\"panel disease_info\">";   
    $q = intval($_GET['q']);
    $selected_disease = find_disease_by_id( $q );
    echo disease_info($selected_disease);
    echo "</div>";
?>