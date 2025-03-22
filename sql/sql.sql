# Host: localhost  (Version: 5.7.26)
# Date: 2025-03-23 07:01:49
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "admins"
#

CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "admins"
#

INSERT INTO `admins` VALUES (1,'admin','$2y$10$PoOnVBi0qawi.G5b3AnGx.AUyS5K82CRwTfL5jbwS9Ps0Gr9tIuSO');

#
# Structure for table "domains"
#

CREATE TABLE `domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_name` varchar(255) NOT NULL,
  `register_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `registrar` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `meaning` text,
  `is_sold` tinyint(1) NOT NULL DEFAULT '0',
  `sale_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchase_link` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_registrar` (`registrar`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

#
# Data for table "domains"
#

INSERT INTO `domains` VALUES (2,'MYHome.COM','2001-01-01','2222-11-11','新网',10000.00,'0',1,666.00,'',0),(3,'MY.COM','2021-01-01','2025-03-21','Ag',211.00,'我',0,0.00,NULL,0),(4,'2821.com','2023-07-01','2027-07-01','万网',8888.00,'123123123',0,0.00,'',0),(5,'A.CN','2025-01-01','2040-01-01','Nginx',1234.00,'环境',1,4121.00,NULL,0),(6,'example.com','2023-01-01','2024-01-01','Registrar A',100.00,'Example domain',0,0.00,NULL,0),(7,'example.com','2023-01-01','2024-01-01','Registrar A',100.00,'Example domain',0,0.00,NULL,0),(8,'example.com','2023-01-01','2024-01-01','Registrar A',100.00,'Example domain',0,0.00,NULL,0),(9,'example.com','2023-01-01','2024-01-01','Registrar A',100.00,'Example domain',0,0.00,NULL,0),(19,'example.com','2023-01-01','2024-01-01','Registrar A',100.00,'Example domain',0,0.00,NULL,0),(20,'example2.com','2023-02-01','2024-02-01','Registrar B',200.00,'Another domain',1,150.00,NULL,0),(21,'example.com','2023-01-01','2024-01-01','Registrar A',100.00,'Example domain',0,0.00,NULL,0),(22,'example.com','2023-01-01','2024-01-01','Registrar A',100.00,'Example domain',0,0.00,'http://1.cn/',0),(23,'example.com','2023-01-01','2024-01-01','Registrar A',100.00,'Example domain',0,0.00,NULL,0),(24,'example.com','2023-01-01','2024-01-01','Registrar A',100.00,'Example domain',0,0.00,NULL,0),(25,'example.com','2023-01-01','2024-01-01','Registrar A',100.00,'Example domain',0,0.00,NULL,0),(26,'MI1L.com','2023-01-01','2024-01-01','西部数码',100.00,'Example domain',0,0.00,NULL,0),(27,'1.com','2023-01-01','2024-01-01','西部数码',10022.00,'Example domain',0,0.00,NULL,0),(28,'139MY.COM','2020-01-01','2050-01-01','Dan',991.00,'我的139号码啊',0,0.00,'http://1.cn/',0),(29,'example.com','2023-01-01','2024-01-01','Registrar A',100.00,'Example domain',0,0.00,'http://1.cn/',0),(30,'example.com','2023-01-01','2024-01-01','Registrar A',100.00,'Example domain',0,0.00,'http://1.cn/',0),(31,'example.com','2023-01-01','2024-01-01','Registrar A',100.00,'Example domain',0,0.00,'http://1.cn/',0),(32,'e.com','2023-01-01','2024-01-01','西部数码',100.00,'0',0,0.00,'https://example.com',1),(36,'<script>alert(\'xss\')</script>','2025-11-11','2025-02-02','腾讯云',888.00,'0',0,0.00,'',0);

#
# Structure for table "friend_links"
#

CREATE TABLE `friend_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "friend_links"
#

INSERT INTO `friend_links` VALUES (3,'深蓝丶','https://234.tw'),(4,'小野博客','https://lb5.net');

#
# Structure for table "settings"
#

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) DEFAULT '',
  `phone` varchar(20) DEFAULT '',
  `email` varchar(100) DEFAULT '',
  `logo_url` varchar(255) DEFAULT '',
  `qq_number` varchar(20) DEFAULT '',
  `wechat` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "settings"
#

INSERT INTO `settings` VALUES (1,'游侠米表-v1','','vb77@qq.com','/logo.png','6841847','');
