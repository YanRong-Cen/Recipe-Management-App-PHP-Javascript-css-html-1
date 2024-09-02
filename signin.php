<!--
    student name:jiajun cai, ningyi wang, Yanrong Cen
    file name:sign.html
    Date of create: july 27 2024
    Description: sign in  page that login the  recipe management system.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign-in</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="utf-8">
    <meta name="author" content="jiajun cai">
    <meta name="description" content="the recipe management web-app sign in page">
</head>

<body class="signin">
    <div class="container">
        <img src="images/logo.png" alt="MA-I-RECIPE Logo" class="logo">
        <h1>MA - I - RECIPE</h1>
        <h2 style="text-align: center; color: #8B4513;">sign-in</h2>
        <form action="signin.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="checkbox-group">
                <input type="checkbox" id="auto-login" name="auto-login">
                <label for="auto-login">Auto login</label>
            </div>
            <button type="submit">Login in</button>
        </form>
    </div>
    <footer>
        <div class="footer-content">
            <p>Contact Us:</p>
            <p>Author: Ningyi Wang, Jiajun Cai, Yanrong Cen</p>
            <p>Email: wang0999@algonquinlive.com, cai00075@algonquinlive.com, cen00011@algonquinlive.com</p>
            <p>Address: 1385 Woodroffe Ave, Ottawa, ON, CA</p>
            <p>Copyright © MA-I-RECIPE</p>
        </div>
        <img src="images/logo.png" alt="Footer Logo" class="footer-logo">
    </footer>

</body>

</html>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "recipe",3308);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare to select the user ID and password from the database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id; // Storing user ID in the session

            // Close statement and connection
            $stmt->close();
            $conn->close();

            // Redirect to the recipe management page
            header("Location: Recipe management.php");
            exit(); // Ensure the script stops here after successful login
        } else {
            echo "<script type='text/javascript'>alert('Wrong password!');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('User not found');</script>";
    }

    // Close statement and connection if not already closed
    if (!$stmt->close()) {
        $stmt->close();
    }
    if (!$conn->close()) {
        $conn->close();
    }
}
?>