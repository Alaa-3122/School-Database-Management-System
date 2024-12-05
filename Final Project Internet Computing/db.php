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


// Select and display courses and instructor
function selectcourse_admin() {
    $conn = getConnection();

    // Select query
    $sql = "SELECT c.ID, c.course_name, c.course_code, fc.faculty_id, f.user_id, u.name 
    FROM courses as c inner join faculty_course as fc on c.ID = fc.course_id
    inner join faculty as f on f.ID = fc.faculty_id
    inner join users as u on u.ID = f.user_id
    order by c.ID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    } else {
        return null;
    }
    
    return $rows;
    
    $conn->close();
}

// Admin Dashboard overview table
function getDashboardStats() {
    $conn = getConnection();

    // Multiple queries to get the required statistics
    $sql = "
        SELECT COUNT(*) AS num_courses FROM courses;
        SELECT COUNT(*) AS num_faculty FROM faculty;
        SELECT COUNT(*) AS num_students FROM users WHERE role = 'student';
        SELECT MAX(gpa) AS highest_gpa FROM students;
        SELECT MIN(gpa) AS lowest_gpa FROM students;
        SELECT AVG(gpa) AS average_grade FROM students;
        SELECT u.name AS instructor_name, COUNT(fc.course_id) AS course_count 
        FROM faculty_course AS fc
        INNER JOIN faculty AS f ON fc.faculty_id = f.ID
        INNER JOIN users AS u ON f.user_id = u.ID
        GROUP BY fc.faculty_id
        ORDER BY course_count DESC
        LIMIT 1;
        SELECT COUNT(*) AS num_courses FROM courses;
    ";

    // Execute multiple queries
    if ($conn->multi_query($sql)) {
        $stats = [];
        do {
            if ($result = $conn->store_result()) {
                $row = $result->fetch_assoc();
                $stats[] = $row ? array_values($row)[0] : null; // Store the first value of each result
                $result->free();
            }
        } while ($conn->next_result());

        $conn->close();
        return $stats;
    } else {
        echo "Error: " . $conn->error;
        $conn->close();
        return null;
    }
}


?>

