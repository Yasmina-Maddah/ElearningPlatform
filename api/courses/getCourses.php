<?php
header("Content-Type: application/json");
include "../../config/connection.php";
include "../../config/jwtMiddleware.php";

$headers = getallheaders();
$jwt = str_replace("Bearer ", "", $headers['Authorization']);
$user = validate_jwt($jwt);

$query = $connection->prepare("SELECT * FROM courses");
$query->execute();
$result = $query->get_result();

$courses = [];
while ($course = $result->fetch_assoc()) {
    $courses[] = $course;
}

echo json_encode($courses);
?>