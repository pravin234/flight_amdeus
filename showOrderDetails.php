<?php
session_start();
include 'get_access_token.php';

// try {
    // if (!isset($_SESSION['access_token'])) {
    $access_token = getAccessToken();
    $_SESSION['access_token'] = $access_token;
    // }
    $data = json_decode(file_get_contents("php://input"), true);
    if($data['flight-orderId']){
    $api_url = 'https://test.api.amadeus.com/v1/booking/flight-orders/' . $data['flight-orderId'];
    $api_ch = curl_init();
    curl_setopt($api_ch, CURLOPT_URL, $api_url);
    curl_setopt($api_ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($api_ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $_SESSION['access_token'],
        'Content-Type: application/json',
    ]);

    // Execute cURL session for the API call
    $response = curl_exec($api_ch);

    // Check for cURL errors for the API call
    if (curl_errno($api_ch)) {
        throw new Exception('Error making API call: ' . curl_error($api_ch));
    }

    // Close the cURL session
    curl_close($api_ch);

    // Output the API response
    echo $response;

   }

    // API endpoint for seatmaps.php

// } catch (Exception $e) {
//     // Output an error message
//     echo json_encode(['error' => $e->