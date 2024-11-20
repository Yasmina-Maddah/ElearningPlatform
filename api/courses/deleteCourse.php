<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

if ($user->role !== "admin") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden: Only admins can delete courses"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['course_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Course ID is required"]);
    exit();
}

$course_id = $data['course_id'];

$query = $connection->prepare("DELETE FROM courses WHERE id = ?");
$query->bind_param("i", $course_id);

if ($query->execute()) {
    echo json_encode(["message" => "Course deleted successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "An error occurred while deleting the course"]);
}
?>