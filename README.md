# TestinData PHP Demo

> TestinData SDK Server 和 PHP 集成的示例

## TestinSDK.php

和 SDK Server 的交互逻辑封装在 [TestinSDK.php](./php/classes/TestinSDK.php) 下，使用时需要引入次文件并初始化：

### 引入

```php
include_once("classes/TestinSDK.php");
```

@todo 支持 composer 方式引入

### TestinSDK 初始化

```php
$sdk = new TestinSDK(array(
    "sdk_server" => "http://127.0.0.1:8070",
    "cookie_name" => "my_testin_id"
));
```

| 属性                          | 默认值                   | 备注
| ---------------------------- | ----------------------- | -------
| sdk_server                   | http://127.0.0.1:8070   | 第一步中 SDK Server 的地址
| curl_timeout_ms              | 200                     | curl 超时时间
| curl_connection_timeout_ms   | 200                     | curl connection 超时时间
| cookie_name                  | userid                  | 用来标识用户的 cookie 名称
| cookie_age                   | 86400                   | cookie 过期时间

### setDefaultVars 设置默认变量

```php
$sdk->setDefaultVars(array(
    "version" => "A"
));
```

### getVars 获取实验变量
```php
$variables = $sdk->getVars(array(
    "layerId" => 290504
));
```

### track 打点
```php
$sdk->track("baidusp_convert", 1);
```

# 如何运行 Demo

## 第一步：启动 SDK server

进到 sdk-server 目录下

```bash
./start.sh
```

**配置文件**

| 文件                        | 备注
| -------------------------- | --------------
| application.properties     | SDK Server 的配置文件

**配置项**

| 属性                                  | 备注
| ------------------------------------ | --------
| testin.data.ab.appkey                | appKey，可从应用列表得到
| testin.data.ab.cache.directory       | 本地的缓存目录

## 第二步：启动 PHP Server

进到 php 目录下

```bash
./start.sh
```

| 文件                          | 功能              
| ---------------------------- | ---------------- 
|`classes/TestinSDK.php`       | Testin SDK 类文件     
|`index.php`                   | 访问的 PHP 入口文件     
|`A.html`                      | 原始版本静态页面 
|`B.html`                      | 版本一静态页面
|`C.html`                      | 版本二静态页面

## 第三步：访问页面

```
open http://127.0.0.1:8000
```

## 参考资料

- [SDK Server 帮助文档](http://ab.testin.cn/docs/javaSdk.html)
- [php-curl 文档](http://php.net/manual/en/book.curl.php)

## 更新历史

- 2018.6.20 最基本的 Demo，未做容错处理
- 2018.6.25 使用 OOP 重构，增加超时处理
