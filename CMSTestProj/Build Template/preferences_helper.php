<?php
function savePreference($pdo, $userId, $column, $value) {
    try {
        // Check if the user already has preferences
        $stmt = $pdo->prepare("SELECT id FROM site_preferences WHERE user_id = ?");
        $stmt->execute([$userId]);
        $exists = $stmt->fetch();

        if ($exists) {
            // Update the specific column in the preferences table
            $stmt = $pdo->prepare("UPDATE site_preferences SET $column = ? WHERE user_id = ?");
            return $stmt->execute([$value, $userId]);
        } else {
            // Insert a new row with the specific column value
            $stmt = $pdo->prepare("INSERT INTO site_preferences (user_id, $column) VALUES (?, ?)");
            return $stmt->execute([$userId, $value]);
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function getPreferences($pdo, $userId) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM site_preferences WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return null;
    }
}
?>