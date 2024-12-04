<?php
// Database connection function
function getConnection() {
    $servername = "localhost:3307"; // Adjust port as per your setup
    $username = "root";
    $password = "";
    $dbname = "finalprj";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
