<?php

    require "db.php";
    error_reporting(0);
    $student = selectstudents();
    $faculty =selectfaculty();
    $courses = selectcourse_admin();
    $stats = getDashboardStats();
    echo "<pre>";
    // print_r($student);
    //print_r($faculty);
    print_r($stats);
?>