<?php
	define("DB_SERVER", "localhost");
	define("DB_USER", "health_assessment");
	define("DB_PASS", "YbXxxFULHxDsSHWp");
	define("DB_NAME", "health_assessment");
        
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