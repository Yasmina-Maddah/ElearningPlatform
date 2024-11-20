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

$query = $connection->prepare("SELECT id, title, content, created_at FROM announcements WHERE course_id = ?");
$query->bind_param("i", $course_id);
$query->execute();
$result = $query->get_result();

$announcements = [];
while ($row = $result->fetch_assoc()) {
    $announcements[] = $row;
}

echo json_encode(["announcements" => $announcements]);
?>