<?php require_once("dbconnection.php") ?>
<?php require_once("functions.php") ?>
<?php
    echo "<span class=\"diseasesDD_new\" id=\"diseasesDDNew\">
        <label for=\"newDiseaseDD\" class=\"newDiseaseLbls\">Diseases</label>
        <select class=\"form-control\" id=\"newDiseaseDD\" name=\"disease\" onchange=\"getDiseaseInfoNew(this.value)\">";
    
    $q = intval($_GET['q']);
    $disease_array = find_diseases( $q );
        
    echo disease_dropdown_list($disease_array);

    echo "</select>
        </span>";      
?>