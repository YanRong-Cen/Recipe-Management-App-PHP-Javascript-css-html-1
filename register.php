<!--
    student name:jiajun cai, ningyi wang, Yanrong Cen
    file name:register.php
    Date of create: july 27 2024
    Description: register  page that creat a account ons the  recipe management system.
-->
<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="utf-8">
    <meta name="author" content="jiajun cai">
    <meta name="description" content="the recipe management web-app register page">
</head>

<body class="register">
    <div class="container">
        <img src="images/logo.png" alt="MA-I-RECIPE Logo" class="logo">
        <h1>REGISTER</h1>

     
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="message">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']); 
                ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="re-password" placeholder="Re-enter Password" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <div class="checkbox-group">
                <input type="checkbox" id="promotion" name="promotion">
                <label for="promotion">Accept promotion ad</label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">Check the agree term</label>
            </div>
            <button type="submit">Create Account</button>
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
<script src="js/register.js"></script>
</body>

</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $re_password = $_POST['re-password'];
    $email = $_POST['email'];
    $promotion = isset($_POST['promotion']) ? 1 : 0;
    $terms = isset($_POST['terms']) ? 1 : 0;

    
    if ($password !== $re_password) {
        echo "<script>
            alert('Passwords do not match!');
            window.location.href = 'index.php';
          </script>";
        exit;
    }

    
    $conn = new mysqli("localhost", "root", "", "recipe",3308);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, promotion, terms) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $username, password_hash($password, PASSWORD_DEFAULT), $email, $promotion, $terms);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Registration successful!";
        header("Location: signin.php");
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        header("Location: index.php");
    }

    $stmt->close();
    $conn->close();
}
