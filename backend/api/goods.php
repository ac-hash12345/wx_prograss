<?php
header('Content-Type: application/json');
require '../db.php';

$action = $_GET['action'] ?? 'list';

if ($action == 'list') {
    $stmt = $pdo->query("SELECT * FROM goods ORDER BY id DESC");
    $goods = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["code" => 200, "msg" => "success", "data" => $goods]);
} elseif ($action == 'detail') {
    $id = $_GET['id'] ?? 0;
    $stmt = $pdo->prepare("SELECT * FROM goods WHERE id = ?");
    $stmt->execute([$id]);
    $goods = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(["code" => 200, "msg" => "success", "data" => $goods]);
}
?>
