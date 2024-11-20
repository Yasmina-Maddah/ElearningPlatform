<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

if ($user->role !== "student") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$assignment_id = $data['assignment_id'];
$file_url = $data['file_url'];

$query = $connection->prepare("INSERT INTO submissions (assignment_id, student_id, file_url) VALUES (?, ?, ?)");
$query->bind_param("iis", $assignment_id, $user->id, $file_url);

if ($query->execute()) {
    echo json_encode(["message" => "Assignment submitted successfully"]);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Unable to submit assignment"]);
}
?>