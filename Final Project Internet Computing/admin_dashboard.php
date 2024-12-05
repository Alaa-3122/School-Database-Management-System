<?php
    require "db.php";
    error_reporting(0);

    // To display user
    $users = selectstudents();
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
                        </tr>
                    </thead>
                    <tbody>
                    
                      
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
                            
                            for($i = 0; $i < count($users); $i++){
                                ?>
                                <tr>
                                    <td><?php echo $users[$i]["ID"]?></td>
                                    <td><?php echo $users[$i]["user_id"]?></td>
                                    <td><?php echo $users[$i]["name"]?></td>
                                    <td><?php echo $users[$i]["gpa"]?></td>
                                    <td><?php echo $users[$i]["email"]?></td>
                                    <td><?php echo $users[$i]["password"]?></td>
                                    <td><?php echo $users[$i]["role"]?></td>
                                    <td><?php echo $users[$i]["status"]?></td>
                                    <td>
                                        <a href="signup.php?action=edit&id=<?php echo $users[$i]['user_id']?>">
                                            <i class="fa-regular fa-pen-to-square" style="color: #00ffb3;"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="admindashboard.php?action=delete&id=<?php echo $users[$i]['user_id']?>">
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
                            <th>ID</th>
                            <th>Courses</th>
                            <th>Instructors</th>
                            <th>Delete</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        
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
