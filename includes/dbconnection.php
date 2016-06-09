<?php
//  define("DB_SERVER", $_ENV["DB_SERVER"]);
//  define("DB_USER", $_ENV["DB_USER"]);
//  define("DB_PASS", $_ENV["DB_PASS"]);
//  define("DB_NAME", $_ENV["DB_NAME"]);

	//Local database setup purely for testing purposes.
  
    define("DB_SERVER", "localhost");
    define("DB_USER", "health_assessment");
    define("DB_PASS", "6bJwhvMvjtWCuhMt");
    define("DB_NAME", "health_assessment");
        
    $dbconn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    if(mysqli_connect_errno()) {
        die("Database connection failed: " . 
             mysqli_connect_error() . 
             " (" . mysqli_connect_errno() . ")"
        );
    } else {
   
        mysqli_character_set_name($dbconn);
        mysqli_set_charset($dbconn, "utf8");
    }
  
?>