<?php 
    include_once("server/connect.php");

    //destroy the session
    session_destroy();

    //redirect to index page
    header("location: ./")
?>