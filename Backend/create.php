<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->title) && !empty($data->description) && !empty($data->date) && !empty($data->user_id)) {
    $query = "INSERT INTO events (title, description, date, location, category, price, available_tickets, user_id) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($query);

    // Sanitize input
    $title = htmlspecialchars(strip_tags($data->title));
    $description = htmlspecialchars(strip_tags($data->description));
    $date = htmlspecialchars(strip_tags($data->date));
    $location = htmlspecialchars(strip_tags($data->location));
    $category = htmlspecialchars(strip_tags($data->category));
    $price = floatval($data->price);
    $available_tickets = intval($data->available_tickets);
    $user_id = intval($data->user_id);

    // Bind parameters
    $stmt->bindParam(1, $title);
    $stmt->bindParam(2, $description);
    $stmt->bindParam(3, $date);
    $stmt->bindParam(4, $location);
    $stmt->bindParam(5, $category);
    $stmt->bindParam(6, $price);
    $stmt->bindParam(7, $available_tickets);
    $stmt->bindParam(8, $user_id);

    if($stmt->execute()) {
        http_response_code(201);
        echo json_encode(array(
            "status" => true,
            "message" => "Event created successfully",
            "event_id" => $db->lastInsertId()
        ));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create event"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data"));
}
?>
