# 说明书
### **一、系统简介**
米表后台管理系统是一个用于管理域名信息的工具，支持域名添加、编辑、删除、置顶、统计等功能。用户可以通过后台管理系统高效管理域名数据。

---

### **二、系统功能**

1. **域名管理**
   • 添加域名：支持单个域名添加和批量导入。
   • 编辑域名：修改域名信息，如注册时间、到期时间、报价等。
   • 删除域名：移除不需要的域名记录。
   • 置顶域名：将重要域名置顶显示。

2. **域名统计**
   • 查看域名总数、已售域名数量、置顶域名数量等。

3. **友情链接管理**
   • 添加、编辑、删除友情链接。

4. **系统设置**
   • 自定义网站 Logo、联系方式等信息。
   • 修改管理员密码。

---

### **程序安装教程**
#### ​一、准备工作
​服务器环境：
 - PHP 8.0 或更高版本。
 - MySQL 5.6 或更高版本。
 - Web 服务器（如 Apache、Nginx）。

​下载程序：

 - 从您的代码仓库或网站下载程序压缩包。

​解压程序：

 - 将压缩包解压到 Web 服务器的根目录或子目录中。

以下是一个简单的 ​安装教程，帮助用户快速部署和配置您的程序。
----------


### **二、配置数据库**
​1.修改配置文件：
 - 打开 config.php 文件，修改数据库连接信息：
```php
// 数据库连接配置
define('DB_HOST', 'localhost'); // 数据库主机
define('DB_USER', 'root');      // 数据库用户名
define('DB_PASS', 'password'); // 数据库密码
define('DB_NAME', 'myapp');    // 数据库名称
```
​2.创建数据库(已经创建了的可以忽略这步，直接看3)：
 - 登录 MySQL，创建一个新的数据库：
```sql
CREATE DATABASE myapp;
```
3.​导入 SQL 文件：
使用 phpMyAdmin 或其他 MySQL 工具，导入 sql 文件夹中的 sql.sql 文件。
导入步骤：
 - 登录 phpMyAdmin。
 - 选择刚创建的数据库（如 myapp）。
 - 点击 ​导入，选择 sql.sql 文件，然后点击 ​执行。


----------
### **三、访问网站**
​访问前台：
打开浏览器，输入您的域名（如 http://example.com）即可访问网站。
​访问后台：

后台地址：http://example.com/admin/login.php。
默认账号：[colour type=" red"]admin[/colour]
默认密码：[colour type=" red"]admin123[/colour]


----------
### **四、常见问题**

#### **1. 登录失败**
• 检查用户名和密码是否正确。
• 如果忘记密码，安装下面教程重置密码。

用 password_hash() 加密密码

新建一个php页面。将下面代码复制粘贴，然后进行访问该页面。

```php
<?php
$password = password_hash('admin123', PASSWORD_DEFAULT);
echo $password; // 将输出加密后的密码
?>
```

将生成的加密密码插入到数据库中：

```sql
INSERT INTO admins (username, password) VALUES ('admin', '粘贴刚刚生成的加密密码');
```
#### **功能展示**

[photos]
![1.png][1]
![07.png][2]
![8.png][3]
![17.png][4]
![245.png][5]
![331.png][6]
![3236.png][7]
![071750.png][8]
[/photos]


**注意：安装此程序的时候，如果使用的是二级目录，请自行修改css,js路径。避免网站样式丢失**
#### **下载地址**
<script src='https://gitee.com/c8/ranger-meter-program/widget_preview' async defer></script>
<div id="osc-gitee-widget-tag"></div>
<style>
.osc_pro_color {color: #393222 !important;}
.osc_panel_color {background-color: #ebdfc1 !important;}
.osc_background_color {background-color: #fffae5 !important;}
.osc_border_color {border-color: #d8ca9f !important;}
.osc_desc_color {color: #393222 !important;}
.osc_link_color * {color: #a28b40 !important;}
</style>

  [1]: https://234.tw/usr/uploads/2025/03/508423380.png
  [2]: https://234.tw/usr/uploads/2025/03/4193776370.png
  [3]: https://234.tw/usr/uploads/2025/03/2597257318.png
  [4]: https://234.tw/usr/uploads/2025/03/479530146.png
  [5]: https://234.tw/usr/uploads/2025/03/149531226.png
  [6]: https://234.tw/usr/uploads/2025/03/3872396704.png
  [7]: https://234.tw/usr/uploads/2025/03/3672180231.png
  [8]: https://234.tw/usr/uploads/2025/03/987308138.png
