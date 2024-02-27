<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Validate email format
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $error_message = "Invalid email format.";
    } else {
        // Check if the email already exists in the database
        $existingEmail = mysqli_real_escape_string($conn, $email);
        $checkEmailQuery = "SELECT * FROM users WHERE email = '$existingEmail'";
        $result = $conn->query($checkEmailQuery);

        if ($result->num_rows > 0) {
            $error_message = "Email already registered. Please use a different email.";
        } else {
            // Validate password length
            $password = $_POST['password'];
            if (strlen($password) < 8) {
                $error_message = "Password must be at least 8 characters long.";
            } else {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert the user into the database
                $insertQuery = "INSERT INTO users (email, password) VALUES ('$existingEmail', '$hashedPassword')";

                if ($conn->query($insertQuery) === TRUE) {
                    $success_message = "Registration successful!";
                    // Redirect to the login page after successful registration
                    header("Location: index.php");
                    exit;  // Make sure to exit after header redirection
                } else {
                    $error_message = "Error: " . $insertQuery . "<br>" . $conn->error;
                }
            }
        }
    }
}
?>
