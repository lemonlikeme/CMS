<?php
session_start();
require_once('preferences_helper.php'); 


if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo "User not authenticated";
    exit;
}

require_once('../db/dbConfiguration.php'); 

$userId = $_SESSION['user_id']; 
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['site_title'])) {
            $siteTitle = $_POST['site_title'];
            if (savePreference($pdo, $userId, 'site_title', $siteTitle)) {
                $_SESSION['site_title'] = $siteTitle;
                header('Location: homepage.php');
                exit;
            } else {
                http_response_code(500);
                echo "Failed to save site title";
            }
        } elseif (isset($_POST['homepage_sections'])) {
            // Save Homepage step
            $homepageSections = implode(',', $_POST['homepage_sections']);
            if (savePreference($pdo, $userId, 'homepage_sections', $homepageSections)) {
                $_SESSION['homepage_sections'] = $_POST['homepage_sections'];
                $_SESSION['homepage_sections_string'] = $homepageSections;
                $_SESSION['submission_time'] = date('Y-m-d H:i:s');
                header('Location: pages.php');
                exit;
            } else {
                http_response_code(500);
                echo "Failed to save homepage sections";
            }
        } elseif (isset($_POST['pages_selected'])) {
            // Save Pages step
            $pagesSelected = implode(',', $_POST['pages_selected']);
            if (savePreference($pdo, $userId, 'pages_selected', $pagesSelected)) {
                echo "Pages saved successfully";
            } else {
                http_response_code(500);
                echo "Failed to save pages";
            }
        } elseif (isset($_POST['color_scheme'])) {
            // Save Colors step
            $colorScheme = $_POST['color_scheme'];
            if (savePreference($pdo, $userId, 'color_scheme', $colorScheme)) {
                echo "Color scheme saved successfully";
            } else {
                http_response_code(500);
                echo "Failed to save color scheme";
            }
        } elseif (isset($_POST['selected_font'])) {
            // Save Fonts step
            $selectedFont = $_POST['selected_font'];
            if (savePreference($pdo, $userId, 'selected_font', $selectedFont)) {
                echo "Font saved successfully";
            } else {
                http_response_code(500);
                echo "Failed to save font";
            }
        } else {
            http_response_code(400); // Bad Request
            echo "Invalid request";
        }
    } else {
        http_response_code(405); // Method Not Allowed
        echo "Invalid request method";
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo "Database connection failed";
    exit;
}
?>