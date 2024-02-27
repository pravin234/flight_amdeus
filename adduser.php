<?php
session_start();
include "get_access_token.php";
include "db.php";
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

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
    $created_by = $_SESSION['user_id'];

    $sql = "INSERT INTO users (first_name, last_name, email, gender, date_of_birth, birth_place, contact_number, document_type, passport_number, nationality, address, address2, city, state, zip,created_by)
            VALUES ('$firstName', '$lastName', '$email', '$gender', '$dateOfBirth', '$birthPlace', '$contactNumber', '$documentType', '$passportNumber', '$nationality', '$address', '$address2', '$city', '$state', '$zip','$created_by')";

    if (mysqli_query($conn, $sql)) {
        echo '<script> alert("Data Saved"); </script>';
        header('Location: index.php');
    
    }
    else
    {
        echo '<script> alert("Data Not Saved"); </script>';
    }
    mysqli_close($conn);
} else {
    echo "Invalid request method!";
}
?>