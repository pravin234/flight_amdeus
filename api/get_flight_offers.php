<?php

session_start();
include 'get_access_token.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    // Retrieve form data
    $originLocationCode = $_POST['origin'];
    $destinationLocationCode = $_POST['destination'];
    $departureDate = $_POST['departure_date'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $travelClass = $_POST['travelClass'];
    

    // Call the function with form data
    getFlightOffers($originLocationCode, $destinationLocationCode, $departureDate, $adults,$travelClass);
    exit; // Stop further execution
}

// function getFlightOffers($originLocationCode, $destinationLocationCode, $departureDate, $adults) {
//     try {
//         $access_token = getAccessToken();
//         $_SESSION['access_token'] = $access_token;

//         // Example API call using the obtained access token
//         $flight_offers_url = 'https://test.api.amadeus.com/v2/shopping/flight-offers';
//         $flight_offers_params = [
//             'originLocationCode' => $originLocationCode,
//             'destinationLocationCode' => $destinationLocationCode,
//             'departureDate' => $departureDate,
//             'adults' => $adults,
//             'max' => 100,
//         ];

//         // Build the full URL with parameters
//         $full_url = $flight_offers_url . '?' . http_build_query($flight_offers_params);

//         // Initialize cURL session for the API call
//         $api_ch = curl_init();
//         curl_setopt($api_ch, CURLOPT_URL, $full_url);
//         curl_setopt($api_ch, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($api_ch, CURLOPT_HTTPHEADER, [
//             'Authorization: Bearer ' . $_SESSION['access_token'],
//         ]);

//         // Execute cURL session for the API call
//         $api_response = curl_exec($api_ch);

//         // Check for cURL errors for the API call
//         if (curl_errno($api_ch)) {
//             throw new Exception('Error making API call: ' . curl_error($api_ch));
//         }

//         // Close cURL session for the API call
//         curl_close($api_ch);

//         // Decode the JSON response for the API call
//         $flight_offers = json_decode($api_response, true);

//         foreach ($flight_offers['data'] as $flightOffer) {
//             $itinerary = $flightOffer['itineraries'][0];
//             $segment = $itinerary['segments'][0];
//             $price = $flightOffer['price'];
//             $fareType = $flightOffer['pricingOptions']['fareType'][0];
//             $flightNumber = $flightOffer['itineraries'][0]['segments'][0]['number'];
//             $travelType = $flightOffer['oneWay'] ? 'One Way' : 'Round Trip';

//             // Calculate travel duration

//             // Convert currency to INR
//             $eurToInrRate = 89.50;
//             $currency = $flightOffer['price']['currency'];
//             $totalPrice = $flightOffer['price']['total'];
//             $convertedPrice = ($currency == 'EUR') ? $totalPrice * $eurToInrRate : $totalPrice;

//             $airline = $flightOffer['itineraries'][0]['segments'][0]['operating']['carrierCode'];

//             $source = $segment['departure']['iataCode'];
//             $destination = $segment['arrival']['iataCode'];

//             if ($source === $originLocationCode && $destination === $destinationLocationCode) {
//                 $flightDetail = array(
//                     'source' => $source,
//                     'destination' => $destination,
//                     'departureTime' => $segment['departure']['at'],
//                     'arrivalTime' => $segment['arrival']['at'],
//                     'price' => $price['total'],
//                     'availableSeats' => $flightOffer['numberOfBookableSeats'],
//                     'fareType' => $fareType,
//                     'flightNumber' => $flightNumber,
//                     'airline' => $airline,
//                     'travelType' => $travelType,
//                     'currency' => $currency,
//                     'totalPrice' => number_format($convertedPrice, 2, '.', ''),
//                     'flightOffer' => $flightOffer,
//                 );
//                 $flightDetails[] = $flightDetail;
//             }
//         }
//         echo json_encode($flightDetails);

//     } catch (Exception $e) {
//         echo "Error: " . $e->getMessage();
//     }
// }

function getFlightOffers($originLocationCode, $destinationLocationCode, $departureDate, $adults,$travelClass) {
    try {
        $access_token = getAccessToken();
        $_SESSION['access_token'] = $access_token;

        // Example API call using the obtained access token
        $flight_offers_url = 'https://test.api.amadeus.com/v2/shopping/flight-offers';
        $flight_offers_params = [
            'originLocationCode' => $originLocationCode,
            'destinationLocationCode' => $destinationLocationCode,
            'departureDate' => $departureDate,
            'adults' => $adults,
            'children' => @$children,
            'max' => 100,
            'currencyCode' =>'INR',
            'travelClass' => $travelClass,
        ];

        // Build the full URL with parameters
        $full_url = $flight_offers_url . '?' . http_build_query($flight_offers_params);

        // Initialize cURL session for the API call
        $api_ch = curl_init();
        curl_setopt($api_ch, CURLOPT_URL, $full_url);
        curl_setopt($api_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($api_ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['access_token'],
        ]);

        // Execute cURL session for the API call
        $api_response = curl_exec($api_ch);

        // Check for cURL errors for the API call
        if (curl_errno($api_ch)) {
            throw new Exception('Error making API call: ' . curl_error($api_ch));
        }

        // Close cURL session for the API call
        curl_close($api_ch);

        // Decode the JSON response for the API call
        $flight_offers = json_decode($api_response, true);

        // echo "<pre>";
        // print_r($flight_offers['data'][0]);
        // echo "<pre>";

        if (isset($flight_offers['data'])) {
            $flightDetails = [];
            foreach ($flight_offers['data'] as $flightOffer) {
                $itinerary = $flightOffer['itineraries'][0];
                $segment = $itinerary['segments'][0];
                $price = $flightOffer['price'];
                $fareType = $flightOffer['pricingOptions']['fareType'][0];
                $flightNumber = $flightOffer['itineraries'][0]['segments'][0]['number'];
                $travelType = $flightOffer['oneWay'] ? 'One Way' : 'Round Trip';
                

                // Calculate travel duration

                // Convert currency to INR
                // $eurToInrRate = 89.50;
                $currency = $flightOffer['price']['currency'];
                $totalPrice = $flightOffer['price']['total'];
                $travelClass = $flightOffer['travelerPricings'][0]['fareDetailsBySegment'][0]['cabin'];
                // $convertedPrice = ($currency == 'EUR') ? $totalPrice * $eurToInrRate : $totalPrice;

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
                        'class' => $travelClass,
                        'availableSeats' => $flightOffer['numberOfBookableSeats'],
                        'fareType' => $fareType,
                        'flightNumber' => $flightNumber,
                        'airline' => $airline,
                        'travelType' => $travelType,
                        'currency' => $currency,
                        'totalPrice' => number_format($totalPrice, 2, '.', ''),
                        'flightOffer' => $flightOffer,
                    );
                    $flightDetails[] = $flightDetail;
                }
            }
            echo json_encode( $flightDetails);
        } else {
            // Handle API response errors
            $errorMessage = isset($flight_offers['errors']) ? $flight_offers['errors'][0]['detail'] : 'Unknown error';
            echo json_encode(array('status' => 'error', 'message' => $errorMessage));
        }

    } catch (Exception $e) {
        // Handle other exceptions
        echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
    }
}