<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
if (!$course_id) {
    http_response_code(400);
    echo json_encode(["error" => "Course ID is required"]);
    exit();
}

$query = $connection->prepare("SELECT id FROM courses WHERE id = ?");
$query->bind_param("i", $course_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["error" => "Course not found"]);
    exit();
}

$query = $connection->prepare("
    SELECT c.id, c.content, c.is_private, c.created_at, u.name AS user_name
    FROM comments c
    JOIN users u ON c.user_id = u.id
    WHERE c.course_id = ? AND (c.is_private = 0 OR c.user_id = ?)
");
$query->bind_param("ii", $course_id, $user->id);
$query->execute();
$result = $query->get_result();

$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

echo json_encode(["comments" => $comments]);
?>