<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['course_id']) || !isset($data['title']) || !isset($data['description'])) {
    http_response_code(400);
    echo json_encode(["error" => "Course ID, title, and description are required"]);
    exit();
}

$course_id = $data['course_id'];
$title = $data['title'];
$description = $data['description'];

if ($user->role === "instructor") {
    $query = $connection->prepare("SELECT id FROM courses WHERE id = ? AND instructor_id = ?");
    $query->bind_param("ii", $course_id, $user->id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows === 0) {
        http_response_code(403);
        echo json_encode(["error" => "You are not authorized to edit this course"]);
        exit();
    }
}

$query = $connection->prepare("UPDATE courses SET title = ?, description = ? WHERE id = ?");
$query->bind_param("ssi", $title, $description, $course_id);

if ($query->execute()) {
    echo json_encode(["message" => "Course updated successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "An error occurred while updating the course"]);
}
?>