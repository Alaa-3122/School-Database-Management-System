<?php
    require "db.php";
    error_reporting(0);

    if(isset($_GET["action"]) && $_GET["action"] == "edit"){
        $userToEdit = selectUserFacultyByID($_GET["id"]);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Sign Up</title>
    <link rel="stylesheet" href="faculty.css">
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

    if($_GET["action"] == "edit"){
        $message = updateUserFaculty($_GET["id"], $_POST["name"], $_POST["email"], $_POST["password"], $_POST["department"]);
        header("Location: admin_dashboard.php");
    }else{
        $message = insertUserFaculty($_POST["name"], $_POST["email"], $_POST["password"], $_POST["department"]);
    }
}
?>

<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Create Instructor</h2>
            
            <div style="color: black; text-align: center;">
    <?= $message; ?>
</div>

            <form action="faculty.php?action=<?php echo $_GET['action'];?>&id=<?php echo $_GET["id"];?>" method="POST" id="signInForm" onsubmit="return CheckForm()">
                <div class="input-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name" value="<?php echo $userToEdit["name"]?>">
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email" value="<?php echo $userToEdit["email"]?>">
                </div>
                <div class="input-group">
                    <label for="department">Department</label>
                    <input type="text" id="department" name="department" required placeholder="Enter your department" value="<?php echo $userToEdit["department"]?>">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password" value="<?php echo $userToEdit["password"]?>">
                </div>
                <div class="input-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Enter your password again" value="<?php echo $userToEdit["password"]?>">
                </div>
                <input type="submit" name="submit" value="Create" class="submit-btn">
            </form>
        </div>
    </div>
</body>
</html>
