<?php
session_start();
error_log('Process color script started');

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

// Define palette colors
$palette_colors = [
    'professional1' => ['#ffffff', '#2c3e50', '#34495e'],
    'professional2' => ['#f8f9fa', '#1a237e', '#0d47a1'],
    'professional3' => ['#f5f5f5', '#263238', '#37474f'],
    'playful1'      => ['#fff8e1', '#ff6f00', '#bf360c'],
    'playful2'      => ['#e8f5e9', '#2e7d32', '#1b5e20'],
    'playful3'      => ['#fce4ec', '#d81b60', '#880e4f'],
    'sophisticated1' => ['#fafafa', '#424242', '#212121'],
    'sophisticated2' => ['#f5f5f5', '#455a64', '#263238'],
    'sophisticated3' => ['#fafafa', '#3e2723', '#1b0000'],
    'friendly1'      => ['#e8f5e9', '#43a047', '#1b5e20'],
    'friendly2'      => ['#fff3e0', '#e65100', '#bf360c'],
    'friendly3'      => ['#e3f2fd', '#1976d2', '#0d47a1'],
    'bold1'          => ['#ffffff', '#d32f2f', '#b71c1c'],
    'bold2'          => ['#f5f5f5', '#6a1b9a', '#4a148c'],
    'bold3'          => ['#fafafa', '#c2185b', '#880e4f'],
];

// Check if we have color data
if (!isset($_POST['selected_palette'])) {
    error_log('No color palette selection found in POST data');
    echo 'Error: No color palette selection received. Please go back and try again.';
    exit;
}

$selectedPalette = $_POST['selected_palette'];
error_log('Selected palette: ' . $selectedPalette);

// Get the colors for this palette
if (!isset($palette_colors[$selectedPalette])) {
    error_log('Invalid palette selected: ' . $selectedPalette);
    echo 'Error: Invalid color palette selection.';
    exit;
}

$paletteColors = $palette_colors[$selectedPalette];
error_log('Palette colors: ' . implode(', ', $paletteColors));

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_log('Database connection successful');

    // Save the color preference
    $colorValuesString = implode(',', $paletteColors);
    if (savePreference($pdo, $userId, 'color_scheme', $colorValuesString)) {
        // Update session
        $_SESSION['selected_palette'] = $selectedPalette;
        $_SESSION['selected_palette_colors'] = $paletteColors;
        $_SESSION['submission_time'] = date('Y-m-d H:i:s');
        error_log('Color preference saved successfully');
        
        // Direct redirect without success message
        header('Location: fonts.php');
        exit();
    } else {
        error_log('Failed to save color preference');
        echo 'Error: Failed to save your color preference. Please try again.';
    }
} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    echo 'Database Error: ' . $e->getMessage();
} catch (Exception $e) {
    error_log('General error: ' . $e->getMessage());
    echo 'Error: ' . $e->getMessage();
}
?> 