<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['comment_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Comment ID is required"]);
    exit();
}

$comment_id = $data['comment_id'];

$query = $connection->prepare("SELECT user_id, course_id FROM comments WHERE id = ?");
$query->bind_param("i", $comment_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["error" => "Comment not found"]);
    exit();
}

$comment = $result->fetch_assoc();

if ($comment['user_id'] !== $user->id) {
    $query = $connection->prepare("SELECT id FROM courses WHERE id = ? AND instructor_id = ?");
    $query->bind_param("ii", $comment['course_id'], $user->id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows === 0) {
        http_response_code(403);
        echo json_encode(["error" => "You are not authorized to delete this comment"]);
        exit();
    }
}

$query = $connection->prepare("DELETE FROM comments WHERE id = ?");
$query->bind_param("i", $comment_id);

if ($query->execute()) {
    echo json_encode(["message" => "Comment deleted successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "An error occurred while deleting the comment"]);
}
?>