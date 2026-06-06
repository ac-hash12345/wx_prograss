<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: index.php"); exit; }
require '../db.php';

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM goods WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: goods_manage.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $cover = $_POST['cover'];
    $detail = $_POST['detail'];
    $stock = $_POST['stock'];
    
    $stmt = $pdo->prepare("INSERT INTO goods (name, price, cover, detail, stock) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $price, $cover, $detail, $stock]);
    header("Location: goods_manage.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM goods");
$goodsList = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>商品管理</title></head>
<body>
    <h2>商品管理 <a href="dashboard.php">返回首页</a></h2>
    
    <h3>添加商品</h3>
    <form method="post">
        名称: <input type="text" name="name" required><br>
        价格: <input type="number" step="0.01" name="price" required><br>
        封面URL: <input type="text" name="cover" required><br>
        详情: <textarea name="detail"></textarea><br>
        库存: <input type="number" name="stock" required><br>
        <button type="submit">添加</button>
    </form>
    
    <h3>商品列表</h3>
    <table border="1">
        <tr><th>ID</th><th>名称</th><th>价格</th><th>库存</th><th>操作</th></tr>
        <?php foreach($goodsList as $goods): ?>
        <tr>
            <td><?php echo $goods['id']; ?></td>
            <td><?php echo htmlspecialchars($goods['name']); ?></td>
            <td><?php echo $goods['price']; ?></td>
            <td><?php echo $goods['stock']; ?></td>
            <td><a href="?delete=<?php echo $goods['id']; ?>" onclick="return confirm('确定删除吗？')">删除</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
