<?php
function getDomains($conn, $page, $perPage, $isFeatured = false) {
    $offset = ($page - 1) * $perPage;
    $sql = "SELECT * FROM domains ORDER BY is_featured DESC, id ASC LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $offset, $perPage);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
function getTotalDomains($conn) {
    $sql = "SELECT COUNT(*) as total FROM domains";
    $result = $conn->query($sql);

    if ($result === false) {
        error_log("SQL 查询失败: " . $conn->error);
        return 0;
    }

    return $result->fetch_assoc()['total'];
}
function getTotalSoldDomains($conn) {
    $sql = "SELECT COUNT(*) as total FROM domains WHERE is_sold = 1";
    $result = $conn->query($sql);
    return $result ? $result->fetch_assoc()['total'] : 0;
}

function getPendingDomains($conn) {
    $sql = "SELECT COUNT(*) as total FROM domains WHERE is_sold = 0";
    $result = $conn->query($sql);
    return $result ? $result->fetch_assoc()['total'] : 0;
}

function getNewDomainsThisMonth($conn) {
    $sql = "SELECT COUNT(*) as total FROM domains WHERE MONTH(register_date) = MONTH(CURRENT_DATE())";
    $result = $conn->query($sql);
    return $result ? $result->fetch_assoc()['total'] : 0;
}

// 添加域名
function addDomain($conn, $domain_name, $register_date, $expire_date, $registrar, $price, $meaning, $is_sold, $sale_price, $purchase_link) {
    $stmt = $conn->prepare("INSERT INTO domains (domain_name, register_date, expire_date, registrar, price, meaning, is_sold, sale_price, purchase_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdsiss", $domain_name, $register_date, $expire_date, $registrar, $price, $meaning, $is_sold, $sale_price, $purchase_link);
    return $stmt->execute();
}

function addDomainsBatch($conn, $domains) {
    $sql = "INSERT INTO domains (domain_name, register_date, expire_date, registrar, price, meaning, is_sold, sale_price, purchase_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $conn->begin_transaction(); // 开启事务

    try {
        foreach ($domains as $domain) {
            $stmt->bind_param("ssssdsiss", $domain['domain_name'], $domain['register_date'], $domain['expire_date'], $domain['registrar'], $domain['price'], $domain['meaning'], $domain['is_sold'], $domain['sale_price'], $domain['purchase_link']);
            $stmt->execute();
        }
        $conn->commit(); // 提交事务
        return true;
    } catch (Exception $e) {
        $conn->rollback(); // 回滚事务
        error_log("批量插入失败: " . $e->getMessage());
        return false;
    }
}

function getDomainById($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM domains WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
// 编辑域名
function editDomain($conn, $id, $domain_name, $register_date, $expire_date, $registrar, $price, $meaning, $is_sold, $sale_price, $purchase_link) {
    $stmt = $conn->prepare("UPDATE domains SET domain_name = ?, register_date = ?, expire_date = ?, registrar = ?, price = ?, meaning = ?, is_sold = ?, sale_price = ?, purchase_link = ? WHERE id = ?");
    $stmt->bind_param("ssssdsissi", $domain_name, $register_date, $expire_date, $registrar, $price, $meaning, $is_sold, $sale_price, $purchase_link, $id);
    return $stmt->execute();
}
// 删除域名
function deleteDomain($conn, $id) {
    $sql = "DELETE FROM domains WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// 统计域名总数
function countDomains($conn) {
    $sql = "SELECT COUNT(*) as total FROM domains";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// 按服务商分组统计域名数量
function groupByRegistrar($conn) {
    $sql = "SELECT registrar, COUNT(*) as count FROM domains GROUP BY registrar";
    $result = $conn->query($sql);

    if ($result === false) {
        error_log("SQL 查询失败: " . $conn->error);
        return [];
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[$row['registrar']] = $row['count'];
    }
    return $data;
}

// 获取网站设置
function getSettings($conn) {
    $sql = "SELECT * FROM settings LIMIT 1";
    $result = $conn->query($sql);

    if ($result === false) {
        error_log("SQL 查询失败: " . $conn->error);
        return [
            'site_name' => '',
            'phone' => '',
            'email' => '',
            'logo_url' => '',
            'qq_number' => '',
            'wechat' => ''
        ];
    }

    if ($result->num_rows === 0) {
        return [
            'site_name' => '',
            'phone' => '',
            'email' => '',
            'logo_url' => '',
            'qq_number' => '',
            'wechat' => ''
        ];
    }

    return $result->fetch_assoc();
}

function updateSettings($conn, $site_name, $phone, $email, $logo_url, $qq_number, $wechat) {
    $sql = "UPDATE settings SET site_name = ?, phone = ?, email = ?, logo_url = ?, qq_number = ?, wechat = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $site_name, $phone, $email, $logo_url, $qq_number, $wechat);
    return $stmt->execute();
}

// 获取已出售域名数量和总销售金额
function getSoldStats($conn) {
    $sql = "SELECT COUNT(*) as sold_count, SUM(sale_price) as total_sales FROM domains WHERE is_sold = 1";
    $result = $conn->query($sql);

    if ($result === false) {
        error_log("SQL 查询失败: " . $conn->error);
        return ['sold_count' => 0, 'total_sales' => 0];
    }

    return $result->fetch_assoc();
}

function getFriendLinks($conn) {
    $sql = "SELECT * FROM friend_links";
    $result = $conn->query($sql);

    if ($result === false) {
        error_log("SQL 查询失败: " . $conn->error);
        return [];
    }

    $friendLinks = [];
    while ($row = $result->fetch_assoc()) {
        $friendLinks[] = $row;
    }
    return $friendLinks;
}

function addFriendLink($conn, $name, $url) {
    $sql = "INSERT INTO friend_links (name, url) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $url);
    return $stmt->execute();
}

function updateFriendLink($conn, $id, $name, $url) {
    $sql = "UPDATE friend_links SET name = ?, url = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $url, $id);
    return $stmt->execute();
}

function deleteFriendLink($conn, $id) {
    $sql = "DELETE FROM friend_links WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function getFeaturedDomainsCount($conn) {
    $sql = "SELECT COUNT(*) AS count FROM domains WHERE is_featured = 1";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['count'];
}

function setFeatured($conn, $id, $is_featured) {
    $stmt = $conn->prepare("UPDATE domains SET is_featured = ? WHERE id = ?");
    $stmt->bind_param("ii", $is_featured, $id);
    return $stmt->execute();
}
?>