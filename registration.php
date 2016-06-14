<?php require_once("includes/session.php"); ?>
<?php require_once("includes/dbconnection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php
        //If user IS logged in
	if( isset( $_SESSION["logged_in"]) ){
		redirect_to("search_diseases.php");
	}
?>
<?php include("includes/header.php") ?>

<div class="container">
	
    <?php include("includes/banner.php") ?>

    <form class="form-signin panel" method="post">

        <h2 id="registrationHeader" class="form-signin-heading">Registration</h2>

        <div class="form-group has-feedback" id="emailFormGroup">
            <label class="sr-only" for="inputEmail">Email address</label>
            <input type="email" class="form-control" id="registrationEmail" name="inputEmail" placeholder="Email" required autofocus>
            <span class="glyphicon form-control-feedback" id="emailValidationSpan"></span>
        </div>

        <div id="passwordRequirements">
            <span id="upTriangle">&#9650;</span>
            <h4><strong>Password must meet the following requirements:</strong></h4>
            <ul>
                <li id="letter" class="passwordReqs glyphicon glyphicon-remove">&nbsp;At least <strong>one letter</strong></li><br>
                <li id="capital" class="passwordReqs glyphicon glyphicon-remove">&nbsp;At least <strong>one capital letter</strong></li><br>
                <li id="number" class="passwordReqs glyphicon glyphicon-remove">&nbsp;At least <strong>one number</strong></li><br>
                <li id="length" class="passwordReqs glyphicon glyphicon-remove">&nbsp;Be at least <strong>8 characters</strong></li><br>
            </ul>
        </div>
        
        <div class="form-group has-feedback" id="passwordFormGroup">
            <label class="sr-only" for="inputPassword">Password</label>
            <input type="password" id="registrationPassword" name="inputPassword" class="form-control" placeholder="Password" required>
            <span class="glyphicon form-control-feedback" id="passwordValidationSpan"></span>
        </div>

        <div class="form-group has-feedback" id="confirmFormGroup">
            <label class="sr-only" for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" class="form-control" name="confirmPassword" placeholder="Confirm Password" required>
            <span class="glyphicon form-control-feedback" id="confirmValidationSpan"></span>
        </div>

        <input class="btn btn-lg btn-primary btn-block" value="Register" id="registrationBtn" name="Submit" type="button" onclick="checkValidation()"></input>

        <div class="link" style="margin-left: -1em;">
            <a href="index.php">
                <span class="glyphicon glyphicon-arrow-left" style="padding-right: .5em; margin-top: .3em;"></span>   
                Back to login
            </a>
        </div>
        
    </form>
	
</div>

<?php include("includes/footer.php") ?>
