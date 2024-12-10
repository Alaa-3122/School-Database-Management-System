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
    <script>
        function CheckForm(){
            var pass = document.getElementById("password").value;
            var confirmPass = document.getElementById("confirmPassword").value;
           
            if(pass.trim() == ""){
                alert("Please enter your password");
                return false;
            }

            if(confirmPass.trim() == ""){
                alert("Please enter the password again");
                return false;
            }

            if(pass != confirmPass){
                alert("The passwords should be the same");
                return false;
            }

            return true;  
        }
    </script>
</head>

<?php
$message = "";
if(isset($_POST['submit']) && $_POST['submit'] == "Sign Up"){
    $message = insertUserStudent($_POST["name"], $_POST["email"], $_POST["password"]);
}
?>

<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Create Course</h2>

            <div style="color: black; text-align: center;">
    <?= $message; ?>
</div>

        
            <form action="student.php" method="POST" id="signInForm" onsubmit="return CheckForm()">
                <div class="input-group">
                    <label for="name">Course Code</label>
                    <input type="text" id="Course code" name="course code" required placeholder="Enter the course name">
                </div>
                <div class="input-group">
                <label for="name">Course Name</label>
                    <input type="text" id="Course name" name="course name" required placeholder="Enter the course code">
                </div>
                <input type="submit" name="submit" value="Create Course" class="submit-btn">
            </form>
        </div>
    </div>
</body>
</html>