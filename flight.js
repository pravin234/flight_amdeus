    function bookFlight(flightOfferData) {
        if (flightOfferData) {
            $.ajax({
                url: 'flight_offers_pricing.php',
                type: 'POST',
                data: JSON.stringify(flightOfferData),
                contentType: 'application/json',
                success: function(response) {
                    var responseData = JSON.parse(response);
                    alert(JSON.stringify(responseData.purchase));

                    // Display success message using popup
                    displayFlightDetails(responseData);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                },
            });
        }
    }

    // Function to display response data in a Bootstrap modal and price card
    function displayFlightDetails(data) {
        // Generate HTML content for the modal and price card
        var modalContent = '<div class="modal" id="flightDetailsPopup">';
        modalContent += '<div class="modal-dialog">';
        modalContent += '<div class="modal-content">';
        modalContent += '<div class="modal-header">';
        modalContent += '<h5 class="modal-title">Flight Details</h5>';
        modalContent += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        modalContent += '<span aria-hidden="true">&times;</span>';
        modalContent += '</button>';
        modalContent += '</div>';
        modalContent += '<div class="modal-body">';
        modalContent += '<p><strong>Source:</strong> ' + data.offerDetails.source + '</p>';
        modalContent += '<p><strong>Destination:</strong> ' + data.offerDetails.destination + '</p>';
        modalContent += '<p><strong>Price:</strong> ' + data.priceDetails.total + ' ' +
            data.priceDetails.currency +
            '</p>';
        modalContent += '<p><strong>Departure Time:</strong> ' + data.offerDetails.departureTime + '</p>';
        modalContent += '<p><strong>Arrival Time:</strong> ' + data.offerDetails.arrivalTime + '</p>';
        modalContent += "<button class='btn btn-primary btn-sm' onclick='submitPurchaseForm(" + JSON
            .stringify(data.purchase) + ")'>Book</button>";

        modalContent += '</div>';
        modalContent += '</div>';
        modalContent += '</div>';
        modalContent += '</div>';

        // Append the modal HTML content to the body
        $('body').append(modalContent);

        // Show the Bootstrap modal
        $('#flightDetailsPopup').modal('show');
    }


    function submitPurchaseForm(orderData) {
        // Parse the JSON string to convert it into a JavaScript object
        // var parsedFlightOfferData = JSON.parse(flightOfferData);

        // // Check if parsedFlightOfferData is properly received
        // console.log('Parsed Flight Offer Data:', parsedFlightOfferData);
        var parsedOrderData = (typeof orderData === 'string') ? JSON.parse(orderData) :
            orderData;

        // Check if parsedFlightOfferData is properly received
        console.log('Parsed Flight Offer Data:', parsedOrderData);


        if (orderData) {
            $.ajax({
                url: 'order.php',
                type: 'POST',
                data: JSON.stringify(orderData),
                contentType: 'application/json',
                contentType: 'application/json',
                success: function(response) {
                    var responseOrderData = JSON.parse(response);
                    console.log(responseOrderData);
                    alert(JSON.stringify(responseOrderData));


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                },
            });
        }

    }



    $(document).ready(function() {
        var dataTable = $('#flightTable').DataTable({});

        $("#search_button").click(function() {
            resetValidationStyles();

            var source = $("#origin").val();
            var destination = $("#destination").val();
            if (source === destination) {
                showError($("#origin, #destination"),
                    "Please select different source and destination.");
                return;
            }

            // Validate departure date
            var departureDate = $("#departure_date").val();
            if (departureDate === "") {
                showError($("#departure_date"), "Please select a departure date.");
                return;
            }

            // Validate number of adults
            var adults = $("#adults").val();
            if (adults === "") {
                showError($("#adults"), "Please select the number of adults.");
                return;
            }

            $.ajax({
                type: "POST",
                url: "get_flight_offers.php",
                data: $("#search_form").serialize() + "&ajax=1",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    displayFlightOffers(response);
                },
                error(jqXHR, textStatus, errorThrown) {

                    console.error('AJAX Error:', status, error);
                },
            });
        });


        function displayFlightOffers(flights) {
            var table =
                "<table class='table table-bordered mt-4' id='flightTable'>" +
                "<thead class='thead-dark'>" +
                "<tr><th>Departure Time</th><th>Arrival Time</th><th>Price</th><th>Available Seats</th><th>Fare Type</th><th>Flight Number</th><th>Airline</th><th>Travel Type</th><th>Currency</th><th>Total Price</th><th>Action</th></tr>" +
                "</thead><tbody>";

            $.each(flights, function(index, flight) {
                table += "<tr>";
                table += "<td>" + formatDate(flight.departureTime) + "</td>";
                table += "<td>" + formatDate(flight.arrivalTime) + "</td>";
                table += "<td>" + flight.price + "</td>";
                table += "<td>" + flight.availableSeats + "</td>";
                table += "<td>" + flight.fareType + "</td>";
                table += "<td>" + flight.flightNumber + "</td>";
                table += "<td>" + flight.airline + "</td>";
                table += "<td>" + flight.travelType + "</td>";
                table += "<td>" + flight.currency + "</td>";
                table += "<td>" + flight.totalPrice + "</td>";
                table += "<td><button class='btn btn-primary btn-sm' onclick='bookFlight(" + JSON
                    .stringify(flight.flightOffer) + ")'>Book</button></td>";
                table += "</tr>";
            });

            table += "</tbody></table>";


            // Replace the existing DataTable content
            $('#flight_offers_result').html(table);

            // Clear and destroy the existing DataTable
            dataTable.clear().destroy();

            // Initialize DataTable with updated content
            dataTable = $('#flightTable').DataTable({
                // DataTable options can be configured here
            });
        }

        function formatDate(dateTime) {
            var formattedDate = new Date(dateTime);
            return formattedDate.toLocaleString();
        }

        function showError(element, message) {
            element.addClass("is-invalid");
            element.next(".invalid-feedback").text(message);
        }

        function resetValidationStyles() {
            $(".is-invalid").removeClass("is-invalid");
            $(".invalid-feedback").text("");
        }
    });
  
    $(document).ready(function() {
        $.ajax({
            url: 'get_city_codes.php',
            type: 'GET',
            dataType: 'json',
            success: function(cityCodes) {
                // Populate source and destination dropdowns
                populateCityDropdown('origin', cityCodes);
                populateCityDropdown('destination', cityCodes);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            },
        });

        function populateCityDropdown(dropdownId, cityCodes) {
            var dropdown = $('#' + dropdownId);
            $.each(cityCodes, function(index, city) {
                dropdown.append($('<option>', {
                    value: city.iata_code,
                    text: city.city,
                }));
            });
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        var today = new Date().toISOString().split("T")[0];
        document.getElementById("departure_date").min = today;
    });
  