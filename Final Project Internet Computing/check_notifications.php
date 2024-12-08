<?php
require "db.php";
session_start();

if ($_SESSION["user_ID"] == null || $_SESSION["role"] != "Admin") {
    header("Location: login.php");
    exit();
}

// Fetch new notifications from the database
function getNewNotifications() {
    $conn = getConnection();

    $sql = "SELECT `ID`, `user_id`, `is_read`, `created_at`, `message` FROM `notifications` WHERE `is_read`= 0"; // Assuming 'seen' is a flag to indicate if the notification has been viewed
    $result = $conn->query($sql);

    if ($result === false) {
        // Query execution failed
        $conn->close();
        return null;
    }

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    } else {
        $rows = []; // No new notifications
    }

    $conn->close();
    return $rows;
}

$newNotifications = getNewNotifications();
$count = count($newNotifications);

echo json_encode(["notifications" => $newNotifications, "count" => $count]);
?>



