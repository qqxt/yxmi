<?php
// 数据库连接配置
define('DB_HOST', 'localhost');
define('DB_USER', '1_cn');
define('DB_PASS', '123456');
define('DB_NAME', '1_cn');

// 创建数据库连接
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// 检查连接
if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}
?>