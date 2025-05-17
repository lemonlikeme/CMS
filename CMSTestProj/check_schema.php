<?php
require_once 'db/dbConfiguration.php';

try {
    echo "Connecting to database: $dbname on $servername:$port as $username\n\n";
    
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check user_assets table
    $stmt = $pdo->query("DESCRIBE user_assets");
    echo "=== User Assets Table Schema ===\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Field: " . $row['Field'] . 
             ", Type: " . $row['Type'] . 
             ", Null: " . $row['Null'] . 
             ", Key: " . $row['Key'] . 
             ", Default: " . ($row['Default'] ?? 'NULL') . 
             ", Extra: " . $row['Extra'] . "\n";
    }
    echo "\n";
    
    // Check site_preferences table
    $stmt = $pdo->query("DESCRIBE site_preferences");
    echo "=== Site Preferences Table Schema ===\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Field: " . $row['Field'] . 
             ", Type: " . $row['Type'] . 
             ", Null: " . $row['Null'] . 
             ", Key: " . $row['Key'] . 
             ", Default: " . ($row['Default'] ?? 'NULL') . 
             ", Extra: " . $row['Extra'] . "\n";
    }
    echo "\n";
    
    // Count user_assets by page_id
    $stmt = $pdo->query("SELECT page_id, COUNT(*) as count FROM user_assets GROUP BY page_id");
    echo "=== User Assets Count by Page ID ===\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Page ID: " . $row['page_id'] . ", Count: " . $row['count'] . "\n";
    }
    echo "\n";
    
    // Count site_preferences by template_id
    $stmt = $pdo->query("SELECT template_id, COUNT(*) as count FROM site_preferences GROUP BY template_id");
    echo "=== Site Preferences Count by Template ID ===\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Template ID: " . $row['template_id'] . ", Count: " . $row['count'] . "\n";
    }
    echo "\n";
    
    // List all templates with site_title
    $stmt = $pdo->query("SELECT template_id, site_title FROM site_preferences WHERE site_title IS NOT NULL");
    echo "=== All Templates with Site Titles ===\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Template ID: " . $row['template_id'] . ", Site Title: " . $row['site_title'] . "\n";
    }
    echo "\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?> 