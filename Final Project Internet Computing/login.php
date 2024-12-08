<?php
    require "db.php";
    error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Student Management System - Login</title>
</head>

<?php

    $text = "";
    if(isset($_POST["submit"])){
        $results = checkpassword($_POST["user_id"], $_POST["password"]);
        if($results['success'] == 1)
        {
            session_start();
            $_SESSION["user_ID"] = $results["data"]["ID"];
            $_SESSION["name"] = $results["data"]["name"];
            $_SESSION["email"] = $results["data"]["email"];
            $_SESSION["password"] = $results["data"]["password"];
            $_SESSION["role"] = $results["data"]["role"];
            $_SESSION["status"] = $results["data"]["status"];

            if($_SESSION["status"] == "Approved"){
                
                if($_SESSION["role"] == "Admin"){

                    header("Location: admin_dashboard.php");
                    exit;
                }elseif ($_SESSION["role"] == "Faculty") {

                    header("Location: faculty_dashboard.php");
                    exit;
                }elseif ($_SESSION["role"] == "Student") {

                    header("Location: student_dashboard.php");
                    exit;
                }

            }elseif($_SESSION["status"] == "Pending"){
                
                $text = "Account Waiting Approval";

            }elseif($_SESSION["status"] == "Rejected"){
                
                $text = "Account Rejected";
            }

        }else{
            $text = "Wrong ID or Password";
        }
    }

?>

<style>
/* General Styling */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    height: 100vh;
    margin: 0;
    display: flex;
    align-items: center;
    background: url('bk image.jpg');
    background-size: cover; 
}

/* Container Styling */
.login-container {
    background: rgba(255, 255, 255, 0.9); 
    padding: 5%;
    border-radius: 10px;
    opacity: 80%;
    box-shadow: 0 4% 6% rgba(0, 0, 0, 0.3);
    width: 40%;
    text-align: center;
}

.login-container h1 {
    font-size: 2.5em;
    margin-bottom: 10%;
    color: #333;
}

/* Form Styling */
.login-form label {
    display: block;
    text-align: left;
    font-size: 1.5em;
    margin-bottom: 2%;
    font-weight: bold;
    color: #555;
}

.login-form input {
    width: 90%;
    padding: 2%;
    font-size: 1.3em;
    margin-bottom: 5%;
    border: 2px solid #ccc;
    border-radius: 8px;
}

.login-form button {
    width: 92%;
    padding: 2.5%;
    font-size: 1.5em;
    background-color: #007BFF;
    color: #ffffff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.login-form button:hover {
    background-color: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .login-container {
        width: 90%;
        padding: 8%;
    }

    .login-container h1 {
        font-size: 2em;
    }

    .login-form label {
        font-size: 1.3em;
    }

    .login-form input {
        font-size: 1.2em;
        padding: 3%;
    }

    .login-form button {
        font-size: 1.3em;
        padding: 3%;
    }
}

.signup-link {
    margin-top: 10%;
    display: block;
    font-size: 1.2em;
    color: #007BFF;
    text-decoration: none;
}

.signup-link:hover {
    text-decoration: underline;
}

</style>
<body>
    <div class="login-container">
        <h1>University Student Management System</h1>
        <form action="login.php" method="POST" class="login-form">
            
            <span>
                <?= $text; ?>
            </span>

            <label for="user_id">User ID</label>
            <input type="number" id="user_id" name="user_id" placeholder="Enter your User ID" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>

            <input type="submit" name="submit" value="Log In">
        </form>
        <a href="sign_up.php" class="signup-link">Don't have an account? Sign Up</a>
    </div>
</body>
</html>