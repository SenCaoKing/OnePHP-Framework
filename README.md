# OnePHP-Framework
A Framework of PHP

[开发记录]

### 要求

* PHP 5.4.0+

- 目录准备(2018/06/08)
```
project              WEB部署根目录
|--application       应用目录
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
Apache：
```
<IfModule mod_rewrite.c>
    RewriteEngine On

    # 如果访问的文件存在，则直接访问，不重定向
    RewriteCond %{REQUEST_FILENAME} !-f
    # 如果访问的目录存在，则直接访问，不重4 定向
    RewriteCond %{REQUEST_FILENAME} !-d

    # 如果访问的文件或目录不存在，则重定向所有请求
    # 到：index.php?url=<PARAMS>。
    # 例如：当我们请求<域名>item/index时，实际上是
    # 请求<域名>index.php?url=item/index，在PHP中
    # 用 GET['url'] 就能拿到字符串item/index
    RewriteRule ^(.*)$ index.php?url=$1 [PT,L]
</IfModule>
```

Nginx:
```
location / {
    # 重新向所有非真实存在的请求到index.php
    try_files $uri $uri/ /index.php$args;
}
```
    
### 5.测试访问

打开 index.php 文件，修改

```
define('APP_URL', 'http://localhost/project');
```

为自己代码的具体位置，默认是localhost的project目录下。

然后就可以访问 http://localhost/project/