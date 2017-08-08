# 環境構築

## バージョン

- docker-compose: 1.11.1

- docker: 1.13.1

## 手順

まずはvendorを揃える(一応dockerの中でやった方が良いかも)
```
php composer.phar install
```

dockerで起動する
```
cd TeamLabPhalcon
docker-compose build
docker-compose up -d
```

[http://docker.app:8009/product](url)にアクセスして確認する(docker.appの部分は自分のdocker-machineのIPアドレス)

以下のコマンドでmysqlにログインすることもできる(パスワードはsecret)

```
docker exec -it dockerteamlabphalcon_mysql_1 bash
mysql -u root -p
```

# ルーティング概要

## GET

### 店舗

- [/shop](url)  
店舗リストを見ることができる

- [/shop/edit?id=1](url)  
IDが1の店舗の情報を編集する(情報といっても名前しかないけど)

- [/shop/create](url)  
新しい店舗をリストに追加する

- [/shop/register?id=1](url)  
IDが1の店舗の商品在庫数を設定する

- [/get](url)  
jsonで店舗リストが全て返る

- [/get?id=1](url)  
IDが1の店舗の情報がjsonで返る

- [/getProducts?id=1](url)
IDが1の店舗の商品在庫情報をjsonで返す

### 商品

- [/product](url)  
商品リストを見ることができる

- [/edit?id=1](url)  
IDが1の商品の情報を編集する

- [/create](url)  
新しい商品をリストに追加する

- [/get](url)  
jsonで商品リストが全て返る

- [/get?id=1](url)  
IDが1の商品の情報がjsonで返る

## POST

リクエストデータ内容に関しては割愛する

### 店舗

- [/shop/destroy](url)  
指定されたIDの店舗とその店舗の商品に対する在庫数情報が削除される

- [/shop/store](url)  
新規登録処理

- [/shop/update](url)  
店舗情報編集を反映

- [/shop/add](url)  
その店舗に対する商品在庫情報を登録する

### 商品

- [/product/destroy](url)  
指定されたIDの商品とその商品と店舗の関連付け情報が削除される

- [/product/store](url)  
新規登録処理

- [/product/update](url)  
店舗情報編集を反映

# 実装上妥協している点

Phalconの利用が初めてだったので色々途中で骨が折れて妥協している部分があります  
以下の機能は使い方を調べているうちに疲れてしまったので、愚直に実装しています

- **リレーションを活用したモデル操作**  
例えば、店舗が削除されたらその店舗が所持していた商品在庫情報も削除する、とかは愚直に実装してます

- **マイグレーション**  
いまいち上手く行かなかったので普通にsqlをダンプしてテーブルを作ってます

- **画像アップロードのバリデーション**  
ピュアPHPで実装してしまっているので、直した方が良いです

- **ページネーションなど基本処理**  
リストを表示するページでは全て表示するようにしているのでページネーションの機能を入れた方が良いです

# データベース

- shops
- products
- shops_products