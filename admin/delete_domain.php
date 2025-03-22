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
if (!isset($_GET['id'])) {
    header("Location: domains.php");
    exit();
}

$id = $_GET['id'];

// 删除域名记录
$stmt = $conn->prepare("DELETE FROM domains WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // 删除成功，重定向到域名列表页面
    header("Location: domains.php?success=域名删除成功");
    exit();
} else {
    // 删除失败，重定向到域名列表页面并显示错误信息
    header("Location: domains.php?error=域名删除失败");
    exit();
}
?>