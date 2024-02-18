<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Flight Booking System</h2>
        
        <div class="row">
            <!-- Form Section -->
            <div class="col-md-6">
                <form id="flightSearchForm">
                    <div class="form-group">
                        <label for="origin">Origin:</label>
                        <input type="text" class="form-control" id="origin" name="origin" required>
                    </div>
                    <div class="form-group">
                        <label for="destination">Destination:</label>
                        <input type="text" class="form-control" id="destination" name="destination" required>
                    </div>
                    <div class="form-group">
                        <label for="departureDate">Departure Date:</label>
                        <input type="date" class="form-control" id="departureDate" name="departureDate" required>
                    </div>
                    <div class="form-group">
                        <label for="adults">Adults:</label>
                        <input type="text" class="form-control" id="adults" name="adults" required>
                    </div>
                    <button type="button" class="btn btn-primary" id="searchFlightsBtn">Search Flights</button>
                </form>
            </div>

            <!-- Flight Results Section -->
            <div class="col-md-6">
                <div id="flightResults" class="mt-3"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="main.js"></script>
</body>
</html>
