<?php
// Database upgrade script

// Include database configuration
require_once 'dbConfiguration.php';

// Set up error handling
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "========================================\n";
echo "      CMS Database Upgrade Script      \n";
echo "========================================\n\n";

try {
    // Connect to database
    echo "Connecting to database...\n";
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully to database: $dbname\n\n";

    // Get all migration files from migrations directory
    $migrationDir = __DIR__ . '/migrations';
    $migrationFiles = glob($migrationDir . '/*.sql');
    
    if (empty($migrationFiles)) {
        echo "No migration files found in $migrationDir\n";
        exit(0);
    }
    
    // Create migrations tracking table if it doesn't exist
    echo "Checking migrations table...\n";
    $conn->query("
        CREATE TABLE IF NOT EXISTS `migrations` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `migration` varchar(255) NOT NULL,
          `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
          PRIMARY KEY (`id`),
          UNIQUE KEY `migration` (`migration`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");
    echo "Migrations table ready\n\n";
    
    // Get list of already applied migrations
    $appliedMigrations = [];
    $result = $conn->query("SELECT migration FROM migrations");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $appliedMigrations[] = $row['migration'];
        }
    }
    
    echo "Found " . count($migrationFiles) . " migration files\n";
    echo "Already applied: " . count($appliedMigrations) . " migrations\n\n";
    
    // Sort migration files by name
    sort($migrationFiles);
    
    // Apply each migration if not already applied
    $migrationsApplied = 0;
    
    foreach ($migrationFiles as $migrationFile) {
        $migrationName = basename($migrationFile);
        
        if (in_array($migrationName, $appliedMigrations)) {
            echo "Skipping $migrationName (already applied)\n";
            continue;
        }
        
        echo "Applying migration: $migrationName\n";
        
        // Read and execute migration
        $sql = file_get_contents($migrationFile);
        if ($conn->multi_query($sql)) {
            // Process all result sets
            do {
                if ($result = $conn->store_result()) {
                    $result->free();
                }
            } while ($conn->more_results() && $conn->next_result());
            
            // Record successful migration
            $stmt = $conn->prepare("INSERT INTO migrations (migration) VALUES (?)");
            $stmt->bind_param("s", $migrationName);
            $stmt->execute();
            $stmt->close();
            
            echo "✓ Successfully applied $migrationName\n";
            $migrationsApplied++;
        } else {
            throw new Exception("Error applying migration $migrationName: " . $conn->error);
        }
    }
    
    echo "\nMigrations complete. Applied $migrationsApplied new migrations.\n";
    echo "Database is now up to date!\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}

// Close connection
if (isset($conn)) {
    $conn->close();
}
?> 