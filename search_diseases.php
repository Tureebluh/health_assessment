<?php require_once("includes/session.php"); ?>
<?php require_once("includes/dbconnection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php
	if( !isset( $_SESSION["logged_in"]) ){
		redirect_to("index.php");
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

<div class="container-fluid">   
    <div class="row">
        <div class="container-fluid panel dropdown_panel pull-left col-lg-3 col-md-3 col-sm-3 col-xs-12">

            <?php	 
                    include("includes/body_systems.php");

                    if( isset($_POST["bodySystem"]) || isset($_POST["disease"]) ){
                            include("includes/diseases.php");	
                    }
            ?>

        </div>

        <div class="container-fluid panel content_panel pull-right col-lg-9 col-md-9 col-sm-9 col-xs-12">

            <?php	 
                    if( isset($_POST["disease"]) ){
                        include("includes/disease_assessment.php");
                    }
            ?>

        </div>
    </div>
</div>
<?php include("includes/footer.php") ?>