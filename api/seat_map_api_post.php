<?php
session_start();
include 'get_access_token.php';

try {
    $flightOffersData = json_decode(file_get_contents('php://input'), true);

    // API endpoint for flight_offers_pricing.php
    // $api_url = 'https://test.api.amadeus.com/v1/shopping/flight-offers/pricing';
    $api_url = 'https://test.api.amadeus.com/v1/shopping/seatmaps';

       $request_body = json_encode([
        'data' => [
          
            $flightOffersData,
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

    //   echo "<pre>";print_r($data);echo "<pre>";

    

    // Process the data and create a proper response structure

    // $seatDetails = [];
    // foreach ($data['data'] as $seatmap) {
    //     $departure = $seatmap['departure'];
    //     $arrival = $seatmap['arrival'];
    //     $terminalDeparture = $departure['terminal'];
    //     $terminalArrival = $arrival['terminal'];
    //     $carrierCode = $seatmap['carrierCode'];
    //     $aircraft = $seatmap['aircraft']['code'];
    //     foreach ($seatmap['decks'] as $deck) {
    //         foreach ($deck['seats'] as $seat) { 
      //           if($seat['travelerPricing']['seatAvailabilityStatus'] ==='AVAILABLE'){
    //                 $seatDetails[] = [
    //                 'departureLocation' => $departure['iataCode'],
    //                 'arrivalLocation' => $arrival['iataCode'],
    //                 'terminalDeparture' => $terminalDeparture,
    //                 'terminalArrival' => $terminalArrival,
    //                 'carrierCode' => $carrierCode,
    //                 'aircraft' => $aircraft,
    //                 'class' => $seatmap['class'],
    //                 'cabin' => $seat['cabin'],
    //                 'number' => $seat['number'],
    //                 'characteristicsCodes' => @$seat['characteristicsCodes'],
    //                 'travelerPricing' => $seat['travelerPricing']['seatAvailabilityStatus'],
    //                 'coordinates' => $seat['coordinates'],
    //             ];

    //             }
                
    //         }
    //     }
    // }

    $responseData = [];
    if($data['data']){
         foreach ($data['data'] as $seatmap){
        $departure = $seatmap['departure'];
        $arrival = $seatmap['arrival'];
        $terminalDeparture = $departure['terminal'] ?? null;
        $terminalArrival = $arrival['terminal'] ?? null;
        $carrierCode = $seatmap['carrierCode'];
        $aircraft = $seatmap['aircraft']['code'];
        foreach ($seatmap['decks'] as $deck) {
        foreach ($deck['seats'] as $seat) {
            $availabilityStatus = $seat['travelerPricing'][0]['seatAvailabilityStatus'];
            // Check availability directly in the travelerPricing array
            // print_r( $seat['travelerPricing']);
            // exit;
            if ($availabilityStatus === 'AVAILABLE') {
                $cabinClass = $seat['cabin'];
                $seatNumber = $seat['number'];
                $characteristicsCodes = $seat['characteristicsCodes'];
                $coordinates = $seat['coordinates'];

                $seatDetails[] = [
                    'departureLocation' => $departure['iataCode'],
                    'departureTime' => $departure['at'],
                    'arrivalLocation' => $arrival['iataCode'],
                    'arrivalTime' => $arrival['at'],
                    'terminalDeparture' => $terminalDeparture,
                    'terminalArrival' => $terminalArrival,
                    'carrierCode' => $carrierCode,
                    'aircraft' => $aircraft,
                    'class' => $seatmap['class'],
                    'cabin' => $seat['cabin'],
                    'number' => $seat['number'],
                    'characteristicsCodes' => @$seat['characteristicsCodes'],
                    'travelerPricing' => 'AVAILABLE',
                    'coordinates' => $seat['coordinates'],
                ];
            }


        }
    }
    }
   
}

    //   echo "<pre>";print_r($seatDetails);echo "<pre>";
    

    // Output the JSON response
    echo json_encode($seatDetails);

    // Close the cURL session
    curl_close($api_ch);
} catch (Exception $e) {
    // Output an error message
    echo json_encode(['error' => $e->getMessage()]);
}
?>