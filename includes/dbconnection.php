<?php
  define("DB_SERVER", "us-cdbr-iron-east-04.cleardb.net");
  define("DB_USER", "b9565f77379fad");
  define("DB_PASS", "7b88fb7b");
  define("DB_NAME", "heroku_774b72170d79475");
        
//    define("DB_SERVER", "localhost");
//    define("DB_USER", "health_assessment");
//    define("DB_PASS", "6bJwhvMvjtWCuhMt");
//    define("DB_NAME", "health_assessment");
        
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