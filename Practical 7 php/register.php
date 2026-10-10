<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars(trim($_POST["name"] ?? ""));
    $email = htmlspecialchars(trim($_POST["email"] ?? ""));
    $gender = htmlspecialchars(trim($_POST["gender"] ?? ""));
    $mobile = htmlspecialchars(trim($_POST["mobile"] ?? ""));
    $password = trim($_POST["password"] ?? "");
    $confirmPassword = trim($_POST["confirmPassword"] ?? "");
    $course = htmlspecialchars(trim($_POST["course"] ?? ""));
    $year = htmlspecialchars(trim($_POST["year"] ?? ""));

    if ($name == "") {
        echo "Error: Name is required.";
        exit;
    }

    if (!preg_match("/^[A-Za-z ]+$/", $name)) {
        echo "Error: Name should contain characters only.";
        exit;
    }

    if ($email == "") {
        echo "Error: Email is required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Enter a valid email address.";
        exit;
    }

    if ($gender == "") {
        echo "Error: Please select gender.";
        exit;
    }

    if (!preg_match("/^[6-9][0-9]{9}$/", $mobile)) {
        echo "Error: Enter a valid 10 digit mobile number.";
        exit;
    }

    if (strlen($password) < 6) {
        echo "Error: Password must contain at least 6 characters.";
        exit;
    }

    if ($password != $confirmPassword) {
        echo "Error: Password does not match.";
        exit;
    }

    if ($course == "") {
        echo "Error: Please select a course.";
        exit;
    }

    if ($year == "") {
        echo "Error: Please select a year.";
        exit;
    }
    $data = [
        "name" => $name,
        "email" => $email,
        "gender" => $gender,
        "mobile" => $mobile,
        "course" => $course,
        "year" => $year
    ];
    $file = "registrations.txt";

$data = "Name: $name | Email: $email | Gender: $gender | Mobile: $mobile | Course: $course | Year: $year\n";

if (file_put_contents($file, $data, FILE_APPEND)) {
    echo "<h2>Registration Successful</h2>";
    echo "Thank you, <b>" . $name . "</b>.";
    echo "<br>Your registration has been saved successfully.";
}
else {
    echo "<h2>Error</h2>";
    echo "Could not save your registration.";
}

//     $file = "registrations.json";

//     if (file_exists($file)) {
//         $json = file_get_contents($file);
//         $records = json_decode($json, true);

//         if (!is_array($records)) {
//             $records = [];
//         }
//     }
//     else {
//         $records = [];
//     }

//     $records[] = $data;

//     if (file_put_contents($file, json_encode($records, JSON_PRETTY_PRINT))) {

//         echo "<h2>Registration Successful</h2>";
//         echo "Thank you, <b>" . $name . "</b>.";
//         echo "<br>Your registration has been saved successfully.";

//     }
//     else {

//         echo "<h2>Error</h2>";
//         echo "Could not save your registration.";

//     }

 }

?>

