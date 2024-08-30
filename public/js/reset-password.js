function togglePassword() {
    var password = document.getElementById("password");
    var password_confirmation = document.getElementById("password_confirmation");
    if (password.type === "password") {
        password.type = "text";
        password_confirmation.type = "text";
    } else {
        password.type = "password";
        password_confirmation.type = "password";
    }
}
