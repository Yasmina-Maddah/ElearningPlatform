<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

if ($user->role !== "instructor") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden: Only instructors can view submissions"]);
    exit();
}

$assignment_id = isset($_GET['assignment_id']) ? $_GET['assignment_id'] : null;
if (!$assignment_id) {
    http_response_code(400);
    echo json_encode(["error" => "Assignment ID is required"]);
    exit();
}

$query = $connection->prepare("
    SELECT s.id, s.file_url, s.submitted_at, s.grade, s.feedback, u.name AS student_name
    FROM submissions s
    JOIN users u ON s.student_id = u.id
    WHERE s.assignment_id = ?
");
$query->bind_param("i", $assignment_id);
$query->execute();
$result = $query->get_result();

$submissions = [];
while ($row = $result->fetch_assoc()) {
    $submissions[] = $row;
}

echo json_encode(["submissions" => $submissions]);
?>