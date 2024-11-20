<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

if ($user->role !== "student") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden: Only students can submit assignments"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['assignment_id']) || !isset($data['file_url'])) {
    http_response_code(400);
    echo json_encode(["error" => "Assignment ID and file URL are required"]);
    exit();
}

$assignment_id = $data['assignment_id'];
$file_url = $data['file_url'];

$query = $connection->prepare("SELECT id FROM assignments WHERE id = ?");
$query->bind_param("i", $assignment_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["error" => "Assignment not found"]);
    exit();
}

$query = $connection->prepare("INSERT INTO submissions (assignment_id, student_id, file_url) VALUES (?, ?, ?)");
$query->bind_param("iis", $assignment_id, $user->id, $file_url);

if ($query->execute()) {
    echo json_encode(["message" => "Assignment submitted successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "An error occurred while submitting the assignment"]);
}
?>