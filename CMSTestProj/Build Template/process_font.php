<?php
session_start();
error_log('Process font script started');

// Enable full error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    error_log('No user_id in session - redirecting to login');
    header("Location: ../index.php?login=required");
    exit;
}

require_once('preferences_helper.php'); 
require_once('../db/dbConfiguration.php'); 

$userId = $_SESSION['user_id']; 
error_log('Processing for user ID: ' . $userId);

// Check if we have font data
if (!isset($_POST['selected_font'])) {
    error_log('No font selection found in POST data');
    echo 'Error: No font selection received. Please go back and try again.';
    exit;
}

$selectedFont = $_POST['selected_font'];
error_log('Selected font: ' . $selectedFont);

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_log('Database connection successful');

    // Save the font preference
    if (savePreference($pdo, $userId, 'selected_font', $selectedFont)) {
        // Update session
        $_SESSION['selected_font'] = $selectedFont;
        $_SESSION['submission_time'] = date('Y-m-d H:i:s');
        error_log('Font preference saved successfully');
        
        // Direct redirect without success message
        header('Location: builder/asset_manager.php');
        exit();
    } else {
        error_log('Failed to save font preference');
        echo 'Error: Failed to save your font preference. Please try again.';
    }
} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    echo 'Database Error: ' . $e->getMessage();
} catch (Exception $e) {
    error_log('General error: ' . $e->getMessage());
    echo 'Error: ' . $e->getMessage();
}
?> 