# simpleSNS
[![Build Status](https://www.travis-ci.org/wqer1019/simpleSNS.svg?branch=master)](https://www.travis-ci.org/wqer1019/simpleSNS)
[![continuousphp](https://img.shields.io/badge/mysql-%3E%3D5.7-8B0A50.svg)](https://github.com/wqer1019/simpleSNS)
[![continuousphp](https://img.shields.io/badge/php-%3E%3D7.1-blue.svg)](https://github.com/wqer1019/simpleSNS)
[![continuousphp](https://img.shields.io/badge/node-%3E%3D8.0-ff69b4.svg)](https://github.com/wqer1019/simpleSNS)
[![CocoaPods](https://img.shields.io/cocoapods/dm/AFNetworking.svg)](https://github.com/wqer1019/simpleSNS)
[![Mozilla Add-on](https://img.shields.io/amo/stars/dustman.svg)](https://github.com/wqer1019/simpleSNS)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)
## 说明
simpleSNS 是一个 SNS 社交网站，你可以通过你的Github帐户登录，在这个社交网站上你可以和不同兴趣的好友分享有趣的东西。

## 环境要求
- PHP >= 7.1
- MySQL >= 5.7
- Node >=8.0
- Redis
- Supervisor

## 开始安装
```shell
git clone https://github.com/wqer1019/simpleSNS.git
```
Composer
```shell
cd simpleSNS
composer install
```
安装前端依赖
```npm
npm install
```
编译前端资源
```npm
npm run production
```
## 相关配置
通用
```php
cp .env.example .env
```
Pusher 通知 [Pusher](https://pusher.com)
```php
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=ap1
```
短信通知 [阿里大鱼](https://dayu.aliyun.com/product/sms)
```php
# 阿里短信接口
ALI_ACCESS_KEY_ID=
ALI_ACCESS_KEY_SECRET=
```
GitHub [github oauth2](https://github.com/settings/applications/new) 
```php
GITHUB_CLIENT_ID=
GITHUB_CLIENT_SECRET=
GITHUB_REDIRECT=http://sns.local/oauth/github/callback
```
JSON Web Token
```php
JWT_SECRET=
JWT_TTL=3600
JWT_REFRESH_TTL=21600
JWT_BLACKLIST_GRACE_PERIOD=30
```
## 队列服务

添加队列任务
```shell
ln -s /home/vagrant/code/simpleSNS/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf
```
启动队列任务
 ```shell
$ sudo supervisorctl reread
$ sudo supervisorctl update
$ sudo supervisorctl start laravel-worker:*
```
重启队列
```shell
sudo supervisorctl restart all
```
> 任何与**队列**代码相关的修改都需要重启队列服务！

## 开始使用
生成密钥
```php
php artisan key:generate
php artisan jwt:secret
```
创建数据库并填充测试数据
```php
php artisan migrate --seed
```
创建软链接
```php
php artisan storage:link
```

# 日志

系统日志：
```$xslt
/home/vagrant/code/simpleSNS/storage/logs/laravel*.log
```
队列日志：
```$xslt
/home/vagrant/code/simpleSNS/storage/logs/worker.log
```

## License
The project is open-sourced software licensed under the [MIT license](https://mit-license.org/).