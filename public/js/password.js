function togglePassword() {
    var passwordField = document.getElementById("password");
    var showPasswordCheckbox = document.getElementById("showPassword");
    if (showPasswordCheckbox.checked) {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}
