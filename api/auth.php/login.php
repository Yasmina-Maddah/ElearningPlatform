<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'];
$password = $data['password'];

$query = $conn->prepare("SELECT * FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        $payload = [
            "id" => $user['id'],
            "name" => $user['name'],
            "role" => $user['role'],
            "exp" => time() + 3600
        ];
        $jwt = JWT::encode($payload, $jwt_secret, 'HS256');
        echo json_encode(["token" => $jwt, "user" => $payload]);
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Invalid credentials"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "User not found"]);
}