<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rindi2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM responsi2";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc())
{
    $data[] = [$row['nama'], $row['longitude'], $row['latitude'], $row['gmaps_url']];
}

header('Content-Type: application/json');
echo json_encode($data);