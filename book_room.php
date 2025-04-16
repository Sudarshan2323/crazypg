<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'booking_db');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "redirect", "message" => "Please log in to book a room"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, room_id, check_in, check_out, total_amount, status) VALUES (?, ?, ?, ?, 0, 'Pending')");
    $stmt->bind_param("iiss", $user_id, $room_id, $check_in, $check_out);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Room booked successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to book room"]);
    }

    $stmt->close();
}

$conn->close();
?>
