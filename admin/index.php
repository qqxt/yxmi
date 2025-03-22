<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}


$totalDomains = getTotalDomains($conn);
$totalSoldDomains = getTotalSoldDomains($conn);
$pendingDomains = getPendingDomains($conn);
$newDomainsThisMonth = getNewDomainsThisMonth($conn);
$settings = getSettings($conn);
$featuredCount = getFeaturedDomainsCount($conn);


?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>后台首页</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="/../assets/css/bootstrap.min.css">
    <style>
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 60px;
            height: 60px;
            border-radius: 10%;
            margin-right: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        .stats .card {
            flex: 1;
            min-width: 200px;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .stats .card h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .stats .card p {
            margin: 10px 0 0;
            font-size: 24px;
            font-weight: bold;
        }
        .stats .card.total-domains p {
            color: red;
        }
        .stats .card.sold-domains p {
            color: blue;
        }
        .contact-info {
            margin-bottom: 20px;
        }
        .contact-info p {
            margin: 5px 0;
            color: #333;
            font-size: 16px;
        }
        .announcement {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .quick-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .quick-actions .btn {
            flex: 1;
        }
    </style>
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
        <div class="header">
            <img src="<?php echo $settings['logo_url']; ?>" alt="Logo">
            <h1>欢迎使用米表后台管理系统！</h1>
        </div>

        <!-- 统计信息 -->
        <div class="container mt-4">
            <div class="alert alert-info">
                总置顶精品域名数量：<span class="text-danger fw-bold"><?php echo $featuredCount; ?></span>
            </div>
        </div>
        <div class="stats">
            <div class="card total-domains">
                <h3>总域名数量</h3>
                <p><?php echo $totalDomains; ?></p>
            </div>
            <div class="card sold-domains">
                <h3>累计销售域名数量</h3>
                <p><?php echo $totalSoldDomains; ?></p>
            </div>
            <div class="card">
                <h3>待售域名数量</h3>
                <p><?php echo $pendingDomains; ?></p>
            </div>
           
        </div>


        <!-- 快捷操作 -->
        <h3>快捷操作 >>></h3>
        <div class="quick-actions">
        
            <a href="add_domain.php" class="btn btn-primary">添加域名</a>
            <a href="add_domains_batch.php" class="btn btn-success">批量导入域名</a>
        </div>
    </div>

    <script src="/../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>