<?php
session_start();
if (!isset($_SESSION['email'])) {
    // Redirect to the login page
    header("Location: index.php");
    exit();
}
$accessToken = @$_SESSION['access_token'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Search</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
</head>

<body style="background-color:white;">

    <?php include('navbar.php');?>

    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12">

                <div class="row  text-black p-1">
                    <div class="col-md-2">
                        <!-- Your content at the top-left -->
                        <h4>FLight Search</h4>
                    </div>
                    <div class="col-md-8">
                        <!-- Empty column to center content -->
                    </div>
                    <div class="col-md-2">
                        <!-- Search button on the left -->
                        <button id="searchToggleBtn" class="btn btn-light">
                            <i class="fa fa-search"></i><i class="fa fa-plane" aria-hidden="true"></i> Search
                        </button>
                    </div>
                </div>

                <div id="searchFormContainer" style="display: none;">
                    <form id="search_form">
                        <div class="form-row align-items-end">
                            <div class="col-md-2 mb-2">
                                <label for="origin"><img style={{ width: "30px" }} src="departure.png
                                    " />
                                    <select class="form-control" id="origin" name="origin" required="required"></select>
                                    <div class="invalid-feedback">Please select a valid source.</div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="destination">
                                    <img style={{ width: "30px" }} src="arrival.png" /></label></label>
                                <select class="form-control" id="destination" name="destination"
                                    required="required"></select>
                                <div class="invalid-feedback">Please select a valid destination.</div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="departure_date"><img style={{ width: "30px" }} src="calender.png
                                    " /></label>
                                <input type="date" class="form-control" id="departure_date" name="departure_date"
                                    placeholder="YYYY-MM-DD" required="required">
                                <div class="invalid-feedback">Please select a valid departure date.</div>
                            </div>

                            <div class="col-md-2 mb-2">
                                <label for="adults"><img style={{ width: "30px" }} src="person.png" /></label>
                                <select class="form-control" id="adults" name="adults" required="required">
                                    <option value="">Select Adults</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                </select>
                                <div class="invalid-feedback">Please select the number of adults.</div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="adults"><img style={{ width: "30px" }} src="person.png" /></label>
                                <select class="form-control" id="children" name="children" required="required">
                                    <option value="">Select Child</option>
                                    <option value="00">00</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                </select>
                                <div class="invalid-feedback">Please select the number of childern.</div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="travelClass"><img style={{ width: "30px" }} src="person.png" /></label>
                                <select class="form-control" id="travelClass" name="travelClass" required="required">
                                    <option value="">Select Class</option>
                                    <option value="ECONOMY">Economy</option>
                                    <option value="PREMIUM_ECONOMY">Premium Economy</option>
                                    <option value="BUSINESS">Business</option>
                                    <option value="FIRST">First</option>
                                </select>
                                <div class="invalid-feedback">Please select a valid travel class.</div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-primary" id="search_button"> <i
                                        class="fa fa-plane text-primary-d1 text-110 mr-2 mt-1"></i></button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <br>
        <div class="row">

            <div class="col-md-2">
                <div class="card">
                    <div class="card-header">
                        <div class="panel-heading">
                            <div class="panel-title pull-left">
                                Search Airport Name
                            </div>
                            <div class="panel-title pull-right">

                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                    <div class="card-body">
                        <form id="search_city_form">
                            <div class="form-group">
                                <label for="search_city">Search City</label>
                                <input type="text" class="form-control" id="search_city" name="search_city"
                                    placeholder="Enter city">
                            </div>
                            <div class="form-group">
                                <label for="search_country">Search Country</label>
                                <input type="text" class="form-control" id="search_country" name="search_country"
                                    placeholder="Enter country">
                            </div>

                            <button type="button" class="btn btn-primary" id="search_city_button">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="panel-heading">
                            <div class="panel-title pull-left">
                                Flight Search
                            </div>
                            <div class="panel-title pull-right">

                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="clearfix">
                            <div id="flight_offers_result" class="card">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="flightOfferPopupModal" tabindex="-1" role="dialog"
        aria-labelledby="flightOfferPopupModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="flightOfferPopupModalLabel">Flight Offer Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="flightOfferPopupContent">
                </div>
            </div>
        </div>
    </div>
    <div id="popup" style="display: none;"></div>
    <div id="successMessage"> </div>

    <script>
    function bookFlight(flightOfferData) {

        if (flightOfferData) {
            if (flightOfferData) {
                //try for set button data json data next request purpose
                var storedFlightOfferDataString = localStorage.getItem('flightOfferData');
                var storedFlightOfferData;
                if (storedFlightOfferDataString) {
                    // If stored data exists, parse it to a JSON object
                    storedFlightOfferData = JSON.parse(storedFlightOfferDataString);

                    // Update stored data with new flightOfferData
                    Object.assign(storedFlightOfferData, flightOfferData);

                    // Convert the updated JSON object to a string
                    var updatedFlightOfferDataString = JSON.stringify(storedFlightOfferData);

                    // Store the updated string in local storage
                    localStorage.setItem('flightOfferData', updatedFlightOfferDataString);

                    // Log the updated data
                    console.log('Flight offer data updated:', storedFlightOfferData);
                } else {
                    // If no stored data exists, simply store the new flightOfferData
                    var flightOfferDataString = JSON.stringify(flightOfferData);
                    localStorage.setItem('flightOfferData', flightOfferDataString);

                    // Log the initial data
                    console.log('Flight offer data set:', flightOfferData);
                }
            }

            $.ajax({
                url: 'api/flight_offers_pricing.php',
                type: 'POST',
                data: JSON.stringify(flightOfferData),
                contentType: 'application/json',
                success: function(response) {
                    var responseData = JSON.parse(response);
                    alert(JSON.stringify(responseData.purchase));

                    displayFlightDetails(responseData);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                },
            });
        }
    }

    function seatMap(flightOfferData) {
        if (flightOfferData) {

            $.ajax({
                url: 'api/seat_map_api_post.php',
                type: 'POST',
                data: JSON.stringify(flightOfferData),
                contentType: 'application/json',
                success: function(response) {
                    var responseData = JSON.parse(response);
                    alert(JSON.stringify(responseData.purchase));
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                },
            });
        }
    }



    // Function to display response data in a Bootstrap modal and price card
    function displayFlightDetails(data) {
        // var data = true;

        // if (data) {

        //     $("#flight_offers_result").show();
        // } else {
        //     $("#flight_offers_result").hide();
        // }
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
            .stringify(data.purchase) + ")'>Purchase</button>";

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
        var parsedOrderData = (typeof orderData === 'string') ? JSON.parse(orderData) : orderData;
        console.log('Parsed Order Data:', parsedOrderData);
        alert(orderData);
        $('#flightDetailsPopup').modal('hide');

        if (orderData) {
            $.ajax({
                url: 'api/order.php',
                type: 'POST',
                data: JSON.stringify(orderData),
                contentType: 'application/json',
                success: function(response) {
                    console.log('AJAX Success Response:', response);
                    alert(response);
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
            var departureDate = $("#departure_date").val();
            var adults = $("#adults").val();
            var travelClass = $("#travelClass").val();

            // Validate source and destination
            if (source === destination) {
                showError($("#origin, #destination"),
                    "Please select different source and destination.");
                return;
            }

            // Validate departure date
            if (departureDate === "") {
                showError($("#departure_date"), "Please select a departure date.");
                return;
            }

            // Validate number of adults
            if (adults === "") {
                showError($("#adults"), "Please select the number of adults.");
                return;
            }

            // Validate travel class
            if (travelClass === "") {
                showError($("#travelClass"), "Please select travel class.");
                return;
            }


            $.ajax({
                type: "POST",
                url: "api/get_flight_offers.php",
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
                "<tr><th>Departure Time</th><th>Arrival Time</th><th>Available Seats</th><th>Flight Number</th><th>Airline</th><th>Travel Type</th><th>Currency</th><th>Class</th><th>Total Price</th><th>Action</th><th></th></tr>" +
                "</thead><tbody>";

            $.each(flights, function(index, flight) {
                table += "<tr>";
                table += "<td>" + formatDate(flight.departureTime) + "</td>";
                table += "<td>" + formatDate(flight.arrivalTime) + "</td>";
                //table += "<td>" + flight.price + "</td>";
                table += "<td>" + flight.availableSeats + "</td>";
                // table += "<td>" + flight.fareType + "</td>";
                table += "<td>" + flight.flightNumber + "</td>";
                table += "<td>" + flight.airline + "</td>";
                table += "<td>" + flight.travelType + "</td>";
                table += "<td>" + flight.currency + "</td>";
                table += "<td>" + flight.class + "</td>";
                table += "<td>" + flight.currency + ' ' + flight.totalPrice + "</td>";
                table += "<td><button class='btn btn-primary btn-sm' onclick='bookFlight(" + JSON
                    .stringify(flight.flightOffer) +
                    ")'>Book</button><button class='btn btn-primary btn-sm' onclick='seatMap(" +
                    JSON
                    .stringify(flight.flightOffer) + ")'>Seat Map</button></td>";
                table += "<td><a href='sac.php?flightOffer=" + encodeURIComponent(JSON
                    .stringify(flight.flightOffer)) + "'>Edit</a></td>";
                table += "</tr>";
            });

            table += "</tbody></table>";

            $('#flight_offers_result').html(table);

            dataTable.clear().destroy();

            dataTable = $('#flightTable').DataTable({});
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
    </script>

    <script>
    $(document).ready(function() {
        //populate data for dropdown
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
    </script>

    <script>
    $("#searchToggleBtn").click(function() {
        $("#searchFormContainer").slideToggle();

    });

    document.addEventListener("DOMContentLoaded", function() {
        var today = new Date().toISOString().split("T")[0];
        document.getElementById("departure_date").min = today;
    });
    </script>

    <script>
    $(document).ready(function() {

        $("#search_city_button").click(function() {
            // Get form data
            var formData = {
                search_city: $("#search_city").val(),
                search_country: $("#search_country").val()
            };

            $.ajax({
                type: "POST",
                url: "your_ajax_handler.php",
                data: formData,
                dataType: "json",
                success: function(response) {
                    // Handle the success response
                    console.log(response);

                    // You can update the UI or perform additional actions here
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle the error
                    console.error('AJAX Error:', textStatus, errorThrown);
                }
            });
        });
    });
    </script>

</body>

</html>