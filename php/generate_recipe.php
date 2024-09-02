<?php
function generateRecipeHTML($recipes)
{
  $html = '';
  foreach ($recipes as $recipe) {
    $html .= '<div class="recipe-item">';
    $html .= '<img src="' . htmlspecialchars($recipe['image']) . '" alt="Recipe Image">';
    $html .= '<div class="recipe-info">';
    $html .= '<h3>' . htmlspecialchars($recipe['name']) . '</h3>';
    $html .= '<p>cuisine type: ' . htmlspecialchars($recipe['cuisine_type']) . '</p>';
    $html .= '<p>dietary preference: ' . htmlspecialchars($recipe['dietary_preference']) . '</p>';
    $html .= '<p>Ingredients: ' . htmlspecialchars($recipe['ingredients']) . '</p>';
    $html .= '<p>Description: ' . htmlspecialchars($recipe['description']) . '</p>';
    $html .= '</div>';
    $html .= '<form method="POST" action="php/delete_recipe.php" onsubmit="return confirm(\'Are you sure you want to delete this recipe?\');">';
    $html .= '<input type="hidden" name="recipe_name" value="' . htmlspecialchars($recipe['name']) . '">';
    $html .= '<button type="submit" name="delete" class="delete-btn">Delete</button>';
    $html .= '</form>';
    $html .= '</div>';
  }
  return $html;
}
