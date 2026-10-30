<?php
require "db.php";

header("Content-Type: text/html; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $gender = trim($_POST["gender"] ?? "");
    $mobile = trim($_POST["mobile"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirmPassword"] ?? "";
    $course = trim($_POST["course"] ?? "");
    $year = trim($_POST["year"] ?? "");
    $semester = trim($_POST["semester"] ?? "");

    if (
        $name == "" || $email == "" || $gender == "" ||
        $mobile == "" || $password == "" ||
        $confirmPassword == "" || $course == "" ||
        $year == "" || $semester == ""
    ) {
        die("Error: Please fill all fields.");
    }

    if (!isset($_POST["terms"])) {
        die("Error: Please accept the Terms and Conditions.");
    }

    if (!preg_match("/^[A-Za-z ]+$/", $name)) {
        die("Error: Name should contain letters only.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Enter a valid email address.");
    }

    if (!in_array($gender, ["Male", "Female"], true)) {
        die("Error: Please select a valid gender.");
    }

    if (!preg_match("/^[6-9][0-9]{9}$/", $mobile)) {
        die("Error: Enter a valid 10 digit mobile number.");
    }

    if (strlen($password) < 6) {
        die("Error: Password must contain at least 6 characters.");
    }

    if ($password !== $confirmPassword) {
        die("Error: Passwords do not match.");
    }

    if (!in_array($year, ["1", "2", "3", "4"], true)) {
        die("Error: Please select a valid year.");
    }

    if (!in_array($semester, ["1", "2", "3", "4", "5", "6", "7", "8"], true)) {
        die("Error: Please select a valid semester.");
    }

    $stmt = $conn->prepare(
        "SELECT student_id FROM students WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        die("Error: Email already registered in students.");
    }

    $stmt->close();

    $stmt = $conn->prepare(
        "SELECT id FROM users WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        die("Error: Email already registered in users.");
    }

    $stmt->close();

    $conn->begin_transaction();

    try {

        $stmt = $conn->prepare(
            "INSERT INTO students
            (name, email, gender, mobile, course, year, semester)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssssss",
            $name,
            $email,
            $gender,
            $mobile,
            $course,
            $year,
            $semester
        );

        $stmt->execute();
        $stmt->close();

        $username = $name;
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = "student";

        $stmt = $conn->prepare(
            "INSERT INTO users
            (username, email, password, role)
            VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssss",
            $username,
            $email,
            $hashedPassword,
            $role
        );

        $stmt->execute();
        $stmt->close();

        $conn->commit();

        echo "<h2>Registration Successful!</h2>";
        echo "Welcome, " . htmlspecialchars($name);
        echo "<br>Course: " . htmlspecialchars($course);
        echo "<br>Year: " . htmlspecialchars($year);
        echo "<br>Semester: " . htmlspecialchars($semester);
        echo "<br><a href='login.php'>Please Login</a>";

    } catch (mysqli_sql_exception $e) {

        $conn->rollback();

        echo "Registration failed. Please try again later.";
    }

} else {
    echo "Please submit the registration form.";
}

$conn->close();
?>
