<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?login=required");
    exit();
}

// Include database configuration
require_once '../db/dbConfiguration.php';

// Get template ID from URL parameter
$templateId = $_GET['template_id'] ?? null;

if (!$templateId) {
    header("Location: ../Get Started/gallery.php");
    exit();
}

// Set the current template in session
$_SESSION['current_template_id'] = $templateId;

// Create database connection
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get template preferences from site_preferences table
    $stmt = $pdo->prepare("SELECT * FROM site_preferences WHERE user_id = ? AND template_id = ?");
    $stmt->execute([$_SESSION['user_id'], $templateId]);
    $preferences = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Get template assets
    $stmt = $pdo->prepare("SELECT * FROM user_assets WHERE user_id = ? AND page_id = ? ORDER BY position ASC");
    $stmt->execute([$_SESSION['user_id'], $templateId]);
    $assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Organize assets by type
    $organizedAssets = [
        'header' => null,
        'footer' => null,
        'globalStyles' => null,
        'content' => []
    ];
    
    foreach ($assets as $asset) {
        if ($asset['asset_id'] === 'header') {
            $organizedAssets['header'] = json_decode($asset['asset_data'], true);
        } elseif ($asset['asset_id'] === 'footer') {
            $organizedAssets['footer'] = json_decode($asset['asset_data'], true);
        } elseif ($asset['asset_id'] === 'globalStyles') {
            $organizedAssets['globalStyles'] = json_decode($asset['asset_data'], true);
        } else {
            $organizedAssets['content'][$asset['asset_id']] = json_decode($asset['asset_data'], true);
        }
    }
    
} catch (PDOException $e) {
    // Log the error and redirect to gallery with error message
    error_log("Database error in preview.php: " . $e->getMessage());
    header("Location: ../Get Started/gallery.php?error=database");
    exit();
}

// Get the site title from preferences
$siteTitle = $preferences['site_title'] ?? 'My Website';

// Get color scheme from preferences or use a default
$colorScheme = $preferences['color_scheme'] ?? '#ffffff,#333333,#4a4a4a';
$colorValues = explode(',', $colorScheme);
$primaryColor = $colorValues[1] ?? '#333333';
$secondaryColor = $colorValues[2] ?? '#4a4a4a';
$backgroundColor = $colorValues[0] ?? '#ffffff';

// Get font from preferences or use a default
$font = $preferences['selected_font'] ?? 'Arial, sans-serif';

// Get homepage sections
$homepageSections = $preferences['homepage_sections'] ?? '';
$homepageSectionsList = $homepageSections ? explode(',', $homepageSections) : [];

// Get selected pages
$pagesSelected = $preferences['pages_selected'] ?? '';
$pagesSelectedList = $pagesSelected ? explode(',', $pagesSelected) : [];

// Get creation/modification date
$createdDate = null;
if (!empty($assets)) {
    foreach ($assets as $asset) {
        if (isset($asset['created_at']) && ($createdDate === null || strtotime($asset['created_at']) < strtotime($createdDate))) {
            $createdDate = $asset['created_at'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview: <?php echo htmlspecialchars($siteTitle); ?></title>
    <link rel="stylesheet" href="preview.css">
    <style>
        :root {
            --primary-color: <?php echo $primaryColor; ?>;
            --secondary-color: <?php echo $secondaryColor; ?>;
            --background-color: <?php echo $backgroundColor; ?>;
            --font-family: <?php echo $font; ?>;
        }
    </style>
</head>
<body>
    <div class="preview-header">
        <h1>Template Preview: <?php echo htmlspecialchars($siteTitle); ?></h1>
        <div class="preview-actions">
            <a href="../Get Started/gallery.php" class="preview-btn">Back to Gallery</a>
            <a href="builder/asset_manager.php?page_id=<?php echo urlencode($templateId); ?>" class="preview-btn">View Builder</a>
            <a href="site.php?page_id=<?php echo urlencode($templateId); ?>" class="preview-btn primary">Edit Template</a>
        </div>
    </div>
    
    <div class="preview-container">
        <div class="template-info">
            <h2>Template Information</h2>
            <div class="info-row">
                <div class="info-label">Template ID:</div>
                <div class="info-value"><?php echo htmlspecialchars($templateId); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Site Title:</div>
                <div class="info-value"><?php echo htmlspecialchars($siteTitle); ?></div>
            </div>
            <?php if ($createdDate): ?>
            <div class="info-row">
                <div class="info-label">Created:</div>
                <div class="info-value"><?php echo date('F j, Y \a\t g:i a', strtotime($createdDate)); ?></div>
            </div>
            <?php endif; ?>
            <div class="info-row">
                <div class="info-label">Color Scheme:</div>
                <div class="info-value">
                    <div style="display: flex; gap: 5px;">
                        <?php foreach ($colorValues as $color): ?>
                            <div style="width: 24px; height: 24px; border-radius: 4px; background-color: <?php echo $color; ?>; border: 1px solid #ddd;"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Font:</div>
                <div class="info-value" style="font-family: <?php echo $font; ?>">
                    <?php echo htmlspecialchars($font); ?> - Sample Text
                </div>
            </div>
            <?php if (!empty($homepageSectionsList)): ?>
            <div class="info-row">
                <div class="info-label">Homepage Sections:</div>
                <div class="info-value">
                    <?php foreach ($homepageSectionsList as $section): ?>
                        <span class="badge"><?php echo htmlspecialchars(ucfirst($section)); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($pagesSelectedList)): ?>
            <div class="info-row">
                <div class="info-label">Pages Selected:</div>
                <div class="info-value">
                    <?php foreach ($pagesSelectedList as $page): ?>
                        <span class="badge"><?php echo htmlspecialchars(ucfirst($page)); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Render site preview based on stored assets and preferences -->
        <div class="site-preview">
            <!-- Header -->
            <header class="site-header">
                <h1 class="site-title"><?php echo htmlspecialchars($siteTitle); ?></h1>
                <nav class="site-nav">
                    <a href="#home">Home</a>
                    <?php foreach ($pagesSelectedList as $page): ?>
                        <a href="#<?php echo htmlspecialchars($page); ?>"><?php echo htmlspecialchars(ucfirst($page)); ?></a>
                    <?php endforeach; ?>
                </nav>
            </header>
            
            <!-- Homepage Sections -->
            <?php foreach ($homepageSectionsList as $section): ?>
                <section class="site-section">
                    <h2 class="section-title"><?php echo htmlspecialchars(ucfirst($section)); ?> Section</h2>
                    <p>This is a preview of the <?php echo htmlspecialchars($section); ?> section content.</p>
                    
                    <?php if ($section == 'about'): ?>
                        <p>Here you'll share your story, mission, values, and team members. Let visitors connect with your brand on a personal level.</p>
                    <?php elseif ($section == 'products'): ?>
                        <p>Display your products with beautiful images, detailed descriptions, and pricing information.</p>
                    <?php elseif ($section == 'services'): ?>
                        <p>Highlight your professional services with descriptions, benefits, and calls to action.</p>
                    <?php elseif ($section == 'appointments'): ?>
                        <p>Allow visitors to schedule appointments directly through your website with an integrated booking system.</p>
                    <?php elseif ($section == 'digital'): ?>
                        <p>Showcase your digital products, downloads, courses, or online offerings.</p>
                    <?php elseif ($section == 'intro'): ?>
                        <p>Make a powerful first impression with a striking hero section that captures attention instantly.</p>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
            
            <!-- Footer -->
            <footer class="footer">
                <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($siteTitle); ?>. All rights reserved.</p>
                <div style="margin-top: 10px; font-size: 14px;">
                    <a href="#" style="color: white; text-decoration: none; margin: 0 10px;">Privacy Policy</a>
                    <a href="#" style="color: white; text-decoration: none; margin: 0 10px;">Terms of Service</a>
                    <a href="#" style="color: white; text-decoration: none; margin: 0 10px;">Contact</a>
                </div>
            </footer>
        </div>
    </div>
</body>
</html> 