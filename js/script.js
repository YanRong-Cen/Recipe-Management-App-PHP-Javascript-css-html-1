document.addEventListener('DOMContentLoaded', function () {
    const sections = {
        'search-recipe': document.getElementById('search-recipe'),
        'add-recipe': document.getElementById('add-recipe'),
        'modify-recipe': document.getElementById('modify-recipe')
    };

    function showSection(sectionId) {
        Object.keys(sections).forEach(key => {
            if (sections[key]) {
                sections[key].style.display = key === sectionId ? 'block' : 'none';
            }
        });
    }

    showSection('search-recipe');
    loadAllRecipes();

    document.querySelector('#search-recipe-btn').addEventListener('click', () => showSection('search-recipe'));
    document.querySelector('#add-recipe-btn').addEventListener('click', () => showSection('add-recipe'));
    document.querySelector('#modify-recipe-btn').addEventListener('click', () => showSection('modify-recipe'));

    document.getElementById('search-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const query = document.getElementById('search-query').value;
        const cuisineType = document.getElementById('cuisine_type').value;
        const dietaryPreference = document.getElementById('dietary_preference').value;
        const searchType = document.getElementById('search-type').value;

        fetch(`php/search_recipes.php?search_query=${encodeURIComponent(query)}&cuisine_type=${encodeURIComponent(cuisineType)}&dietary_preference=${encodeURIComponent(dietaryPreference)}&search_type=${encodeURIComponent(searchType)}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('recipe-list').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    });

    const addRecipeForm = document.getElementById('add-recipe-form');
    if (addRecipeForm) {
        addRecipeForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(addRecipeForm);
            
            fetch('php/add_recipe.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('message').innerHTML = data;
                addRecipeForm.reset();
                loadAllRecipes(); // Refresh the recipe list after adding a new recipe
                showSection('search-recipe'); // Show the search recipe section after submission
            })
            .catch(error => console.error('Error:', error));
        });
    }

    const modifyRecipeForm = document.getElementById('modify-recipe-form');
    if (modifyRecipeForm) {
        modifyRecipeForm.addEventListener('submit', function (e) {
            // Implement modification logic here
            e.preventDefault();

            const formData = new FormData(modifyRecipeForm);
            
            fetch('php/modify_recipe.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('message').innerHTML = data;
                modifyRecipeForm.reset();
                showSection('search-recipe'); // Show the search recipe section after submission
            })
            .catch(error => console.error('Error:', error));
        });
    }
});

function loadAllRecipes() {
    fetch('php/get_all_recipes.php')
        .then(response => response.text())
        .then(data => {
            const recipeList = document.getElementById('recipe-list');
            if (recipeList) {
                recipeList.innerHTML = data;
            }
        })
        .catch(error => console.error('Error:', error));
}

function searchRecipes(query, type, searchType) {
    fetch(`php/search_recipes.php?search_query=${encodeURIComponent(query)}&recipe_type=${encodeURIComponent(type)}&search_type=${encodeURIComponent(searchType)}`)
        .then(response => response.text())
        .then(data => {
            const recipeList = document.getElementById('recipe-list');
            if (recipeList) {
                recipeList.innerHTML = data;
            }
        })
        .catch(error => console.error('Error:', error));
}

function loadRecipeDetails(recipeId) {
    fetch(`php/get_all_recipes.php?recipe_id=${recipeId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modify-recipe-id').value = data.id;
            document.getElementById('modify-recipe-name').value = data.name;
            document.getElementById('modify-recipe-cuisine').value = data.cuisine_type;
            document.getElementById('modify-recipe-dietary').value = data.dietary_preference;
            document.getElementById('modify-recipe-ingredients').value = data.ingredients;
            document.getElementById('modify-recipe-description').value = data.description;
        })
        .catch(error => console.error('Error loading recipe details:', error));
}
