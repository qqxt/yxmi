<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php'; 

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}


$friendLinks = getFriendLinks($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = $_POST['name'];
    $url = $_POST['url'];

    if ($action === 'add') {
        addFriendLink($conn, $name, $url);
    } elseif ($action === 'edit') {
        updateFriendLink($conn, $id, $name, $url);
    } elseif ($action === 'delete') {
        deleteFriendLink($conn, $id);
    }

    header("Location: friend_links.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>友情链接管理</title>
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
        <h1>友情链接管理</h1>
        <form method="POST">
            <div class="form-group">
                <label>名称</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>URL</label>
                <input type="url" name="url" class="form-control" required>
            </div>
            <input type="hidden" name="action" value="add">
            <button type="submit" class="btn btn-primary">添加</button>
        </form>

        <h2 class="mt-4">友情链接列表</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>名称</th>
                    <th>URL</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($friendLinks as $link): ?>
                <tr>
                    <td><?php echo $link['name']; ?></td>
                    <td><a href="<?php echo $link['url']; ?>" target="_blank"><?php echo $link['url']; ?></a></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $link['id']; ?>">
                            <input type="hidden" name="name" value="<?php echo $link['name']; ?>">
                            <input type="hidden" name="url" value="<?php echo $link['url']; ?>">
                            <input type="hidden" name="action" value="edit">
                            <button type="submit" class="btn btn-sm btn-warning">编辑</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $link['id']; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-sm btn-danger">删除</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="/../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>