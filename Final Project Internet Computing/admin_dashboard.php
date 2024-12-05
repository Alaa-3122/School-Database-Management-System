<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
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
                            <th>ID</th>
                            <th>Courses</th>
                            <th>Faculty</th>
                            <th>Instructor Name</th>
                            <th>Delete</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>
                       
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
