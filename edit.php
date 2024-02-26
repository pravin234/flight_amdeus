<?php
session_start();
if (!isset($_SESSION['email'])) {
    // Redirect to the login page
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Form with jQuery Validation</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- jQuery Validation plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
</head>

<body>

    <div class="container">

        <div class="profile-card">
            <h2>Profile Information</h2>
            <div>
                <strong>First Name:</strong> <span id="profileFirstName"></span>
            </div>
            <div>
                <strong>Last Name:</strong> <span id="profileLastName"></span>
            </div>
            <div>
                <strong>Email:</strong> <span id="profileEmail"></span>
            </div>
            <!-- Add more fields as needed -->
        </div>

        <form id="myForm">

            <!-- Your form fields here -->

        </form>
    </div>

    <script>
    $(document).ready(function() {
        // Fetch user data from the server
        $.ajax({
            url: 'fetch_user_data.php',
            method: 'GET',
            data: {
                userId: <?php echo json_encode($_SESSION['user_id']); ?>
            },
            success: function(response) {
                var userData = JSON.parse(response);
                console.log(userData.email);
                if (userData) {
                    // Populate form fields with fetched data
                    $("#profileFirstName").text(userData.first_name || '');
                    $("#profileLastName").text(userData.last_name || '');
                    $("#profileEmail").text(userData.email || '');

                    $("#firstName").val(userData.first_name || '');
                    $("#lastName").val(userData.last_name || '');
                    $("#email").val(userData.email || '');
                    $("#gender").val(userData.gender || '');
                    $("#dateOfBirth").val(userData.date_of_birth || '');
                    $("#birthPlace").val(userData.birth_place || '');
                    $("#contactNumber").val(userData.contact_number || '');
                    $("#documentType").val(userData.document_type || '');
                    $("#passport_number").val(userData.passport_number || '');
                    $("#nationality").val(userData.nationality || '');
                    $("#address").val(userData.address || '');
                    $("#address2").val(userData.address2 || '');
                    $("#city").val(userData.city || '');
                    $("#state").val(userData.state || '');
                    $("#zip").val(userData.zip || '');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        // Add validation rules
        $("#myForm").validate({
            // Your validation rules here
        });

        // Handle form submission
        $("#myForm").submit(function(event) {
            event.preventDefault(); // Prevent the default form submission
            var formData = $(this).serialize(); // Serialize form data

            // Send the form data to the server using AJAX
            $.ajax({
                url: 'update_user.php', // Replace with your PHP script to update user data
                method: 'POST', // You can use GET or POST method
                data: formData,
                success: function(response) {
                    // Handle the success response
                    alert(response); // You can replace this with any action you want
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
    </script>

</body>

</html>