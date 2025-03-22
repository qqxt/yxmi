<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $domains = [];
    $data = $_POST['domains'];

    // 解析批量输入的数据
    $lines = explode("\n", $data);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;

        // 假设每行数据格式为：域名,注册时间,到期时间,服务商,报价,含义,是否已出售,销售价格
        $fields = explode(",", $line);
        if (count($fields) === 9) {
            $domains[] = [
                'domain_name' => trim($fields[0]),
                'register_date' => trim($fields[1]),
                'expire_date' => trim($fields[2]),
                'registrar' => trim($fields[3]),
                'price' => trim($fields[4]),
                'meaning' => trim($fields[5]),
                'is_sold' => trim($fields[6]),
                'sale_price' => trim($fields[7]),
                'purchase_link' => trim($fields[8])
            ];
        }
    }

    if (addDomainsBatch($conn, $domains)) {
        header("Location: domains.php");
        exit();
    } else {
        $error = "批量添加域名失败";
    }
}

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>批量添加域名</title>
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
        <h1>批量添加域名</h1>
        <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>域名数据</label>
                <textarea name="domains" class="form-control" rows="10" required></textarea>
                <small class="form-text text-muted">
                每行一条域名记录，格式：域名,注册时间,到期时间,服务商,报价,域名含义,是否已出售,出售价格,购买链接<br>
                    示例：example.com,2023-01-01,2024-01-01,西部数码,100.00,Example domain,0,0,https://example.com(购买链接)
                </small>
            </div>
            <button type="submit" class="btn btn-primary">批量添加</button>
            <a href="domains.php" class="btn btn-secondary">返回列表</a>
        </form>
        <div class="mt-4">
            <h4>字段解释</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>字段位置</th>
                        <th>字段名称</th>
                        <th>示例值</th>
                        <th>说明</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>域名名称</td>
                        <td>example.com</td>
                        <td>域名的完整名称，例如 `example.com`。</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>注册时间</td>
                        <td>2023-01-01</td>
                        <td>域名的注册日期，格式为 `YYYY-MM-DD`。</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>到期时间</td>
                        <td>2024-01-01</td>
                        <td>域名的到期日期，格式为 `YYYY-MM-DD`。</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>域名平台</td>
                        <td>万网</td>
                        <td>域名注册的服务商名称。</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>报价</td>
                        <td>100.00</td>
                        <td>域名的报价</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>域名含义</td>
                        <td>Example domain</td>
                        <td>域名的含义或描述，可以是简短说明。</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>是否已出售</td>
                        <td>0</td>
                        <td>`0` 表示未出售，`1` 表示已出售。</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>出售价格</td>
                        <td>0</td>
                        <td>如果域名已出售，填写销售价格；如果未出售，可以填写 `0` 或留空。</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>购买链接</td>
                        <td>https://example.com</td>
                        <td>如果域名已上架平台，直接填写购买地址或留空。    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>