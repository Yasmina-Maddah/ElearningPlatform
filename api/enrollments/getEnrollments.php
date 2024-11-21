<?php
header("Content-Type: application/json");
include "../../config/connection.php"; 
include "../../config/jwtMiddleware.php"; 

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

if ($user->role !== "instructor") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden: Only instructors can view enrollments"]);
    exit();
}

$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
if (!$course_id) {
    http_response_code(400);
    echo json_encode(["error" => "Course ID is required"]);
    exit();
}

$query = $connection->prepare("SELECT id FROM courses WHERE id = ? AND instructor_id = ?");
$query->bind_param("ii", $course_id, $user->id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["error" => "Course not found or you are not the instructor"]);
    exit();
}

$query = $connection->prepare("
    SELECT u.id, u.name, u.email 
    FROM enrollments e 
    JOIN users u ON e.student_id = u.id 
    WHERE e.course_id = ?");
$query->bind_param("i", $course_id);
$query->execute();
$result = $query->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

echo json_encode(["students" => $students]);
?>