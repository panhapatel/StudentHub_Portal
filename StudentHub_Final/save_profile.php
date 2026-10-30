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

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid profile data."]);
    exit;
}

$name = trim($data["name"] ?? "");
$enrollment = trim($data["enrollment"] ?? "");
$dob = trim($data["dob"] ?? "");
$gender = trim($data["gender"] ?? "");
$department = trim($data["department"] ?? "");
$course = trim($data["course"] ?? "");
$semester = trim($data["semester"] ?? "");
$cgpa = trim((string)($data["cgpa"] ?? ""));
$mobile = trim($data["mobile"] ?? "");
$collegeEmail = trim($data["collegeEmail"] ?? "");
$personalEmail = trim($data["personalEmail"] ?? "");
$address = trim($data["address"] ?? "");

if ($name === "" || $enrollment === "") {
    http_response_code(400);
    echo json_encode(["message" => "Name and enrollment number are required."]);
    exit;
}

if (!in_array($gender, ["Male", "Female", ""], true)) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid gender."]);
    exit;
}

if ($cgpa !== "" && (!is_numeric($cgpa) || $cgpa < 0 || $cgpa > 10)) {
    http_response_code(400);
    echo json_encode(["message" => "CGPA must be between 0 and 10."]);
    exit;
}

if ($dob !== "" && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid date of birth."]);
    exit;
}

$dobValue = $dob === "" ? null : $dob;
$cgpaValue = $cgpa === "" ? null : (float)$cgpa;
$userId = (int)$_SESSION["user_id"];

$sql = "INSERT INTO student_profiles
(user_id, enrollment, dob, gender, department, course, semester,
 cgpa, mobile, college_email, personal_email, address)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE
enrollment = VALUES(enrollment),
dob = VALUES(dob),
gender = VALUES(gender),
department = VALUES(department),
course = VALUES(course),
semester = VALUES(semester),
cgpa = VALUES(cgpa),
mobile = VALUES(mobile),
college_email = VALUES(college_email),
personal_email = VALUES(personal_email),
address = VALUES(address)";

try {
    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "issssssdssss",
        $userId,
        $enrollment,
        $dobValue,
        $gender,
        $department,
        $course,
        $semester,
        $cgpaValue,
        $mobile,
        $collegeEmail,
        $personalEmail,
        $address
    );

    $stmt->execute();
    $stmt->close();
    echo json_encode(["message" => "Profile saved successfully!"]);
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Profile could not be saved."]);
}

$conn->close();
?>
