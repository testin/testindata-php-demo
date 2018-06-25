# testindata php demo

**启动 SDK server**

进到 sdk-server 目录下

```bash
wget https://ab.testin.cn/sdk/java/testin-ab-v1.2.1.war
java -jar testin-ab-v1.2.1.war
```

**启动 PHP Server**

进到 php 目录下

`php -S 0.0.0.0:8000`

`index.php` 是访问的入口文件，`init.php` 是初始化脚本，`A.html` `B.html` `C.html` 是三个版本对应的页面代码

## 参考资料

- [SDK Server 帮助文档](http://ab.testin.cn/docs/javaSdk.html)
- [php-curl 文档](http://php.net/manual/en/book.curl.php)

## 更新历史

- 2018.6.20 最基本的 Demo，未做容错处理
- 2018.6.25 使用 OOP 重构，增加超时处理
