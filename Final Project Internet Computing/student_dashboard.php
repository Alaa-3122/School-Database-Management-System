<?php
    require "db.php";
    error_reporting(0);
    session_start();
    if($_SESSION["user_ID"] == null){
        header("Location: login.php");
    }

    $student_name = isset($_SESSION["name"]) ? $_SESSION["name"] : 'N/A';
    $student_id = isset($_SESSION["user_ID"]) ? $_SESSION["user_ID"] : 'N/A';
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
    </div>

    <div class="container">
        <div class="section">
            <h2>Overall View</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Number Of Courses</th>
                            <th>Registered Credits</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td><?php echo isset($stats[0]) ? $stats[0] : 'N/A'; ?></td>
                        <td><?php echo isset($stats[1]) ? $stats[1] : 'N/A'; ?></td>
                        <td><?php echo isset($stats[2]) ? $stats[2] : 'N/A'; ?></td>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <h2>Courses Registered</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
