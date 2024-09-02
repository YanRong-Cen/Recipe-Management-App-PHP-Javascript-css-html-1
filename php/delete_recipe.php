<?php
include 'db_connect.php';

if (isset($_POST['delete']) && isset($_POST['recipe_name'])) {
  $recipe_name = $_POST['recipe_name'];

  try {
    $stmt = $pdo->prepare("DELETE FROM recipes WHERE name = ?");
    $stmt->execute([$recipe_name]);

    header("Location: ../recipe_management.php?deleted=success");
    exit();
  } catch (PDOException $e) {
    echo "Delete failed: " . htmlspecialchars($e->getMessage());
  }
} else {
  header("Location: ../recipe_management.php");
  exit();
}
