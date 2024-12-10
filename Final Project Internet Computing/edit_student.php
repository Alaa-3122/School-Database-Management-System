<?php
    require "db.php";
    error_reporting(0);
    if(isset($_GET["action"]) && $_GET["action"] == "edit"){
        $userToEdit = selectUserStudentByID($_GET["id"]);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sign Up</title>
    <link rel="stylesheet" href="student.css">
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
if(isset($_POST['submit']) && $_POST['submit'] == "Update"){
    if($_GET["action"] == "edit"){
        $message = updateUserStudent($_GET["id"], $_POST["name"], $_POST["email"], $_POST["password"], $_POST["gpa"]);
        if ($message == "Record updated successfully") {
            header("Location: admin_dashboard.php");
        }
    }
}
?>

<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Edit Student</h2>

            <span style="color: #d82828;">
            <?= $message; ?>
            </span>
        
            <form action="edit_student.php?action=<?php echo $_GET['action'];?>&id=<?php echo $_GET["id"];?>" method="POST" id="signInForm" onsubmit="return CheckForm()">
                <div class="input-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter full name" value="<?php echo $userToEdit["name"]?>">
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input readonly type="email" id="email" name="email" required placeholder="Enter email" value="<?php echo $userToEdit["email"]?>">
                </div>
                <div class="input-group">
                    <label for="gpa">GPA</label>
                    <input type="number" id="gpa" name="gpa" required placeholder="Enter GPA" value="<?php echo $userToEdit["gpa"]?>">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter password" value="<?php echo $userToEdit["password"]?>">
                </div>
                <div class="input-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Enter password again" value="<?php echo $userToEdit["password"]?>">
                </div>
                <input type="submit" name="submit" value="Update" class="submit-btn">
            </form>
        </div>
    </div>
</body>
</html>