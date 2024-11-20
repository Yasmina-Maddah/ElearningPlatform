<?php
header("Content-Type: application/json");
include "../../config/connection.php"; 
include "../../config/jwtMiddleware.php"; 

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt); 

if ($user->role !== "instructor") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden: Only instructors can post announcements"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['course_id']) || !isset($data['title']) || !isset($data['content'])) {
    http_response_code(400);
    echo json_encode(["error" => "Course ID, title, and content are required"]);
    exit();
}

$course_id = $data['course_id'];
$title = $data['title'];
$content = $data['content'];

$query = $connection->prepare("SELECT id FROM courses WHERE id = ? AND instructor_id = ?");
$query->bind_param("ii", $course_id, $user->id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["error" => "Course not found or you are not the instructor"]);
    exit();
}

$query = $connection->prepare("INSERT INTO announcements (course_id, title, content) VALUES (?, ?, ?)");
$query->bind_param("iss", $course_id, $title, $content);

if ($query->execute()) {
    echo json_encode(["message" => "Announcement posted successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "An error occurred while posting the announcement"]);
}
?>