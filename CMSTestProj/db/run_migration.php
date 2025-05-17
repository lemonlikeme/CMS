<?php
// Simple migration script for the template_id field

// Include database configuration
require_once 'dbConfiguration.php';

echo "========================================\n";
echo "   Running Template ID Migration Script \n";
echo "========================================\n\n";

try {
    // Connect to database
    echo "Connecting to database...\n";
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully to database: $dbname\n\n";

    // Check if template_id column exists
    echo "Checking if template_id column exists...\n";
    $stmt = $pdo->query("SHOW COLUMNS FROM site_preferences LIKE 'template_id'");
    $columnExists = $stmt->rowCount() > 0;
    
    if ($columnExists) {
        echo "Column template_id already exists.\n";
    } else {
        echo "Adding template_id column...\n";
        $pdo->exec("ALTER TABLE site_preferences ADD COLUMN template_id VARCHAR(100) NOT NULL DEFAULT 'homepage' AFTER user_id");
        echo "Column added successfully.\n";
    }
    
    // Check if index exists
    echo "Checking if user_template_idx index exists...\n";
    $stmt = $pdo->query("SHOW INDEX FROM site_preferences WHERE Key_name = 'user_template_idx'");
    $indexExists = $stmt->rowCount() > 0;
    
    if ($indexExists) {
        echo "Index user_template_idx already exists.\n";
    } else {
        echo "Adding unique index on user_id and template_id...\n";
        $pdo->exec("ALTER TABLE site_preferences ADD UNIQUE KEY user_template_idx (user_id, template_id)");
        echo "Index added successfully.\n";
    }
    
    // Update existing records
    echo "Updating existing records with unique template IDs...\n";
    $stmt = $pdo->query("UPDATE site_preferences SET template_id = CONCAT('template_', id, '_', UNIX_TIMESTAMP()) WHERE template_id = 'homepage'");
    $rowsUpdated = $stmt->rowCount();
    echo "Updated $rowsUpdated records.\n";
    
    echo "\nMigration completed successfully!\n";
    
} catch (PDOException $e) {
    echo "ERROR: Database error: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
?> 