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
    //print_r($stats);
    $cc = getStudentCourseCount(8);
    // echo $cc;
    $cs = selectcourse_student(8);
    //print_r($cs);
    $fc = selectcourse_faculty(6);
    // print_r($fc);
    // for($i = 0; $i < count($fc); $i++){
    //     $cc[$i] = $fc[$i]["ID"]; 
    // }

    
    // $students = studentsInCourse($fc[""])
    // $students = [];
    // $courses = selectcourse_faculty(6);
    // for($i = 0; $i < count($courses); $i++){
    //     $students[$i] = studentsInCourse($courses[$i]["ID"]);
    // }
    // print_r($students);
    $newNotifications = getNewNotifications();
    print_r($newNotifications);
?>