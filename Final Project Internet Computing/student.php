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
<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Student Sign Up</h2>
            <form action="submit_form.php" method="POST" id="signInForm" onsubmit="return CheckForm()">
                <div class="input-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name">
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                <div class="input-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Enter your password again">
                </div>
                <button type="submit" class="submit-btn">Sign Up</button>
            </form>
        </div>
    </div>
</body>
</html>
