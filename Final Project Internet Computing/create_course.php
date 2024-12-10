<?php
    require "db.php";
    error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sign Up</title>
    <link rel="stylesheet" href="create_course.css">
</head>

<?php
$message = "";
if(isset($_POST['submit']) && $_POST['submit'] == "Create Course"){
    $message = insertCourse($_POST["course_code"],$_POST["course_name"]);
    if ($message == "New course created successfully") {
        header("Location: admin_dashboard.php");
    }
}
?>

<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Create Course</h2>

            <div style="color: black; text-align: center;">
    <?= $message; ?>
</div>

        
            <form action="create_course.php" method="POST" id="signInForm" onsubmit="return CheckForm()">
                <div class="input-group">
                    <label for="name">Course Code</label>
                    <input type="text" id="Course code" name="course_code" required placeholder="Enter the course name">
                </div>
                <div class="input-group">
                <label for="name">Course Name</label>
                    <input type="text" id="Course name" name="course_name" required placeholder="Enter the course code">
                </div>
                <input type="submit" name="submit" value="Create Course" class="submit-btn">
            </form>
        </div>
    </div>
</body>
</html>