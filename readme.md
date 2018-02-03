# simpleSNS
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)
## 说明
simpleSNS 是一个 SNS 社交网站，你可以通过你的Github帐户登录，在这个社交网站上你可以和不同兴趣的好友分享有趣的东西。

## 环境要求
- PHP >= 7.1
- MySQL >= 5.7
- Node >=8.0

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
## License
The project is open-sourced software licensed under the [MIT license](https://mit-license.org/).