
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars(trim($_POST["name"] ?? ""));
    $email = htmlspecialchars(trim($_POST["email"] ?? ""));
    $subject = htmlspecialchars(trim($_POST["subject"] ?? ""));
    $message = htmlspecialchars(trim($_POST["message"] ?? ""));

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

    if ($subject == "") {
        echo "Error: Subject is required.";
        exit;
    }

    if ($message == "") {
        echo "Error: Message is required.";
        exit;
    }

    $data = "Name: $name | Email: $email | Subject: $subject | Message: $message\n";

    $file = "contacts.txt";

    if (file_put_contents($file, $data, FILE_APPEND)) {
        echo "<h2>Message Sent Successfully</h2>";
        echo "Thank you, <b>" . $name . "</b>.";
        echo "<br>Your message has been saved successfully.";
    }
    else {
        echo "<h2>Error</h2>";
        echo "Could not save your message.";
    }
}

?>

