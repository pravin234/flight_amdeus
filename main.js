$(document).ready(function () {
    // Handle button click
    $("#searchFlightsBtn").click(function () {
        // Show loader while waiting for the response
        var loader = $('<div class="loader"></div>');
        $("#flightResults").empty().append(loader);

        // Make AJAX call
        $.ajax({
            url: "main.php",
            type: "POST",
            data: $("#flightSearchForm").serialize() + "&ajax=1",
            success: function (response) {
                // Remove the loader
                loader.remove();

                // Check if the response has data
                if (response && response.data) {
                    // Create a table dynamically
                    var table = $('<table>').addClass('flight-table');
                    var headerRow = $('<tr>').append(
                        $('<th>').text('Flight Number'),
                        $('<th>').text('Departure Time'),
                        $('<th>').text('Arrival Time'),
                        $('<th>').text('Price'),
                        $('<th>').text('Book Now')
                    );
                    table.append(headerRow);

                    // Populate table with flight details
                    $.each(response.data, function (index, flight) {
                        var row = $('<tr>').append(
                            $('<td>').text(flight.flightNumber),
                            $('<td>').text(flight.departureTime),
                            $('<td>').text(flight.arrivalTime),
                            $('<td>').text(flight.price),
                            $('<td>').html('<button onclick="bookFlight(' + flight.id + ')">Book Now</button>')
                        );
                        table.append(row);
                    });

                    // Append table to the result div
                    $("#flightResults").append(table);
                } else {
                    // Display a message if no data found
                    $("#flightResults").text("No flight offers available.");
                }
            },
            error: function (xhr, status, error) {
                // Hide the loader on error
                loader.remove();

                console.error("AJAX Error: " + status + "\n" + error);
            }
        });
    });
});

// Function to handle flight booking
function bookFlight(flightId) {
    alert('Booking flight with ID: ' + flightId);
}
