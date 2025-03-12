<?php
session_start();
$servername = "localhost";
$username = "root";      
$password = "";             
$database = "apcadnu"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// for message inquiry 
function getNextCustomID($conn) {
    $query = "SELECT custom_id FROM inquiryForm ORDER BY custom_id DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastID = intval(substr($row['custom_id'], 4)); // basta extract after "-"
		$newID = $lastID + 1; 
		  $digits = max(4, strlen((string)$newID));
        return "MSG-" . str_pad($newID, $digits, "0", STR_PAD_LEFT); 
    } elseif ($result) {
        return "MSG-0001"; // Start from MSG-0001 if no entries exist
    } else {
        die("Error retrieving ID: " . $conn->error); // Handle query failure
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['nameD']);
    $email = trim($_POST['emailD']);
    $message = trim($_POST['messageD']);
    $customID = getNextCustomID($conn); 

	// from post to session
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;

	// insertion
    $prepQuery = $conn->prepare("INSERT INTO inquiryForm (custom_id, name, email, message) VALUES (?, ?, ?, ?)");
	if ($prepQuery === false) {
        die("Error preparing query: " . $conn->error);
    }
    $prepQuery->bind_param("ssss", $customID, $name, $email, $message);

    if ($prepQuery->execute()) {
        $prepQuery->close();
        $conn->close();
        header("Location: ContactUs.php");
        exit();
    } else {
        echo "Error: " . $prepQuery->error;
    }
}
$conn->close();
?>
