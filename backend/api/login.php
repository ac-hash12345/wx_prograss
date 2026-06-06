<?php
header('Content-Type: application/json');
require '../db.php';

$data = json_decode(file_get_contents('php://input'), true);
$openid = $data['openid'] ?? '';
$nickname = $data['nickname'] ?? '微信用户';
$avatar = $data['avatar'] ?? '';

if (!$openid) {
    echo json_encode(["code" => 400, "msg" => "openid不能为空"]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM user WHERE openid = ?");
$stmt->execute([$openid]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $stmt = $pdo->prepare("INSERT INTO user (openid, nickname, avatar) VALUES (?, ?, ?)");
    $stmt->execute([$openid, $nickname, $avatar]);
    $userId = $pdo->lastInsertId();
    $user = ["id" => $userId, "openid" => $openid, "nickname" => $nickname, "avatar" => $avatar];
}

echo json_encode(["code" => 200, "msg" => "success", "data" => $user]);
?>
