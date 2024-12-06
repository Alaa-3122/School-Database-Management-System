<?php
    require "db.php";
    error_reporting(0);
    session_start();
    if($_SESSION["user_ID"] == null){
        header("Location: login.php");
    }

    $user_name = isset($_SESSION["name"]) ? $_SESSION["name"] : 'N/A';
    $user_id = isset($_SESSION["user_ID"]) ? $_SESSION["user_ID"] : 'N/A';
    $faculty_id = isset($_SESSION["faculty_ID"]) ? $_SESSION["user_ID"] : 'N/A';
    $department = isset($_SESSION["department_ID"]) ? $_SESSION["user_ID"] : 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="faculty_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <div class="header">
        <h1>Faculty Dashboard</h1>
    </div>

    <div class="student-info-box">
        <p><strong>Instructor ID:</strong> <?php echo $user_id; ?></p>
        <p><strong>Instructor Name:</strong> <?php echo $user_name; ?></p>
        <p><strong>Faculty ID:</strong> <?php echo $faculty_id; ?></p>
        <p><strong>Department:</strong> <?php echo $department; ?></p>
    </div>

    <div class="section">
        <h2><span class="course-name">Course 1: Theory of Computation</span></h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Grade</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Elyan</td>
                        <td class="grade-cell">95</td>
                        <td>
                            <form class="update-grade-form">
                                <input type="number" placeholder="Update Grade" min="0" max="100">
                                <button type="submit">Update Grade</button>
                            </form>
                        </td>
                    </tr>
             
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
