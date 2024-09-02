//// Wait for the DOM to be fully loaded before executing the script
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');// Select the form element

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission until validation is complete
        let isValid = true; // Flag to determine if the form should be submitted

        // Select form fields by their 'name' attribute
        const username = form.querySelector('[name="username"]');
        const password = form.querySelector('[name="password"]');
        const confirmPassword = form.querySelector('[name="re-password"]');
        const email = form.querySelector('[name="email"]');
        const terms = form.querySelector('[name="terms"]');

        // Clear previous error messages
        document.querySelectorAll('.error').forEach(function (errorElement) {
            errorElement.textContent = ''; // Clear the text
        });

        // Validate username: ensure it's not empty and within 30 characters
        if (!username.value.trim()) {
            displayError(username, "Username cannot be empty.");
            isValid = false;
        } else if (username.value.length > 30) {
            displayError(username, "Username must be within 30 characters long.");
            isValid = false;
        }

       // Validate password: ensure it's at least 8 characters long and meets complexity requirements
        if (password.value.length < 8) {
            displayError(password, "Password must be at least 8 characters long.");
            isValid = false;
        } else if (!password.value.match(/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/)) {
            displayError(password, "Password must include at least one uppercase letter, one lowercase letter, and one number.");
            isValid = false;
        }

       // Validate password confirmation: ensure both passwords match
        if (password.value !== confirmPassword.value) {
            displayError(confirmPassword, "Passwords do not match.");
            isValid = false;
        }

        // Validate email: ensure it follows a basic email format
        if (!/^\S+@\S+\.\S+$/.test(email.value)) {
            displayError(email, "Please enter a valid email address.");
            isValid = false;
        }

        // Validate terms and conditions: ensure the checkbox is checked
        if (!terms.checked) {
            displayError(terms, "You must agree to the terms and conditions.");
            isValid = false;
        }
		// If all validations pass, submit the form
        if (isValid) {
            form.submit(); // Submit the form if all validations are passed
        }
    });
	 // Function to display an error message next to the corresponding input field
    function displayError(inputElement, message) {
        const errorDiv = document.createElement('div');// Create a new div element for the error message
        errorDiv.textContent = message;// Set the error message text
        errorDiv.className = 'error';// Assign a class name for styling
        inputElement.parentNode.insertBefore(errorDiv, inputElement.nextSibling);// Insert the error message after the input field
    }
});
