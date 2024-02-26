<?php
session_start();
include 'get_access_token.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    // Retrieve form data
    $originLocationCode = $_POST['origin'];
    $destinationLocationCode = $_POST['destination'];
    $departureDate = $_POST['departure_date'];
    $adults = $_POST['adults'];

    // Call the function with form data
    getFlightOffers($originLocationCode, $destinationLocationCode, $departureDate, $adults);
    exit; // Stop further execution
}

function getFlightOffers($originLocationCode, $destinationLocationCode, $departureDate, $adults){
    try {
        $access_token = getAccessToken();
        $_SESSION['access_token'] = $access_token;
        $api_url = "https://test.api.amadeus.com/v1/shopping/availability/flight-availabilities";
        $request_body = json_encode([
            "originDestinations" =>[
                [
                    "id" => "1", 
                    "originLocationCode" => "BOM", 
                    "destinationLocationCode" => "DEL", 
                    "departureDateTime" => ["date" => "2024-12-29", "time" => "21:15:00" ] 
                ] 
            ],
            "travelers" =>[
                [   "id" => "1", "travelerType" => "ADULT" ], 
                [   "id" => "2", "travelerType" => "CHILD" ] 
            ], 
            "sources" => ["GDS" ] 
        ]);
        // Initialize cURL session for the API call
        $api_ch = curl_init();
        curl_setopt($api_ch, CURLOPT_URL, $api_url);
        curl_setopt($api_ch, CURLOPT_POST, 1);
        curl_setopt($api_ch, CURLOPT_POSTFIELDS, $request_body);
        curl_setopt($api_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($api_ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $_SESSION["access_token"],
            "Content-Type: application/json",
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
        $responseData= json_decode($api_response, true);
        if (isset($responseData['data'])) {
            // Mapping of classes to cabin classes
            $classToCabinMap = [
                'F' => 'First Class',
                'A' => 'First Class',
                'C' => 'Business Class',
                'J' => 'Business Class',
                'R' => 'Business Class',
                'D' => 'Business Class',
                'I' => 'Business Class',
                'W' => 'Premium Economy',
                'P' => 'Premium Economy',
                'Y' => 'Economy',
                'H' => 'Economy',
                'K' => 'Economy',
                'M' => 'Economy',
                'L' => 'Economy',
                'G' => 'Economy',
                'V' => 'Economy',
                'S' => 'Economy',
                'N' => 'Economy',
                'Q' => 'Economy',
                'O' => 'Economy',
                'E' => 'Economy',
                'B' => 'Basic Economy',
            ];
            foreach ($responseData['data'] as $flightAvailability) {
                // Check if the necessary data is present
                if (isset($flightAvailability['segments'])) {
                    // Iterate through each segment
                foreach ($flightAvailability['segments'] as $segment) {
                    // Extract relevant information
 
                    $arrivalDateTime = $segment['arrival']['at'];
                    $arrivalTerminal = isset($segment['arrival']['terminal']) ? $segment['arrival']['terminal'] : null;
                    $arrivalLocation = $segment['arrival']['iataCode'];
                    $departureDateTime = $segment['departure']['at'];
                    $departureTerminal = isset($segment['departure']['terminal']) ? $segment['departure']['terminal'] : null;
                    $departureLocation = $segment['departure']['iataCode'];

                    // Extract available classes and seats
                    $availableClasses = [];
                    foreach ($segment['availabilityClasses'] as $availabilityClass) {
                        $class = $availabilityClass['class'];
                        $cabinClass = $classToCabinMap[$class] ?? 'Unknown Cabin';

                        $availableClasses[] = [
                            'class' => $class,
                            'cabinClass' => $cabinClass,
                            'availableSeats' => $availabilityClass['numberOfBookableSeats']
                        ];
                    }
                    $segmentData = [
                        'arrivalDateTime' => $arrivalDateTime,
                        'arrivalTerminal' => $arrivalTerminal,
                        'arrivalTerminal' => $arrivalTerminal,
                        'departureDateTime' =>$departureDateTime,
                        'departureTerminal' =>$departureTerminal,
                        'departureLocation' => $departureLocation,
                        'availableClasses' => $availableClasses ,
                    ];
                    $responseData['availableData'][] = $segmentData;
                }
            }
        }
    } else {
        $errorMessage = isset($responseData['errors']) ? $responseData['errors'][0]['detail'] : 'Unknown error';
        echo json_encode(['status' => 'error', 'message' => $errorMessage]);
    }

    echo json_encode($responseData['availableData']);
    
} catch (Exception $e) {
    // Handle other exceptions
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
}
?>