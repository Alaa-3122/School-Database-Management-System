<?php
    
    require "db.php";
    error_reporting(0);
    session_start();
    if($_SESSION["user_ID"] == null){
        header("Location: sign-in.php");
    }

?>