<?php
session_start();
include "db.php";

if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit;
}
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


</head>

<body>

    <?php include('navbar.php'); ?>

    <div class="container">
        <div class="table-responsive">
            <table class="table" id="bookingTable">
                <thead>
                    <tr>
                        <!-- <th>Order ID</th> -->
                        <th>Traveler Name</th>
                        <th>From Airport</th>
                        <th>Departure Time</th>
                        <th>To Airport</th>
                        <th>Arrival Time</th>
                        <th>Duration (HH:MM)</th>
                        <th>Airline Code</th>
                        <th>Flight Number</th>
                        <th>Class</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $userId = $_SESSION['user_id'];

                        $sql = "SELECT  orders.order_id As OrderID, orders.booking_date As travelDate, travelers.date_of_birth As dob, travelers.gender As gender, travelers.first_name As first_name,
                                travelers.last_name As last_name, travelers.email As email, departure_airport.city AS source_city, departure_airport.country AS source_country,
                                arrival_airport.city AS destination_city, arrival_airport.country AS destination_country, flights.departure_time As departure_time ,flights.arrival_time As arrival_time ,flights.airline_code As airline_code, flights.flight_number As flight_number, flights.cabin_class As cabin_class
                            FROM
                            orders
                            JOIN travelers ON orders.id = travelers.order_id
                            JOIN flights ON orders.id = flights.order_id
                            JOIN locations ON orders.id = locations.order_id
                            JOIN airports AS departure_airport ON flights.departure_airport = departure_airport.iata_code
                            JOIN airports AS arrival_airport ON flights.arrival_airport = arrival_airport.iata_code
                            WHERE orders.user_id = $userId
                             ORDER BY orders.created_at DESC";
                        } else {
                            echo "User not logged in.";
                        }

          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
           $departureTime = strtotime($row['departure_time']);
           $arrivalTime = strtotime($row['arrival_time']);
           $duration = gmdate("H:i", $arrivalTime - $departureTime);
           echo "<tr>";
                    //  echo "<td>" . $row['OrderID'] . "</td>";
           echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
           echo "<td>" . $row['source_city'] . "</td>";
           echo "<td>" . $row['departure_time'] . "</td>";
           echo "<td>" . $row['destination_city'] . "</td>";
           echo "<td>" . $row['arrival_time'] . "</td>";
           echo "<td>" . $duration . "</td>";
           echo "<td>" . $row['airline_code'] . "</td>";
           echo "<td>" . $row['flight_number'] . "</td>";
           echo "<td>" . $row['cabin_class'] . "</td>";

           echo "<td class='text-center'>" ."<div class='btn-group' role='group'>" .
           "<a href='#' class='btn btn-success' onclick='showOrderDetails(\"" . htmlspecialchars($row['OrderID'], ENT_QUOTES) . "\")' data-toggle='tooltip' data-placement='top' title='View Order'>" .
           "<span class='glyphicon glyphicon-user'></span>" .
           "</a>" .
           "</div>" .
           "</td>";
           echo "<td class='text-center'>" .
           "<div class='btn-group' role='group'>" .
           "<a href='#' class='btn btn-primary' onclick='showSeatMap(\"" . htmlspecialchars($row['OrderID'], ENT_QUOTES) . "\")' data-toggle='tooltip' data-placement='top' title='View Seat Map'>" .
           "<span class='glyphicon glyphicon-envelope'></span>" .
           "</a>" .
           "</div>" .
           "</td>";



           echo "</tr>";
         }
         ?>
                </tbody>
            </table>
        </div>
    </div>


    <script>
    function showSeatMap(orderId) {
        alert("Show Seat Map for Order ID: " + orderId);
        $.ajax({
            url: `seatmaps.php`,
            type: 'post',
            contentType: 'application/json',
            data: JSON.stringify({
                'flight-orderId': orderId
            }),
            success: function(response) {
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("flightOrderId not found on server");
                console.error('AJAX Error:', textStatus, errorThrown);
            },

        });
    }

    function showOrderDetails(orderId) {
        // Your logic to show order details for the given orderId
        alert("Show Order Details for Order ID: " + orderId);
        alert("Show Seat Map for Order ID: " + orderId);
        $.ajax({
            url: `showOrderDetails.php`,
            type: 'post',
            contentType: 'application/json',
            data: JSON.stringify({
                'flight-orderId': orderId
            }),
            success: function(response) {
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("flightOrderId not found on server");
                console.error('AJAX Error:', textStatus, errorThrown);
            },

        });
    }
    </script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js" defer="defer"></script>



    <script>
    $(document).ready(function() {
        var table = $('#bookingTable').DataTable({
            "paging": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "pageLength": 10
        });

        $('#searchInput').on('keyup', function() {
            table.search(this.value).draw();
        });

        $('#classFilter').on('change', function() {
            table.column(9).search($(this).val()).draw();
        });
    });
    </script>


</body>

</html>