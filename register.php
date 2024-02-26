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
                     header("Location:login.php");
                } else {
                    $error_message = "Error: " . $insertQuery . "<br>" . $conn->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .error-message {
        color: red;
    }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h2>Registration Form</h2>

        <?php
    if (isset($error_message)) {
        echo '<p class="error-message">' . $error_message . '</p>';
    } elseif (isset($success_message)) {
        echo '<p class="text-success">' . $success_message . '</p>';
    }
    ?>

        <form method="post" action="register.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="email">Username:</label>
                <input type="text" class="form-control" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>

            <button type="submit" class="btn btn-primary" name="register">Register</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    function validateForm() {
        var emailInput = document.getElementById('email').value;
        var passwordInput = document.getElementById('password').value;

        if (emailInput.trim() === '' || passwordInput.trim() === '') {
            alert('Please fill in all fields.');
            return false;
        }

        return true;
    }
    </script>

</body>

</html>