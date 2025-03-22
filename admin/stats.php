<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$domainsByRegistrar = groupByRegistrar($conn);
$soldStats = getSoldStats($conn);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>域名统计</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="/../assets/css/bootstrap.min.css">
    <script src="/../assets/js/chart.js"></script>
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
                        <a class="nav-link" href="stats.php">域名平台统计</a>
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
        <h1>域名平台统计</h1>

        <!-- 已出售域名统计 -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">已出售域名</h5>
                <p class="card-text">
                    已出售域名数量: <strong><?php echo $soldStats['sold_count']; ?></strong><br>
                    总销售金额: <strong><?php echo number_format($soldStats['total_sales'], 2); ?> 元</strong>
                </p>
            </div>
        </div>

        <!-- 按pt统计 -->
        <div class="row">
            <div class="col-md-6">
                <canvas id="registrarChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const registrars = <?php echo json_encode(array_keys($domainsByRegistrar)); ?>;
        const counts = <?php echo json_encode(array_values($domainsByRegistrar)); ?>;

        // 创建图表  // 创建图表  type: 'bra' 树状统计
        const ctx = document.getElementById('registrarChart').getContext('2d');
        const registrarChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: registrars,
                datasets: [{
                    label: '域名数量',
                    data: counts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script src="/../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>