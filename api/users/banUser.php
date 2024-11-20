<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

if ($user->role !== "admin") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden: Only admins can access this API"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['user_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "User ID is required"]);
    exit();
}

$user_id = $data['user_id'];

$query = $connection->prepare("UPDATE users SET is_active = 0 WHERE id = ?");
$query->bind_param("i", $user_id);

if ($query->execute()) {
    echo json_encode(["message" => "User banned successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "An error occurred while banning the user"]);
}
?>