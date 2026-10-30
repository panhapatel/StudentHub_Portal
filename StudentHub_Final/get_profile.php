<?php
session_start();
header("Content-Type: application/json");

require "db.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    echo json_encode(["message" => "Please login first."]);
    exit;
}

$userId = (int)$_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT enrollment, dob, gender, department, course, semester,
            cgpa, mobile, college_email, personal_email, address
     FROM student_profiles WHERE user_id = ?"
);
$stmt->bind_param("i", $userId);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$row) {
    echo json_encode(new stdClass());
    exit;
}

echo json_encode([
    "name"          => $_SESSION["username"],
    "enrollment"    => $row["enrollment"],
    "dob"           => $row["dob"],
    "gender"        => $row["gender"],
    "department"    => $row["department"],
    "course"        => $row["course"],
    "semester"      => $row["semester"],
    "cgpa"          => $row["cgpa"],
    "mobile"        => $row["mobile"],
    "collegeEmail"  => $row["college_email"],
    "personalEmail" => $row["personal_email"],
    "address"       => $row["address"]
]);
