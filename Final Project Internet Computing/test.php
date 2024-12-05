<?php

    require "db.php";
    error_reporting(0);
    $student = selectstudents();
    $faculty =selectfaculty();
    echo "<pre>";
    // print_r($student);
    print_r($faculty);
?>