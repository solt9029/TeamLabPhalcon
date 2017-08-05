# 手順

dockerteamlabphalcon_app_1の中での設定をする

```
cd /project
curl -sS https://getcomposer.org/installer | php
```

上記のコマンドを行うと、curlが通らず以下のようなエラーが出てしまう

```
curl: (6) Could not resolve host
```

そのため、以下のような手順を踏む必要がある（手順を踏まなくても出来るときもある）

```
apt-get update
apt-get install vim
vi /etc/resolv.conf
/etc/init.d/apache2 restart
```

これで127.0.0.11を8.8.8.8に書き換えてapacheリスタート
その後以下の処理を行う

```
cd /project
curl -sS https://getcomposer.org/installer | php
php composer.phar install
cd /project/vendor/phalcon/devtools
php phalcon.php
```

これでコマンドを確認することができる
例として、ProductControllerを作成するには以下のコマンドを打つ

```
php /project/vendor/phalcon/devtools/phalcon.php controller --name=product --output=app/controllers
```