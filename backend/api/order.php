<?php
header('Content-Type: application/json');
require '../db.php';

$action = $_GET['action'] ?? 'create';

if ($action == 'create') {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data['user_id'] ?? 0;
    $goods_info = json_encode($data['goods'] ?? []);
    $total_price = $data['total_price'] ?? 0;
    $order_no = date('YmdHis') . rand(1000, 9999);
    
    $stmt = $pdo->prepare("INSERT INTO orders (order_no, user_id, goods_info, total_price, status) VALUES (?, ?, ?, ?, 0)");
    $stmt->execute([$order_no, $user_id, $goods_info, $total_price]);
    
    echo json_encode(["code" => 200, "msg" => "success"]);
} elseif ($action == 'list') {
    $user_id = $_GET['user_id'] ?? 0;
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
    $stmt->execute([$user_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Parse goods_info JSON string back to array
    foreach ($orders as &$order) {
        $order['goods_info'] = json_decode($order['goods_info'], true);
    }
    
    echo json_encode(["code" => 200, "msg" => "success", "data" => $orders]);
}
?>
