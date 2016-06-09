<?php require_once("dbconnection.php") ?>
<?php require_once("functions.php") ?>
<?php
    echo "<form class=\"form-vertical diseasesDD\" id=\"diseasesDD\">
        <h2 class=\"bs_heading\">Diseases</h2>
        <select class=\"form-control bs_dropdown\" name=\"disease\" onchange=\"getDiseaseInfo(this.value)\">";
    
    $q = intval($_GET['q']);
    $disease_array = find_diseases( $q );
        
    echo disease_dropdown_list($disease_array);

    echo "</select>
        </form>";      
?>