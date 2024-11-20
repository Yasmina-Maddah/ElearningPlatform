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

$query = $connection->prepare("SELECT id, name, email, role, is_active FROM users");
$query->execute();
$result = $query->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode(["users" => $users]);
?>