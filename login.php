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
                header("Location: index1.php");
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .error-message {
            color: red;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h2>Login Form</h2>

        <?php
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>

        <form method="post" action="login.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="email">Username:</label>
                <input type="text" class="form-control" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>

            <button type="submit" class="btn btn-primary" name="login">Login</button>
        </form>

        <p class="mt-3">Don't have an account? <a href="register.php">Register here</a>.</p>
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