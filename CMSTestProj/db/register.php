<?php
ob_start();
error_reporting(0); 
header('Content-Type: text/plain');

include 'dbConfiguration.php';

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

$checkSql = "SELECT id FROM users WHERE email = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    http_response_code(409); // Conflict
    echo "Email already exists";
    $checkStmt->close();
    $conn->close();
    exit;
}

$checkStmt->close();

$sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $password);

if ($stmt->execute()) {
    http_response_code(200);
    echo "success";
} else {
    http_response_code(400);
    echo "Something went wrong";
}

$stmt->close();
$conn->close();
?>
