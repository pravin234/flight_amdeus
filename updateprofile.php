<?php
session_start();
include "get_access_token.php";
include "db.php";
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}
$email = $_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $birthPlace = $_POST["birthPlace"];
    $contactNumber = $_POST["contactNumber"];
    $documentType = $_POST["documentType"];
    $passportNumber = $_POST["passportNumber"];
    $nationality = $_POST["nationality"];
    $address = $_POST["address"];
    $address2 = $_POST["address2"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $user_id = $_POST["userId"];

    // Prepare and execute the SQL UPDATE query
    $sql = "UPDATE users SET first_name='$firstName', last_name='$lastName', email='$email', gender='$gender',date_of_birth='$dateOfBirth', birth_place='$birthPlace',contact_number='$contactNumber', document_type='$documentType', passport_number='$passportNumber',nationality='$nationality', address='$address', address2='$address2', city='$city',state='$state', zip='$zip' WHERE user_id = $user_id";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true, "message" => "Profile updated successfully"]);

    } else {
        echo json_encode(["failure" => false, "message" => "Error updating profile"]);
      
    }
    mysqli_close($conn);
} else {
    echo "Invalid request method!";
}
?>