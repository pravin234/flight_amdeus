<?php

// Set your Amadeus API credentials
$client_id = 'k6a9NOGWyrA6xgAJJbG9ATy3NrE4LdeL';
$client_secret = '0L3ftxmiNGMErfkn';
$grant_type = 'client_credentials';

// Set the token endpoint URL
$token_url = 'https://test.api.amadeus.com/v1/security/oauth2/token';

// Build the request body
$post_data = [
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'grant_type' => $grant_type,
];

// Initialize cURL session for token request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute cURL session for token request
$response = curl_exec($ch);

// Check for cURL errors for token request
if (curl_errno($ch)) {
    echo json_encode(['error' => 'Error obtaining access token: ' . curl_error($ch)]);
    exit;
}

// Close cURL session for token request
curl_close($ch);

// Decode the JSON response for token request
$token_data = json_decode($response, true);

// Get the access token
$access_token = $token_data['access_token'];

// Check if AJAX request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    // Retrieve form data
    $originLocationCode = $_POST['origin'];
    $destinationLocationCode = $_POST['destination'];
    $departureDate = $_POST['departureDate'];
    $adults = $_POST['adults'];

    // Example API call using the obtained access token
    $flight_offers_url = 'https://test.api.amadeus.com/v2/shopping/flight-offers';
    $flight_offers_params = [
        'originLocationCode' => $originLocationCode,
        'destinationLocationCode' => $destinationLocationCode,
        'departureDate' => $departureDate,
        'adults' => $adults,
        'max' => 5,
    ];

    // Build the full URL with parameters
    $full_url = $flight_offers_url . '?' . http_build_query($flight_offers_params);

    // Initialize cURL session for the API call
    $api_ch = curl_init();
    curl_setopt($api_ch, CURLOPT_URL, $full_url);
    curl_setopt($api_ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($api_ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $access_token,
    ]);

    // Execute cURL session for the API call
    $api_response = curl_exec($api_ch);

    // Check for cURL errors for the API call
    if (curl_errno($api_ch)) {
        echo json_encode(['error' => 'Error making API call: ' . curl_error($api_ch)]);
        exit;
    }

    // Close cURL session for the API call
    curl_close($api_ch);

    // Decode the JSON response for the API call
    $flight_offers = json_decode($api_response, true);

    // Output the results as JSON
    //echo json_encode($flight_offers);

    foreach ($flight_offers['data'] as $flightOffer) {
            $itinerary = $flightOffer['itineraries'][0];
            $segment = $itinerary['segments'][0];
            $price = $flightOffer['price'];
            $fareType = $flightOffer['pricingOptions']['fareType'][0];
            $flightNumber = $flightOffer['itineraries'][0]['segments'][0]['number'];
            $travelType = $flightOffer['oneWay'] ? 'One Way' : 'Round Trip';

            // Calculate travel duration

            // Convert currency to INR
            $eurToInrRate = 89.50;
            $currency = $flightOffer['price']['currency'];
            $totalPrice = $flightOffer['price']['total'];
            $convertedPrice = ($currency == 'EUR') ? $totalPrice * $eurToInrRate : $totalPrice;
            $airline = $flightOffer['itineraries'][0]['segments'][0]['operating']['carrierCode'];

            $source = $segment['departure']['iataCode'];
            $destination = $segment['arrival']['iataCode'];

            if ($source === $originLocationCode && $destination === $destinationLocationCode) {
                $flightDetail = array(
                    'source' => $source,
                    'destination' => $destination,
                    'departureTime' => $segment['departure']['at'],
                    'arrivalTime' => $segment['arrival']['at'],
                    'price' => $price['total'],
                    'availableSeats' => $flightOffer['numberOfBookableSeats'],
                    'fareType' => $fareType,
                    'flightNumber' => $flightNumber,
                    'airline' => $airline,
                    'travelType' => $travelType,
                    'currency' => $currency,
                    'totalPrice' => $convertedPrice,
                );
                $flightDetails[] = $flightDetail;
            }
        }
        
        
        return json_encode($flightDetails);
}
?>
