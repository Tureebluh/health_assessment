<?php require_once("includes/session.php"); ?>
<?php require_once("includes/dbconnection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php   
        //If user has already logged in
	if( isset( $_SESSION["logged_in"]) ){
		redirect_to("search_diseases.php");
	}
?>   

<?php include("includes/header.php") ?>

    <div class="container login">
	
        <?php include("includes/banner.php") ?>

        <form class="form-signin panel" method="post">

            <h2 id="loginHeader" class="form-signin-heading">Please Login</h2>

            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" name="inputEmail" id="loginEmail" class="form-control" placeholder="Email address" required autofocus>

            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="inputPassword" id="loginPassword" class="form-control" placeholder="Password" required>

            <input class="btn btn-lg btn-primary btn-block" value="Sign In" name="submit" id="loginBtn" type="button" onclick="logInUser()"></input>
            
            <hr id="loginHr">
            
            <fb:login-button scope="public_profile,email" onlogin="checkLoginState();" size="xlarge" id="fbLogin">
                Login with Facebook
            </fb:login-button>

            <div class="link">
                <span id="registrationLink">Don't have an account? <br> 
                    <a href="registration.php"> Sign up! It's free! <span class="glyphicon glyphicon-arrow-right"></span></a>  
                </span>
            </div>	
        </form>
    </div> <!-- /container -->
	
<?php include("includes/footer.php") ?>