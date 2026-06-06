<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: index.php"); exit; }
require '../db.php';

if (isset($_GET['ship'])) {
    $stmt = $pdo->prepare("UPDATE orders SET status = 2 WHERE id = ?");
    $stmt->execute([$_GET['ship']]);
    header("Location: order_manage.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM orders ORDER BY id DESC");
$orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>订单管理</title></head>
<body>
    <h2>订单管理 <a href="dashboard.php">返回首页</a></h2>
    <table border="1">
        <tr><th>订单号</th><th>用户ID</th><th>总价</th><th>状态</th><th>操作</th></tr>
        <?php foreach($orders as $order): ?>
        <tr>
            <td><?php echo $order['order_no']; ?></td>
            <td><?php echo $order['user_id']; ?></td>
            <td><?php echo $order['total_price']; ?></td>
            <td>
                <?php 
                $statuses = ['待付款', '待发货', '已发货', '已完成'];
                echo $statuses[$order['status']];
                ?>
            </td>
            <td>
                <?php if($order['status'] == 1 || $order['status'] == 0): ?>
                    <a href="?ship=<?php echo $order['id']; ?>">发货</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
