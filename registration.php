<?php require_once("includes/session.php"); ?>
<?php require_once("includes/dbconnection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php
        //If user IS logged in
	if( isset( $_SESSION["logged_in"]) ){
		redirect_to("search_diseases.php");
	}
?>
<?php
        //Make sure no fields are blank
	if( !empty($_POST['inputUsername']) && !empty($_POST['inputEmail']) && !empty($_POST['inputPassword']) ) {
		
		$register_success = attempt_registration($_POST["inputUsername"], $_POST["inputEmail"], $_POST["inputPassword"]);
		
		if($register_success){
			redirect_to("index.php");
		} else {
			$errors["registration_failed"] = "Registration failed.";
		}
	} else {
		$errors = array();
	}
?>
<?php include("includes/header.php") ?>

<style>
	body {
	background: url('img/heartMonitor.jpg');
	background-repeat: no-repeat;
	background-size: 100% auto;
	background-color: black;
	}
</style>

<div class="container">
	
    <div class="jumbotron">
            <h1>MyAssessment<small><sup>&trade;</sup></small></h1> 
            <p>Providing quality resources for providers worldwide.</p> 
    </div>

    <form class="form-signin panel" method="post">

    <h2 class="form-signin-heading">Registration</h2>

    <?php echo form_errors($errors);?>

    <div class="form-group">
            <label class="sr-only" for="inputUsername">Display name</label>
            <input type="text" class="form-control" name="inputUsername" placeholder="Display name" value="" required autofocus>
    </div>

    <div class="form-group">
            <label class="sr-only" for="inputEmail">Email address</label>
            <input type="email" class="form-control" name="inputEmail" placeholder="Email" value="" required>
    </div>

    <div class="form-group">
            <label class="sr-only" for="inputPassword">Password</label>
            <input type="password" class="form-control" name="inputPassword" placeholder="Password" required>
    </div>

    <button class="btn btn-lg btn-primary btn-block" value="submit" name="submit" type="submit">Submit</button>

    </form>
	
</div>

<?php include("includes/footer.php") ?>
