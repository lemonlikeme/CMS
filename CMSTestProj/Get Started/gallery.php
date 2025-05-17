<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: ../index.php");
    exit;
}

// Include database configuration
require_once '../db/dbConfiguration.php';

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID
$userId = $_SESSION['user_id'] ?? 0;

// Debug info
$debug = [];
$debug['user_id'] = $userId;
$debug['session'] = $_SESSION;

// Function to get a thumbnail preview from assets
function getPageThumbnail($conn, $userId, $templateId) {
    $thumbnailData = null;
    
    // First, try to find a hero or image asset type
    $query = "SELECT asset_data FROM user_assets 
              WHERE user_id = ? AND page_id = ? AND asset_type IN ('hero', 'image')
              LIMIT 1";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("is", $userId, $templateId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $assetData = json_decode($row['asset_data'], true);
            if (isset($assetData['config']['imageUrl'])) {
                $thumbnailData = $assetData['config']['imageUrl'];
            }
        }
        
        $stmt->close();
    }
    
    // If no hero or image found, use the default color from global styles
    if (!$thumbnailData) {
        $query = "SELECT asset_data FROM user_assets 
                  WHERE user_id = ? AND page_id = ? AND asset_id = 'globalStyles'
                  LIMIT 1";
        
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("is", $userId, $templateId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $globalStyles = json_decode($row['asset_data'], true);
                if (isset($globalStyles['primaryColor'])) {
                    $thumbnailData = $globalStyles['primaryColor'];
                }
            }
            
            $stmt->close();
        }
    }
    
    // If still no thumbnail, get color from site_preferences
    if (!$thumbnailData) {
        $query = "SELECT color_scheme FROM site_preferences
                  WHERE user_id = ? AND template_id = ?
                  LIMIT 1";
        
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("is", $userId, $templateId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $colors = explode(',', $row['color_scheme']);
                if (!empty($colors)) {
                    $thumbnailData = $colors[0]; // Use the first color
                }
            }
            
            $stmt->close();
        }
    }
    
    return $thumbnailData;
}

// Modified query to get any user assets (not filtering by specific asset ids)
$recentAssetsQuery = "SELECT DISTINCT template_id as page_id, site_title, MAX(created_at) as latest_date 
                     FROM site_preferences 
                     WHERE user_id = ? AND site_title IS NOT NULL
                     GROUP BY template_id, site_title
                     ORDER BY latest_date DESC 
                     LIMIT 6";

$allAssetsQuery = "SELECT DISTINCT template_id as page_id, site_title, MAX(created_at) as created_date 
                  FROM site_preferences 
                  WHERE user_id = ? AND site_title IS NOT NULL
                  GROUP BY template_id, site_title
                  ORDER BY created_date DESC";

$recentWorks = [];
$allWorks = [];

// Debug queries
$debug['queries'] = [];
$debug['queries']['recent'] = $recentAssetsQuery;
$debug['queries']['all'] = $allAssetsQuery;

if ($stmt = $conn->prepare($recentAssetsQuery)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $debug['recent_count'] = $result->num_rows;
    
    while ($row = $result->fetch_assoc()) {
        $row['thumbnail'] = getPageThumbnail($conn, $userId, $row['page_id']);
        $recentWorks[] = $row;
    }
    $stmt->close();
}

if ($stmt = $conn->prepare($allAssetsQuery)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $debug['all_count'] = $result->num_rows;
    
    while ($row = $result->fetch_assoc()) {
        $row['thumbnail'] = getPageThumbnail($conn, $userId, $row['page_id']);
        $allWorks[] = $row;
    }
    $stmt->close();
}

// Check if any templates exist for this user at all
$anyTemplatesQuery = "SELECT COUNT(DISTINCT template_id) as total FROM site_preferences WHERE user_id = ? AND site_title IS NOT NULL";
if ($stmt = $conn->prepare($anyTemplatesQuery)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $debug['total_templates'] = $row['total'];
    $hasTemplates = ($row['total'] > 0);
    $stmt->close();
} else {
    $hasTemplates = false;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Gallery</title>
  <link rel="stylesheet" href="gallery.css" />
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Your Gallery</h1>
      <a href="get_Started.php"><button class="back-btn">BACK</button></a>
    </div>

    <!-- Debug info section - will be hidden in production -->
    <?php if(isset($_GET['debug'])): ?>
    <div class="debug-info" style="margin-bottom: 20px; padding: 15px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 5px;">
      <h3 style="margin-top: 0;">Debug Information</h3>
      <p><strong>User ID:</strong> <?php echo $userId; ?></p>
      <p><strong>Session Name:</strong> <?php echo $_SESSION['name'] ?? 'Not set'; ?></p>
      <p><strong>Total Templates:</strong> <?php echo $debug['total_templates'] ?? 'None'; ?></p>
      <p><strong>Recent Works Count:</strong> <?php echo $debug['recent_count'] ?? 0; ?></p>
      <p><strong>All Works Count:</strong> <?php echo $debug['all_count'] ?? 0; ?></p>
      
      <?php if (!$hasTemplates): ?>
        <div style="padding: 10px; background-color: #fff3cd; border: 1px solid #ffeeba; color: #856404; border-radius: 5px; margin-top: 10px;">
          <strong>No templates found in the database for this user.</strong> Please make sure:
          <ul>
            <li>You are logged in with the correct account</li>
            <li>You have completed the template creation process</li>
            <li>The user ID is correctly stored in your session</li>
          </ul>
        </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="gallery">
      <?php if (!$hasTemplates): ?>
        <!-- Show create template prompt if no templates exist -->
        <div class="empty-gallery">
          <h2>Welcome to Your Gallery</h2>
          <p>You don't have any templates yet. Get started by creating your first template!</p>
          <div class="create-template-container">
            <a href="../Build Template/site.php">
              <button class="create-template-btn">Create Your First Template</button>
            </a>
          </div>
        </div>
      <?php else: ?>
        <h2>Recently Opened</h2>
        <div class="gallery-grid animated fade-in">
          <?php if (empty($recentWorks)): ?>
            <div class="gallery-item placeholder"><span>No recent work found</span></div>
          <?php else: ?>
            <?php foreach ($recentWorks as $work): ?>
              <div class="gallery-item" 
                   onclick="location.href='../Build Template/preview.php?template_id=<?php echo urlencode($work['page_id']); ?>'"
                   <?php if ($work['thumbnail'] && strpos($work['thumbnail'], '#') === 0): ?>
                   style="background: linear-gradient(135deg, <?php echo $work['thumbnail']; ?>, <?php echo adjustBrightness($work['thumbnail'], 20); ?>);"
                   <?php endif; ?>>
                <?php if ($work['thumbnail'] && strpos($work['thumbnail'], 'uploads/') === 0): ?>
                  <div class="thumbnail-bg" style="background-image: url('../Build Template/builder/<?php echo htmlspecialchars($work['thumbnail']); ?>');"></div>
                <?php endif; ?>
                <span><?php echo htmlspecialchars($work['site_title'] ?: $work['page_id']); ?></span>
                <div class="work-date">Last edited: <?php echo date('M d, Y', strtotime($work['latest_date'])); ?></div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <h2>All Works by Date Created</h2>
        <div class="gallery-grid animated fade-in">
          <?php if (empty($allWorks)): ?>
            <div class="gallery-item placeholder"><span>No work found</span></div>
          <?php else: ?>
            <?php foreach ($allWorks as $work): ?>
              <div class="gallery-item" 
                   onclick="location.href='../Build Template/preview.php?template_id=<?php echo urlencode($work['page_id']); ?>'"
                   <?php if ($work['thumbnail'] && strpos($work['thumbnail'], '#') === 0): ?>
                   style="background: linear-gradient(135deg, <?php echo $work['thumbnail']; ?>, <?php echo adjustBrightness($work['thumbnail'], 20); ?>);"
                   <?php endif; ?>>
                <?php if ($work['thumbnail'] && strpos($work['thumbnail'], 'uploads/') === 0): ?>
                  <div class="thumbnail-bg" style="background-image: url('../Build Template/builder/<?php echo htmlspecialchars($work['thumbnail']); ?>');"></div>
                <?php endif; ?>
                <span><?php echo htmlspecialchars($work['site_title'] ?: $work['page_id']); ?></span>
                <div class="work-date">Created: <?php echo date('M d, Y', strtotime($work['created_date'])); ?></div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <div class="action-buttons">
        <a href="../Build Template/site.php"><button class="action-btn">Create New Template</button></a>
        <?php if (!empty($allWorks)): ?>
          <a href="gallery.php?debug=1"><button class="action-btn secondary">Show Debug Info</button></a>
        <?php endif; ?>
      </div>
    </div>
  </div>

<?php
// Helper function to adjust brightness of hex colors
function adjustBrightness($hex, $steps) {
    // Remove # if present
    $hex = ltrim($hex, '#');
    
    // Convert to RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    // Adjust
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));
    
    // Convert back to hex
    return '#' . sprintf('%02x%02x%02x', $r, $g, $b);
}
?>
</body>
</html>
