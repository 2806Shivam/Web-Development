// Validate sign-up form
function validateSignupForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;

    if (password.length < 8) {
        alert("Password must be at least 8 characters long.");
        return false;
    }
    if (password != confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }
    return true;
}

// Validate login form
function validateLoginForm() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    if (email == "" || password == "") {
        alert("All fields are required.");
        return false;
    }
    return true;
}
