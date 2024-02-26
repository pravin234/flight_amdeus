<?php

function getAccessToken() {
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
        throw new Exception('Error obtaining access token: ' . curl_error($ch));
    }

    // Close cURL session for token request
    curl_close($ch);

    // Decode the JSON response for token request
    $token_data = json_decode($response, true);

    // Get the access token
    $access_token = $token_data['access_token'];

    return $access_token;
}

?>
