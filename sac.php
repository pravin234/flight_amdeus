<?php

$flightOfferData = json_decode(urldecode($_GET['flightOffer']), true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Map</title>
    <!-- Include jQuery -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row" id="cardContainer"></div>

    </div>

    <!-- 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    function seatMap(flightOfferData) {
        if (flightOfferData) {
            $.ajax({
                url: 'seat_map_api_post.php',
                type: 'POST',
                data: JSON.stringify(flightOfferData),
                contentType: 'application/json',
                success: function(response) {
                    var responseData = JSON.parse(response);
                    alert(responseData);
                    displayCard(responseData);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                },
            });
        }
    }

    // Function to display data in card format
    function displayCard(responseData) {
        // Clear existing cards
        cardContainer.innerHTML = '';

        // Loop through the response data and create a card for each item
        responseData.forEach(function(data) {
            // Create a card element
            var card = document.createElement('div');
            card.className = 'card';

            card.className = 'col-xl-3 col-sm-6 col-12';

            // Add card content based on data
            card.innerHTML = `
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="icon-pencil primary font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3>${data.number}</h3>
                                <span>arrivalLocation: ${data.arrivalLocation}</span>
                                <span>arrivalTime: ${data.arrivalTime}</span>
                                <span>terminalArrival: ${data.terminalArrival}</span>
                                <span>departureLocation: ${data.departureLocation}</span>
                                <span>departureTime: ${data.departureTime}</span>
                                <span>terminalDeparture: ${data.terminalDeparture}</span>

                                 <span>carrierCode: ${data.carrierCode}</span>
                                <span>class: ${data.class}</span>
                                 <span>Cabin: ${data.cabin}</span>
                               
                                
                                <span>Seat : ${data.number}</span>
                                <span>characteristicsCodes: ${data.characteristicsCodes}</span>
                                 <span>travelerPricing: ${data.travelerPricing}</span>
                               

                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;




            // Append the card to the container
            cardContainer.appendChild(card);
        });
    }
    </script>

    <!-- Trigger the seatMap function on page load or any event you prefer -->
    <script>
    $(document).ready(function() {
        seatMap(<?php echo json_encode($flightOfferData); ?>);
    });
    </script>

</body>

</html>