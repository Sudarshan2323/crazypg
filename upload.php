<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'booking_db');

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed"]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];
    $available_from = $_POST['available_from'];
    $available_to = $_POST['available_to'];

    // Insert room details
    $stmt = $conn->prepare("INSERT INTO rooms (title, description, price, location, capacity, available_from, available_to) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsiis", $title, $description, $price, $location, $capacity, $available_from, $available_to);

    if ($stmt->execute()) {
        $room_id = $stmt->insert_id;
        $stmt->close();

        // Upload images
        $uploaded_files = $_FILES['images'];
        $target_dir = "uploads/";

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        foreach ($uploaded_files['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($uploaded_files['name'][$key]);
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                $stmt = $conn->prepare("INSERT INTO room_images (room_id, image_url) VALUES (?, ?)");
                $stmt->bind_param("is", $room_id, $target_file);
                $stmt->execute();
                $stmt->close();
            }
        }

        echo json_encode(["status" => "success", "message" => "Room added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add room"]);
    }
}

$conn->close();
?>
