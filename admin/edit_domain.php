<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("ID 参数未提供");
}
$id = $_GET['id'];

$domain = getDomainById($conn, $id);
if (!$domain) {
    die("未找到对应的域名记录");
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $is_featured = $_POST['is_featured']; // 获取是否置顶
    $domain_name = $_POST['domain_name'];
    $register_date = $_POST['register_date'];
    $expire_date = $_POST['expire_date'];
    $registrar = $_POST['registrar'];
    $price = $_POST['price'];
    $meaning = $_POST['meaning'];
    $is_sold = $_POST['is_sold'];
    $sale_price = $_POST['sale_price'];
    $purchase_link = $_POST['purchase_link'];
    $id = $_GET['id']; 
    error_log("Form submitted - domain: " . $domain_name . ", meaning: " . $meaning);// 获取域名 ID

    // 更新 SQL 语句
    $sql = "UPDATE domains SET is_featured = ?, domain_name = ?, register_date = ?, expire_date = ?, registrar = ?, price = ?, meaning = ?, is_sold = ?, sale_price = ?, purchase_link = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // 绑定参数
    $stmt->bind_param("isssssdissi", $is_featured, $domain_name, $register_date, $expire_date, $registrar, $price, $meaning, $is_sold, $sale_price, $purchase_link, $id);

    if ($stmt->execute()) {
        header("Location: domains.php");
        exit();
    } else {
        $error = "更新域名失败";
    }
}

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>编辑域名</title>
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
    <div class="container">
        <h1>编辑域名</h1>
        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
        <div class="form-group">
    <label>是否置顶</label>
    <select name="is_featured" class="form-control" required>
        <option value="0">否</option>
        <option value="1" <?php echo $domain['is_featured'] ? 'selected' : ''; ?>>是</option>
    </select>
</div>
            <div class="form-group">
                <label>域名名称</label>
                <input type="text" name="domain_name" class="form-control" value="<?php echo $domain['domain_name']; ?>" required>
            </div>
            <div class="form-group">
                <label>注册时间</label>
                <input type="date" name="register_date" class="form-control" value="<?php echo $domain['register_date']; ?>" required>
            </div>
            <div class="form-group">
                <label>到期时间</label>
                <input type="date" name="expire_date" class="form-control" value="<?php echo $domain['expire_date']; ?>" required>
            </div>
            <div class="form-group">
                <label>服务商</label>
                <input type="text" name="registrar" class="form-control" value="<?php echo $domain['registrar']; ?>" required>
            </div>
            <div class="form-group">
                <label>报价</label>
                <input type="number" name="price" class="form-control" value="<?php echo $domain['price']; ?>" step="0.01" required>
            </div>
            <div class="form-group">
                <label>域名含义</label>
                <input type="text" name="meaning" class="form-control" value="<?php echo $domain['meaning']; ?>" required>
            </div>
            <div class="form-group">
                <label>是否已出售</label>
                <select name="is_sold" class="form-control" required>
                    <option value="0" <?php echo $domain['is_sold'] == 0 ? 'selected' : ''; ?>>未出售</option>
                    <option value="1" <?php echo $domain['is_sold'] == 1 ? 'selected' : ''; ?>>已出售</option>
                </select>
            </div>
            <div class="form-group">
                <label>出售价格</label>
                <input type="number" name="sale_price" class="form-control" value="<?php echo $domain['sale_price']; ?>" step="0.01" required>
            </div>
            <div class="form-group">
                <label>购买链接</label>
                <input type="text" name="purchase_link" class="form-control" value="<?php echo $domain['purchase_link']; ?>" placeholder="请输入购买链接（可选）">
            </div>
            <button type="submit" class="btn btn-primary">保存</button>
        </form>
    </div>
</body>
</html>