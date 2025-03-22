<?php
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 8 ; // 每页显示的域名数量
$domains = getDomains($conn, $page, $perPage, true);
$totalDomains = getTotalDomains($conn);
$totalPages = ceil($totalDomains / $perPage);
$settings = getSettings($conn);
$friendLinks = getFriendLinks($conn);


?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title><?php echo $settings['site_name']; ?></title>
    <link rel="stylesheet" href="/../assets/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <style>
        body {
            background: rgba(0, 0, 0, 0) url(bg.png) ;
}
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
            height: 100px;
            border-radius: 10%;  /* QQ头像圆形控制器 */
            margin-right: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .contact-info {
            margin-top: 10px;
        }
        .contact-info p {
            margin: 5px 0;
            color: #333;
            font-size: 16px;
        }
        .domain-list {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }
        .domain-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            width: calc(25% - 15px); /* 每行最多 4 个 */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .domain-card h5 {
            margin: 0;
            font-size: 18px;
        }
        .domain-card p {
            margin: 5px 0;
            color: #666;
            font-weight: bold;
        }
        .domain-card .price {
            color: orange; /* 域名价格用橙色表示 */
        }
        .domain-card .badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        @media (max-width: 1200px) {
            .domain-card {
                width: calc(33.33% - 15px); /* 每行最多 3 个 */
            }
        }
        @media (max-width: 992px) {
            .domain-card {
                width: calc(50% - 15px); /* 每行最多 2 个 */
            }
        }
        @media (max-width: 576px) {
            .domain-card {
                width: 100%; /* 每行最多 1 个 */
            }
        }
        .footer {
            margin-top: 40px;
            padding: 20px 0;
            background-color: #f8f9fa;
            text-align: center;
            background: rgba(0, 0, 0, 0) url('bg.png');
        }
        .friend-links {
            margin-top: 20px;
            text-align: center;
            background: rgba(0, 0, 0, 0) url('bg.png');
        }
        .friend-links a {
            margin: 0 10px;
            color: #333;
            text-decoration: none;
        }
        .friend-links a:hover {
            color: #007bff;
        }
        .friend-links .card {
            display: inline-block;
            margin: 2px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 120px;
        }
        .friend-links .card a {
            color: #333;
            text-decoration: none;
        }
        .friend-links .card a:hover {
            color: #007bff;
        }
       
    .domain-card.sold::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('assets/img/pass.jpg');
        background-repeat: no-repeat;
        background-position: center;
        background-size: 80%;
        opacity: 0.8;
        pointer-events: none;
    }
    .badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 14px;
}

.bg-warning {
    background-color: #ffc107;
    color: #000;
}
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="header">
        <a href="/" style="text-decoration: none; color: inherit;">
    <img src="<?php echo htmlspecialchars($settings['logo_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="Logo">
            <div>
            <a href="/" style="text-decoration: none; color: inherit;">
            <h1><?php echo htmlspecialchars($settings['site_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
                </a>
                <div class="contact-info">
    <?php if (!empty($settings['qq_number'])): ?>
        <p>QQ：<?php echo htmlspecialchars($settings['qq_number'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <?php if (!empty($settings['wechat'])): ?>
        <p>微信：<?php echo htmlspecialchars($settings['wechat'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <?php if (!empty($settings['phone'])): ?>
        <p>手机：<?php echo htmlspecialchars($settings['phone'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <?php if (!empty($settings['email'])): ?>
        <p>邮箱：<?php echo htmlspecialchars($settings['email'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
</div>
            </div>
        </div>
        <div class="domain-list">
    <?php foreach ($domains as $domain): ?>
    <div class="domain-card <?php echo $domain['is_sold'] ? 'sold' : ''; ?>">
    <?php if ($domain['is_featured']): ?>
        <span class="badge bg-warning">精品域名</span>
    <?php endif; ?>
    <h5><?php echo htmlspecialchars($domain['domain_name'], ENT_QUOTES, 'UTF-8'); ?></h5>
<p>注册时间：<?php echo htmlspecialchars($domain['register_date'], ENT_QUOTES, 'UTF-8'); ?></p>
<p>到期时间：<?php echo htmlspecialchars($domain['expire_date'], ENT_QUOTES, 'UTF-8'); ?></p>
<p>平台：<?php echo htmlspecialchars($domain['registrar'], ENT_QUOTES, 'UTF-8'); ?></p>
<p class="price">报价：<?php echo htmlspecialchars($domain['price'], ENT_QUOTES, 'UTF-8'); ?> 元</p>
<p>含义：<?php echo htmlspecialchars($domain['meaning'], ENT_QUOTES, 'UTF-8'); ?></p>
        <?php if (!$domain['is_sold'] && !empty($domain['purchase_link'])): ?>
            <a href="<?php echo htmlspecialchars($domain['purchase_link'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-sm" target="_blank">购买</a>
    <?php endif; ?>
    
    </div>
    <?php endforeach; ?>
</div>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                <li class="page-item">
                <a class="page-link" href="index.php?page=<?php echo htmlspecialchars($page - 1, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                <a class="page-link" href="index.php?page=<?php echo htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                <li class="page-item">
                <a class="page-link" href="index.php?page=<?php echo htmlspecialchars($page + 1, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
<!-- 页脚和友链模块 -->
<div class="footer">
        <div class="friend-links">
            <h4>友情链接</h4>
            <?php foreach ($friendLinks as $link): ?>
            <div class="card">
            <a href="<?php echo htmlspecialchars($link['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank"><?php echo htmlspecialchars($link['name'], ENT_QUOTES, 'UTF-8'); ?></a>
            </div>
            <?php endforeach; ?>
        </div>
        <p>&copy; 2025 <?php echo htmlspecialchars($settings['site_name'], ENT_QUOTES, 'UTF-8'); ?>. 保留所有权利.</p>
    </div>
    <script src="/../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>