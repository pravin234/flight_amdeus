<?php
session_start();
include 'get_access_token.php';

// try {
    $flightOffersData = json_decode(file_get_contents('php://input'), true);

    // API endpoint for flight_offers_pricing.php
    $api_url = 'https://test.api.amadeus.com/v1/booking/flight-orders';
    $request_body = json_encode([
        'data' => [
            "type" => "flight-order",
            'flightOffers' => [$flightOffersData],
            "travelers" => [
            [
               "id" => "1", 
               "dateOfBirth" => "1994-04-16", 
               "name" => [
                  "firstName" => "Pravin", 
                  "lastName" => "Kadam" 
               ], 
               "gender" => "MALE", 
               "contact" => [
                     "emailAddress" => "pravinkadam234@gmail.com", 
                     "phones" => [
                        [
                           "deviceType" => "MOBILE", 
                           "countryCallingCode" => "91", 
                           "number" => "9403739410" 
                        ] 
                     ] 
                  ], 
               "documents" => [
                              [
                                 "documentType" => "PASSPORT", 
                                 "birthPlace" => "Madrid", 
                                 "issuanceLocation" => "Madrid", 
                                 "issuanceDate" => "2015-04-14", 
                                 "number" => "00000000", 
                                 "expiryDate" => "2025-04-14", 
                                 "issuanceCountry" => "ES", 
                                 "validityCountry" => "ES", 
                                 "nationality" => "ES", 
                                 "holder" => true 
                              ] 
                           ] 
            ], 
            [
                                    "id" => "2", 
                                    "dateOfBirth" => "2012-10-11", 
                                    "gender" => "FEMALE", 
                                    "contact" => [
                                       "emailAddress" => "omkarkadam@gmail.com", 
                                       "phones" => [
                                          [
                                             "deviceType" => "MOBILE", 
                                             "countryCallingCode" => "91", 
                                             "number" => "9403739410" 
                                          ] 
                                       ] 
                                    ], 
                                    "name" => [
                                                "firstName" => "Omkar", 
                                                "lastName" => "Kadam" 
                                             ] 
                                 ] 
         ], 
         "remarks" => [
                                                   "general" => [
                                                      [
                                                         "subType" => "GENERAL_MISCELLANEOUS", 
                                                         "text" => "ONLINE BOOKING FROM INCREIBLE VIAJES" 
                                                      ] 
                                                   ] 
                                                ], 
         "ticketingAgreement" => [
                                                            "option" => "DELAY_TO_CANCEL", 
                                                            "delay" => "6D" 
                                                         ], 
         "contacts" => [
                                                               [
                                                                  "addresseeName" => [
                                                                     "firstName" => "PABLO", 
                                                                     "lastName" => "RODRIGUEZ" 
                                                                  ], 
                                                                  "companyName" => "INCREIBLE VIAJES", 
                                                                  "purpose" => "STANDARD", 
                                                                  "phones" => [
                                                                        [
                                                                           "deviceType" => "LANDLINE", 
                                                                           "countryCallingCode" => "34", 
                                                                           "number" => "480080071" 
                                                                        ], 
                                                                        [
                                                                              "deviceType" => "MOBILE", 
                                                                              "countryCallingCode" => "33", 
                                                                              "number" => "480080072" 
                                                                           ] 
                                                                     ], 
                                                                  "emailAddress" => "support@increibleviajes.es", 
                                                                  "address" => [
                                                                                 "lines" => [
                                                                                    "Calle Prado, 16" 
                                                                                 ], 
                                                                                 "postalCode" => "28014", 
                                                                                 "cityName" => "Madrid", 
                                                                                 "countryCode" => "ES" 
                                                                              ] 
                                                               ] 
                                                            ] 
                                                                                ], 
                                                                            ]
);
    

    // Initialize cURL session for the API call
    $api_ch = curl_init();
    curl_setopt($api_ch, CURLOPT_URL, $api_url);
    curl_setopt($api_ch, CURLOPT_POST, 1);
    curl_setopt($api_ch, CURLOPT_POSTFIELDS, $request_body);
    curl_setopt($api_ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($api_ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $_SESSION['access_token'],
        'Content-Type: application/json',
    ]);

    $response = curl_exec($api_ch);

    if (curl_errno($api_ch)) {
        throw new Exception('Error making API call: ' . curl_error($api_ch));
    }

    $orderData = json_decode($response, true);
   
    echo json_encode($orderData);
    $orderType = $orderData['data']['type']; // "flight-order"
    $orderId = $orderData['data']['id']; // "eJzTd9f3co1wCQoBAAtqAnc%3D"
    $queuingOfficeId = $orderData['data']['queuingOfficeId']; // "NCE4D31SB"
    $travelerDetails = [];
    foreach ($orderData['data']['travelers'] as $traveler) {
        $travelerId = $traveler['id'];
        $dateOfBirth = $traveler['dateOfBirth'];
        $gender = $traveler['gender'];
        $firstName = $traveler['name']['firstName'];
        $lastName = $traveler['name']['lastName'];
        $emailAddress = $traveler['contact']['emailAddress'];
        $phoneNumber = $traveler['contact']['phones'][0]['number'];
        $travelerDetails[] = [
            'travelerId' => $travelerId,
            'dateOfBirth' => $dateOfBirth,
            'gender' => $gender,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'emailAddress' => $emailAddress,
            'phoneNumber' => $phoneNumber,];
    }
    $orderArray = [
        'orderType' => $orderType,
        'orderId' => $orderId,
        'queuingOfficeId' => $queuingOfficeId,
        'travelerDetails' => $travelerDetails,
    ];
    echo "<pre>";
    print_r($orderArray);
    echo "<pre>";
 
    // Close the cURL session
    curl_close($api_ch);
// } catch (Exception $e) {
//     // Output an error message
//     echo json_encode(['error' => $e->getMessage()]);
// }
?>