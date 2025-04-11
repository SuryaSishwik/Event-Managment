<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

try {
    $stats = array();
    
    // Total events
    $events_query = "SELECT COUNT(*) as total_events FROM events";
    $events_stmt = $db->prepare($events_query);
    $events_stmt->execute();
    $stats['total_events'] = $events_stmt->fetch(PDO::FETCH_ASSOC)['total_events'];
    
    // Total tickets sold
    $tickets_query = "SELECT SUM(quantity) as total_tickets FROM tickets";
    $tickets_stmt = $db->prepare($tickets_query);
    $tickets_stmt->execute();
    $stats['total_tickets_sold'] = $tickets_stmt->fetch(PDO::FETCH_ASSOC)['total_tickets'];
    
    // Total revenue
    $revenue_query = "SELECT SUM(total_price) as total_revenue FROM tickets";
    $revenue_stmt = $db->prepare($revenue_query);
    $revenue_stmt->execute();
    $stats['total_revenue'] = $revenue_stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'];
    
    // Events by category
    $category_query = "SELECT category, COUNT(*) as count FROM events GROUP BY category";
    $category_stmt = $db->prepare($category_query);
    $category_stmt->execute();
    $stats['events_by_category'] = $category_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Recent ticket sales
    $recent_sales_query = "SELECT t.*, e.title as event_name, u.name as buyer_name 
                          FROM tickets t 
                          JOIN events e ON t.event_id = e.id 
                          JOIN users u ON t.user_id = u.id 
                          ORDER BY t.purchase_date DESC 
                          LIMIT 10";
    $recent_sales_stmt = $db->prepare($recent_sales_query);
    $recent_sales_stmt->execute();
    $stats['recent_sales'] = $recent_sales_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    http_response_code(200);
    echo json_encode($stats);
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Error fetching analytics: " . $e->getMessage()));
}
?>
