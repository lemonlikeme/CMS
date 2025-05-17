<?php
function savePreference($pdo, $userId, $column, $value, $templateId = 'homepage') {
    try {
        error_log("Attempting to save preference: column=$column, userId=$userId, templateId=$templateId, value=$value");
        
        // Check if the user already has preferences for this template
        $sql = "SELECT id FROM site_preferences WHERE user_id = ? AND template_id = ?";
        error_log("Executing query: $sql with user_id=$userId, template_id=$templateId");
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId, $templateId]);
        $exists = $stmt->fetch();
        
        error_log("User preferences exist for template $templateId: " . ($exists ? "Yes (ID: {$exists['id']})" : "No"));

        if ($exists) {
            // Update the specific column in the preferences table
            $sql = "UPDATE site_preferences SET $column = ? WHERE user_id = ? AND template_id = ?";
            error_log("Executing update query: $sql with value=$value, user_id=$userId, template_id=$templateId");
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$value, $userId, $templateId]);
            error_log("Update result: " . ($result ? "Success (rows affected: {$stmt->rowCount()})" : "Failed"));
            return $result;
        } else {
            // Insert a new row with the specific column value
            $sql = "INSERT INTO site_preferences (user_id, template_id, $column) VALUES (?, ?, ?)";
            error_log("Executing insert query: $sql with user_id=$userId, template_id=$templateId, value=$value");
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$userId, $templateId, $value]);
            error_log("Insert result: " . ($result ? "Success (last insert ID: {$pdo->lastInsertId()})" : "Failed"));
            return $result;
        }
    } catch (PDOException $e) {
        error_log("Database error in savePreference: " . $e->getMessage());
        error_log("SQL State: " . $e->getCode());
        error_log("Driver error code: " . $e->errorInfo[1] ?? 'unknown');
        error_log("Driver error message: " . $e->errorInfo[2] ?? 'unknown');
        return false;
    } catch (Exception $e) {
        error_log("General error in savePreference: " . $e->getMessage());
        return false;
    }
}

function getPreferences($pdo, $userId, $templateId = 'homepage') {
    try {
        $stmt = $pdo->prepare("SELECT * FROM site_preferences WHERE user_id = ? AND template_id = ?");
        $stmt->execute([$userId, $templateId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return null;
    }
}
?>