<?php
header("Content-Type: application/json");
require_once "../../config/connection.php";
require_once "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

if ($user->role !== "instructor") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden: Only instructors can grade submissions"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['submission_id']) || !isset($data['grade']) || !isset($data['feedback'])) {
    http_response_code(400);
    echo json_encode(["error" => "Submission ID, grade, and feedback are required"]);
    exit();
}

$submission_id = $data['submission_id'];
$grade = $data['grade'];
$feedback = $data['feedback'];

$query = $connection->prepare("UPDATE submissions SET grade = ?, feedback = ? WHERE id = ?");
$query->bind_param("dsi", $grade, $feedback, $submission_id);

if ($query->execute()) {
    echo json_encode(["message" => "Submission graded successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "An error occurred while grading the submission"]);
}
?>