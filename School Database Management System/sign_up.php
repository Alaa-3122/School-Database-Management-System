<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Role Selection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            background: url('bk image.jpg');
            background-size: cover; 
        }

        .form-container {
            max-width: 25%; /* Assuming the parent width is 100% */
            margin: 5% 0 0 6%; /* Approximate percentages for spacing */
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
            padding: 3%; /* Based on the container width */
            border-radius: 2%; /* Rounded corners in percentage */
            box-shadow: 0 0.5% 1% rgba(0, 0, 0, 0.1); /* Shadow dimensions as percentage */
            text-align: left; /* Align text to the left */
        }

        .form-container h1 {
            color: #1e3a8a;
            margin-bottom: 2%; /* Based on container height */
            font-size: 1.5em; /* Scaled relative to font size */
            line-height: 1.4;
        }

        .form-container label {
            display: block;
            margin: 2% 0; /* Vertical spacing in percentage */
            font-size: 1.2em; /* Scaled relative to font size */
            font-weight: bold;
        }

        .form-container input[type="radio"] {
            margin-right: 2%; /* Space between radio button and label */
        }

        .form-container button {
            background-color: #1e3a8a;
            color: white;
            padding: 1.5% 3%; /* Padding relative to the container width */
            border: none;
            border-radius: 0.5%; /* Rounded corners */
            font-size: 1.2em; /* Scaled relative to font size */
            cursor: pointer;
            margin-top: 2%; /* Spacing from the last element */
            width: 100%;
        }

        .form-container button:hover {
            background-color: #15527a;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Are you an Instructor or a Student?</h1>
        <br>
        <form id="roleForm">
            <label>
                <input type="radio" name="role" value="student" required>
                Student
              
            </label>
            <br>
            <label>
                <input type="radio" name="role" value="instructor" required>
                Instructor
              
            </label>
            <br>
            <button type="submit">Proceed</button>
        </form>
    </div>

    <script>
        document.getElementById('roleForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const selectedRole = document.querySelector('input[name="role"]:checked').value;
            if (selectedRole === 'instructor') {
                window.location.href = 'faculty.php';
            } else if (selectedRole === 'student') {
                window.location.href = 'student.php';
            }
        });
    </script>
</body>
</html>