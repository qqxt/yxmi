<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// 获取当前页码
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10; // 每页显示的域名数量

// 获取域名数据和总数
$domains = getDomains($conn, $page, $perPage);
$totalDomains = getTotalDomains($conn);
$totalPages = ceil($totalDomains / $perPage);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>域名管理</title>
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
        <h1>域名管理</h1>
        <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>
        <form method="POST" action="batch_delete_domains.php" onsubmit="return confirm('确定要删除选中的域名吗？');">
            <a href="add_domain.php" class="btn btn-success mb-3">添加域名</a>
            <a href="add_domains_batch.php" class="btn btn-primary mb-3">批量添加域名</a>
            <button type="submit" class="btn btn-danger mb-3">批量删除域名</button>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>域名名称</th>
                        <th>注册时间</th>
                        <th>到期时间</th>
                        <th>服务商</th>
                        <th>报价</th>
                        <th>域名含义</th>
                        <th>是否已出售</th>
                        <th>出售价格</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($domains as $domain): ?>
                    <tr>
                        <td><input type="checkbox" name="domain_ids[]" value="<?php echo $domain['id']; ?>"></td>
                        <td><?php echo htmlspecialchars($domain['domain_name'], ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($domain['register_date'], ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($domain['expire_date'], ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($domain['registrar'], ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($domain['price'], ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($domain['meaning'], ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo $domain['is_sold'] ? '是' : '否'; ?></td>
<td><?php echo htmlspecialchars($domain['sale_price'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <a href="edit_domain.php?id=<?php echo $domain['id']; ?>" class="btn btn-primary btn-sm">编辑</a>
                            <a href="delete_domain.php?id=<?php echo $domain['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('确定要删除该域名吗？');">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>

        <!-- 分页控件 -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                <li class="page-item">
                <a class="page-link" href="domains.php?page=<?php echo htmlspecialchars($page - 1, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                <a class="page-link" href="domains.php?page=<?php echo htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                <li class="page-item">
                <a class="page-link" href="domains.php?page=<?php echo htmlspecialchars($page + 1, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <script src="/../assets/js/bootstrap.bundle.min.js"></script>
    <script>

        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="domain_ids[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
</body>
</html>