<?php
    require "db.php";
    error_reporting(0);
    session_start();
    if($_SESSION["user_ID"] == null || $_SESSION["role"] != "Admin"){
        header("Location: login.php");
    }

    // To display students
    $StudentsToDisplay = selectstudents();
    // To dispplay faculty
    $FacultyToDisplay = selectfaculty();
    // To display courses and instructor
    $coursesInstructor = selectcourse_admin();
    // To display stats
    $stats = getDashboardStats();

    if(isset($_POST["action"])){
        if ($_POST["action"] == "Approve") {
            approveUserNotification($_POST["notification_id"]);
            header("Location: admin_dashboard.php");
        }elseif ($_POST["action"] == "Reject") {
            rejectUserNotification($_POST["notification_id"]);
            header("Location: admin_dashboard.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    function updateNotifications(data) {
    const notifications = data.notifications;
    const notificationCount = data.count;
    const notificationBadge = document.querySelector('.notification-badge');
    const notificationMenu = document.getElementById('notificationMenu');

    // Update notification badge
    if (notificationCount > 0) {
        notificationBadge.style.display = 'block';
        notificationBadge.textContent = notificationCount;
    } else {
        notificationBadge.style.display = 'none';
    }

    // Update notification menu
    notificationMenu.innerHTML = '<h2>Notifications</h2>'; // Clear previous notifications
    notifications.forEach(notification => {
        const notificationElement = document.createElement('div');
        notificationElement.classList.add('notification');
        notificationElement.innerHTML = `
            ${notification.message}
            <form method="POST">
                <input type="hidden" name="notification_id" value="${notification.ID}">
                <input type="submit" name="action" value="Approve" class="btn-approve">
                <input type="submit" name="action" value="Reject" class="btn-reject">
            </form>
        `;
        notificationMenu.appendChild(notificationElement);
    });
}

// Fetch notifications periodically
function checkNotifications() {
    setInterval(() => {
        $.ajax({
            url: 'check_notifications.php',
            method: 'GET',
            success: function(response) {
                const data = JSON.parse(response);
                updateNotifications(data);
            },
            error: function(error) {
                console.error('Error fetching notifications:', error);
            }
        });
    }, 2000); // 10 seconds interval
}

checkNotifications();

</script>
</head>
<body>
    
<!-- Bell Icon for Menu -->
<div class="bell-menu" onclick="toggleMenu()">
    <i class="fa-solid fa-bell"></i> 
    <span class="notification-badge"></span>
</div>

<!-- Notifications Menu -->
<div class="notification-menu" id="notificationMenu">
    <h2>Notifications</h2>
</div>


    <script>
        function toggleMenu() {
    const menu = document.getElementById('notificationMenu');
    menu.classList.toggle('active');
}

    </script>

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
<!-- 
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
    </div> -->


    <!-- 
<script>
    function checkNotifications() {
        setInterval(() => {
            $.ajax({
                url: 'check_notifications.php', // URL of your server-side script
                method: 'GET',
                success: function(response) {
                    updateNotifications(response);
                },
                error: function(error) {
                    console.error('Error fetching notifications:', error);
                }
            });
        }, 10000); // 10 seconds interval
    }

    function updateNotifications(data) {
        const notifications = JSON.parse(data);
        const notificationMenu = document.getElementById('notificationMenu');
        notificationMenu.innerHTML = '<h2>Notifications</h2>'; // Clear previous notifications
        notifications.forEach(notification => {
            const notificationElement = document.createElement('div');
            notificationElement.classList.add('notification');
            notificationElement.innerHTML = `
                ${notification.message}
                <form method = "POST">
                    <input type="hidden" name="notification_id" value="${notification.ID}">
                    <input type="submit" name="action" value="Approve" class="btn-approve">
                    <input type="submit" name="action" value="Reject" class="btn-reject">
                </form>
            `;
            notificationMenu.appendChild(notificationElement);
        });
    }

    checkNotifications();
</script> -->