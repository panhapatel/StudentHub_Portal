let form = document.getElementById("registerForm");

let nameInput = document.getElementById("name");
let email = document.getElementById("email");
let contact = document.getElementById("contact");
let password = document.getElementById("Password");
let confirmPassword = document.getElementById("ConfirmPassword");
let course = document.getElementById("course");
let year = document.getElementById("year");
let semester = document.getElementById("semester");
let terms = document.getElementById("terms");
let genderError = document.getElementById("gendererror");
let semesterError = document.getElementById("semestererror");

let nameError = document.getElementById("nameerror");
let emailError = document.getElementById("emailerror");
let contactError = document.getElementById("contacterror");
let passwordError = document.getElementById("passworderror");
let confirmPasswordError = document.getElementById("confirmpassworderror");
let courseError = document.getElementById("courseerror");
let yearError = document.getElementById("yearerror");
let termsError = document.getElementById("termserror");

let namePattern = /^[A-Za-z ]+$/;
let contactPattern = /^[6-9][0-9]{9}$/;
let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


form.addEventListener("submit", function(event) {

    event.preventDefault();


    let value = nameInput.value.trim();

    if (value === "") {

        nameError.textContent = "Name is required";
        nameInput.focus();
        return;

    }

    if (!namePattern.test(value)) {

        nameError.textContent = "Name should contain characters only";
        nameInput.focus();
        return;

    }

    nameError.textContent = "";


    value = email.value.trim();

    if (value === "") {

        emailError.textContent = "Email is required";
        email.focus();
        return;

    }

    if (!emailPattern.test(value)) {

        emailError.textContent = "Enter a valid email address";
        email.focus();
        return;

    }

    emailError.textContent = "";


    value = contact.value.trim();

    if (value === "") {

        contactError.textContent = "Mobile number is required";
        contact.focus();
        return;

    }

    if (!contactPattern.test(value)) {

        contactError.textContent = "Mobile number must contain valid 10 digits";
        contact.focus();
        return;

    }

    contactError.textContent = "";


    value = password.value;

    if (value === "") {

        passwordError.textContent = "Password is required";
        password.focus();
        return;

    }

    if (value.length < 6) {

        passwordError.textContent = "Password must contain at least 6 characters";
        password.focus();
        return;

    }

    passwordError.textContent = "";


    value = confirmPassword.value;

    if (value === "") {

        confirmPasswordError.textContent = "Confirm password is required";
        confirmPassword.focus();
        return;

    }

    if (value !== password.value) {

        confirmPasswordError.textContent = "Password does not match";
        confirmPassword.focus();
        return;

    }

    confirmPasswordError.textContent = "";


    if (!document.querySelector('input[name="gender"]:checked')) {

        genderError.textContent = "Please select gender";
        return;

    }

    genderError.textContent = "";


    value = course.value;

    if (value === "") {

        courseError.textContent = "Please select a course";
        course.focus();
        return;

    }

    courseError.textContent = "";


    value = year.value;

    if (value === "") {

        yearError.textContent = "Please select a year";
        year.focus();
        return;

    }

    yearError.textContent = "";


    value = semester.value;

    if (value === "") {

        semesterError.textContent = "Please select a semester";
        semester.focus();
        return;

    }

    semesterError.textContent = "";


    if (!terms.checked) {

        termsError.textContent = "Please accept terms and conditions";
        terms.focus();
        return;

    }

    termsError.textContent = "";


    form.submit();

});
