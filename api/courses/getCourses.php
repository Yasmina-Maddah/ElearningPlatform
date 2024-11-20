<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

$query = $connection->prepare("SELECT id, title, description, instructor_id FROM courses");
$query->execute();
$result = $query->get_result();

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

echo json_encode(["courses" => $courses]);
?>