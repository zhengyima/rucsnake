# rucsnake
支持多人对战的AI贪吃蛇大作战平台。

使用C代码编写程序，上传程序至平台，从而控制你的蛇与其他AI蛇进行贪吃蛇大作战。

具体规则请参见`rule.php`



## Environments

PHP5.6

MySQL


## Launch

修改环境中的```php.ini```文件，更改文件上传与POST协议的的相关配置。
```
 max_execution_time = 300
 post_max_size = 128M
 upload_max_filesize = 256M
```


创建项目必需目录，并给予777权限
```
 mkdir map
 chmod -R 777 map
 mkdir upload
 chmod -R 777 upload
```

在MySQL中建库，建表

注：可自定义库名，表名。需相应修改`change.php`与`login.php`中的数据库库名与SQL语句中的表名
```
# 建库
CREATE DATABASE IF NOT EXISTS syzoj DEFAULT CHARSET utf8 COLLATE utf8_general_ci; 
# 进库
use syzoj
# 建表
CREATE TABLE `syzoj`.`student` ( `sno` VARCHAR(64) NOT NULL , `spsw` VARCHAR(128) NOT NULL , PRIMARY KEY (`sno`)) ENGINE = InnoDB;
# 添加用户名和密码都为'2019101404'的测试账号
INSERT INTO `student` (`sno`, `spsw`) VALUES ('2019101404',md5('2019101404'))
```

在`change.php`与`login.php`中更改数据库ip，用户名，密码
```
# 四个参数分别代表：IP, 用户名，密码，数据库名
$mysqli = new mysqli("localhost", "root", "PASSWORD", "syzoj");		
```


启动超时程序自动kill程序
```
# 目前只能杀学号为2012-2019开头的程序，扩展需要更改脚本中的正则表达式
python delet_process.py
```

进入系统，以2019101404为账号与密码登录。



## 效果图

![Alt](http://39.105.149.229/images/show.png)

## 链接
- https://github.com/DaoD/Snake
