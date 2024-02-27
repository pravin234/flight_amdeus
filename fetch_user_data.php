<?php
include 'db.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    if (isset($_GET['editUserId'])) {
        // If an edit button ID is passed, use that ID instead
        $editUserId = $_GET['editUserId'];
        $sql = "SELECT * FROM `users` WHERE `user_id` = ? AND created_by = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $editUserId, $userId);
    } else {
        // If no edit button ID is passed, use the session user ID
        $sql = "SELECT * FROM `users` WHERE `user_id` = ? OR created_by = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $userId, $userId);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $userData = $result->fetch_all(MYSQLI_ASSOC);

    if (!empty($userData)) {
        echo json_encode($userData);
    } else {
        echo json_encode([]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([]);
}
?>
