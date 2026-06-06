<?php
session_start();
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    if ($stmt->fetch()) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "账号或密码错误";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>后台登录</title></head>
<body>
    <h2>商城后台管理系统</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        用户名: <input type="text" name="username"><br>
        密码: <input type="password" name="password"><br>
        <button type="submit">登录</button>
    </form>
</body>
</html>
