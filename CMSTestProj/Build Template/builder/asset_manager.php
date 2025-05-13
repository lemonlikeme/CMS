<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize or get the current state
$currentState = isset($_SESSION['asset_state']) ? $_SESSION['asset_state'] : [
    'assets' => [],
    'header' => [
        'logo' => 'assets/logo.png',
        'title' => 'University Name',
        'nav' => [
            'home' => 'Home',
            'about' => 'About',
            'admissions' => 'Admissions',
            'contact' => 'Contact'
        ],
        'styles' => [
            'bgColor' => '#ffffff',
            'textColor' => '#333333',
            'navColor' => '#333333',
            'navHoverColor' => '#4A90E2'
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
        'copyright' => '© 2024 University Name. All rights reserved.',
        'styles' => [
            'bgColor' => '#ffffff',
            'textColor' => '#333333',
            'linkColor' => '#333333',
            'linkHoverColor' => '#4A90E2'
        ]
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
            $assetPath = __DIR__ . "/../assets/{$assetType}";
            
            // Log the asset request
            error_log("Loading asset: {$assetType} from path: {$assetPath}");
            
            if (file_exists($assetPath)) {
                $htmlFile = "{$assetPath}/{$assetType}.html";
                $cssFile = "{$assetPath}/{$assetType}.css";
                
                if (file_exists($htmlFile) && file_exists($cssFile)) {
                    $html = file_get_contents($htmlFile);
                    $css = file_get_contents($cssFile);
                    
                    if ($html === false || $css === false) {
                        error_log("Error reading asset files for: {$assetType}");
                        echo json_encode([
                            'success' => false,
                            'error' => 'Error reading asset files'
                        ]);
                    } else {
                        echo json_encode([
                            'success' => true,
                            'html' => $html,
                            'css' => $css
                        ]);
                    }
                } else {
                    error_log("Asset files not found for: {$assetType}");
                    echo json_encode([
                        'success' => false,
                        'error' => 'Asset files not found'
                    ]);
                }
            } else {
                error_log("Asset directory not found: {$assetPath}");
                echo json_encode([
                    'success' => false,
                    'error' => 'Asset directory not found'
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
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Manager</title>
    <link rel="stylesheet" href="asset_manager.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Lato:wght@400;700&family=Merriweather:wght@400;700&family=Montserrat:wght@400;600&family=Nunito:wght@400;600&family=Open+Sans:wght@400;600&family=Playfair+Display:wght@400;600&family=Poppins:wght@400;600&family=Raleway:wght@400;600&family=Roboto:wght@400;500&family=Source+Sans+Pro:wght@400;600&family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="manager-wrapper">
        <!-- Preview Panel -->
        <div class="preview-panel">
            <div class="preview-header">
                <h2>Preview</h2>
                <button id="savePreview" class="btn-primary">Save Changes</button>
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
                    'Homepage' => ['programs-listing', 'news-event', 'campus-life', 'photo-collage', 'social-media'],
                    'About' => ['university-history', 'campus-life', 'social-media'],
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
    </script>
    <script src="asset_manager.js"></script>
</body>
</html> 