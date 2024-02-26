<?php
session_start();
include 'get_access_token.php';

try {
    $flightOffersData = json_decode(file_get_contents('php://input'), true);

    // API endpoint for flight_offers_pricing.php
    $api_url = 'https://test.api.amadeus.com/v1/shopping/flight-offers/pricing';
    $request_body = json_encode([
        'data' => [
            'type' => 'flight-offers-pricing',
            'flightOffers' => [$flightOffersData],
        ],
        
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
        'X-HTTP-Method-Override: GET',
    ]);

    // Execute cURL session for the API call
    $response = curl_exec($api_ch);

    // Check for cURL errors for the API call
    if (curl_errno($api_ch)) {
        throw new Exception('Error making API call: ' . curl_error($api_ch));
    }

    // Decode the JSON response for the API call
    $data = json_decode($response, true);

    // Process the data and create a proper response structure
    $flightOffers = $data['data']['flightOffers'];
    $responseData = [];
    foreach ($flightOffers as $flightOffer) {
        $departureLocation = $flightOffer['itineraries'][0]['segments'][0]['departure']['iataCode'];
        $arrivalLocation = $flightOffer['itineraries'][0]['segments'][0]['arrival']['iataCode'];
        $priceDetails = $flightOffer['price']['grandTotal'];

        $responseData['priceDetails'] = [
            'currency' => $flightOffer['price']['currency'],
            'total' => $flightOffer['price']['total'],
            'base' => $flightOffer['price']['base'],
            'grandTotal' => $flightOffer['price']['grandTotal'],
        ];

        $responseData['offerDetails'] = [
            'source' => $departureLocation,
            'destination' => $arrivalLocation,
            'priceOffer' => $priceDetails,
            'amount' => $flightOffer['travelerPricings'][0]['price']['total'],
            'carrierCode' => $flightOffer['validatingAirlineCodes'][0],
            'departureTime' => $flightOffer['itineraries'][0]['segments'][0]['departure']['at'],
            'arrivalTime' => $flightOffer['itineraries'][0]['segments'][0]['arrival']['at'],
        ];
        $responseData['purchase'] = $flightOffer;


        // Add the offer details to the response array
    }

    // Add a success message to the response
   

    // Output the JSON response
    echo json_encode($responseData);

    // Close the cURL session
    curl_close($api_ch);
} catch (Exception $e) {
    // Output an error message
    echo json_encode(['error' => $e->getMessage()]);
}
?>