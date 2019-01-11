# OnePHP-Framework

## 简述
**OnePHP**是一款简单的PHP MVC框架。

[开发记录]

### 要求

* PHP 5.4.0+

- 目录准备(2018/06/08)
```
project              根目录
|--app               应用目录
|  |--controllers    控制器目录
|  |--models         模块目录
|  |--views          视图目录
|--config            配置文件目录
|--onephp            框架核心目录
|  |--base           MVC基类目录
|  |--db             数据库操作类目录
|  |--Onephp.php     内核文件
|--runtime           运行目录
|  |--caches         缓存文目录
|  |--logs           日志目录
|  |--sessions       缓存目录
|--static            静态文件目录
|--index.php         入口文件

```

## 使用

### 1.克隆代码

```
git clone https://github.com/SenCaoKing/OnePHP-Framework
```

### 2.创建数据库 

创建名为 todo 的数据库，并插入两条记录，命令：

```
CREATE DATABASE IF NOT EXISTS `todo`;
    USE `todo`;
    
    DROP TABLE IF EXISTS `item`;
    CREATE TABLE `item`  (
      `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      `item_name` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE = MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;
    
    INSERT INTO `item` VALUES (1, 'Hello World.');
    INSERT INTO `item` VALUES (2, 'Lets go!');
```


### 3.修改配置文件

打开配置文件 config/config.php ，使之与自己的数据库匹配

```
$config['db']['host'] = 'localhost';
$config['db']['username'] = 'root';
$config['db']['password'] = 'root';
$config['db']['dbname'] = 'todo';
```

### 4.配置Nginx或Apache
在Apache或Nginx中创建一个站点，把 project 设置为站点根目录（入口文件 index.php 所在的目录）。

然后设置单一入口，Apache服务器配置：
```
<IfModule mod_rewrite.c>
    # 打开Rewrite功能
    RewriteEngine On

    # 如果请求的是真实存在的文件或目录，直接访问
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d

    # 如果访问的文件或目录不是真实存在，分发请求至 index.php
    RewriteRule . index.php
</IfModule>
```

Nginx服务器配置:
```
location / {
    # 重新向所有非真实存在的请求到index.php
    try_files $uri $uri/ /index.php$args;
}
```
    
### 5.测试访问

然后访问站点域名：http://localhost/ 就可以了。