<?php
session_start();
include 'php/db_connect.php';

$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';


if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Recipe Management</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="author" content="Jiajun Cai">
    <meta name="description" content="The recipe management web-app management page">
</head>

<body class="management">
    <nav>
        <img src="images/logo.png" alt="App Logo" class="logo">
        <div class="nav-links">
            <span id="account-name"><?php echo htmlspecialchars($username); ?></span>
            <a href="?action=logout" class="logout-link">Log out</a>
        </div>
    </nav>
    <div class="content-wrapper">
        <aside>
            <ul>
                <li><button id="search-recipe-btn">Search Recipe</button></li>
                <li><button id="add-recipe-btn">Add New Recipe</button></li>
                <li><button id="modify-recipe-btn">Modify Recipe</button></li>
            </ul>
        </aside>
        <main>
            <section id="search-recipe" class="content-section">
                <form id="search-form" method="GET" action="php/search_recipes.php"> <!-- Removed enctype as it's not needed for GET requests -->
                    <div class="search-bar">
                        <input type="text" id="search-query" name="search_query" placeholder="Search by name or ingredients...">

                        <!-- Dropdown for Cuisine Type -->
                        <select id="cuisine_type" name="cuisine_type">
                            <option value="">All Cuisines</option>
                            <option value="Italian">Italian</option>
                            <option value="Mexican">Mexican</option>
                            <option value="Chinese">Chinese</option>
                            <option value="Indian">Indian</option>
                            <option value="French">French</option>
                            <option value="Thai">Thai</option>
                            <option value="Japanese">Japanese</option>
                            <option value="Mediterranean">Mediterranean</option>
                            <option value="Middle Eastern">Middle Eastern</option>
                            <option value="other">Other</option>
                        </select>

                        <!-- Dropdown for Dietary Preferences -->
                        <select id="dietary_preference" name="dietary_preference">
                            <option value="">All Preferences</option>
                            <option value="vegan">Vegan</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="gluten-free">Gluten-Free</option>
                            <option value="paleo">Paleo</option>
                            <option value="ketogenic">Ketogenic</option>
                            <option value="lactose-free">Lactose-Free</option>
                            <option value="halal">Halal</option>
                            <option value="kosher">Kosher</option>
                            <option value="other">Other</option>
                        </select>

                        <!-- Dropdown for Search Type -->
                        <select id="search-type" name="search_type">
                            <option value="name">Search by Name</option>
                            <option value="ingredients">Search by Ingredients</option>
                        </select>

                        <button type="submit" name="search" id="search-btn">Search</button>
                    </div>
                </form>
                <div class="recipe-list" id="recipe-list">
                    <?php if (!empty($recipes)) : ?>
                        <?php foreach ($recipes as $recipe) : ?>
                            <div class="recipe-item">
                                <img src="images/<?php echo basename(htmlspecialchars($recipe['image'])); ?>" alt="Recipe Image">
                                <div class="recipe-info">
                                    <h3><?php echo htmlspecialchars($recipe['name']); ?></h3>
                                    <p>Cuisine Type: <?php echo htmlspecialchars($recipe['cuisine_type']); ?></p>
                                    <p>Dietary Preference: <?php echo htmlspecialchars($recipe['dietary_preference']); ?></p>
                                    <p>Ingredients: <?php echo htmlspecialchars($recipe['ingredients']); ?></p>
                                    <p>Description: <?php echo htmlspecialchars($recipe['description']); ?></p>
                                </div>
                                <form method="POST" action="php/delete_recipe.php" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                                    <input type="hidden" name="recipe_name" value="<?php echo htmlspecialchars($recipe['name']); ?>">
                                    <button type="submit" name="delete" class="delete-btn">Delete</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No recipes found.</p>
                    <?php endif; ?>
                </div>
            </section>

            <section id="add-recipe" class="content-section" style="display: none;">
                <form id="add-recipe-form" method="post" enctype="multipart/form-data" action="php/add_recipe.php">
                    <div class="form-group">
                        <label for="recipe-image">Upload Your Recipe Image:</label>
                        <input type="file" id="recipe-image" name="recipe_image">
                    </div>
                    <div class="form-group">
                        <label for="recipe-name">Name:</label>
                        <input type="text" id="recipe-name" name="recipe_name" required>
                    </div>
                    <div class="form-group">
                        <label for="dietary_preference">Dietary Preference:</label>
                        <select name="dietary_preference" id="dietary_preference" required>
                            <option value="vegan">Vegan</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="gluten-free">Gluten-Free</option>
                            <option value="paleo">Paleo</option>
                            <option value="ketogenic">ketogenic</option>
                            <option value="lactose-free">lactose-free</option>
                            <option value="halal">halal</option>
                            <option value="kosher">kosher</option>
                            <option value="other">other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cuisine_type">Cuisine Type:</label>
                        <select name="cuisine_type" id="cuisine_type" required>
                            <option value="Italian">Italian</option>
                            <option value="Mexican">Mexican</option>
                            <option value="Chinese">Chinese</option>
                            <option value="Indian">Indian</option>
                            <option value="French">French</option>
                            <option value="Thai">Thai</option>
                            <option value="Japanese">Japanese</option>
                            <option value="Mediterranean">Mediterranean</option>
                            <option value="Middle Eastern">Middle Eastern</option>
                            <option value="other">other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipe-ingredients">Ingredients:</label>
                        <textarea id="recipe-ingredients" name="recipe_ingredients" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="recipe-description">Description:</label>
                        <textarea id="recipe-description" name="recipe_description" required></textarea>
                    </div>
                    <div class="form-buttons">
                        <button type="submit" name="submit">Save</button>
                        <button type="reset">Reset</button>
                    </div>
                </form>
                <div id="message"></div>
            </section>

            <section id="modify-recipe" class="content-section" style="display: none;">
                <!-- Dropdown to select a recipe to modify -->
                <div class="form-group">
                    <label for="select-recipe">Select Recipe:</label>


                <!-- Form to modify the selected recipe -->
                <form id="modify-recipe-form" method="post" enctype="multipart/form-data" action="php/modify_recipe.php">

                    <select id="select-recipe" name="recipe_id" required onchange="loadRecipeDetails(this.value);">
                        <option value="">Choose a Recipe</option>
                        <?php include 'php/load_recipes_dropdown.php'; ?>
                    </select>

                    <div class="form-group">
                        <label for="modify-recipe-name">Name:</label>
                        <input type="text" id="modify-recipe-name" name="recipe_name" required>
                    </div>

                    <div class="form-group">
                        <label for="modify-recipe-image">Upload New Recipe Image:</label>
                        <input type="file" id="modify-recipe-image" name="recipe_image">
                    </div>

                    <div class="form-group">
                        <label for="modify-recipe-cuisine">Cuisine Type:</label>
                        <select id="modify-recipe-cuisine" name="cuisine_type" required>
                            <option value="Italian">Italian</option>
                            <option value="Mexican">Mexican</option>
                            <option value="Chinese">Chinese</option>
                            <option value="Indian">Indian</option>
                            <option value="French">French</option>
                            <option value="Thai">Thai</option>
                            <option value="Japanese">Japanese</option>
                            <option value="Mediterranean">Mediterranean</option>
                            <option value="Middle Eastern">Middle Eastern</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="modify-recipe-dietary">Dietary Preference:</label>
                        <select id="modify-recipe-dietary" name="dietary_preference" required>
                            <option value="vegan">Vegan</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="gluten-free">Gluten-Free</option>
                            <option value="paleo">Paleo</option>
                            <option value="ketogenic">Ketogenic</option>
                            <option value="lactose-free">Lactose-Free</option>
                            <option value="halal">Halal</option>
                            <option value="kosher">Kosher</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="modify-recipe-ingredients">Ingredients:</label>
                        <textarea id="modify-recipe-ingredients" name="recipe_ingredients" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="modify-recipe-description">Description:</label>
                        <textarea id="modify-recipe-description" name="recipe_description" required></textarea>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" name="update">Update</button>
                        <button type="reset">Reset</button>
                    </div>
                </form>
            </section>


            




        </main>
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

    <script src="js/script.js"></script>
</body>

</html>