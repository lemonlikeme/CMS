<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
require_once '../../db/dbConfiguration.php';

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
}

// Get saved preferences
$siteTitle = $_SESSION['site_title'] ?? 'University Name';
$selectedFont = $_SESSION['selected_font'] ?? 'Arial, sans-serif';
$selectedPaletteColors = $_SESSION['selected_palette_colors'] ?? ['#ffffff', '#333333', '#4a4a4a'];

// Initialize or get the current state
$currentState = isset($_SESSION['asset_state']) ? $_SESSION['asset_state'] : [
    'assets' => [],
    'header' => [
        'logo' => 'assets/logo.png',
        'title' => $siteTitle, // Use site title from preferences
        'nav' => [
            'home' => 'Home',
            'about' => 'About',
            'admissions' => 'Admissions',
            'contact' => 'Contact'
        ],
        'styles' => [
            'bgColor' => $selectedPaletteColors[0] ?? '#ffffff',
            'textColor' => $selectedPaletteColors[2] ?? '#333333',
            'navColor' => $selectedPaletteColors[1] ?? '#333333',
            'navHoverColor' => $selectedPaletteColors[1] ?? '#4A90E2',
            'fontFamily' => $selectedFont
        ]
    ],
    'footer' => [
        'contact' => [
            'title' => 'Contact Us',
            'address' => '123 University Ave, City, State 12345',
            'phone' => 'Phone: (123) 456-7890',
            'email' => 'Email: info@university.edu'
        ],
        'social' => [
            'title' => 'Follow Us',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'instagram' => 'Instagram'
        ],
        'copyright' => '© 2024 ' . $siteTitle . '. All rights reserved.',
        'styles' => [
            'bgColor' => $selectedPaletteColors[0] ?? '#ffffff',
            'textColor' => $selectedPaletteColors[2] ?? '#333333',
            'linkColor' => $selectedPaletteColors[1] ?? '#333333',
            'linkHoverColor' => $selectedPaletteColors[1] ?? '#4A90E2',
            'fontFamily' => $selectedFont
        ]
    ],
    'globalStyles' => [
        'primaryColor' => $selectedPaletteColors[1] ?? '#333333',
        'secondaryColor' => $selectedPaletteColors[2] ?? '#4a4a4a',
        'backgroundColor' => $selectedPaletteColors[0] ?? '#ffffff',
        'fontFamily' => $selectedFont
    ]
];

// Create uploads directory if it doesn't exist
$uploadDir = __DIR__ . '/uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'save_state':
            try {
                $newState = json_decode($_POST['state'], true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception('Invalid JSON data received');
                }
                
                // Validate state structure
                if (!isset($newState['assets']) || !isset($newState['header']) || !isset($newState['footer'])) {
                    throw new Exception('Invalid state structure');
                }
                
                // Save to session
                $_SESSION['asset_state'] = $newState;
                
                // Check if user is logged in
                if (isset($_SESSION['user_id'])) {
                    $userId = $_SESSION['user_id'];
                    $pageId = $_POST['page_id'] ?? 'homepage'; // Default to homepage if not specified
                    
                    // Delete existing assets for this user and page
                    $stmt = $conn->prepare("DELETE FROM user_assets WHERE user_id = ? AND page_id = ?");
                    $stmt->bind_param("is", $userId, $pageId);
                    $stmt->execute();
                    $stmt->close();
                    
                    // Save assets to database
                    if (!empty($newState['assets'])) {
                        $stmt = $conn->prepare("INSERT INTO user_assets (user_id, page_id, asset_id, asset_type, asset_data, position) VALUES (?, ?, ?, ?, ?, ?)");
                        
                        $position = 0;
                        foreach ($newState['assets'] as $assetId => $asset) {
                            $assetType = $asset['type'] ?? 'unknown';
                            $assetData = json_encode($asset);
                            
                            $stmt->bind_param("issssi", $userId, $pageId, $assetId, $assetType, $assetData, $position);
                            $stmt->execute();
                            
                            $position++;
                        }
                        
                        $stmt->close();
                    }
                    
                    // Save header and footer as special assets
                    $headerData = json_encode($newState['header']);
                    $footerData = json_encode($newState['footer']);
                    $globalStylesData = json_encode($newState['globalStyles']);
                    
                    // Prepare statement for header, footer, and global styles
                    $stmt = $conn->prepare("INSERT INTO user_assets (user_id, page_id, asset_id, asset_type, asset_data, position) VALUES (?, ?, ?, ?, ?, ?)");
                    
                    // Insert header
                    $assetId = 'header';
                    $assetType = 'header';
                    $position = -2;  // Special position for header
                    $stmt->bind_param("issssi", $userId, $pageId, $assetId, $assetType, $headerData, $position);
                    $stmt->execute();
                    
                    // Insert footer
                    $assetId = 'footer';
                    $assetType = 'footer';
                    $position = -1;  // Special position for footer
                    $stmt->bind_param("issssi", $userId, $pageId, $assetId, $assetType, $footerData, $position);
                    $stmt->execute();
                    
                    // Insert global styles
                    $assetId = 'globalStyles';
                    $assetType = 'globalStyles';
                    $position = -3;  // Special position for global styles
                    $stmt->bind_param("issssi", $userId, $pageId, $assetId, $assetType, $globalStylesData, $position);
                    $stmt->execute();
                    
                    $stmt->close();
                } else {
                    // User not logged in, just keep in session (already done above)
                    error_log('User not logged in. State saved only to session.');
                }
                
                // Log success
                error_log('State saved successfully: ' . print_r($newState, true));
                
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                error_log('Error saving state: ' . $e->getMessage());
                echo json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ]);
            }
            exit;
            
        case 'load_asset':
            $assetType = $_POST['asset'] ?? '';
            
            if (empty($assetType)) {
                echo json_encode([
                    'success' => false,
                    'error' => 'Asset type is required'
                ]);
                exit;
            }
            
            // Try to find the asset
            $assetPath = dirname(__DIR__) . "/assets/{$assetType}";
            $htmlFile = "{$assetPath}/{$assetType}.html";
            $cssFile = "{$assetPath}/{$assetType}.css";
            
            if (file_exists($htmlFile) && file_exists($cssFile)) {
                $html = file_get_contents($htmlFile);
                $css = file_get_contents($cssFile);
                
                echo json_encode([
                    'success' => true,
                    'html' => $html,
                    'css' => $css
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'error' => 'Asset files not found'
                ]);
            }
            exit;
            
        case 'update_asset':
            $assetId = $_POST['asset_id'] ?? '';
            $updates = json_decode($_POST['updates'], true);
            
            if (isset($currentState['assets'][$assetId])) {
                $currentState['assets'][$assetId] = array_merge(
                    $currentState['assets'][$assetId],
                    $updates
                );
                $_SESSION['asset_state'] = $currentState;
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Asset not found']);
            }
            exit;
            
        case 'upload_image':
            if (isset($_FILES['image'])) {
                $file = $_FILES['image'];
                $fileName = uniqid() . '_' . basename($file['name']);
                $targetPath = $uploadDir . $fileName;
                
                // Check file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($file['type'], $allowedTypes)) {
                    echo json_encode([
                        'success' => false,
                        'error' => 'Invalid file type. Only JPG, PNG and GIF are allowed.'
                    ]);
                    exit;
                }
                
                // Check file size (max 5MB)
                if ($file['size'] > 5 * 1024 * 1024) {
                    echo json_encode([
                        'success' => false,
                        'error' => 'File too large. Maximum size is 5MB.'
                    ]);
                    exit;
                }
                
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    echo json_encode([
                        'success' => true,
                        'url' => 'uploads/' . $fileName
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'error' => 'Failed to upload file'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'error' => 'No file uploaded'
                ]);
            }
            exit;
            
        case 'upload_video':
            if (isset($_FILES['video'])) {
                $file = $_FILES['video'];
                $fileName = uniqid() . '_' . basename($file['name']);
                $targetPath = $uploadDir . $fileName;

                // Check file type
                $allowedTypes = ['video/mp4'];
                if (!in_array($file['type'], $allowedTypes)) {
                    echo json_encode([
                        'success' => false,
                        'error' => 'Invalid file type. Only MP4 is allowed.'
                    ]);
                    exit;
                }

                // Check file size (max 50MB)
                if ($file['size'] > 50 * 1024 * 1024) {
                    echo json_encode([
                        'success' => false,
                        'error' => 'File too large. Maximum size is 50MB.'
                    ]);
                    exit;
                }

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    echo json_encode([
                        'success' => true,
                        'url' => 'uploads/' . $fileName
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'error' => 'Failed to upload file'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'error' => 'No file uploaded'
                ]);
            }
            exit;
            
        case 'load_user_assets':
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                $pageId = $_POST['page_id'] ?? 'homepage';
                
                // Query to get user assets
                $stmt = $conn->prepare("SELECT * FROM user_assets WHERE user_id = ? AND page_id = ? ORDER BY position ASC");
                $stmt->bind_param("is", $userId, $pageId);
                $stmt->execute();
                $result = $stmt->get_result();
                
                $assets = [];
                $header = null;
                $footer = null;
                $globalStyles = null;
                
                while ($row = $result->fetch_assoc()) {
                    if ($row['asset_id'] === 'header') {
                        $header = json_decode($row['asset_data'], true);
                    } else if ($row['asset_id'] === 'footer') {
                        $footer = json_decode($row['asset_data'], true);
                    } else if ($row['asset_id'] === 'globalStyles') {
                        $globalStyles = json_decode($row['asset_data'], true);
                    } else {
                        $assets[$row['asset_id']] = json_decode($row['asset_data'], true);
                    }
                }
                
                $state = [
                    'assets' => $assets,
                    'header' => $header ?: $currentState['header'],
                    'footer' => $footer ?: $currentState['footer'],
                    'globalStyles' => $globalStyles ?: $currentState['globalStyles']
                ];
                
                // Update session with loaded state
                $_SESSION['asset_state'] = $state;
                
                echo json_encode([
                    'success' => true,
                    'state' => $state
                ]);
                
                $stmt->close();
            } else {
                echo json_encode([
                    'success' => false,
                    'error' => 'User not logged in'
                ]);
            }
            exit;

        case 'cleanup_unsaved':
            try {
                // Check if user is logged in
                if (!isset($_SESSION['user_id'])) {
                    throw new Exception('User not logged in');
                }
                
                $userId = $_SESSION['user_id'];
                $pageId = $_POST['page_id'] ?? 'homepage';
                $lastSaveTime = $_POST['last_save'] ?? 0;
                
                // Log the cleanup attempt
                error_log("Cleanup request for user {$userId}, page {$pageId}, last save time: " . date('Y-m-d H:i:s', $lastSaveTime/1000));
                
                // Check conditions for cleanup
                $shouldCleanup = true;
                
                // If conditions are met, delete the assets
                if ($shouldCleanup) {
                    // Delete data for this user and page
                    $stmt = $conn->prepare("DELETE FROM user_assets WHERE user_id = ? AND page_id = ?");
                    $stmt->bind_param("is", $userId, $pageId);
                    $stmt->execute();
                    $deletedRows = $stmt->affected_rows;
                    $stmt->close();
                    
                    error_log("Cleaned up {$deletedRows} rows of unsaved data for user {$userId}, page {$pageId}");
                    
                    echo json_encode([
                        'success' => true,
                        'message' => "Cleaned up {$deletedRows} rows of unsaved data"
                    ]);
                } else {
                    echo json_encode([
                        'success' => true,
                        'message' => 'No cleanup needed'
                    ]);
                }
            } catch (Exception $e) {
                error_log('Error during cleanup: ' . $e->getMessage());
                echo json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ]);
            }
            exit;
    }
}
?>
<script>
        console.group('Form Submission Data');
        console.log('Submission Time:', <?php echo json_encode($_SESSION['submission_time'] ?? 'Not set'); ?>);
        console.log('Site Title:', <?php echo json_encode($_SESSION['site_title'] ?? 'Not set'); ?>);
        console.log('Font Selected:', <?php echo json_encode($_SESSION['selected_font'] ?? 'Not set'); ?>);
        console.log('Homepage Sections (array):', <?php echo json_encode($_SESSION['homepage_sections'] ?? 'Not set'); ?>);
        console.log('Homepage Sections (string):', <?php echo json_encode($_SESSION['homepage_sections_string'] ?? 'Not set'); ?>);
        console.log('Pages Selected (array):', <?php echo json_encode($_SESSION['pages_selected'] ?? 'Not set'); ?>);
        console.log('Pages Selected (string):', <?php echo json_encode($_SESSION['pages_selected_string'] ?? 'Not set'); ?>); 
        console.log('Selected Palette:', <?php echo json_encode($_SESSION['selected_palette'] ?? 'Not set'); ?>);
        console.log('Palette Colors:', <?php echo json_encode($_SESSION['selected_palette_colors'] ?? []); ?>);
        console.log('Full Session:', <?php echo json_encode($_SESSION); ?>);
        console.groupEnd();
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Manager</title>
    <link rel="stylesheet" href="asset_manager.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Lato:wght@400;700&family=Merriweather:wght@400;700&family=Montserrat:wght@400;600&family=Nunito:wght@400;600&family=Open+Sans:wght@400;600&family=Playfair+Display:wght@400;600&family=Poppins:wght@400;600&family=Raleway:wght@400;600&family=Roboto:wght@400;500&family=Source+Sans+Pro:wght@400;600&family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Apply custom styles from preferences */
        :root {
            --primary-color: <?php echo $selectedPaletteColors[1] ?? '#333333'; ?>;
            --secondary-color: <?php echo $selectedPaletteColors[2] ?? '#4a4a4a'; ?>;
            --background-color: <?php echo $selectedPaletteColors[0] ?? '#ffffff'; ?>;
            --font-family: <?php echo '"'.$selectedFont.'"' ?? 'Arial, sans-serif'; ?>;
        }
        
        /* Apply font to preview */
        .preview-content {
            font-family: var(--font-family);
        }
        
        /* Header/footer styles */
        .site-header, .site-footer {
            background-color: var(--background-color);
            color: var(--secondary-color);
            font-family: var(--font-family);
        }
        
        /* Typography */
        .preview-content h1, 
        .preview-content h2, 
        .preview-content h3 {
            color: var(--primary-color);
            font-family: var(--font-family);
        }
        
        .preview-content p {
            color: var(--secondary-color);
            font-family: var(--font-family);
        }
        
        /* Button styles */
        .preview-content button,
        .preview-content .btn {
            background-color: var(--primary-color);
            color: var(--background-color);
            font-family: var(--font-family);
        }
        
        /* Link styles */
        .preview-content a {
            color: var(--primary-color);
        }
        
        /* Site title */
        .site-title {
            font-family: var(--font-family);
            color: var(--primary-color) !important;
        }
    </style>
</head>
<body>
    <div class="manager-wrapper">
        <!-- Preview Panel -->
        <div class="preview-panel">
            <div class="preview-header">
                <h2>Preview</h2>
                <div class="preview-actions">
                    <button id="savePreview" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 5px;">
                            <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
                        </svg>
                        Save Work
                    </button>
                    <button id="nextStep" class="btn-primary" onclick="saveAndNavigate()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 5px;">
                            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                        Next Step
                    </button>
                    <a href="../fonts.php" class="back-link">
                        <button class="btn-back">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 5px;">
                                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                            </svg>
                            Back
                        </button>
                    </a>
                </div>
            </div>
            <div id="preview" class="preview-content">
                <p class="placeholder">Add assets from the right panel to start building your page.</p>
            </div>
        </div>

        <!-- Control Panel -->
        <div class="control-panel">
            <div class="panel-header">
                <h2>Assets</h2>
            </div>
            
            <!-- Asset Categories -->
            <div class="asset-categories">
                <?php
                $categories = [
                    'Homepage' => ['programs-listing', 'news-event', 'campus-life', 'photo-collage', 'social-media', 'hero', 'intro-video'],
                    'About' => ['university-history', 'campus-life', 'social-media', 'intro'],
                    'Admissions' => ['admissions-form', 'programs-listing', 'faq', 'academic-calendar'],
                    'Contact' => ['contact-info', 'campus-map', 'social-media']
                ];

                foreach ($categories as $title => $assets): ?>
                    <div class="asset-category">
                        <h3><?php echo htmlspecialchars($title); ?></h3>
                        <div class="asset-grid">
                            <?php foreach ($assets as $asset): ?>
                                <button class="asset-btn" data-asset="<?php echo htmlspecialchars($asset); ?>">
                                    <?php echo ucwords(str_replace('-', ' ', $asset)); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="asset-category">
                    <h3>Edit Site Navigation</h3>
                    <button id="editHeaderFooter" class="edit-site-nav-btn">
                        Edit Header & Footer
                    </button>
                </div>
            </div>

            <!-- Asset Properties Panel -->
            <div id="assetProperties" class="asset-properties">
                <h3>
                    Asset Properties
                    <button class="close-properties" title="Close properties">×</button>
                </h3>
                <div class="properties-content">
                    <!-- Properties will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Templates for different asset types -->
    <template id="textProperty">
        <div class="property-group">
            <label class="property-label"></label>
            <input type="text" class="property-input">
        </div>
    </template>

    <template id="imageProperty">
        <div class="property-group">
            <label class="property-label"></label>
            <input type="file" class="property-input" accept="image/*">
            <div class="image-preview"></div>
        </div>
    </template>

    <template id="colorProperty">
        <div class="property-group">
            <label class="property-label"></label>
            <input type="color" class="property-input">
        </div>
    </template>

    <template id="fontProperty">
        <div class="property-group">
            <label class="property-label"></label>
            <select class="property-input">
                <option value="roboto">Roboto</option>
                <option value="montserrat">Montserrat</option>
                <option value="opensans">Open Sans</option>
                <option value="poppins">Poppins</option>
                <option value="lato">Lato</option>
                <option value="raleway">Raleway</option>
                <option value="nunito">Nunito</option>
                <option value="inter">Inter</option>
                <option value="playfair">Playfair Display</option>
                <option value="merriweather">Merriweather</option>
                <option value="source">Source Sans Pro</option>
                <option value="ubuntu">Ubuntu</option>
            </select>
        </div>
    </template>

    <!-- Header and Footer Templates -->
    <template id="headerTemplate">
        <header class="site-header">
            <div class="header-content">
                <div class="logo-section">
                    <img src="assets/logo.png" alt="Logo" class="site-logo" data-editable="header_logo" data-type="image">
                    <h1 class="site-title" data-editable="header_title" data-type="text">University Name</h1>
                </div>
                <nav class="main-nav">
                    <ul>
                        <li><a href="#" data-editable="nav_home" data-type="text">Home</a></li>
                        <li><a href="#" data-editable="nav_about" data-type="text">About</a></li>
                        <li><a href="#" data-editable="nav_admissions" data-type="text">Admissions</a></li>
                        <li><a href="#" data-editable="nav_contact" data-type="text">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </header>
    </template>

    <template id="footerTemplate">
        <footer class="site-footer">
            <div class="footer-content">
                <div class="footer-section">
                    <h3 data-editable="footer_contact_title" data-type="text">Contact Us</h3>
                    <p data-editable="footer_address" data-type="text">123 University Ave, City, State 12345</p>
                    <p data-editable="footer_phone" data-type="text">Phone: (123) 456-7890</p>
                    <p data-editable="footer_email" data-type="text">Email: info@university.edu</p>
                </div>
                <div class="footer-section">
                    <h3 data-editable="footer_social_title" data-type="text">Follow Us</h3>
                    <div class="social-links">
                        <a href="#" data-editable="footer_facebook" data-type="text">Facebook</a>
                        <a href="#" data-editable="footer_twitter" data-type="text">Twitter</a>
                        <a href="#" data-editable="footer_instagram" data-type="text">Instagram</a>
                    </div>
                </div>
                <div class="footer-section">
                    <p class="copyright" data-editable="footer_copyright" data-type="text">© 2024 University Name. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </template>

    <script>
        // Pass PHP state to JavaScript
        const assetState = <?php echo json_encode($currentState); ?>;
        
        // Function to save state and navigate to next step
        async function saveAndNavigate() {
            // Show confirmation dialog
            if (!confirm('Save your work and proceed to the next step?')) {
                return;
            }
            
            // Disable button to prevent multiple clicks
            document.getElementById('nextStep').disabled = true;
            document.getElementById('nextStep').innerHTML = 'Saving...';
            
            try {
                // Get the saveState function from global scope
                if (typeof saveState === 'function') {
                    // Wait for save to complete
                    await saveState();
                    
                    // Redirect after successful save
                    window.location.href = '../../Get Started/get_Started.php';
                } else {
                    console.error('saveState function not found');
                    alert('Unable to save your work. Redirecting anyway.');
                    window.location.href = '../../Get Started/get_Started.php';
                }
            } catch (error) {
                console.error('Error saving before navigation:', error);
                
                // Ask if they want to continue anyway
                if (confirm('Error saving your work. Do you want to continue to the next step anyway?')) {
                    window.location.href = '../../Get Started/get_Started.php';
                } else {
                    // Re-enable the button if they choose to stay
                    document.getElementById('nextStep').disabled = false;
                    document.getElementById('nextStep').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 5px;"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>Next Step';
                }
            }
        }
    </script>
    <script src="asset_manager.js"></script>
</body>
</html> 