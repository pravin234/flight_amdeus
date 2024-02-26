<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Validate email format
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $error_message = "Invalid email format.";
    } else {
        $existingEmail = mysqli_real_escape_string($conn, $email);
        $password = $_POST['password'];

        $checkEmailQuery = "SELECT * FROM users WHERE email = '$existingEmail'";
        $result = $conn->query($checkEmailQuery);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['user_id'];
                header("Location: dashboard.php");
                exit;
            } else {
                $error_message = "Incorrect password.";
            }
        } else {
            $error_message = "User not found.";
        }
    }
}
?>