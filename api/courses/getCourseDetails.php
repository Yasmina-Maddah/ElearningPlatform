<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

$course_id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$course_id) {
    http_response_code(400);
    echo json_encode(["error" => "Course ID is required"]);
    exit();
}

$query = $connection->prepare("SELECT id, title, description, instructor_id FROM courses WHERE id = ?");
$query->bind_param("i", $course_id);
$query->execute();
$result = $query->get_result();

if ($course = $result->fetch_assoc()) {
    echo json_encode($course);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Course not found"]);
}
?>