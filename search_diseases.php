<?php require_once("includes/session.php"); ?>
<?php require_once("includes/dbconnection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php
	if( !isset( $_SESSION["logged_in"]) ){
		redirect_to("index.php");
	}
?>
<?php include("includes/header.php") ?>
<?php include("includes/navbar.php") ?>

<div class="container-fluid">   
    <div class="row">
        <div class="container-fluid panel dropdown_panel pull-left col-lg-3 col-md-3 col-sm-3 col-xs-12" id="ddPanel">

            <?php include("includes/body_systems.php"); ?>

        </div>

        <div class="container-fluid panel content_panel pull-right col-lg-9 col-md-9 col-sm-9 col-xs-12" id="contentPanel">

            

        </div>
    </div>
</div>
<?php include("includes/footer.php") ?>