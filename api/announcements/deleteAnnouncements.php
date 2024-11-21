<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['announcement_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Announcement ID is required"]);
    exit();
}

$announcement_id = $data['announcement_id'];

$query = $connection->prepare("SELECT a.course_id FROM announcements a JOIN courses c ON a.course_id = c.id WHERE a.id = ? AND (c.instructor_id = ? OR ? = 'admin')");
$query->bind_param("iis", $announcement_id, $user->id, $user->role);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    http_response_code(403);
    echo json_encode(["error" => "You are not authorized to delete this announcement or it does not exist"]);
    exit();
}

$query = $connection->prepare("DELETE FROM announcements WHERE id = ?");
$query->bind_param("i", $announcement_id);

if ($query->execute()) {
    echo json_encode(["message" => "Announcement deleted successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "An error occurred while deleting the announcement"]);
}
?>