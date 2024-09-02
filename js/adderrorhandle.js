


document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('add-recipe-form');// Get the form element by its ID
    
	// Check if the form exists on the page
	if (form) {
		// Add a 'submit' event listener to the form
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            var formData = new FormData(this);// Create a FormData object to capture form data

			// Send the form data using the Fetch API
            fetch(this.action, {
                method: 'POST', // Set the HTTP method to POST
                body: formData // Include the form data in the request body
            })
                .then(response => response.text())// Convert the response to text
                .then(text => {
					// Display a success message if the recipe was added successfully
                    document.getElementById('message').innerHTML = "<div class='alert-success'>New recipe added successfully!</div>";
                })
                .catch(error => {
					 // Display an error message if there was an issue adding the recipe
                    document.getElementById('message').innerHTML = "<div class='alert-error'>Error adding recipe: " + error + "</div>";
                });
        });
    }
});
