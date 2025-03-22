<?php
// 检查用户是否登录
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// 用户登录
function login($conn, $username, $password) {
    // 从数据库中查询用户
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // 验证用户名和密码
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['user'] = $admin['username']; // 设置会话变量
        return true;
    }
    return false;
}

// 用户退出
function logout() {
    session_destroy();
}
?>