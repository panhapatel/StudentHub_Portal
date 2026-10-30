<?php
session_start();
header("Content-Type: application/json");

require "db.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    echo json_encode(["message" => "Please login first."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["message" => "Invalid request."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$eventId = (int)($data["event_id"] ?? 0);

if ($eventId <= 0) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid event."]);
    exit;
}

$userId = (int)$_SESSION["user_id"];


$stmt = $conn->prepare(
    "SELECT s.student_id
     FROM students s
     JOIN users u ON u.email = s.email
     WHERE u.id = ?"
);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($studentId);

if (!$stmt->fetch()) {
    $stmt->close();
    http_response_code(404);
    echo json_encode(["message" => "Student record not found."]);
    exit;
}
$stmt->close();

try {
    $stmt = $conn->prepare(
        "INSERT INTO registrations (student_id, event_id, registration_date)
         VALUES (?, ?, CURDATE())"
    );
    $stmt->bind_param("ii", $studentId, $eventId);
    $stmt->execute();
    $stmt->close();

    echo json_encode(["message" => "Event registration successful!"]);
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() === 1062) {
        http_response_code(409);
        echo json_encode(["message" => "You are already registered for this event."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Registration failed."]);
    }
}

$conn->close();
