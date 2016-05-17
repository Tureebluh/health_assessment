<?php require_once("includes/session.php"); ?>
<?php require_once("includes/dbconnection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php
	if( !isset( $_SESSION["logged_in"]) ){
		redirect_to("index.php");
	}
	
	if( !isset( $_SESSION["admin"]) ){
		redirect_to("index.php");
        if(!$_SESSION["admin"] == 1 ) {
            redirect_to("index.php");
        }
    }
?>
<?php
	if( isset( $_POST["create_disease"]) ){
            
                $body_system = mysql_prep($_POST["body_system"]);
		$disease_name = mysql_prep($_POST["disease_name"]);
		$subjective = mysql_prep($_POST["subjective"]);
		$objective = mysql_prep($_POST["objective"]);
		$icd_codes = mysql_prep($_POST["icd_codes"]);
		$labs = mysql_prep($_POST["labs"]);
		$diagnostics = mysql_prep($_POST["diagnostics"]);
		$referral = mysql_prep($_POST["referral"]);
		$medication = mysql_prep($_POST["medication"]);
		$patient_ed = mysql_prep($_POST["patient_ed"]);
		$follow_up = mysql_prep($_POST["follow_up"]);
		
		if ( !empty($disease_name) && !empty($subjective) && !empty($objective) && !empty($icd_codes) && !empty($labs) && !empty($diagnostics)
				&& !empty($referral) && !empty($medication) && !empty($patient_ed) && !empty($follow_up) ) {
			
			$result = create_disease($body_system, $disease_name, $subjective, $objective, $icd_codes, $labs, $diagnostics, $referral, $medication, $patient_ed, $follow_up);
                        if ( $result ){
                            $success["successful"] = "Successfully created disease.";
                            $errors = array();
                        } else {
                            $errors["failed"] = "Failed to create new disease.";
                            $success = array();
                        }
                    
		} else {
			
			$errors["not_empty"] = "All fields are required.";
                        $success = array();
			
		}
            
	} else {
		$errors = array();
                $success = array();
	}
?>

<?php include("includes/header.php") ?>

<style>
	body {
		background: url('img/straws.jpg');
		background-color: black;
	}
</style>

<?php include("includes/navbar.php") ?>

<div class="container create_disease">
    <form method="post">
        <h1>Create New Disease</h1>
        
        <?php echo form_errors($errors);?>
        <?php echo form_success($success);?>
        
        <div class="form-group">
            <label for="bodySystem">Body System:</label>
            <select class="form-control" name="body_system">
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
            </select>
        </div>
        
        <div class="form-group">
            <label for="disease_name">Disease Name:</label>
            <input class="form-control" name="disease_name" placeholder="Disease name" type="text">
        </div>
        
        <div class="form-group">
            <label for="subjective">Subjective:</label>
            <input class="form-control" name="subjective" placeholder="Subjective" type="text">
        </div>
        
        <div class="form-group">    
            <label for="objective">Objective:</label>
            <input class="form-control" name="objective" placeholder="Objective" type="text">
        </div>
        
        <div class="form-group">
            <label for="icd_codes">ICD-10 Codes:</label>
            <input class="form-control" name="icd_codes" placeholder="ICD-10 Codes" type="text">
        </div>
        
        <div class="form-group">
            <label for="labs">Labs:</label>
            <input class="form-control" name="labs" placeholder="Labs" type="text">
        </div>
        
        <div class="form-group">
            <label for="diagnostics">Diagnostics:</label>
            <input class="form-control" name="diagnostics" placeholder="Diagnostics" type="text">
        </div>
        
        <div class="form-group">
            <label for="referral">Referrals:</label>
            <input class="form-control" name="referral" placeholder="Referral" type="text">
        </div>
        
        <div class="form-group">
            <label for="medication">Medications:</label>
            <input class="form-control" name="medication" placeholder="Medications" type="text">
        </div>
        
        <div class="form-group">
            <label for="patient_ed">Patient Education:</label>
            <input class="form-control" name="patient_ed" placeholder="Patient Education" type="text">
        </div>
        
        <div class="form-group">
            <label for="follow_up">Follow-up:</label>
            <input class="form-control" name="follow_up" placeholder="Follow-up" type="text">
        </div>
        
        <input class="btn btn-danger pull-right" type="submit" value="Create Disease" name="create_disease">
    </form>
</div>

<?php include("includes/footer.php") ?>