<?php require_once("includes/session.php"); ?>
<?php require_once("includes/dbconnection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php
	if( isset( $_SESSION["logged_in"]) ){
		redirect_to("search.php");
	}
?>
<?php 

	if(isset($_POST["submit"])){
		//POST REQUEST
		$email = mysql_prep($_POST["inputEmail"]);
		$password = mysql_prep($_POST["inputPassword"]);
		
		$found_user = attempt_login($email, $password);
		
		if ($found_user){
			//successful login
			$_SESSION["logged_in"] = true;
			$_SESSION["username"] = $found_user["username"];
                        $_SESSION["admin"] = $found_user["admin"];
			redirect_to("search_diseases.php");
		}else {
			$errors["no_login"] = "Username/password not found.";
		}
		
	} else {
		//GET REQUEST
		$errors = array();
		$email = "";
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

	
	
    <div class="container login">
	
		<div class="jumbotron">
			<h1>MyAssessment<small><sup>&trade;</sup></small></h1> 
			<p>Up-to-date treatment guidelines, right at your fingertips.</p> 
		</div>
	
		<form class="form-signin panel" method="post">
	  
			<h2 class="form-signin-heading">Please Login</h2>
			
			<?php echo form_errors($errors);?>
			
			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="email" name="inputEmail" class="form-control" placeholder="Email address" value="<?php echo htmlspecialchars($email); ?>" required autofocus>
			
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" name="inputPassword" class="form-control" placeholder="Password" required>
			
			<button class="btn btn-lg btn-primary btn-block" value="submit" name="submit" type="submit">Sign In</button>
			
			<div class="link">
				Don't have an account? <br> 
				<a href="registration.php"> Sign up! It's free! ;) </a>
			</div>	
		</form>
    </div> <!-- /container -->
	
<?php include("includes/footer.php") ?>