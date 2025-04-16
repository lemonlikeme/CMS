<?php
header('Content-Type: text/plain');

include 'dbConfiguration.php';

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    http_response_code(500);
    echo "Database connection failed";
    exit;
}

$email = $_POST['email'];
$passwordInput = $_POST['password'];

$sql = "SELECT id, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $hashedPassword);
    $stmt->fetch();

    if (password_verify($passwordInput, $hashedPassword)) {
        http_response_code(200);
        echo "success";
    } else {
        http_response_code(401);
        echo "Invalid credentials";
    }
} else {
    http_response_code(401);
    echo "Invalid credentials";
}

$stmt->close();
$conn->close();