<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: index.php"); exit; }
require '../db.php';

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: user_manage.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM user ORDER BY id DESC");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>用户管理</title></head>
<body>
    <h2>用户管理 <a href="dashboard.php">返回首页</a></h2>
    <table border="1">
        <tr><th>ID</th><th>OpenID</th><th>昵称</th><th>注册时间</th><th>操作</th></tr>
        <?php foreach($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['openid']; ?></td>
            <td><?php echo htmlspecialchars($user['nickname'] ?? '微信用户'); ?></td>
            <td><?php echo $user['create_time']; ?></td>
            <td><a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('确定删除吗？')">删除</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
