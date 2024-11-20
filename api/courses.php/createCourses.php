<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

if ($user->role !== "instructor") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$title = $data['title'];
$description = $data['description'];

$query = $connection->prepare("INSERT INTO courses (title, description, instructor_id) VALUES (?, ?, ?)");
$query->bind_param("ssi", $title, $description, $user->id);

if ($query->execute()) {
    echo json_encode(["message" => "Course created successfully"]);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Unable to create course"]);
}
?>