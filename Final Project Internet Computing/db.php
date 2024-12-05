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

// Function to check password for logging in AND HASH
function checkpassword($id, $pass) {
    $conn = getConnection();
    
    // Select query
    $sql = "SELECT * FROM users where ID = $id";
    $result = $conn->query($sql);
    $conn->close();

    $row = $result->fetch_assoc();

    $results = array();
    if (password_verify($pass, $row["password"])) {

        
        $results['data'] = $row;
        $results['success'] = 1;
        return $results;
    } else {
        $results['success'] = 0;
        return $results;
    }

    // $conn->close();
}

// Display Students in admin dashboard

// Select and display all students
function selectstudents() {
    $conn = getConnection();

    // Select query
    $sql = "SELECT * FROM users inner join students on users.ID = students.user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    } else {
        echo "0 results";
    }
    
    return $rows;
    
    $conn->close();
}

// Select and display all faculty
function selectfaculty() {
    $conn = getConnection();

    // Select query
    $sql = "SELECT * FROM users inner join faculty on users.ID = faculty.user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    } else {
        echo "0 results";
    }
    
    return $rows;
    
    $conn->close();
}

?>

