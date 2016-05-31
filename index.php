<?php require_once("includes/session.php"); ?>
<?php require_once("includes/dbconnection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php   
        //If user has already logged in
	if( isset( $_SESSION["logged_in"]) ){
		redirect_to("search_diseases.php");
	}
?>
<?php 
        //If user actually submits the page
	if(isset($_POST["submit"])){
            
            //Check database for email/password combo
            $found_user = attempt_login($_POST["inputEmail"], $_POST["inputPassword"]);

            //If not equal to false, user was found
            if ($found_user){
                    //Successful login
                    //Set SESSION variables respectively
                    $_SESSION["logged_in"] = true;
                    $_SESSION["email"] = $found_user["email"];
                    $_SESSION["admin"] = $found_user["admin"];
                    redirect_to("search_diseases.php");
            }else {
                    //Failed login
                    //Add error message to errors array
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
                <h1>HealthAssessment<small><sup>&trade;</sup></small></h1> 
                <p>Up-to-date treatment guidelines, right at your fingertips.</p> 
        </div>

        <form class="form-signin panel" method="post">

            <h2 class="form-signin-heading">Please Login</h2>

            <!-- Display errors to user -->
            <?php echo form_errors($errors);?>

            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>

            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="inputPassword" class="form-control" placeholder="Password" required>

            <button class="btn btn-lg btn-primary btn-block" value="submit" name="submit" type="submit">Sign In</button>
            
            <hr id="fbLogin">
            
            <fb:login-button scope="public_profile,email" onlogin="checkLoginState();" size="xlarge" id="fbLogin">
                Login with Facebook
            </fb:login-button>

            <div class="link">
                    <span id="registrationLink">Don't have an account? <br> 
                        <a href="registration.php"> Sign up! It's free! ;) </a><span>
            </div>	
        </form>
    </div> <!-- /container -->
	
<?php include("includes/footer.php") ?>