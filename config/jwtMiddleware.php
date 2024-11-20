<?php
require_once "vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$jwt_secret = "your_secret_key"; 
function validate_jwt($token) {
    global $jwt_secret;
    try {
        return JWT::decode($token, new Key($jwt_secret, 'HS256'));
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized"]);
        exit();
    }
}
?>