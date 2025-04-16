<?php
$conn = new mysqli('localhost', 'root', '', 'booking_db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $password, $phone, $address);

    if ($stmt->execute()) {
        header("Location: auth.html");
        exit();
    } else {
        echo "Signup failed.";
    }
}

$conn->close();
?>
