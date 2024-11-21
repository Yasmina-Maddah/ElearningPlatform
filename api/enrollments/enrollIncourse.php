<?php
header("Content-Type: application/json");
include "../../config/connection.php"; 
include "../../config/jwtMiddleware.php"; 

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

if ($user->role !== "student") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden: Only students can enroll in courses"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['course_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Course ID is required"]);
    exit();
}

$course_id = $data['course_id'];

$query = $connection->prepare("SELECT id FROM courses WHERE id = ?");
$query->bind_param("i", $course_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["error" => "Course not found"]);
    exit();
}

$query = $connection->prepare("SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?");
$query->bind_param("ii", $user->id, $course_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    http_response_code(409);
    echo json_encode(["error" => "You are already enrolled in this course"]);
    exit();
}

$query = $connection->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)");
$query->bind_param("ii", $user->id, $course_id);

if ($query->execute()) {
    echo json_encode(["message" => "Enrolled successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "An error occurred while enrolling"]);
}
?>