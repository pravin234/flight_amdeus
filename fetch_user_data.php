<?php
include 'db.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `users` WHERE `user_id` = ? OR created_by = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $userId, $userId);
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