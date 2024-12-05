<?php
    require "db.php";
    error_reporting(0);

    // To display user
    $StudentsToDisplay = selectstudents();
    $FacultyToDisplay = selectfaculty();
    $coursesInstructor = selectcourse_admin();
    $stats = getDashboardStats();
?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>

    <div class="container">
     <!-- Overall View Table -->   
        <div class="section">
            <h2>Overall View</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Number of Courses</th>
                            <th>Number of Faculty Members</th>
                            <th>Number of Students</th>
                            <th>Highest Grade</th>
                            <th>Lowest Grade</th>
                            <th>Average Grade</th>
                            <th>Instructor Teaching The Most Courses</th>
                            <th>Number Of Courses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td><?php echo isset($stats[0]) ? $stats[0] : 'N/A'; ?></td>
                        <td><?php echo isset($stats[1]) ? $stats[1] : 'N/A'; ?></td>
                        <td><?php echo isset($stats[2]) ? $stats[2] : 'N/A'; ?></td>
                        <td><?php echo isset($stats[3]) ? $stats[3] : 'N/A'; ?></td>
                        <td><?php echo isset($stats[4]) ? $stats[4] : 'N/A'; ?></td>
                        <td><?php echo isset($stats[5]) ? $stats[5] : 'N/A'; ?></td>
                        <td><?php echo isset($stats[6]) ? $stats[6] : 'N/A'; ?></td>
                        <td><?php echo isset($stats[7]) ? $stats[7] : 'N/A'; ?></td>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Students Table -->
        <div class="section">
            <h2>Students</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>StudentID</th>
                            <th>UserID</th>
                            <th>Name</th>
                            <th>GPA</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            for($i = 0; $i < count($StudentsToDisplay); $i++){
                                ?>
                                <tr>
                                    <td><?php echo $StudentsToDisplay[$i]["ID"]?></td>
                                    <td><?php echo $StudentsToDisplay[$i]["user_id"]?></td>
                                    <td><?php echo $StudentsToDisplay[$i]["name"]?></td>
                                    <td><?php echo $StudentsToDisplay[$i]["gpa"]?></td>
                                    <td><?php echo $StudentsToDisplay[$i]["email"]?></td>
                                    <td><?php echo $StudentsToDisplay[$i]["password"]?></td>
                                    <td><?php echo $StudentsToDisplay[$i]["role"]?></td>
                                    <td><?php echo $StudentsToDisplay[$i]["status"]?></td>
                                    <td>
                                        <a href="signup.php?action=edit&id=<?php echo $StudentsToDisplay[$i]['user_id']?>">
                                            <i class="fa-regular fa-pen-to-square" style="color: #00ffb3;"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="admindashboard.php?action=delete&id=<?php echo $StudentsToDisplay[$i]['user_id']?>">
                                            <i class="fa-solid fa-trash" style="color: #ff0000;"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Faculty Table -->
        <div class="section">
            <h2>Faculty</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>FacultyID</th>
                            <th>UserID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            for($i = 0; $i < count($FacultyToDisplay); $i++){
                                ?>
                                <tr>
                                    <td><?php echo $FacultyToDisplay[$i]["ID"]?></td>
                                    <td><?php echo $FacultyToDisplay[$i]["user_id"]?></td>
                                    <td><?php echo $FacultyToDisplay[$i]["name"]?></td>
                                    <td><?php echo $FacultyToDisplay[$i]["department"]?></td>
                                    <td><?php echo $FacultyToDisplay[$i]["email"]?></td>
                                    <td><?php echo $FacultyToDisplay[$i]["password"]?></td>
                                    <td><?php echo $FacultyToDisplay[$i]["role"]?></td>
                                    <td><?php echo $FacultyToDisplay[$i]["status"]?></td>
                                    <td>
                                        <a href="signup.php?action=edit&id=<?php echo $FacultyToDisplay[$i]['user_id']?>">
                                            <i class="fa-regular fa-pen-to-square" style="color: #00ffb3;"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="admindashboard.php?action=delete&id=<?php echo $FacultyToDisplay[$i]['user_id']?>">
                                            <i class="fa-solid fa-trash" style="color: #ff0000;"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Courses Table (each course and who's teaching it) -->
        <div class="section">
            <h2>Courses</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Faculty ID</th>                           
                            <th>User ID</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            for($i = 0; $i < count($coursesInstructor); $i++){
                                ?>
                                <tr>
                                    <td><?php echo $coursesInstructor[$i]["ID"]?></td>
                                    <td><?php echo $coursesInstructor[$i]["course_code"]?></td>
                                    <td><?php echo $coursesInstructor[$i]["course_name"]?></td>
                                    <td><?php echo $coursesInstructor[$i]["faculty_id"]?></td>
                                    <td><?php echo $coursesInstructor[$i]["user_id"]?></td>
                                    <td><?php echo $coursesInstructor[$i]["name"]?></td>
                                </tr>
                                <?php
                            }
                        
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    <!-- Hamburger Menu Icon -->
    <div class="hamburger-menu" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Notifications Menu -->
    <div class="notification-menu" id="notificationMenu">
        <h2>Notifications</h2>
        <div class="notification">
            New student "John Doe" has registered.
            <form>
                <input type="submit" name="submit" value="Approve" class="btn-approve">
                <input type="submit" name="submit" value="Reject" class="btn-reject">
            </form>
        </div>
        <div class="notification">
            New faculty "Dr. Smith" has registered.
            <form>
                <input type="submit" name="submit" value="Approve" class="btn-approve">
                <input type="submit" name="submit" value="Reject" class="btn-reject">
            </form>
        </div>
    </div>

    <script>
        // JavaScript for toggling the notification menu
        function toggleMenu() {
            const menu = document.getElementById('notificationMenu');
            menu.classList.toggle('active');
        }
    </script>

</body>
</html>
