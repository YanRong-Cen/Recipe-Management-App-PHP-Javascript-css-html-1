<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: signin.php');
    exit();
}

// Proceed if the user is logged in and the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['recipe_name'] ?? null;
    $ingredients = $_POST['recipe_ingredients'] ?? null;
    $description = $_POST['recipe_description'] ?? null;
    $dietary_preference = $_POST['dietary_preference'] ?? null;
    $cuisine_type = $_POST['cuisine_type'] ?? null;
    $user_id = $_SESSION['user_id'];

    $imagePath = null; // Default image path as null


        if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] == 0) {
            $fileTmpPath = $_FILES['recipe_image']['tmp_name'];
            $fileName = $_FILES['recipe_image']['name'];
            $fileSize = $_FILES['recipe_image']['size'];
            $fileType = $_FILES['recipe_image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

            if (in_array($fileExtension, $allowedfileExtensions)) {
                // Directory where the file is going to be stored
                $uploadFileDir = '../images/upload/';  // Adjusted path
                $dest_path = $uploadFileDir . $newFileName;

                // Create the directory if it does not exist
                if (!file_exists($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $imagePath = 'images/upload/' . $newFileName;  // Store relative path for use in web pages
                } else {
                    echo 'Error moving the file.';
                }
            } else {
                echo 'Upload failed. Allowed file types: ' . implode(', ', $allowedfileExtensions);
            }
    }

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "recipe",3308);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare an INSERT statement to add a new recipe
    $stmt = $conn->prepare("INSERT INTO recipes (name, ingredients, description, dietary_preference, cuisine_type, image, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $name, $ingredients, $description, $dietary_preference, $cuisine_type, $imagePath, $user_id);
    // Execute the statement and check if the recipe was added successfully
    if ($stmt->execute()) {
        echo "New recipe added successfully!";
        echo '<a href="../Recipe Management.php">Back to Management Page</a>';
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>