# 🐳

## 環境構築

### 1. ローカルに clone する

### 2. Docker のインストール

### 3. Docker コンテナの起動

```
./docker-compose-local.sh up
```

## ページ紹介

php

[localhost:8080](http://localhost:8080)

PHPMyAdmin

[localhost:3306](http://localhost:3306)

## Repository とは？

- Entity と Dao の間に存在する Object
- Repository(書き込み処理)
- 主な役割は下記
  - DB とのやり取りをしやすくする
  - API とのやり取りをしやすくする
  - CSV ファイルとのやり取りをしやすくする
- DB に保存しやすい形にする(value object をむくなど)
- Entity を永続化する存在(完了未完了を 0 と 1 で表しているのは、Domain は知らなくて良い。そのつじつまを合わせるのが Repository の仕事)
