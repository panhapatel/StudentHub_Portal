
let form = document.getElementById("registerForm");

form.addEventListener("submit", function(event) {

    event.preventDefault();

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let contact = document.getElementById("contact").value.trim();
    let password = document.getElementById("Password").value;
    let confirmPassword = document.getElementById("ConfirmPassword").value;
    let course = document.getElementById("course").value;
    let year = document.getElementById("year").value;
    let terms = document.getElementById("terms").checked;

    let gender = document.querySelector('input[name="gender"]:checked');

    if (name == "") {
        document.getElementById("nameerror").textContent = "Name is required";
        return;
    }
    else if (!/^[A-Za-z ]+$/.test(name)) {
        document.getElementById("nameerror").textContent = "Enter a valid name";
        return;
    }
    document.getElementById("nameerror").textContent = "";

    if (email == "") {
        document.getElementById("emailerror").textContent = "Email is required";
        return;
    }
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById("emailerror").textContent = "Enter a valid email";
        return;
    }
    document.getElementById("emailerror").textContent = "";

    if (gender == null) {
        document.getElementById("gendererror").textContent = "Select your gender";
        return;
    }
    document.getElementById("gendererror").textContent = "";

    if (!/^[6-9][0-9]{9}$/.test(contact)) {
        document.getElementById("contacterror").textContent = "Enter a valid 10-digit mobile number";
        return;
    }
    document.getElementById("contacterror").textContent = "";

    if (password.length < 6) {
        document.getElementById("passworderror").textContent = "Password must have at least 6 characters";
        return;
    }
    document.getElementById("passworderror").textContent = "";

    if (confirmPassword == "") {
        document.getElementById("confirmpassworderror").textContent = "Confirm your password";
        return;
    }
    else if (password != confirmPassword) {
        document.getElementById("confirmpassworderror").textContent = "Passwords do not match";
        return;
    }
    document.getElementById("confirmpassworderror").textContent = "";

    if (course == "") {
        document.getElementById("courseerror").textContent = "Select your course";
        return;
    }
    document.getElementById("courseerror").textContent = "";

    if (year == "") {
        document.getElementById("yearerror").textContent = "Select your year";
        return;
    }
    document.getElementById("yearerror").textContent = "";

    if (!terms) {
        document.getElementById("termserror").textContent = "Accept terms and conditions";
        return;
    }
    document.getElementById("termserror").textContent = "";

    alert("Registration successful!");

    window.location.href = "login.html";

});
