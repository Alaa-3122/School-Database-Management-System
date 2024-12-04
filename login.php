<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Student Management System - Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
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
   background: url('https://th.bing.com/th/id/R.307f786bd7ee49ae114cfb5257a01f46?rik=ssy8CvwVQwynkg&riu=http%3a%2f%2fwww.ndu.edu.lb%2fLibrary%2fAssets%2fMicro%2fTest%2fNotreDameUniversity-Louaize%2fDSC_0158.jpg%3fw%3d870%26h%3d581%26scale%3dboth&ehk=fBoGSYPxtu9OByCCT0R1M%2fjImUsRfZNp7wt57YuLpIQ%3d&risl=&pid=ImgRaw&r=0') no-repeat center center fixed;
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



    </style>
<body>
    <div class="login-container">
        <h1>University Student Management System</h1>
        <form action="login.php" method="POST" class="login-form">
            <label for="user_id">User ID</label>
            <input type="number" id="user_id" name="user_id" placeholder="Enter your User ID" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

