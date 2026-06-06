<?php
$host = '127.0.0.1';
$dbname = 'wx_prograss';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["code" => 500, "msg" => "数据库连接失败: " . $e->getMessage()]));
}
?>
