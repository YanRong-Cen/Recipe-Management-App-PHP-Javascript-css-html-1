<?php
session_start();
include 'db_connect.php';
include 'generate_recipe.php';

// Ensure the user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    die('User is not logged in.');
}

$user_id = $_SESSION['user_id'];

// Ensure user_id exists in the database schema
try {
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo generateRecipeHTML($recipes);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>