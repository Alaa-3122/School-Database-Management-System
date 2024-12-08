<?php
    require "db.php";
    error_reporting(0);
    session_start();
    if($_SESSION["user_ID"] == null || $_SESSION["role"] != "Faculty"){
        header("Location: login.php");
    }

    $user_name = isset($_SESSION["name"]) ? $_SESSION["name"] : 'N/A';
    $user_id = isset($_SESSION["user_ID"]) ? $_SESSION["user_ID"] : 'N/A';

    $department = getFacultyDept($user_id);

    $courses = selectcourse_faculty($user_id);
    for($i = 0; $i < count($courses); $i++){
        $students[$i] = studentsInCourse($courses[$i]["ID"]);
    }

    
    if(isset($_POST["submit"]) && $_POST["submit"] == "Update"){
        $studentID = getstudentIDFromUserID($_POST["student_id"]);
        updateGrade($studentID, $_POST["course_id"], $_POST["grade"]);
        header("Location: faculty_dashboard.php");        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="faculty_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <div class="header">
        <h1>Faculty Dashboard</h1>
    </div>

    <h2><a href="login.php" class="back-button">Log out</a></h2>
    
    <div class="faculty-info-box">
        <p><strong>Instructor ID:</strong> <?php echo $user_id; ?></p>
        <p><strong>Instructor Name:</strong> <?php echo $user_name; ?></p>
        <p><strong>Department:</strong> <?php echo isset($department) ? $department : 'N/A'; ?></p>
    </div>

    <?php
        
            for($i = 0; $i < count($courses); $i++){
                ?>
                <div class="section">
                    <h2><span class="course-name"><?php echo $courses[$i]["course_code"] .  ": " . $courses[$i]["course_name"]?></span></h2>
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
                                <?php
                                    for($j = 0; $j < count($students[$i]); $j++){
                                        ?>
                                        <tr>
                                            <td><?php echo $students[$i][$j]["ID"]?></td>
                                            <td><?php echo $students[$i][$j]["name"]?></td>
                                            <td><?php echo isset($students[$i][$j]["grade"]) ? $students[$i][$j]["grade"] : "N/A";?></td>
                                            <td>
                                            <form class="update-grade-form" method="post">
                                                <input type="hidden" name="course_id" value="<?php echo $courses[$i]['ID']; ?>">
                                                <input type="hidden" name="student_id" value="<?php echo $students[$i][$j]['ID']; ?>">
                                                <input type="number" placeholder="Update Grade" min="0" max="100" name="grade">
                                                <!-- <button type="submit" name="update" value="1">Update Grade</button> -->
                                                <input type="submit" name="submit" id="submit" value="Update">
                                            </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
            }
        
        ?>

</body>
</html>


<!-- <div class="section">
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
    </div> -->