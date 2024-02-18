<?php
session_start();
include 'get_access_token.php';

try {
    // Get the JSON data from the POST request
    $flightOffersData = json_decode(file_get_contents('php://input'), true);
    // Print the received data for debugging
    echo 'Received Flight Offers Data: ' . json_encode($flightOffersData) . '<br>';
    // API endpoint for flight_offers_pricing.php
    $api_url = 'https://test.api.amadeus.com/v1/shopping/flight-offers/pricing';
    $request_body = json_encode([
        'data' => [
            'type' => 'flight-offers-pricing',
            'flightOffers' => [ $flightOffersData],
        ]
    ]);
    // Initialize cURL session for the API call
    $api_ch = curl_init();
    curl_setopt($api_ch, CURLOPT_URL, $api_url);
    curl_setopt($api_ch, CURLOPT_POST, 1);
    curl_setopt($api_ch, CURLOPT_POSTFIELDS, $request_body);
    curl_setopt($api_ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($api_ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $_SESSION['access_token'],
        'Content-Type: application/json',
        'X-HTTP-Method-Override: GET'
    ]);

    // Execute cURL session for the API call
    $response = curl_exec($api_ch);

    // Check for cURL errors for the API call
    if (curl_errno($api_ch)) {
        throw new Exception('Error making API call: ' . curl_error($api_ch));
    }

    // Decode the JSON response for the API call
    $api_response = json_decode($response, true);

    // Print debug information
    echo 'Access Token: ' . $_SESSION['access_token'] . '<br>';
    echo 'API Response: ' . json_encode($api_response);

    // Close cURL session for the API call
    curl_close($api_ch);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
