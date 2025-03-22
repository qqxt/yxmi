<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ .  '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (login($conn, $username, $password)) {
        header("Location: index.php");
        exit();
    } else {
        $error = "用户名或密码错误！";
    }
}

if (isset($_GET['success'])) {
    $success = $_GET['success'];
}


?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>后台登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <link href="/../assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- 自定义样式 -->
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: #333;
        }
        .form-control {
            margin-bottom: 1rem;
        }
        .btn-primary {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
        }
        .alert {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>后台登录</h1>
        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username" class="form-label">用户名</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="请输入用户名" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">密码</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="请输入密码" required>
            </div>
            <button type="submit" class="btn btn-primary">登录</button>
        </form>
    </div>
    <script src="/../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>