# TestinData php demo

> Testin SDK Server 和 PHP 集成的示例

**第一步：启动 SDK server**

进到 sdk-server 目录下

```bash
wget https://ab.testin.cn/sdk/java/testin-ab-v1.2.1.war
java -jar testin-ab-v1.2.1.war
```

| 文件                        | 备注
| -------------------------- | --------------
| application.properties     | 配置文件

**配置项**

| 属性                                  | 备注
| ------------------------------------ | --------
| testin.data.ab.appkey                | appKey
| testin.data.ab.cache.directory       | 缓存目录

**第二步：启动 PHP Server**

进到 php 目录下

`php -S 0.0.0.0:8000`

| 文件                          | 功能              
| ---------------------------- | ---------------- 
|`classes/TestinSDK.php`       | Testin SDK 类文件     
|`index.php`                   | 是访问的入口文件     
|`A.html`                      | 原始版本 
|`B.html`                      | 版本一 
|`C.html`                      | 版本二

**配置项**

| 属性                          | 默认值                   | 备注
| ---------------------------- | ----------------------- | -------
| sdk_server                   | http://127.0.0.1:8070   | 第一步中 SDK Server 的地址
| curl_timeout_ms              | 200                     | curl 超时时间
| curl_connection_timeout_ms   | 200                     | curl connection 超时时间
| cookie_name                  | userid                  | 用来标识用户的 cookie 名称
| cookie_age                   | 86400                   | cookie 过期时间

## 参考资料

- [SDK Server 帮助文档](http://ab.testin.cn/docs/javaSdk.html)
- [php-curl 文档](http://php.net/manual/en/book.curl.php)

## 更新历史

- 2018.6.20 最基本的 Demo，未做容错处理
- 2018.6.25 使用 OOP 重构，增加超时处理
