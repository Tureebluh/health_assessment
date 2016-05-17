<?php
	define("DB_SERVER", "us-cdbr-iron-east-04.cleardb.net");
	define("DB_USER", "b504718ed4bcac");
	define("DB_PASS", "af6c6511");
	define("DB_NAME", "heroku_bc0dad0dfe44fdf");
        
    $dbconn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    if(mysqli_connect_errno()) {
        die("Database connection failed: " . 
             mysqli_connect_error() . 
             " (" . mysqli_connect_errno() . ")"
        );
    } else {
   
      $query = "SET NAMES utf8";
      $result = mysqli_query($dbconn, $query);
      $query = "";
      $query = "SET CHARACTER SET utf8";
      $result = mysqli_query($dbconn, $query);
  }
?>