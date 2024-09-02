<?php
session_start();
require_once 'db_connect.php';  // Include your database connection script

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipe_id = $_POST['recipe_id'] ?? null;
    $name = $_POST['recipe_name'] ?? null;
    $ingredients = $_POST['recipe_ingredients'] ?? null;
    $description = $_POST['recipe_description'] ?? null;
    $cuisine_type = $_POST['cuisine_type'] ?? null;
    $dietary_preference = $_POST['dietary_preference'] ?? null;

    // Validate input
    if ($recipe_id && $name && $ingredients && $description && $cuisine_type && $dietary_preference) {
        // Handle image upload
        if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] === UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['recipe_image']['tmp_name'];
            $image_name = basename($_FILES['recipe_image']['name']);
            $image_upload_dir = '../images/uploads/';
            $image_upload_path = $image_upload_dir . $image_name;
            $image_relative_path = 'images/uploads/' . $image_name; // Relative path to store in the database

            // Ensure the directory exists
            if (!is_dir($image_upload_dir)) {
                mkdir($image_upload_dir, 0777, true);
            }

            if (move_uploaded_file($image_tmp_name, $image_upload_path)) {
                $stmt = $pdo->prepare("UPDATE recipes SET name = ?, ingredients = ?, description = ?, image = ? WHERE id = ?");
                $stmt->execute([$name, $ingredients, $description, $image_relative_path, $recipe_id]);
            } else {
                echo "Failed to upload image.";
            }
        } else {
            // If no new image is uploaded, update without changing the image
            $stmt = $pdo->prepare("UPDATE recipes SET name = ?, ingredients = ?, description = ? WHERE id = ?");
            $stmt->execute([$name, $ingredients, $description, $recipe_id]);
        }

        echo "Recipe updated successfully.";
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request method.";
}