<?php
session_start();

include 'dbConfiguration.php';

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    http_response_code(500);
    echo "Database connection failed";
    exit;
}

$email = $_POST['email'];
$passwordInput = $_POST['password'];

$sql = "SELECT id, name, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $name, $hashedPassword);
    $stmt->fetch();

    if (password_verify($passwordInput, $hashedPassword)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['name'] = $name; 
       
        header("Location: ../Get%20Started/get_Started.php"); 
        exit; 
    }
}

header("Location: ../index.php?login=failed");
exit;
