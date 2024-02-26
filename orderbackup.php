<?php
session_start();
include "get_access_token.php";
include "db.php";

// try {
$flightOffersData = json_decode(file_get_contents("php://input"), true);

// API endpoint for flight_offers_pricing.php
$api_url = "https://test.api.amadeus.com/v1/booking/flight-orders";
$request_body = json_encode([
    "data" => [
        "type" => "flight-order",
        "flightOffers" => [$flightOffersData],
        "travelers" => [
            [
                "id" => "1",
                "dateOfBirth" => "1982-01-16",
                "name" => [
                    "firstName" => "Pravin",
                    "lastName" => "Kadam",
                ],
                "gender" => "MALE",
                "contact" => [
                    "emailAddress" => "pravinkadam234@gmail.com",
                    "phones" => [
                        [
                            "deviceType" => "MOBILE",
                            "countryCallingCode" => "91",
                            "number" => "480080076",
                        ],
                    ],
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
                        "holder" => true,
                    ],
                ],
            ],
            [
                "id" => "2",
                "dateOfBirth" => "2012-10-11",
                "gender" => "FEMALE",
                "contact" => [
                    "emailAddress" => "jorge.gonzales833@telefonica.es",
                    "phones" => [
                        [
                            "deviceType" => "MOBILE",
                            "countryCallingCode" => "34",
                            "number" => "480080076",
                        ],
                    ],
                ],
                "name" => [
                    "firstName" => "ADRIANA",
                    "lastName" => "GONZALES",
                ],
            ],
        ],
        "remarks" => [
            "general" => [
                [
                    "subType" => "GENERAL_MISCELLANEOUS",
                    "text" => "ONLINE BOOKING FROM INCREIBLE VIAJES",
                ],
            ],
        ],
        "ticketingAgreement" => [
            "option" => "DELAY_TO_CANCEL",
            "delay" => "6D",
        ],
        "contacts" => [
            [
                "addresseeName" => [
                    "firstName" => "PABLO",
                    "lastName" => "RODRIGUEZ",
                ],
                "companyName" => "INCREIBLE VIAJES",
                "purpose" => "STANDARD",
                "phones" => [
                    [
                        "deviceType" => "LANDLINE",
                        "countryCallingCode" => "34",
                        "number" => "480080071",
                    ],
                    [
                        "deviceType" => "MOBILE",
                        "countryCallingCode" => "33",
                        "number" => "480080072",
                    ],
                ],
                "emailAddress" => "support@increibleviajes.es",
                "address" => [
                    "lines" => ["Calle Prado, 16"],
                    "postalCode" => "28014",
                    "cityName" => "Madrid",
                    "countryCode" => "ES",
                ],
            ],
        ],
    ],
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

$response = curl_exec($api_ch);

if (curl_errno($api_ch)) {
    throw new Exception("Error making API call: " . curl_error($api_ch));
}

$orderData = json_decode($response, true);

echo json_encode($orderData);
if (isset($orderData["data"])) {
    // Extracting basic details
    $orderId = $orderData["data"]["id"];
    $queuingOfficeId = $orderData["data"]["queuingOfficeId"];
    $bookingDate = $orderData["data"]["associatedRecords"][0]["creationDate"];
    $remarks = $orderData["data"]["remarks"]["general"][0]["text"];
    // Inserting order details into the 'orders' table
    $sqlOrders = "INSERT INTO orders (order_id, queuing_office_id, booking_date, remarks) 
              VALUES ('$orderId', '$queuingOfficeId', '$bookingDate', '$remarks')";
    if ($conn->query($sqlOrders) === true) {
        echo "Order details inserted successfully. ";
    } else {
        echo "Error: " . $sqlOrders . "<br>" . $conn->error;
    }

    $orderId = mysqli_insert_id($conn);

    // Extracting traveler details
    $travelers = [];
    if (
        isset($orderData["data"]["travelers"]) &&
        is_array($orderData["data"]["travelers"])
    ) {
        foreach ($orderData["data"]["travelers"] as $traveler) {
            $travelerId = $traveler["id"];
            $dateOfBirth = $traveler["dateOfBirth"];
            $gender = $traveler["gender"];
            $firstName = $traveler["name"]["firstName"];
            $lastName = $traveler["name"]["lastName"];
            $email = $traveler["contact"]["emailAddress"];
            $phone = $traveler["contact"]["phones"][0]["number"]; // Assuming there is at least one phone

            // Creating traveler array
            $travelers[] = [
                "travelerId" => $travelerId,
                "dateOfBirth" => $dateOfBirth,
                "gender" => $gender,
                "firstName" => $firstName,
                "lastName" => $lastName,
                "email" => $email,
                "phone" => $phone,
            ];

            $sql = "INSERT INTO travelers (order_id, traveler_id, date_of_birth, gender, first_name, last_name, email, phone) 
  VALUES ('$orderId', '$travelerId', '$dateOfBirth', '$gender', '$firstName', '$lastName', '$email', '$phone')";
            mysqli_query($conn, $sql);
        }
    }
    // Extracting flight details
    $flightDetails = [];
    if (
        isset($orderData["data"]["flightOffers"]) &&
        is_array($orderData["data"]["flightOffers"])
    ) {
        foreach ($orderData["data"]["flightOffers"] as $flightOffer) {
            $flightId = $flightOffer["id"];
            $source = $flightOffer["source"];
            $totalPrice = $flightOffer["price"]["total"];
            $currency = $flightOffer["price"]["currency"];

            // Assuming there is only one itinerary for simplicity
            $itinerary = $flightOffer["itineraries"][0];
            $segments = $itinerary["segments"];

            // Extracting the first segment details
            $departureAirport = $segments[0]["departure"]["iataCode"];
            $arrivalAirport = $segments[0]["arrival"]["iataCode"];
            $departureTime = $segments[0]["departure"]["at"];
            $arrivalTime = $segments[0]["arrival"]["at"];
            $airlineCode = $segments[0]["carrierCode"];
            $flightNumber = $segments[0]["number"];
            $cabinClass = $segments[0]["co2Emissions"][0]["cabin"]; // Assuming there is at least one cabin

            // Creating flight details array
            $flightDetails[] = [
                "flightId" => $flightId,
                "source" => $source,
                "totalPrice" => $totalPrice,
                "currency" => $currency,
                "departureAirport" => $departureAirport,
                "arrivalAirport" => $arrivalAirport,
                "departureTime" => $departureTime,
                "arrivalTime" => $arrivalTime,
                "airlineCode" => $airlineCode,
                "flightNumber" => $flightNumber,
                "cabinClass" => $cabinClass,
            ];
            $sql = "INSERT INTO flights (order_id, flight_id, source, total_price, currency, departure_airport, arrival_airport, departure_time, arrival_time, airline_code, flight_number, cabin_class) 
  VALUES ('$orderId', '$flightId', '$source', '$totalPrice', '$currency', '$departureAirport', '$arrivalAirport', '$departureTime', '$arrivalTime', '$airlineCode', '$flightNumber', '$cabinClass')";
            mysqli_query($conn, $sql); // Execute the SQL query
        }
    }
    // Extracting travel locations and dates
    $locations = [];
    if (
        isset($orderData["dictionaries"]["locations"]) &&
        is_array($orderData["dictionaries"]["locations"])
    ) {
        foreach (
            $orderData["dictionaries"]["locations"]
            as $locationCode => $locationDetails
        ) {
            $locations[$locationCode] = [
                "cityCode" => $locationDetails["cityCode"],
                "countryCode" => $locationDetails["countryCode"],
            ];
            $sql = "INSERT INTO locations (order_id, location_code, city_code, country_code) 
          VALUES ('$orderId', '$locationCode', '{$locationDetails["cityCode"]}', '{$locationDetails["countryCode"]}')";
            mysqli_query($conn, $sql); // Execute the SQL query
        }
    }

    // Creating the final array to save in the database
    $orderArray = [
        "orderId" => $orderId,
        "queuingOfficeId" => $queuingOfficeId,
        "bookingDate" => $bookingDate,
        "remarks" => $remarks,
        "travelers" => $travelers,
        "flightDetails" => $flightDetails,
        "locations" => $locations,
    ];

    $response = [
        "success" => true,
        "orderId" => $orderId,
    ];

    echo json_encode($response);
    echo "
    <pre>";
    print_r($orderArray);
    echo "<pre>";
} else {
  
    $errorResponse = [
        "success" => false,
        "error" => 'Invalid API response. Missing "data" key.',
    ];

    echo json_encode($errorResponse);
}

// Close the cURL session
curl_close($api_ch);
// } catch (Exception $e) {
//     // Output an error message
//     echo json_encode(['error' => $e->getMessage()]);
// }
?>