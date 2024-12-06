<?php
    require "db.php";
    error_reporting(0);
    session_start();
    if($_SESSION["user_ID"] == null){
        header("Location: login.php");
    }
    $student_name = isset($_SESSION["name"]) ? $_SESSION["name"] : 'N/A';
    $student_id = isset($_SESSION["user_ID"]) ? $_SESSION["user_ID"] : 'N/A';
    $coursecount = getStudentCourseCount($_SESSION["user_ID"]);
    $courses = selectcourse_student($_SESSION["user_ID"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="student_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <div class="header">
        <h1>Student Dashboard</h1>
    </div>

    <div class="student-info-box">
        <p><strong>Student ID:</strong> <?php echo $student_id; ?></p>
        <p><strong>Student Name:</strong> <?php echo $student_name; ?></p>
        <p><strong>Number Of Courses:</strong> <?php echo isset($coursecount) ? $coursecount : 0; ?></p>
        <p><strong>Registered Credits:</strong> <?php echo isset($coursecount) ? $coursecount * 3 : 0;; ?></p>
    </div>

    <div class="container">

        <div class="section">
            <h2>Courses Registered</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Instructor</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            for($i = 0; $i < count($courses); $i++){
                                ?>
                                <tr>
                                    <td><?php echo $courses[$i]["course_code"]?></td>
                                    <td><?php echo $courses[$i]["course_name"]?></td>
                                    <td><?php echo $courses[$i]["instructor"]?></td>
                                    <td><?php echo isset($courses[$i]["grade"]) ? $courses[$i]["grade"] : "N/A";?></td>
                                </tr>
                                <?php
                            }
                        
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
