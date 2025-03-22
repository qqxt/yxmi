<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// 获取当前设置
$settings = getSettings($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_name = $_POST['site_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $logo_url = $_POST['logo_url']; // 用户手动输入的 Logo 地址
    $qq_number = $_POST['qq_number'];
    $wechat = $_POST['wechat'];

    // 如果未输入 Logo 地址且输入了 QQ 号码，则使用 QQ 头像
    if (empty($logo_url) && !empty($qq_number)) {
        $logo_url = "https://q1.qlogo.cn/g?b=qq&nk={$qq_number}&s=100"; // QQ 头像地址
    }

    // 更新设置
    $stmt = $conn->prepare("UPDATE settings SET site_name = ?, phone = ?, email = ?, logo_url = ?, qq_number = ?, wechat = ? WHERE id = 1");
    $stmt->bind_param("ssssss", $site_name, $phone, $email, $logo_url, $qq_number, $wechat);

    if ($stmt->execute()) {
        $success = "设置更新成功！";
    } else {
        $error = "设置更新失败！";
    }
}

// 重新获取设置以显示更新后的值
$settings = getSettings($conn);


?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>后台设置</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="/../assets/css/bootstrap.min.css">
</head>
<body>
     <!-- 导航栏 -->
     <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">米表后台</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="domains.php">域名管理</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="stats.php">域名统计</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="friend_links.php">友情链接</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">自定义设置</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="change_password.php">更改密码</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">退出登录</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>后台设置</h1>
        <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>网站名称</label>
                <input type="text" name="site_name" class="form-control" value="<?php echo $settings['site_name']; ?>">
            </div>
            <div class="form-group">
                <label>联系电话</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $settings['phone']; ?>">
                <small class="form-text text-muted">留空前台不展示</small>
            </div>
            <div class="form-group">
                <label>联系邮箱</label>
                <input type="email" name="email" class="form-control" value="<?php echo $settings['email']; ?>">
                <small class="form-text text-muted">留空前台不展示</small>
            </div>
            <div class="form-group">
                <label>Logo 地址</label>
                <input type="text" name="logo_url" class="form-control" value="<?php echo $settings['logo_url']; ?>">
                <small class="form-text text-muted">输入 Logo 的 URL 地址，或留空使用 QQ 头像。 注：.header img {
            border-radius: 10%;  /* logo圆形与正方形控制器 */  10正方形。50圆形
        }</small>
            </div>
            <div class="form-group">
                <label>QQ 号码</label>
                <input type="text" name="qq_number" class="form-control" value="<?php echo $settings['qq_number']; ?>">
                <small class="form-text text-muted">如果未输入 Logo 地址且输入了 QQ 号码，则使用 QQ 头像作为logo </small>
            </div>
            <div class="form-group">
                <label>微信</label>
                <input type="text" name="wechat" class="form-control" value="<?php echo $settings['wechat']; ?>">
                <small class="form-text text-muted">输入微信号或者留空前台不展示</small>
            </div>
            <button type="submit" class="btn btn-primary">保存设置</button>
        </form>
    </div>

    <script src="/../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>