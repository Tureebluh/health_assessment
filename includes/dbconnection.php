<?php
  define("DB_SERVER", getenv('DB_SERVER'));
  define("DB_USER", getenv('DB_USER'));
  define("DB_PASS", getenv('DB_PASS'));
  define("DB_NAME", getenv('DB_NAME'));
        
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