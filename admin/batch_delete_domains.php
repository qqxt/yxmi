<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

// 检查用户是否登录
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// 检查是否传递了域名 ID
if (!isset($_POST['domain_ids']) || empty($_POST['domain_ids'])) {
    header("Location: domains.php?error=请选择要删除的域名");
    exit();
}

$domainIds = $_POST['domain_ids'];

// 构建 SQL 语句
$placeholders = implode(',', array_fill(0, count($domainIds), '?'));
$sql = "DELETE FROM domains WHERE id IN ($placeholders)";

// 执行删除操作
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('i', count($domainIds)), ...$domainIds);

if ($stmt->execute()) {
    // 删除成功，重定向到域名列表页面
    header("Location: domains.php?success=批量删除域名成功");
    exit();
} else {
    // 删除失败，重定向到域名列表页面并显示错误信息
    header("Location: domains.php?error=批量删除域名失败");
    exit();
}
?>