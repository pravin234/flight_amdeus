<?php
session_start();

// Simulating user login; you should replace this with your actual user authentication logic
$_SESSION['user_id'] = 1;
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
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #343a40 !important;
        }

        .navbar-brand,
        .navbar-text {
            color: #ffffff !important;
        }

        #search_form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #search_button {
            background-color: #007bff;
            border: none;
        }

        #flight_offers_result {
            background-color: #ffffff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #flightTable th,
        #flightTable td {
            text-align: center;
        }

        #flightTable th {
            background-color: #343a40;
            color: #ffffff;
        }

        #flightTable tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #flightTable tbody tr:hover {
            background-color: #cce5ff;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand" href="#">Your Logo</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <?php
                    // Check if the user is logged in
                    if (isset($_SESSION['user_id'])) {
                        echo '<span class="navbar-text mr-3">Welcome, User!</span>';
                        echo '<a class="btn btn-outline-danger" href="#">Logout</a>';
                    } else {
                        echo '<a class="btn btn-outline-success" href="#">Login</a>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Travel Search</h1>
                <form id="search_form">
                    <div class="form-row align-items-end">
                        <!-- Your form fields go here -->
                        <div class="col-md-2 mb-2">
                            <label for="origin">Source</label>
                            <input type="text" class="form-control" id="origin" name="origin" required="required">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="destination">Destination</label>
                            <input type="text" class="form-control" id="destination" name="destination" required="required">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="departure_date">Departure Date</label>
                            <input type="date" class="form-control" id="departure_date" name="departure_date"
                                placeholder="YYYY-MM-DD">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="adults">Adults</label>
                            <select class="form-control" id="adults" name="adults">
                                <option>01</option>
                                <option>02</option>
                                <option>03</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button type="button" class="btn btn-primary" id="search_button">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div id="flight_offers_result" class="card">
                    <div class="card-body">
                        <!-- Table will be inserted here dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    function bookFlight(flightOfferData) {
        if (flightOfferData) {
            $.ajax({
                url: 'flight_offers_pricing.php',
                type: 'POST',
                data: JSON.stringify(flightOfferData),
                contentType: 'application/json',
                success: function (response) {
                    displayFlightOfferPopup(response);
                    alert('Flight booked successfully!');
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                },
            });
        }
    }

    $(document).ready(function () {
            // Initialize DataTable once on page load
            var dataTable = $('#flightTable').DataTable({
                // DataTable options can be configured here
            });

            $("#search_button").click(function () {
                $.ajax({
                    type: "POST",
                    url: "get_flight_offers.php",
                    data: $("#search_form").serialize() + "&ajax=1",
                    dataType: "json",
                    success: function (response) {
                        displayFlightOffers(response);
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    },
                });
            });

            function displayFlightOffers(flights) {
                var table = "<table class='table table-bordered mt-4' id='flightTable'><thead class='thead-dark'><tr><th>Departure Time</th><th>Arrival Time</th><th>Price</th><th>Available Seats</th><th>Fare Type</th><th>Flight Number</th><th>Airline</th><th>Travel Type</th><th>Currency</th><th>Total Price</th><th>Action</th></tr></thead><tbody>";

                $.each(flights, function (index, flight) {
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
                    table += "<td><button class='btn btn-primary btn-sm' onclick='bookFlight(" + JSON.stringify(flight.flightOffer) + ")'>Book</button></td>";
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
        });
    </script>

</body>

</html>
