<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'booking_db');

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed"]));
}

$sql = "SELECT r.*, ri.image_url 
        FROM rooms r
        LEFT JOIN room_images ri ON r.room_id = ri.room_id
        GROUP BY r.room_id";

$result = $conn->query($sql);

$rooms = [];

while ($row = $result->fetch_assoc()) {
    $rooms[] = $row;
}

echo json_encode($rooms);

$conn->close();
?>
