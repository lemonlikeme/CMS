<?php
session_start();

error_log('Save preferences script started');
error_log('Session user_id: ' . ($_SESSION['user_id'] ?? 'NOT SET'));
error_log('Request Method: ' . $_SERVER['REQUEST_METHOD']);
error_log('POST data: ' . json_encode($_POST));
error_log('All POST keys: ' . implode(', ', array_keys($_POST)));
error_log('Template ID: ' . ($_POST['template_id'] ?? $_SESSION['current_template_id'] ?? 'NOT SET'));

if (!isset($_SESSION['user_id'])) {
    error_log('No user_id in session - redirecting to login');
    header("Location: ../index.php?login=required");
    exit();
}

require_once('preferences_helper.php'); 
require_once('../db/dbConfiguration.php'); 

$userId = $_SESSION['user_id']; 
error_log('Processing for user ID: ' . $userId);

// Get template ID from POST or session
$templateId = $_POST['template_id'] ?? $_SESSION['current_template_id'] ?? null;
if (!$templateId) {
    error_log('No template_id found - generating a new one');
    $templateId = 'template_' . time() . '_' . uniqid();
    $_SESSION['current_template_id'] = $templateId;
}
error_log('Using template ID: ' . $templateId);

try {
    error_log('Attempting database connection');
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_log('Database connection successful');
    
    // Check if the site_preferences table has the template_id column
    try {
        $stmt = $pdo->query("SHOW COLUMNS FROM site_preferences LIKE 'template_id'");
        $hasTemplateIdColumn = $stmt->rowCount() > 0;
        error_log('site_preferences table has template_id column: ' . ($hasTemplateIdColumn ? 'YES' : 'NO'));
        
        if (!$hasTemplateIdColumn) {
            // Try to add the column
            error_log('Attempting to add template_id column to site_preferences');
            $alterResult = $pdo->exec("ALTER TABLE site_preferences ADD COLUMN template_id VARCHAR(100) NOT NULL DEFAULT 'homepage' AFTER user_id");
            error_log('Added template_id column. Result: ' . ($alterResult !== false ? 'SUCCESS' : 'FAILED'));
            
            // Try to add the index
            try {
                $pdo->exec("ALTER TABLE site_preferences ADD UNIQUE KEY user_template_idx (user_id, template_id)");
                error_log('Added unique index on user_id and template_id: SUCCESS');
            } catch (PDOException $indexError) {
                error_log('Error adding index: ' . $indexError->getMessage());
                // Continue anyway - the column is more important than the index
            }
        }
    } catch (PDOException $tableError) {
        error_log('Error checking/updating table structure: ' . $tableError->getMessage());
        // Continue anyway - might still work with the old schema
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error_log('Processing POST request');
        
        if (isset($_POST['site_title'])) {
            error_log('Processing site title: ' . $_POST['site_title']);
            $siteTitle = $_POST['site_title'];
            
            // Save the site title with template ID
            try {
                // Debug the query that will be executed
                $query = "INSERT INTO site_preferences (user_id, template_id, site_title) VALUES (?, ?, ?) 
                          ON DUPLICATE KEY UPDATE site_title = ?";
                error_log("Will execute query: $query with params: user_id=$userId, template_id=$templateId, site_title=$siteTitle");
                
                $stmt = $pdo->prepare($query);
                $result = $stmt->execute([$userId, $templateId, $siteTitle, $siteTitle]);
                
                if ($result) {
                    error_log('Direct database write successful for template: ' . $templateId);
                    $_SESSION['site_title'] = $siteTitle;
                    // Pass template ID to the next step
                    header('Location: homepage.php?template_id=' . urlencode($templateId));
                    exit();
                } else {
                    error_log('Direct database write failed: ' . implode(', ', $stmt->errorInfo()));
                    throw new Exception('Database write error: ' . implode(', ', $stmt->errorInfo()));
                }
            } catch (PDOException $directError) {
                error_log('Direct database write exception: ' . $directError->getMessage());
                
                // Try fallback to helper function
                if (savePreference($pdo, $userId, 'site_title', $siteTitle, $templateId)) {
                    error_log('Site title saved successfully for template: ' . $templateId);
                    $_SESSION['site_title'] = $siteTitle;
                    // Pass template ID to the next step
                    header('Location: homepage.php?template_id=' . urlencode($templateId));
                    exit();
                } else {
                    error_log('Failed to save site title with helper function');
                    http_response_code(500);
                    echo "Failed to save site title: " . $directError->getMessage();
                    exit();
                }
            }
        } elseif (isset($_POST['homepage_sections'])) {
            
            $homepageSections = implode(',', $_POST['homepage_sections']);
            if (savePreference($pdo, $userId, 'homepage_sections', $homepageSections, $templateId)) {
                $_SESSION['homepage_sections'] = $_POST['homepage_sections'];
                $_SESSION['homepage_sections_string'] = $homepageSections;
                $_SESSION['submission_time'] = date('Y-m-d H:i:s');
                header('Location: pages.php?template_id=' . urlencode($templateId));
                exit;
            } else {
                http_response_code(500);
                echo "Failed to save homepage sections";
            }
        } elseif (isset($_POST['pages_selected'])) {
            // Save Pages step
            $pagesSelected = implode(',', $_POST['pages_selected']);
            if (savePreference($pdo, $userId, 'pages_selected', $pagesSelected, $templateId)) {
                $_SESSION['pages_selected'] = $_POST['pages_selected'];
                $_SESSION['pages_selected_string'] = $pagesSelected;
                $_SESSION['submission_time'] = date('Y-m-d H:i:s');
                header('Location: colors.php?template_id=' . urlencode($templateId));
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
            if (savePreference($pdo, $userId, 'color_scheme', $colorValuesString, $templateId)) {
                header('Location: fonts.php?template_id=' . urlencode($templateId));
                exit;
            } else {
                http_response_code(500);
                echo "Failed to save color scheme";
            }
        
        } elseif (isset($_POST['selected_font'])) {
            $selectedFont = $_POST['selected_font'];
            error_log('Processing font selection: ' . $selectedFont);
            $_SESSION['selected_font'] = $selectedFont;
            error_log('Session updated with selected font');

            // Debug database connection before attempting save
            try {
                $testStmt = $pdo->prepare("SELECT 1");
                $testResult = $testStmt->execute();
                error_log('Database connection test: ' . ($testResult ? 'SUCCESS' : 'FAILED'));
            } catch (Exception $e) {
                error_log('Database test error: ' . $e->getMessage());
            }

            $saveResult = savePreference($pdo, $userId, 'selected_font', $selectedFont, $templateId);
            error_log('Save preference result: ' . ($saveResult ? 'SUCCESS' : 'FAILED'));

            if ($saveResult) {
                error_log('Font preference saved successfully');
                $_SESSION['submission_time'] = date('Y-m-d H:i:s');

                // Use a simple HTML meta refresh as a fallback with template ID
                error_log('Using META refresh fallback for redirection');
                echo '<!DOCTYPE html>
                <html>
                <head>
                    <title>Redirecting...</title>
                    <meta http-equiv="refresh" content="1;url=builder/asset_manager.php?page_id=' . htmlspecialchars(urlencode($templateId)) . '">
                </head>
                <body>
                    <h3>Saving your font preferences...</h3>
                    <p>If you are not redirected automatically, <a href="builder/asset_manager.php?page_id=' . htmlspecialchars(urlencode($templateId)) . '">click here</a>.</p>
                    <script>window.location.href = "builder/asset_manager.php?page_id=' . htmlspecialchars(urlencode($templateId)) . '";</script>
                </body>
                </html>';
                exit();
            } else {
                error_log('Failed to save font preference');
                http_response_code(500);
                echo "Failed to save font";
                exit();
            }
        } 
    } else {
        error_log('Request method is not POST');
        http_response_code(400);
        echo "Invalid request method";
        exit();
    }

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    error_log("SQL State: " . $e->getCode());
    error_log("Driver error code: " . ($e->errorInfo[1] ?? 'unknown'));
    error_log("Driver error message: " . ($e->errorInfo[2] ?? 'unknown'));
    http_response_code(500);
    echo "Database error: " . $e->getMessage();
    exit();
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    http_response_code(500);
    echo "An error occurred: " . $e->getMessage();
    exit();
}

// This should never be reached if redirection is working
error_log("End of script reached without redirection - this indicates a problem");
echo "ERROR: Failed to process your request. Check the server logs for details.";
?>