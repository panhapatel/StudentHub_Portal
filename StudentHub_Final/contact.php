<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contact.html");
    exit;
}

$name    = trim($_POST["name"] ?? "");
$email   = trim($_POST["email"] ?? "");
$subject = trim($_POST["subject"] ?? "");
$message = trim($_POST["message"] ?? "");

if ($name === "" || $email === "" || $subject === "" || $message === "") {
    die("Error: Please fill all fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: Enter a valid email address.");
}

$stmt = $conn->prepare(
    "INSERT INTO contact_messages (name, email, subject, message)
     VALUES (?, ?, ?, ?)"
);

$stmt->bind_param("ssss", $name, $email, $subject, $message);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: message-sent.html");
exit;
