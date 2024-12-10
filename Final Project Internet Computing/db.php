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
function checkpassword($email, $pass) {
    $conn = getConnection();
    
    // Select query
    $sql = "SELECT * FROM users where email = '$email'";
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
function selectcourseInstructor_admin() {
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

// function selectcourse_faculty($id) {
//     $conn = getConnection();

//     // Select query
//     $sql = "SELECT c.ID, c.course_code, c.course_name
//     from faculty as f inner join faculty_course as fc on f.ID = fc.faculty_id
//     inner join courses as c on c.ID = fc.course_id
//     where f.user_id = $id";

//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//         // Output data of each row
//         while($row = $result->fetch_assoc()) {
//             $rows[] = $row;
//         }
//     } else {
//         return null;
//     }
    
//     return $rows;
    
//     $conn->close();
// }


function selectcourse_faculty($id) {
    $conn = getConnection();

    // Sanitize the input to prevent SQL injection
    $id = $conn->real_escape_string($id);

    // Select query
    $sql = "SELECT c.ID, c.course_code, c.course_name
            FROM faculty AS f
            INNER JOIN faculty_course AS fc ON f.ID = fc.faculty_id
            INNER JOIN courses AS c ON c.ID = fc.course_id
            WHERE f.user_id = '$id'";

    $result = $conn->query($sql);

    $rows = []; // Initialize an empty array
    if ($result && $result->num_rows > 0) {
        // Fetch all rows
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    $conn->close(); // Ensure the connection is closed
    return $rows; // Return the array (empty if no results)
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


// function insertUserStudent($Name, $Email, $Password) {
//     $conn = getConnection();
//     $hashpass = password_hash($Password, PASSWORD_DEFAULT);
//     // Insert query
//     $sql = "INSERT INTO users (Name, Email, Password) 
//             VALUES ('$Name', '$Email', '$hashpass')";

//     if ($conn->query($sql) === TRUE) {
//         return insertStudent(findUserID($Email));
//     } else {
//         return "Error: " . $conn->error;
//     }

//     $conn->close();
// }


// function findUserID($email) {
//     $conn = getConnection();

    
//     $sql = "select ID from users
//     where email = '$email'";
    
//     $result = $conn->query($sql);
//     if ($result && $row = $result->fetch_assoc()) {
//         return $row['ID'];
//     } else {
//         return null;
//     }
// }

// function insertStudent($id) {
//     $conn = getConnection();
    
//     // Insert query
//     $sql = "INSERT INTO `students`(`user_id`) VALUES ('$id')";

//     if ($conn->query($sql) === TRUE) {
//         return createNotification($id);
//     } else {
//         return "Error: " . $conn->error;
//     }

//     $conn->close();
// }

// function createNotification($id) {
//     $conn = getConnection();
//     $msg = createMessage($id);
//     // Insert query
//     $sql = "INSERT INTO `notifications`(`user_id`, `is_read`, `message`)
//     VALUES ('$id','0','$msg')";

//     if ($conn->query($sql) === TRUE) {
//         return "New record created successfully";
//     } else {
//         return "Error: " . $conn->error;
//     }

//     $conn->close();
// }


// function createMessage($id) {
//     $conn = getConnection();

    
//     $sql = "select name, role from users
//     where ID = $id";
    
//     $result = $conn->query($sql);
//     if ($result && $row = $result->fetch_assoc()) {
//         return "New " . $row['role'] . " " . $row["name"] . " has registered" ;
//     } else {
//         return null;
//     }
// }
function insertUserStudent($Name, $Email, $Password) {
    $conn = getConnection();
    try {
        // Check if email already exists
        if (doesEmailExist($Email)) {
            return "Error: Email already exists.";
        }

        $hashpass = password_hash($Password, PASSWORD_DEFAULT);

        // Prepared statement to insert user
        $stmt = $conn->prepare("INSERT INTO users (Name, Email, Password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $Name, $Email, $hashpass);
        
        if ($stmt->execute()) {
            return insertStudent(findUserID($Email));
        } else {
            return "Error: " . $conn->error;
        }
    } finally {
        $conn->close();
    }
}

function doesEmailExist($Email) {
    $conn = getConnection();
    try {
        // Prepared statement to check email existence
        $stmt = $conn->prepare("SELECT 1 FROM users WHERE email = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    } finally {
        $conn->close();
    }
}


function findUserID($email) {
    $conn = getConnection();
    try {
        // Prepared statement to find user ID
        $stmt = $conn->prepare("SELECT ID FROM users WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $row['ID'];
        } else {
            return null;
        }
    } finally {
        $conn->close();
    }
}

function insertStudent($id) {
    if ($id === null) {
        return "Error: User ID not found.";
    }

    $conn = getConnection();
    try {
        // Prepared statement to insert student
        $stmt = $conn->prepare("INSERT INTO students (user_id) VALUES (?)");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return createNotification($id);
        } else {
            return "Error: " . $conn->error;
        }
    } finally {
        $conn->close();
    }
}

function createNotification($id) {
    if ($id === null) {
        return "Error: User ID not found.";
    }

    $conn = getConnection();
    try {
        $msg = createMessage($id);
        if ($msg === null) {
            return "Error: Unable to create message.";
        }

        // Prepared statement to insert notification
        $stmt = $conn->prepare("INSERT INTO notifications (user_id, is_read, message) VALUES (?, 0, ?)");
        $stmt->bind_param("is", $id, $msg);

        if ($stmt->execute()) {
            return "New record created successfully";
        } else {
            return "Error: " . $conn->error;
        }
    } finally {
        $conn->close();
    }
}

function createMessage($id) {
    $conn = getConnection();
    try {
        // Prepared statement to create message
        $stmt = $conn->prepare("SELECT Name, Role FROM users WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return "New " . $row['Role'] . " " . $row['Name'] . " has registered";
        } else {
            return null;
        }
    } finally {
        $conn->close();
    }
}


// function insertUserFaculty($Name, $Email, $Password, $department) {
//     $conn = getConnection();
//     $hashpass = password_hash($Password, PASSWORD_DEFAULT);
//     // Insert query
//     $sql = "INSERT INTO users (Name, Email, Password, role) 
//             VALUES ('$Name', '$Email', '$hashpass', 'Faculty')";

//     if ($conn->query($sql) === TRUE) {
//         return insertFaculty(findUserID($Email), $department);
//     } else {
//         return "Error: " . $conn->error;
//     }

//     $conn->close();
// }



// function insertFaculty($id, $department) {
//     $conn = getConnection();
    
//     // Insert query
//     $sql = "INSERT INTO `faculty`(`user_id`, `department`) VALUES ('$id','$department')";

//     if ($conn->query($sql) === TRUE) {
//         return createNotification($id);
//     } else {
//         return "Error: " . $conn->error;
//     }

//     $conn->close();
// }

function insertUserFaculty($Name, $Email, $Password, $department) {
    $conn = getConnection();
    try {
        // Check if email already exists
        if (doesEmailExist($Email)) {
            return "Error: Email already exists.";
        }

        $hashpass = password_hash($Password, PASSWORD_DEFAULT);

        // Prepared statement to insert user
        $stmt = $conn->prepare("INSERT INTO users (Name, Email, Password, Role) VALUES (?, ?, ?, 'Faculty')");
        $stmt->bind_param("sss", $Name, $Email, $hashpass);
        
        if ($stmt->execute()) {
            return insertFaculty(findUserID($Email), $department);
        } else {
            return "Error: " . $conn->error;
        }
    } finally {
        $conn->close();
    }
}

function insertFaculty($id, $department) {
    if ($id === null) {
        return "Error: User ID not found.";
    }

    $conn = getConnection();
    try {
        // Prepared statement to insert faculty
        $stmt = $conn->prepare("INSERT INTO faculty (user_id, department) VALUES (?, ?)");
        $stmt->bind_param("is", $id, $department);

        if ($stmt->execute()) {
            return createNotification($id);
        } else {
            return "Error: " . $conn->error;
        }
    } finally {
        $conn->close();
    }
}


function deleteStudent($id) {
    $conn = getConnection();

    // Delete query
    $sql = "DELETE FROM students WHERE user_id=$id";

    if ($conn->query($sql) === TRUE) {
        return deleteUser($id);
    } else {
        return "Error: " . $conn->error;
    }

    $conn->close();
}

function deleteUser($id) {
    $conn = getConnection();

    // Delete query
    $sql = "DELETE FROM users WHERE ID=$id";

    if ($conn->query($sql) === TRUE) {
        return "Record deleted successfully";
    } else {
        return "Error: " . $conn->error;
    }

    $conn->close();
}


function selectUserFacultyByID($id) {
    $conn = getConnection();

    
    $sql = "select * from users as u inner join faculty as f on u.ID = f.user_id
    where u.ID = $id";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
    if ($result && $row) {
        return $row;
    } else {
        return null;
    }
}

function updateUserFaculty($id, $name, $Email, $Password, $department) {
    $conn = getConnection();
    $hashpass = password_hash($Password, PASSWORD_DEFAULT);
    // Update query
    $sql = "UPDATE `users` 
    SET `name`='$name',`email`='$Email',`password`='$hashpass' WHERE ID = $id";

    if ($conn->query($sql) == TRUE) {
        return updateFaculty($id, $department);
    } else {
        return "Error: " . $conn->error;
    }

    $conn->close();
}

function updateFaculty($id, $department) {
    $conn = getConnection();

    // Update query
    $sql = "UPDATE `faculty` SET `department`='$department' WHERE user_id = $id";

    if ($conn->query($sql) == TRUE) {
        return "Record updated successfully";
    } else {
        return "Error: " . $conn->error;
    }

    $conn->close();
}



function selectUserStudentByID($id) {
    $conn = getConnection();

    
    $sql = "select * from users as u inner join students as s on u.ID = s.user_id
    where u.ID = $id";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
    if ($result && $row) {
        return $row;
    } else {
        return null;
    }
}

function updateUserStudent($id, $name, $Email, $Password, $gpa) {
    $conn = getConnection();
    $hashpass = password_hash($Password, PASSWORD_DEFAULT);
    // Update query
    $sql = "UPDATE `users` 
    SET `name`='$name',`email`='$Email',`password`='$hashpass' WHERE ID = $id";

    if ($conn->query($sql) == TRUE) {
        return updateStudent($id, $gpa);
    } else {
        return "Error: " . $conn->error;
    }

    $conn->close();
}

function updateStudent($id, $gpa) {
    $conn = getConnection();

    // Update query
    $sql = "UPDATE `students` SET `gpa`='$gpa' WHERE user_id = $id";

    if ($conn->query($sql) == TRUE) {
        return "Record updated successfully";
    } else {
        return "Error: " . $conn->error;
    }

    $conn->close();
}

// Courses enrolled by all student (For courses student table in admin)
function selectCoursesStudents() {
    $conn = getConnection();

    // Select query
    $sql = "SELECT c.ID, c.course_code, c.course_name, s.ID as student_id, s.user_id, u.name, sc.grade
    from students as s inner join student_courses as sc on s.ID = sc.student_id
    inner join courses as c on c.ID = sc.course_id
    inner join users as u on u.ID = s.user_id";
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

// courses for admin
function selectCourses() {
    $conn = getConnection();

    // Select query
    $sql = "SELECT * from courses";
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


function insertAdmin($Name, $Email, $Password) {
    $conn = getConnection();
    try {
        // Check if email already exists
        if (doesEmailExist($Email)) {
            return "Error: Email already exists.";
        }

        $hashpass = password_hash($Password, PASSWORD_DEFAULT);

        // Prepared statement to insert user
        $stmt = $conn->prepare("INSERT INTO users (Name, Email, Password, Role) VALUES (?, ?, ?, 'Admin')");
        $stmt->bind_param("sss", $Name, $Email, $hashpass);
        
        if ($stmt->execute()) {
            return createNotification(findUserID($Email));
        } else {
            return "Error: " . $conn->error;
        }
    } finally {
        $conn->close();
    }
}

function insertCourse($code, $name) {
    $conn = getConnection();
    try {

        // Prepared statement to insert user
        // INSERT INTO `courses`(`ID`, `course_name`, `course_code`) VALUES ('[value-1]','[value-2]','[value-3]')
        $stmt = $conn->prepare("INSERT INTO courses (course_name, course_code) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $code);
        
        if ($stmt->execute()) {
            return "New course created successfully";
        } else {
            return "Error: " . $conn->error;
        }
    } finally {
        $conn->close();
    }
}

function enrollStudent($sid, $cid) {
    $conn = getConnection();
    try {

        // Prepared statement to insert user
        // INSERT INTO `courses`(`ID`, `course_name`, `course_code`) VALUES ('[value-1]','[value-2]','[value-3]')
        $stmt = $conn->prepare("INSERT INTO student_courses (student_id, course_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $sid, $cid);
        
        if ($stmt->execute()) {
            return "New Student enrolled successfully";
        } else {
            return "Error: " . $conn->error;
        }
    } finally {
        $conn->close();
    }
}

function assignFaculty($fid, $cid) {
    $conn = getConnection();
    try {

        // Prepared statement to insert user
        $stmt = $conn->prepare("INSERT INTO faculty_course (faculty_id, course_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $fid, $cid);
        
        if ($stmt->execute()) {
            return "New Faculty Assigned successfully";
        } else {
            return "Error: " . $conn->error;
        }
    } finally {
        $conn->close();
    }
}

?>













