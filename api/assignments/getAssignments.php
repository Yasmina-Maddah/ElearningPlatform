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

$query = $connection->prepare("SELECT id, title, description, due_date FROM assignments WHERE course_id = ?");
$query->bind_param("i", $course_id);
$query->execute();
$result = $query->get_result();

$assignments = [];
while ($row = $result->fetch_assoc()) {
    $assignments[] = $row;
}

echo json_encode(["assignments" => $assignments]);
?>