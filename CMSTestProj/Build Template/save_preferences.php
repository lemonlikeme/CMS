<?php
session_start();

error_log('POST data: ' . print_r($_POST, true));
error_log('About to save font: ' . ($_POST['selected_font'] ?? 'NOT SET'));
require_once('preferences_helper.php'); 

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
        error_log('POST data: ' . print_r($_POST, true));
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
                $_SESSION['pages_selected'] = $_POST['pages_selected'];
                $_SESSION['pages_selected_string'] = $pagesSelected;
                $_SESSION['submission_time'] = date('Y-m-d H:i:s');
                header('Location: colors.php');
                exit;
            } else {
                http_response_code(500);
                echo "Failed to save pages";
            }
        } elseif (isset($_POST['selected_palette'])) {           
            $palette = $_POST['selected_palette'];
            error_log('Palette value: ' . $palette);
            error_log('Palette colors: ' . print_r($palette_colors[$palette] ?? 'NOT FOUND', true));
            $_SESSION['selected_palette'] = $palette;   
            $_SESSION['selected_palette_colors'] = $palette_colors[$palette] ?? [];
            $colorValuesString = implode(',', $_SESSION['selected_palette_colors']);
            if (savePreference($pdo, $userId, 'color_scheme', $colorValuesString)) {
                header('Location: fonts.php');
                exit;
            } else {
                http_response_code(500);
                echo "Failed to save color scheme";
            }
        
        } elseif (isset($_POST['selected_font'])) {
            $selectedFont = $_POST['selected_font'];
            $_SESSION['selected_font'] = $selectedFont;

            if (savePreference($pdo, $userId, 'selected_font', $selectedFont)) {
                header('Location: builder/asset_manager.php');
                exit;
            } else {
                http_response_code(500);
                echo "Failed to save font";
            }
        } 
    }

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo "Database connection failed";
    exit;
}
?>