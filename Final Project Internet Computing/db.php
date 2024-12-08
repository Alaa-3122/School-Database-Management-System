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


// Student Dashboard Course Count
function getStudentCourseCount($id) {
    $conn = getConnection();

    // SQL query to count the courses a student is enrolled in
    $sql = "SELECT COUNT(*) AS course_count 
    FROM student_courses as sc 
    INNER JOIN students as s ON sc.student_id = s.ID
    WHERE s.user_id = $id
    GROUP BY s.user_id";
    
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        return $row['course_count']; // Return the course count directly
    } else {
        return null;
    }
}

// Courses enrolled by the student
function selectcourse_student($id) {
    $conn = getConnection();

    // Select query
    $sql = "SELECT c.course_code, c.course_name, sc.grade, u.name as instructor
    from students as s inner join student_courses as sc on s.ID = sc.student_id
    inner join courses as c on c.ID = sc.course_id
    inner join faculty_course as fc on fc.course_id = c.ID
    inner join faculty as f on f.ID = fc.faculty_id
    inner join users as u on u.ID = f.user_id
    where s.user_id = $id";
    $result = $conn->query($sql);

    $rows = [];
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

// Faculty Dashboard
function getFacultyDept($id) {
    $conn = getConnection();

    
    $sql = "select department from faculty
    where user_id = $id";
    
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        return $row['department'];
    } else {
        return null;
    }
}

function selectcourse_faculty($id) {
    $conn = getConnection();

    // Select query
    $sql = "SELECT c.ID, c.course_code, c.course_name
    from faculty as f inner join faculty_course as fc on f.ID = fc.faculty_id
    inner join courses as c on c.ID = fc.course_id
    where f.user_id = $id";

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


function studentsInCourse($id) {
    $conn = getConnection();

    // Select query
    $sql = "SELECT u.ID, u.name, sc.grade
    from users as u inner join students as s on u.ID = s.user_id
    inner join student_courses as sc on sc.student_id = s.ID
    where sc.course_id = $id";

    $result = $conn->query($sql);
    $rows = [];
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

function updateGrade($student_id, $course_id, $grade) {
    $conn = getConnection();

    
    $sql = "UPDATE `student_courses` SET `grade`='$grade'
    WHERE student_id = $student_id and course_id = $course_id;
    ";

    if ($conn->query($sql) === TRUE) {
        return "Grade Updated";
    } else {
        return "Error: " . $conn->error;
    }

    $conn->close();
}

function getstudentIDFromUserID($id) {
    $conn = getConnection();

    
    $sql = "select ID from students
    where user_id = $id";
    
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        return $row['ID'];
    } else {
        return null;
    }
}


function approveUserNotification($nid) {
    $conn = getConnection();

    
    $sql = "UPDATE `notifications`
    SET `is_read`='1'
    WHERE ID = $nid
    ";

    if ($conn->query($sql) === TRUE) {
        return approveUser($nid);
    } else {
        return "Error: " . $conn->error;
    }

    $conn->close();
}

function approveUser($nid) {
    $conn = getConnection();

    
    $sql = "UPDATE users
    SET status = 'Approved'
    WHERE users.ID IN (
    SELECT user_id 
    FROM notifications
    WHERE notifications.ID = $nid
    )

    ";

    if ($conn->query($sql) === TRUE) {
        return "Status Updated";
    } else {
        return "Error: " . $conn->error;
    }

    $conn->close();



}



function rejectUserNotification($nid) {
    $conn = getConnection();

    
    $sql = "UPDATE `notifications`
    SET `is_read`='1'
    WHERE ID = $nid
    ";

    if ($conn->query($sql) === TRUE) {
        return rejectUser($nid);
    } else {
        return "Error: " . $conn->error;
    }

    $conn->close();
}

function rejectUser($nid) {
    $conn = getConnection();

    
    $sql = "UPDATE users
    SET status = 'Rejected'
    WHERE users.ID IN (
    SELECT user_id 
    FROM notifications
    WHERE notifications.ID = $nid
    )

    ";

    if ($conn->query($sql) === TRUE) {
        return "Status Updated";
    } else {
        return "Error: " . $conn->error;
    }

    $conn->close();



}











?>













