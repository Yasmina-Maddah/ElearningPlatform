<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['course_id']) || !isset($data['content']) || !isset($data['is_private'])) {
    http_response_code(400);
    echo json_encode(["error" => "Course ID, content, and privacy status are required"]);
    exit();
}

$course_id = $data['course_id'];
$content = $data['content'];
$is_private = $data['is_private'];

$query = $connection->prepare("SELECT id FROM courses WHERE id = ?");
$query->bind_param("i", $course_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["error" => "Course not found"]);
    exit();
}

$query = $connection->prepare("INSERT INTO comments (course_id, user_id, is_private, content) VALUES (?, ?, ?, ?)");
$query->bind_param("iiis", $course_id, $user->id, $is_private, $content);

if ($query->execute()) {
    echo json_encode(["message" => "Comment posted successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "An error occurred while posting the comment"]);
}
?>