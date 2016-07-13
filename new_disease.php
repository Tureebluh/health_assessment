<?php require_once("includes/session.php"); ?>
<?php require_once("includes/dbconnection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php
        // If user is NOT logged in
	if( !isset( $_SESSION["logged_in"]) ){
		redirect_to("index.php");
	}
	// If user is NOT an admin
	if( !isset( $_SESSION["admin"]) ) {
            redirect_to("index.php");
            // If user has admin, check for correct value
            if(!$_SESSION["admin"] == 1 ) {
                redirect_to("index.php");
            }
        }
?>


<?php include("includes/header.php") ?>

<?php include("includes/navbar.php") ?>

<div class="container create_disease">
    <form method="post">
        <h1 class="newDiseaseLbls" id="newDiseaseLbl">Create New Disease</h1>
        
        <div class="form-group">
            <label for="newBodySystem" class="newDiseaseLbls">Body System</label>
            <select class="form-control" name="body_system" id="newBodySystem" onchange="getDiseasesNew(this.value)">
                <option value="default">Select System</option>
                <option value="1">Cardiac</option>
                <option value="2">Dermatology</option>
                <option value="3">Endocrine</option>
                <option value="4">GI</option>
                <option value="5">HEENT</option>
                <option value="6">Musculoskeletal</option>
                <option value="7">Neurological</option>
                <option value="8">Psych</option>
                <option value="9">Reproductive</option>
                <option value="10">Respiratory</option>
                <option value="11">Health Maintenance</option>
                <option value="12">Hematology</option>
                <option value="22">Urology</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="disease_name" class="newDiseaseLbls">Disease Name</label>
            <input class="form-control" name="disease_name" id="disease_name" placeholder="Disease name" type="text">
        </div>
        
        <div class="form-group">
            <label for="subjective" class="newDiseaseLbls">Subjective</label>
            <input class="form-control" name="subjective" id="subjective" placeholder="Subjective" type="text">
        </div>
        
        <div class="form-group">    
            <label for="objective" class="newDiseaseLbls">Objective</label>
            <input class="form-control" name="objective" id="objective" placeholder="Objective" type="text">
        </div>
        
        <div class="form-group">
            <label for="icd_codes" class="newDiseaseLbls">ICD-10 Codes</label>
            <input class="form-control" name="icd_codes" id="icd_codes" placeholder="ICD-10 Codes" type="text">
        </div>
        
        <div class="form-group">
            <label for="labs" class="newDiseaseLbls">Labs</label>
            <input class="form-control" name="labs" id="labs" placeholder="Labs" type="text">
        </div>
        
        <div class="form-group">
            <label for="diagnostics" class="newDiseaseLbls">Diagnostics</label>
            <input class="form-control" name="diagnostics" id="diagnostics" placeholder="Diagnostics" type="text">
        </div>
        
        <div class="form-group">
            <label for="referral" class="newDiseaseLbls">Referrals</label>
            <input class="form-control" name="referral" id="referral" placeholder="Referral" type="text">
        </div>
        
        <div class="form-group">
            <label for="medication" class="newDiseaseLbls">Medications</label>
            <input class="form-control" name="medication" id="medication" placeholder="Medications" type="text">
        </div>
        
        <div class="form-group">
            <label for="patient_ed" class="newDiseaseLbls">Patient Education</label>
            <input class="form-control" name="patient_ed" id="patient_ed" placeholder="Patient Education" type="text">
        </div>
        
        <div class="form-group">
            <label for="follow_up" class="newDiseaseLbls">Follow-up</label>
            <input class="form-control" name="follow_up" id="follow_up" placeholder="Follow-up" type="text">
        </div>
        
        <input type="button" class="btn btn-danger pull-right" value="Create Disease" name="create_disease" id="createDiseaseBtn" onclick="createDisease()">
    </form>
</div>

<?php include("includes/footer.php") ?>