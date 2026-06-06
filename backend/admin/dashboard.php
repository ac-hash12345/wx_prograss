<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>管理后台</title></head>
<body>
    <h2>欢迎使用商城后台, <?php echo $_SESSION['admin']; ?>!</h2>
    <ul>
        <li><a href="goods_manage.php">商品管理</a></li>
        <li><a href="order_manage.php">订单管理</a></li>
        <li><a href="user_manage.php">用户管理</a></li>
        <li><a href="logout.php">退出登录</a></li>
    </ul>
</body>
</html>
