<?php
include 'db.php';
// session_start();

$query = "SELECT iata_code, city FROM airports";
$result = mysqli_query($conn, $query);

$cityCodes = array();

while ($row = mysqli_fetch_assoc($result)) {
    $cityCodes[] = $row;
}

header('Content-Type: application/json');
echo json_encode($cityCodes);
?>
