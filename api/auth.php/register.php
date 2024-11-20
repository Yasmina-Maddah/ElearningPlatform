<?php
header("Content-Type: application/json");
include "../../config/connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_BCRYPT);
$role = $data['role'];

$query = $connection->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
$query->bind_param("ssss", $name, $email, $password, $role);

if ($query->execute()) {
    echo json_encode(["message" => "User registered successfully"]);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Unable to register user"]);
}
?>
