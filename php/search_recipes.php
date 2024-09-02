<?php
require 'db_connect.php';

$search_query = $_GET['search_query'] ?? '';
$cuisine_type = $_GET['cuisine_type'] ?? '';
$dietary_preference = $_GET['dietary_preference'] ?? '';
$search_type = $_GET['search_type'] ?? 'name';

$sql = "SELECT * FROM recipes WHERE $search_type LIKE ?";

$params = ["%$search_query%"];

if ($cuisine_type) {
    $sql .= " AND cuisine_type = ?";
    $params[] = $cuisine_type;
}

if ($dietary_preference) {
    $sql .= " AND dietary_preference = ?";
    $params[] = $dietary_preference;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$recipes = $stmt->fetchAll();

if (count($recipes) > 0) {
    foreach ($recipes as $recipe) {
        echo "<div class='recipe-item'>";
        echo "<img src='{$recipe['image']}' alt='Recipe Image'>";
        echo "<div class='recipe-info'>";
        echo "<h3>{$recipe['name']}</h3>";
        echo "<p>Cuisine Type: " . htmlspecialchars($recipe['cuisine_type']) . "</p>";
        echo "<p>Dietary Preference: " . htmlspecialchars($recipe['dietary_preference']) . "</p>";
        echo "<p>Ingredients: " . htmlspecialchars($recipe['ingredients']) . "</p>";
        echo "<p>Description: " . htmlspecialchars($recipe['description']) . "</p>";
        echo "</div>";
        echo "<form method='POST' action='delete_recipe.php' onsubmit=\"return confirm('Are you sure you want to delete this recipe?');\">";
        echo "<input type='hidden' name='recipe_name' value='" . htmlspecialchars($recipe['name']) . "'>";
        echo "<button type='submit' name='delete' class='delete-btn'>Delete</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "<p>No recipes found.</p>";
}
?>
