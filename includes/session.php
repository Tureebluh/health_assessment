<?php

    /*************************************************************************************
     * Checks to see if HTTPS is set on SERVER for Apache, OR if HTTPS is == off for IIS
     * Redirects user to https://hostname/currentPage
     * Adds Moved Permanently to header so HTTPS will remain with all future request
     * Run before session_start() because redirecting between http/https starts a new session
     ************************************************************************************/
    if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }

    session_start();

?>