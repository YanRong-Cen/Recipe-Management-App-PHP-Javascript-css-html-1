<?php
session_start();
require_once 'db_connect.php';

// Debugging: Output session information
echo "<!-- Session info: " . print_r($_SESSION, true) . " -->";

if (!isset($_SESSION['user_id'])) {
    echo "<option value=''>Please log in</option>";
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $query = "SELECT id, name FROM recipes WHERE user_id = :user_id ORDER BY name ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $user_id]);

    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debugging: Output query results
    echo "<!-- Query results: " . print_r($recipes, true) . " -->";

    if (count($recipes) > 0) {
        foreach ($recipes as $recipe) {
            echo "<option value='" . htmlspecialchars($recipe['id']) . "'>" . htmlspecialchars($recipe['name']) . "</option>";
        }
    } else {
        echo "<option value=''>No recipes found</option>";
    }
} catch (PDOException $e) {
    echo "<option value=''>Error loading recipes</option>";
    // Log the error for debugging
    error_log("Error loading recipes: " . $e->getMessage());
    // Debugging: Output error message
    echo "<!-- Error: " . $e->getMessage() . " -->";
}
?>